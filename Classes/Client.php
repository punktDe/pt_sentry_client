<?php
declare(strict_types=1);

namespace PunktDe\PtSentryClient;

/*
 *  (c) 2023 punkt.de GmbH - Karlsruhe, Germany - https://punkt.de
 *  All rights reserved.
 */

use Neos\Utility\Files;
use Sentry\State\Scope;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function Sentry\captureException;
use function Sentry\configureScope;
use function Sentry\init;
use function Sentry\withScope;

class Client implements SingletonInterface
{
    /**
     * Initialize the sentry client and fatal error handler (shutdown function)
     */
    public function captureException(\Throwable $exception): void
    {
        if (isset($_ENV['SENTRY_DSN'])) {
            $sentryDsn = $_ENV['SENTRY_DSN'];
        }
        if (!empty($sentryDsn)) {
            init([
                'dsn' => $sentryDsn,
                'environment' => $this->getEnvironment(),
                'release' => $this->getRelease()
            ]);
            configureScope(function (Scope $scope): void {
                $scope->setTags(['typo3_context' => (string)Environment::getContext()]);
            });

            configureScope(function (Scope $scope): void {
                $scope->setContext('character', $this->getUserContext());
            });

            withScope(function (Scope $scope) use ($exception) {
                $scope->setFingerprint([$exception->getCode()]);
                captureException($exception);
            });
        }
    }

    /**
     * @return mixed[]
     * @throws AspectNotFoundException
     */
    protected function getUserContext(): array
    {
        $userContext = [];
        /** @var Context $context */
        $context = GeneralUtility::makeInstance(Context::class);

        if ($context->getPropertyFromAspect('frontend.user', 'isLoggedIn')) {
            $userContext['feUid'] = $context->getPropertyFromAspect('frontend.user', 'id');
        }
        if ($context->getPropertyFromAspect('backend.user', 'isLoggedIn')) {
            $userContext['beUid'] = $context->getPropertyFromAspect('backend.user', 'id');
        }
        return $userContext;
    }

    /**
     * @return string
     */
    protected function getRelease(): string
    {
        $filenames = scandir(Files::concatenatePaths([Environment::getPublicPath(), '..']));
        if ($filenames !== false) {
            foreach ($filenames as $filename) {
                if (str_starts_with($filename, 'RELEASE_') === true) {
                    return substr($filename, 8);
                }
            }
        }
        return 'dev';
    }


    /**
     * @return string
     */
    protected function getEnvironment(): string
    {
        return (string)str_replace('Production/', '', (string)Environment::getContext());
    }
}
