<?php
namespace Nimut\Hellurl;

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

use Nimut\Hellurl\Updates\DatabaseFieldUpdater;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class updates database fields from realurl to hellurl.
 */
class ext_update
{
    /**
     * @var DatabaseFieldUpdater
     */
    protected $updater;

    /**
     * @param DatabaseFieldUpdater|null $updater
     */
    public function __construct(DatabaseFieldUpdater $updater = null)
    {
        $this->updater = $updater !== null ? $updater : GeneralUtility::makeInstance('Nimut\\Hellurl\\Updates\\DatabaseFieldUpdater');
    }

    /**
     * Checks if the script should execute.
     *
     * @return bool
     */
    public function access()
    {
        if ($this->isWizardDone()) {
            return false;
        }

        if (!$this->updater->checkForUpdate()) {
            $this->markWizardAsDone();
            return false;
        }

        return true;
    }

    /**
     * Runs the update.
     */
    public function main()
    {
        $this->updater->performUpdate();

        $flashMessage = GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'All database fields were updated.',
            'hellurl',
            FlashMessage::OK
        );
        $flashMessageService = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessageService');
        $defaultFlashMessageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $defaultFlashMessageQueue->enqueue($flashMessage);

        $this->markWizardAsDone();

        return $defaultFlashMessageQueue->renderFlashMessages();
    }

    /**
     * Mark RealurlToHellurlUpdate wizard as done
     */
    protected function markWizardAsDone()
    {
        GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Registry')->set('installUpdate', 'Nimut\\Hellurl\\Updates\\RealurlToHellurlUpdate', 1);
    }

    /**
     * Checks if the RealurlToHellurlUpdate wizard has been "done" before
     *
     * @return bool
     */
    protected function isWizardDone()
    {
        return GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Registry')->get('installUpdate', 'Nimut\\Hellurl\\Updates\\RealurlToHellurlUpdate', false);
    }
}
