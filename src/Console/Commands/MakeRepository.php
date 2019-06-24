<?php

namespace Aidias\GelbRepository\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gelb:make:repository {repositoryName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Gelb repository with a interface injection in Repository Service Provider. Eloquent repository is generate as standard';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!file_exists(app_path()."/Providers/RepositoryServiceProvider.php")) {
            $this->warn('There is no RepositoryServiceProvider in Providers folder, run: php artisan gelb:repository:init');
        } else {
            $repo = $this->argument('repositoryName');

            if(!file_exists(app_path()."/Repositories/Interfaces/{$repo}Interface.php"))
                $this->generateInterface($repo);

            if(!file_exists(app_path()."/Repositories/Eloquent/{$repo}Eloquent.php"))
                $this->generateEloquent($repo);

            if(
                file_exists(app_path()."/Repositories/Interfaces/{$repo}Interface.php") &&
                file_exists(app_path()."/Repositories/Eloquent/{$repo}Eloquent.php")
            )
                $this->addBindRegister($repo);
            
            if(!file_exists(app_path()."/{$repo}.php"))
                $this->generateModel($repo);

            if(!file_exists(app_path()."/Http/Controllers/{$repo}Controller.php"))
                $this->generateController($repo);

            if(!file_exists(app_path()."/Http/Requests/{$repo}StoreRequest.php")) {
                $this->info("Generating {$repo}StoreRequest");
                Artisan::call("make:request {$repo}StoreRequest");
            }
            
            if(!file_exists(app_path()."/Http/Requests/{$repo}UpdateRequest.php")) {
                $this->info("Generating {$repo}UpdateRequest");
                Artisan::call("make:request {$repo}UpdateRequest");
            }
        }
    }

    /**
     * Bind Provider to Register Function in RepositoryServiceProvider
     */
    public function addBindRegister($name) {
        $this->info('Binding interface in service provider.');
        $modelTemplate = preg_replace(
            "/public function register\(\)\n*\s*{/",
            "public function register()\n\t{\n\t\t\$this->app->bind(".$name."Interface::class, ".$name."Eloquent::class);",
            file_get_contents(app_path("Providers/RepositoryServiceProvider.php"))
        );

        file_put_contents(app_path("Providers/RepositoryServiceProvider.php"), $modelTemplate);
    }

    /**
     * Create a Model Interface
     */
    public function generateInterface($name) {
        $path = app_path().'/Repositories/Interfaces/';

        if(file_exists($path)){
            $this->info("Generating {$name} Interface");

            $modelTemplate = str_replace(
                [
                    '%DummyStoreRequest%',
                    '%DummyUpdateRequest%',
                    '%DummyInterface%',
                    '%$dummyModel%',
                ],
                [
                    ucfirst($name).'StoreRequest',
                    ucfirst($name).'UpdateRequest',
                    ucfirst($name).'Interface',
                    '$'.strtolower($name),
                ],
                $this->getStub('RepositoryInterface')
            );

            file_put_contents($path."{$name}Interface.php", $modelTemplate);
        }
    }

    /**
     * Create a Model Eloquent Repository
     */
     public function generateEloquent($name) {
        $path = app_path().'/Repositories/Eloquent/';

        if(file_exists($path)){
            $this->info("Generating {$name} Eloquent");

            $modelTemplate = str_replace(
                [
                    '%DummyStoreRequest%', 
                    '%DummyUpdateRequest%', 
                    '%DummyInterface%',
                    '%Model%', 
                    '%DummyEloquent%',
                ],
                [
                    ucfirst($name).'StoreRequest',
                    ucfirst($name).'UpdateRequest',
                    ucfirst($name).'Interface',
                    ucfirst($name),
                    ucfirst($name).'Eloquent',
                ],
                $this->getStub('RepositoryEloquent')
            );

            file_put_contents($path."{$name}Eloquent.php", $modelTemplate);
        }
    }

    /** 
     * Generate a Model
     */
    public function generateModel($name) {
        if(file_exists(app_path())){
            $this->info("Generating {$name} Model");

            $modelTemplate = str_replace(
                ['%Model%'],
                [ucfirst($name)],
                $this->getStub('Model')
            );

            file_put_contents(app_path()."/{$name}.php", $modelTemplate);
        }
    }

    /**
     * Generate a Controller
     */
     public function generateController($name) {
        $path = app_path().'/Http/Controllers/';

        if(file_exists($path)){
            $this->info("Generating {$name} Controller");

            $modelTemplate = str_replace(
                [
                    '%DummyStoreRequest%',
                    '%DummyUpdateRequest%',
                    '%DummyInterface%',
                    '%Model%',
                    '%DummyController%',
                ],
                [
                    ucfirst($name).'StoreRequest',
                    ucfirst($name).'UpdateRequest',
                    ucfirst($name).'Interface',
                    ucfirst($name),
                    ucfirst($name).'Controller',
                ],
                $this->getStub('Controller')
            );

            file_put_contents($path."{$name}Controller.php", $modelTemplate);
        }
    }


    /**
     * Get Stub
     */
    public function getStub($name) {
        return file_get_contents(__DIR__."/../Stubs/$name.stub");
    }
}
