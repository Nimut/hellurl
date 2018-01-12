<?php
defined('TYPO3_MODE') or die('Access denied.');

if (TYPO3_MODE === 'BE') {
    // Add Web>Info module:
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
        'web_info',
        'Nimut\\Hellurl\\View\\AdministrationModuleFunction',
        '',
        'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:moduleFunction.tx_hellurl_modfunc1',
        'function',
        'online'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('pages', 'EXT:hellurl/Resources/Private/Language/locallang_csh.xml');
}
