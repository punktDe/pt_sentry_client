<?php
declare(strict_types=1);

namespace PunktDe\PtSentryClient\Handler;

/*
 *  (c) 2023 punkt.de GmbH - Karlsruhe, Germany - https://punkt.de
 *  All rights reserved.
 */

use PunktDe\PtSentryClient\Client;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use TYPO3\CMS\Frontend\ContentObject\Exception\ProductionExceptionHandler;

class SentryProductionExceptionHandler extends ProductionExceptionHandler
{
    /**
     * @param \Exception $exception
     * @param AbstractContentObject|null $contentObject
     * @param mixed[] $contentObjectConfiguration
     * @return string
     * @throws \Exception
     */
    public function handle(
        \Exception $exception,
        AbstractContentObject $contentObject = null,
        $contentObjectConfiguration = []
    ): string {

        /** @var Client $client */
        $client = GeneralUtility::makeInstance(Client::class);
        $client->captureException($exception);
        return parent::handle($exception, $contentObject, $contentObjectConfiguration);
    }
}
