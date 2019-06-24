<?php

namespace Aidias\GelbRepository\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gelb:repository:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init Gelb Repository';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!file_exists(app_path()."/Repositories")){
            $this->info("Creating Repositories folder: ".app_path()."/Repositories/");
            mkdir(app_path()."/Repositories");
        }

        $this->generateInterfaces();
        $this->generateEloquents();
        $this->createRepositoryServiceProvider();
    }

    /**
     * Generate Interfaces
     */
    public function generateInterfaces() {
        $path = app_path().'/Repositories/Interfaces/';

        if(!file_exists($path)){
            $this->info('Generating Interfaces in folder: '.$path);
            $this->files->makeDirectory($path, 0777, true, true);
            file_put_contents($path.'AbstractInterface.php', $this->getStub('AbstractInterface'));
        }
    }

    /**
     * Generate Eloquent Class for Abstract Interface
     */
    public function generateEloquents() {
        $path = app_path().'/Repositories/Eloquent/';

        if(!file_exists($path)){
            $this->info('Generating Eloquents in folder: '.$path);
            $this->files->makeDirectory($path, 0777, true, true);
            file_put_contents($path.'AbstractEloquent.php', $this->getStub('AbstractEloquent'));
        }
    }

    /**
     * Create Repository Service Provider
     */
    public function createRepositoryServiceProvider() {
        if(!file_exists(app_path()."/Providers/RepositoryServiceProvider.php")) {
            $this->info("Creating Repository Service Provider");
            Artisan::call('make:provider RepositoryServiceProvider');
        }
    }

    /**
     * Get Stub
     */
    public function getStub($name) {
        return file_get_contents(__DIR__."/../Stubs/$name.stub");
    }
}
