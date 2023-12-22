<?php
declare(strict_types=1);

namespace PunktDe\PtSentryClient\Handler\Frontend;

use PunktDe\PtSentryClient\Client;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use TYPO3\CMS\Frontend\ContentObject\Exception\ProductionExceptionHandler;

class SentryProductionExceptionHandler extends ProductionExceptionHandler
{

    /**
     * @param \Exception $exception
     * @param AbstractContentObject|null $contentObject
     * @param $contentObjectConfiguration
     * @return string
     * @throws \Exception
     */
    public function handle(
        \Exception $exception,
        AbstractContentObject $contentObject = null,
        $contentObjectConfiguration = []): string
    {
        $client = GeneralUtility::makeInstance(Client::class);
        /** @var Client $client */
        $client->captureException($exception);
        return parent::handle($exception, $contentObject, $contentObjectConfiguration);
    }
}
