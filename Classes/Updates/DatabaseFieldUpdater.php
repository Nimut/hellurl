<?php
namespace Nimut\Hellurl\Updates;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Nicole Cordes (typo3@cordes.co)
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Database\DatabaseConnection;

/**
 * Migrates old realurl database fields to hellurl database fields
 */
class DatabaseFieldUpdater
{
    /**
     * @var array
     */
    protected $migrationPaths = array(
        'pages' => array(
            'tx_realurl_pathsegment' => 'tx_hellurl_pathsegment',
            'tx_realurl_pathoverride' => 'tx_hellurl_pathoverride',
            'tx_realurl_exclude' => 'tx_hellurl_exclude',
            'tx_realurl_nocache' => 'tx_hellurl_nocache',
        ),
        'pages_language_overlay' => array(
            'tx_realurl_pathsegment' => 'tx_hellurl_pathsegment',
        ),
    );

    /**
     * Checks if an update is needed
     *
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     */
    public function checkForUpdate()
    {
        $database = $this->getDatabaseConnection();
        foreach ($this->migrationPaths as $table => $fieldArray) {
            $databaseFields = $database->admin_get_fields($table);
            $intersectFields = array_intersect_key($databaseFields, $fieldArray);
            if (empty($intersectFields)) {
                continue;
            }
            $whereClauseArray = array();
            foreach ($intersectFields as $field => $_) {
                $whereClauseArray[] = $field . '!=' . $fieldArray[$field];
            }
            $count = $database->exec_SELECTcountRows(
                '*',
                $table,
                implode(' OR ', $whereClauseArray)
            );
            if (!empty($count)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Performs the update
     *
     * @return array
     */
    public function performUpdate()
    {
        $database = $this->getDatabaseConnection();
        $databaseQueries = array();
        foreach ($this->migrationPaths as $table => $fieldArray) {
            $databaseFields = $database->admin_get_fields($table);
            $intersectFields = array_intersect_key($databaseFields, $fieldArray);
            if (empty($intersectFields)) {
                continue;
            }

            $updateArray = array();
            foreach ($intersectFields as $field => $_) {
                $updateArray[$fieldArray[$field]] = $field;
            }
            $database->exec_UPDATEquery(
                $table,
                '1=1',
                $updateArray,
                array_keys($updateArray)
            );
            $databaseQueries[] = $database->debug_lastBuiltQuery;
        }

        return $databaseQueries;
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
