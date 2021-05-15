<?php

namespace App\Providers;

use App\Interfaces\AccountsServiceInterface;
use App\Interfaces\ServiceInterface;
use App\Interfaces\TagsServiceInterface;
use App\Interfaces\TemplatesServiceInterface;
use App\Interfaces\TransactionsServiceInterface;
use App\Services\AbstractService;
use App\Services\AccountsServiceService;
use App\Services\TagsServiceService;
use App\Services\TemplatesServiceService;
use App\Services\TransactionsServiceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const BINDINGS = [
        ServiceInterface::class => AbstractService::class,
        AccountsServiceInterface::class => AccountsServiceService::class,
        TagsServiceInterface::class => TagsServiceService::class,
        TemplatesServiceInterface::class => TemplatesServiceService::class,
        TransactionsServiceInterface::class => TransactionsServiceService::class,
    ];

    public function register(): void
    {
        foreach (self::BINDINGS as $interface => $concreteImplementation) {
            $this->app->bind(
                $interface,
                $concreteImplementation
            );
        }
    }

    public function boot(): void
    {
        //TODO: Bootstrap app services
    }
}
