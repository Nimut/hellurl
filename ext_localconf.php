<?php
defined('TYPO3_MODE') or die('Access denied.');

call_user_func(function ($extensionConfiguration) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['Nimut\\Hellurl\\Updates\\RealurlToHellurlUpdate'] =
        'Nimut\\Hellurl\\Updates\\RealurlToHellurlUpdate';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tstemplate.php']['linkData-PostProc']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\UrlRewritingHook->encodeSpURL';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typoLink_PostProc']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\UrlRewritingHook->encodeSpURL_urlPrepend';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\UrlRewritingHook->decodeSpURL';

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\DataHandling\\DataHandlerHook->flushCacheTables';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearPageCacheEval']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\DataHandling\\DataHandlerHook->clearPageRelatedUrlCaches';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\DataHandling\\DataHandlerHook';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['tx_hellurl'] = 'Nimut\\Hellurl\\Hooks\\DataHandling\\DataHandlerHook';

    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_hellurl_pathsegment,tx_hellurl_exclude,tx_hellurl_pathoverride';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ',tx_hellurl_pathsegment';

    // Include configuration file
    $_hellurl_conf = unserialize($extensionConfiguration);
    if (is_array($_hellurl_conf)) {
        $_hellurl_conf_file = trim($_hellurl_conf['configFile']);
        if ($_hellurl_conf_file && file_exists(PATH_site . $_hellurl_conf_file)) {
            /** @noinspection PhpIncludeInspection */
            require_once PATH_site . $_hellurl_conf_file;
        }
    }

    $_hellurl_conf_file = PATH_site . \Nimut\Hellurl\Configuration\ConfigurationGenerator::AUTOCONFIGURTION_FILE;
    if ($_hellurl_conf['enableAutoConf'] && !isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hellurl']) && file_exists($_hellurl_conf_file)) {
        require_once $_hellurl_conf_file;
    }

    define('TX_HELLURL_SEGTITLEFIELDLIST_DEFAULT', 'tx_hellurl_pathsegment,alias,nav_title,title,uid');
    define('TX_HELLURL_SEGTITLEFIELDLIST_PLO', 'tx_hellurl_pathsegment,nav_title,title,uid');
}, $_EXTCONF);
