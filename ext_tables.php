<?php
defined('TYPO3_MODE') or die('Access denied.');

if (TYPO3_MODE == 'BE') {
    // Add Web>Info module:
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
        'web_info',
        'Nimut\\Hellurl\\View\\AdministrationModuleFunction',
        '',
        'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:moduleFunction.tx_hellurl_modfunc1',
        'function',
        'online'
    );
}

$GLOBALS['TCA']['pages']['columns'] += [
    'tx_hellurl_pathsegment' => [
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_pathsegment',
        'displayCond' => 'FIELD:tx_hellurl_exclude:!=:1',
        'exclude' => 1,
        'config' => [
            'type' => 'input',
            'max' => 255,
            'eval' => 'trim,nospace,lower',
        ],
    ],
    'tx_hellurl_pathoverride' => [
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_path_override',
        'displayCond' => 'FIELD:tx_hellurl_exclude:!=:1',
        'exclude' => 1,
        'config' => [
            'type' => 'check',
            'items' => [
                ['', ''],
            ],
        ],
    ],
    'tx_hellurl_exclude' => [
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_exclude',
        'exclude' => 1,
        'config' => [
            'type' => 'check',
            'items' => [
                ['', ''],
            ],
        ],
    ],
    'tx_hellurl_nocache' => [
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_nocache',
        'exclude' => 1,
        'config' => [
            'type' => 'check',
            'items' => [
                ['', ''],
            ],
        ],
    ],
];

$GLOBALS['TCA']['pages']['ctrl']['requestUpdate'] .= ',tx_hellurl_exclude';

$GLOBALS['TCA']['pages']['palettes']['hellurl'] = [
    'showitem' => '
        tx_hellurl_pathsegment,
        --linebreak--,
        tx_hellurl_pathoverride,
        --linebreak--,
        tx_hellurl_exclude
    ',
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--palette--;LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.palette.hellurl;hellurl', '1,5,4,199,254', 'after:title');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('pages', 'EXT:hellurl/Resources/Private/Language/locallang_csh.xml');

$GLOBALS['TCA']['pages_language_overlay']['columns'] += [
    'tx_hellurl_pathsegment' => [
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_pathsegment',
        'exclude' => 1,
        'config' => [
            'type' => 'input',
            'max' => 255,
            'eval' => 'trim,nospace,lower',
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages_language_overlay', 'tx_hellurl_pathsegment', '', 'after:nav_title');
