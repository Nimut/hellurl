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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Controller\Action\Tool\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractUpdate;

/**
 * Migrates old realurl database fields to hellurl database fields
 */
class RealurlToHellurlUpdate extends AbstractUpdate
{
    /**
     * @var string
     */
    protected $title = 'Migrates old realurl database fields to hellurl database fields';

    /**
     * @var DatabaseFieldUpdater
     */
    protected $updater;

    /**
     * @param string $identifier
     * @param int $versionAsInt
     * @param array $userInput
     * @param UpgradeWizard $parentObject
     * @param DatabaseFieldUpdater $updater
     */
    public function __construct($identifier = '', $versionAsInt = 0, $userInput = array(), $parentObject = null, DatabaseFieldUpdater $updater = null)
    {
        $this->updater = $updater !== null ? $updater : GeneralUtility::makeInstance('Nimut\\Hellurl\\Updates\\DatabaseFieldUpdater');
    }

    /**
     * Checks if an update is needed
     *
     * @param string &$description The description for the update
     * @return bool Whether an update is needed (TRUE) or not (FALSE)
     */
    public function checkForUpdate(&$description)
    {
        if ($this->isWizardDone()) {
            return false;
        }

        $description = 'Realurl provides some additional page fields for advanced url handling.'
            . ' These fields need to be migrated to new hellurl database fields to be able to generate the exactly same'
            . ' paths as before.';

        if (!$this->updater->checkForUpdate()) {
            $this->markWizardAsDone();
            return false;
        }

        return true;
    }

    /**
     * Performs the update
     *
     * @param array &$databaseQueries Queries done in this update
     * @param string &$customMessage Custom message
     * @return bool
     */
    public function performUpdate(array &$databaseQueries, &$customMessage)
    {
        $databaseQueries = array_merge($databaseQueries, $this->updater->performUpdate());
        $this->markWizardAsDone();

        return true;
    }
}
