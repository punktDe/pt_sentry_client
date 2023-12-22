# pt_sentry_client

## Environment Variable
SENTRY_DSN Url der Sentry Instanz

## Settings
In der Settings-Datei unter config/system muss folgendes hinzugefügt werden:

```php
'SYS' => [
    'productionExceptionHandler' => \PunktDe\PtSentryClient\Handler\SentryProductionExceptionHandler::class,
    'debugExceptionHandler' => \PunktDe\PtSentryClient\Handler\SentryDebugExceptionHandler::class,
];
```

## TypoScript
Entweder das statische TypoScript der Extension einbinden oder mit dem folgenden
Import in das eigene TypoScript integrieren:

```typo3_typoscript
@import 'EXT:pt_sentry_client/Configuration/TypoScript'
```
