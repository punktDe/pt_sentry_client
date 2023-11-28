<?php

$EM_CONF['sentry'] = [
    'title' => 'Sentry Client',
    'description' => 'Sentry Client for TYPO3 - https://www.getsentry.com/',
    'category' => 'services',
    'version' => '1.0.0',
    'state' => 'alpha',
    'author' => 'punktde',
    'author_email' => 'evo@punkt.de',
    'author_company' => 'punkt.de GmbH',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.8',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
