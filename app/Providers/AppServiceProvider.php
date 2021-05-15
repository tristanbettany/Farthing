<?php

namespace App\Providers;

use App\Interfaces\AccountsInterface;
use App\Interfaces\ServiceInterface;
use App\Interfaces\TagsInterface;
use App\Interfaces\TemplatesInterface;
use App\Interfaces\TransactionsInterface;
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
        AccountsInterface::class => AccountsService::class,
        TagsInterface::class => TagsService::class,
        TemplatesInterface::class => TemplatesService::class,
        TransactionsInterface::class => TransactionsService::class,
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
