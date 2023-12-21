<?php
defined('TYPO3') or die();

call_user_func(function()
{
    $extensionKey = 'pt_sentry_client';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        '[sentry] Activate Content Exception'
    );
});
