<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@files' => dirname(__DIR__) . '/files',
        
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [        
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_backendIdentity', 'httpOnly' => true],
        ],
    ],
    'container' => [
        'definitions' => [
            \common\repositories\interfaces\UserRepositoryInterface::class => \common\repositories\UserRepository::class,
            \common\repositories\interfaces\DocumentRepositoryInterface::class => \common\repositories\DocumentRepository::class,
            \common\repositories\interfaces\DocumentTypeRepositoryInterface::class => \common\repositories\DocumentTypeRepository::class,
            \common\repositories\interfaces\LoanApplicationRepositoryInterface::class => \common\repositories\LoanApplicationRepository::class,
            \common\repositories\interfaces\LoanApplicationStatusRepositoryInterface::class => \common\repositories\LoanApplicationStatusRepository::class,
            \common\repositories\interfaces\RefreshTokenRepositoryInterface::class => \common\repositories\RefreshTokenRepository::class,
            
            \common\services\interfaces\AuthServiceInterface::class => \common\services\AuthService::class,
            \common\services\interfaces\LoanApplicationServiceInterface::class => \common\services\LoanApplicationService::class,
            \common\services\interfaces\DocumentServiceInterface::class => \common\services\DocumentService::class,
            \common\services\interfaces\DocumentTypeServiceInterface::class => \common\services\DocumentTypeService::class,
            \common\services\interfaces\DebtClearingServiceInterface::class => \common\services\DebtClearingService::class,
            \common\services\interfaces\UserServiceInterface::class => \common\services\UserService::class,
        ],
    ],
];
