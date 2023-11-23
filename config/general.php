<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

return [
    // Global settings
    '*' => [
        'defaultWeekStartDay' => 0,
        'enableCsrfProtection' => true,
        'omitScriptNameInUrls' => true,
        'cpTrigger' => 'admin',
        'securityKey' => getenv('SECURITY_KEY'),
        'pageTrigger' => 'page/',
        'limitAutoSlugsToAscii' => true,
        'enableGql' => false,
        'maxRevisions' => '10',
        'maxBackups' => '7',
        'sendPoweredByHeader' => false,
        'autoLoginAfterAccountActivation' => true,
        'activateAccountSuccessPath' => '/customer-profile',
        'deferPublicRegistrationPassword' => true,
        'maxUploadFileSize' => '40MB',
        'defaultTokenDuration' => 172800,
        'setPasswordPath' => '/set-password',
    ],

    // Dev environment settings
    'dev' => [
        'devMode' => true,
        'allowAdminChanges' => true,
        'enableTemplateCaching' => false,
        'maxInvalidLogins' => 10,
    ],

    // Staging environment settings
    'staging' => [
        'devMode' => false,
        'allowAdminChanges' => false,
        'disallowRobots' => true,
        'enableTemplateCaching' => true,
        'maxInvalidLogins' => 5,
    ],

    // Production environment settings
    'production' => [
        'devMode' => false,
        'allowAdminChanges' => false,
        'disallowRobots' => false,
        'enableTemplateCaching' => true,
        'maxInvalidLogins' => 3,
    ],
];