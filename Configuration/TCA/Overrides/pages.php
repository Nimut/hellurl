<?php
$GLOBALS['TCA']['pages']['columns'] += array(
    'tx_hellurl_pathsegment' => array(
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_pathsegment',
        'displayCond' => 'FIELD:tx_hellurl_exclude:!=:1',
        'exclude' => 1,
        'config' => array(
            'type' => 'input',
            'max' => 255,
            'eval' => 'trim,nospace,lower',
        ),
    ),
    'tx_hellurl_pathoverride' => array(
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_path_override',
        'displayCond' => 'FIELD:tx_hellurl_exclude:!=:1',
        'exclude' => 1,
        'config' => array(
            'type' => 'check',
            'items' => array(
                array('', ''),
            ),
        ),
    ),
    'tx_hellurl_exclude' => array(
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_exclude',
        'exclude' => 1,
        'config' => array(
            'type' => 'check',
            'items' => array(
                array('', ''),
            ),
        ),
    ),
    'tx_hellurl_nocache' => array(
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_nocache',
        'exclude' => 1,
        'config' => array(
            'type' => 'check',
            'items' => array(
                array('', ''),
            ),
        ),
    ),
);

$GLOBALS['TCA']['pages']['ctrl']['requestUpdate'] .= ',tx_hellurl_exclude';

$GLOBALS['TCA']['pages']['palettes']['hellurl'] = array(
    'showitem' => '
        tx_hellurl_pathsegment,
        --linebreak--,
        tx_hellurl_pathoverride,
        --linebreak--,
        tx_hellurl_exclude
    ',
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--palette--;LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.palette.hellurl;hellurl', '1,5,4,199,254', 'after:title');

$GLOBALS['TCA']['pages_language_overlay']['columns'] += array(
    'tx_hellurl_pathsegment' => array(
        'label' => 'LLL:EXT:hellurl/Resources/Private/Language/locallang_db.xml:pages.tx_hellurl_pathsegment',
        'exclude' => 1,
        'config' => array(
            'type' => 'input',
            'max' => 255,
            'eval' => 'trim,nospace,lower',
        ),
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages_language_overlay', 'tx_hellurl_pathsegment', '', 'after:nav_title');
