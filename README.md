# GelbRepository
Repository structure for Laravel applications.

## Getting Started
These instructions will get you a copy of the project up and running.

### Prerequisites
- Laravel >= 5.8
- PHP >= 7.2

### Installing

1. You will need [composer](https://getcomposer.org/) and a [Laravel](https://laravel.com/) project set in your development environment. Then, type the following code in terminal:
```
composer require aidias/gelb-repository
```

2. After the installation, type:
```
php artisan gelb:repository:install
```
This will create GelbRepository structure in your Laravel app:
- **App\Repositories**: It will contain all repositories related files;
- **App\Repositories\Interfaces\AbstractInterface.php**: This interface will have a common basic rules for others repositories implementation;
- **App\Repositories\Eloquent\AbstractEloquent.php**: This is the Eloquent implementation for the ```AbstractInterface.php```. You can use other framework by using the this [guide](https://github.com/aidias/gelb-repository);
- **App\Providers\RepositoryServiceProvider.php**: This is the service provider for the repository injections.

3. Insert the following code in ```config\app.php``` at *providers* key:
```
App\Providers\RepositoryServiceProvider::class,
```

## Authors
- Rafael Casachi - Initial work - [Website](http://www.rafaelcasachi.eti.br)

## Licence
This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/aidias/gelb-repository) file for details.
