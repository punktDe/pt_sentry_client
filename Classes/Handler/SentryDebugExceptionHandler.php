<?php
declare(strict_types=1);

namespace PunktDe\PtSentryClient\Handler;

/*
 *  (c) 2023 punkt.de GmbH - Karlsruhe, Germany - https://punkt.de
 *  All rights reserved.
 */

use PunktDe\PtSentryClient\Client;
use TYPO3\CMS\Core\Error\DebugExceptionHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SentryDebugExceptionHandler extends DebugExceptionHandler
{
    /**
     * @param \Throwable $exception The throwable object.
     * @throws \Exception
     */
    public function handleException(\Throwable $exception): void
    {
        /** @var Client $client */
        $client = GeneralUtility::makeInstance(Client::class);
        $client->captureException($exception);
        parent::handleException($exception);
    }
}
