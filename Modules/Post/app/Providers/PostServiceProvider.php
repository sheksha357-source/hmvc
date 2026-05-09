<?php

namespace Modules\Post\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;

class PostServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Post';

    protected string $nameLower = 'post';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];
}
