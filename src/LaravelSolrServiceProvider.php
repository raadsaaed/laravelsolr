<?php
namespace haiderjabbar\LaravelSolr;

use haiderjabbar\LaravelSolr\Console\Commands\CreateSolrFields;
use haiderjabbar\LaravelSolr\Console\Commands\CreateSolrCore;
use haiderjabbar\LaravelSolr\Console\Commands\DeleteSolrCore;
use haiderjabbar\LaravelSolr\Console\Commands\DeleteSolrFields;
use haiderjabbar\LaravelSolr\Console\Commands\UpdateSolrCore;
use haiderjabbar\LaravelSolr\Console\Commands\UpdateSolrFields;
use Illuminate\Support\ServiceProvider;

class LaravelSolrServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register LaravelSolr services
        $this->app->singleton(LaravelSolr::class, function ($app) {
            return new LaravelSolr();
        });

        // Merge the configuration file
        $this->mergeConfigFrom(__DIR__.'/Config/solr.php', 'solr');
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/Config/solr.php' => config_path('solr.php'),
        ]);

        // Load routes
//        $this->loadRoutesFrom(__DIR__.'/../routes/solr.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateSolrCore::class,
                UpdateSolrCore::class,
                DeleteSolrCore::class,
                CreateSolrFields::class,
                UpdateSolrFields::class,
                DeleteSolrFields::class,
            ]);
        }
    }
}
