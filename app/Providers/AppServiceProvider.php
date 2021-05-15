<?php

namespace App\Providers;

use App\Interfaces\AccountsServiceInterface;
use App\Interfaces\ServiceInterface;
use App\Interfaces\TagsServiceInterface;
use App\Interfaces\TemplatesServiceInterface;
use App\Interfaces\TransactionsServiceInterface;
use App\Services\AbstractService;
use App\Services\AccountsService;
use App\Services\TagsService;
use App\Services\TemplatesService;
use App\Services\TransactionsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const BINDINGS = [
        ServiceInterface::class => AbstractService::class,
        AccountsServiceInterface::class => AccountsService::class,
        TagsServiceInterface::class => TagsService::class,
        TemplatesServiceInterface::class => TemplatesService::class,
        TransactionsServiceInterface::class => TransactionsService::class,
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
