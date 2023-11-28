# pt_sentry_client

## Environment Variable
SENTRY_DSN Url der Sentry Instanz

## Settings
In der Settings-Datei unter config/system muss folgendes hinzugefügt werden:

    'SYS' => [
        'productionExceptionHandler' => \PunktDe\PtSentryClient\Handler\SentryProductionExceptionHandler::class,
        'debugExceptionHandler' => \PunktDe\PtSentryClient\Handler\SentryDebugExceptionHandler::class,
    ];
