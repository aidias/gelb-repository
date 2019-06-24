<?php

namespace Aidias\GelbRepository;

use Illuminate\Support\ServiceProvider;

class GelbRepositoryServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Aidias\GelbRepository\Console\Commands\Init',
        'Aidias\GelbRepository\Console\Commands\MakeRepository',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands($this->commands);
    }
}
