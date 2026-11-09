<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', fn (): Filesystem => new class extends Filesystem
        {
            public function replace($path, $content, $mode = null): void
            {
                file_put_contents($path, $content, LOCK_EX);

                if ($mode !== null) {
                    @chmod($path, $mode);
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
