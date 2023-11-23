<?php

namespace App\Providers;

use App\Models\EmailRecord;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\ElasticsearchHelper;
use App\Utilities\RedisHelper;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ElasticsearchHelperInterface::class, ElasticsearchHelper::class);
        $this->app->singleton(RedisHelperInterface::class, RedisHelper::class);
    }
}
