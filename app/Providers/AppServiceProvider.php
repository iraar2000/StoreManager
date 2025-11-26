<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Nette\Utils\Callback;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        // Schema::defaultStringLength(191);
        Schema::macro('createIfNotExists', function (string $table, \Closure $callback) {
            if (!Schema::hasTable($table)) {
                Schema::create($table, $callback);
            }
        });

        Schema::macro('addColumnsIfNotExists', function (string $table, array $colums, \Closure $callback) {
            $allow_addition = true;
            foreach ($colums as $colums) {
                if (Schema::hasColumn($table, $colums)) $allow_addition = false;
            }
            if (Schema::hasTable($table) && $allow_addition) {
                Schema::table($table, $callback);
            } else {
                Log::info("schema has some columns which were provided", ["table Name" => $table]);
            }
        });

        Schema::macro('editColumnsIfNotExists', function (string $table, array $colums, \Closure $callback) {
            $allow_addition = true;
            foreach ($colums as $colums) {
                if (Schema::hasColumn($table, $colums)) $allow_addition = false;
            }
            if (Schema::hasTable($table) && $allow_addition) {
                Schema::table($table, $callback);
            } else {
                Log::info("schema has some columns which were provided");
            }
        });

        $this->app->bind(\App\ViewModels\ISmsModel::class, \App\ViewModels\SmsModel::class);
    }
}
