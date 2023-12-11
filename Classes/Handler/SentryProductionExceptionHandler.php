<?php
declare(strict_types=1);

namespace PunktDe\PtSentryClient\Handler;

/*
 *  (c) 2023 punkt.de GmbH - Karlsruhe, Germany - https://punkt.de
 *  All rights reserved.
 */

use PunktDe\PtSentryClient\Client;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Error\ProductionExceptionHandler;
use TYPO3\CMS\Core\Controller\ErrorPageController;
use TYPO3\CMS\Core\Error\Http\AbstractClientErrorException;

class SentryProductionExceptionHandler extends ProductionExceptionHandler
{
    /**
     * Echoes an exception for the web.
     *
     * @param \Throwable $exception The throwable object.
     */
    public function echoExceptionWeb(\Throwable $exception)
    {
        /** @var Client $client */
        $client = GeneralUtility::makeInstance(Client::class);
        $client->captureException($exception);

        $this->sendStatusHeaders($exception);
        $this->writeLogEntries($exception, self::CONTEXT_WEB);
        echo GeneralUtility::makeInstance(ErrorPageController::class)->errorAction(
            $this->getTitle($exception),
            $this->getMessage($exception),
            $this->discloseExceptionInformation($exception) ? $exception->getCode() : 0,
            503
        );
    }

    /**
     * Echoes an exception for the command line.
     *
     * @param \Throwable $exception The throwable object.
     */
    public function echoExceptionCLI(\Throwable $exception)
    {
        /** @var Client $client */
        $client = GeneralUtility::makeInstance(Client::class);
        $client->captureException($exception);

        $filePathAndName = $exception->getFile();
        $exceptionCodeNumber = $exception->getCode() > 0 ? '#' . $exception->getCode() . ': ' : '';
        $this->writeLogEntries($exception, self::CONTEXT_CLI);
        echo LF . 'Uncaught TYPO3 Exception ' . $exceptionCodeNumber . $exception->getMessage() . LF;
        echo 'thrown in file ' . $filePathAndName . LF;
        echo 'in line ' . $exception->getLine() . LF . LF;
        die(1);
    }
}
