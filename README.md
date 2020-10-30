# GelbRepository
Repository structure for Laravel applications.

## Getting Started
These instructions will get you a copy of the project up and running.

### Prerequisites
- Laravel >= 5.8
- PHP >= 7.2

### Installing

1. You will need [composer](https://getcomposer.org/) and a [Laravel](https://laravel.com/) project set in your development environment. Then, run the following command in terminal:

```bash
composer require aidias/gelb-repository
```

2. After the package installation, run:

```bash
php artisan gelb:repository:init
```

This will create the following GelbRepository structure in your Laravel app:
- `app\Providers\RepositoryServiceProvider.php`: This is the service provider for the repository injections.
- `app\Repositories`: It will contain all repositories related files;
- `app\Repositories\Interfaces\AbstractInterface.php`: This interface will have a common basic rules for others repositories implementation;
- `app\Repositories\Eloquent\AbstractEloquent.php`: This is the Eloquent implementation for the `AbstractInterface.php`. You can use other framework by using the this [guide](https://github.com/aidias/gelb-repository);
	

3. Register the `RepositoryServiceProvider` in `config\app.php` at *providers* array:

```php
	'providers' => [
		...
		App\Providers\RepositoryServiceProvider::class,
		...
	],
```

### Usage

1. For example, to create a `Post` repository, run:

```bash
php artisan gelb:make:repository Post
```

This will create the following files (if they don't exist already):
- `app\Http\Controllers\PostController.php`
- `app\Http\Requests\PostStoreRequest.php`
- `app\Http\Requests\PostUpdateRequest.php`
- `app\Repositories\Eloquent\PostEloquent.php`
- `app\Repositories\Interfaces\PostInterface.php`
- `app\Post.php`

## Authors
- Rafael Casachi - Initial work - [Website](https://rafaelcasachi.dev)
- Cristiano Fromagio - Contributor - [GitHub](https://github.com/cristianofromagio)
- Leandro Cuminato - Contributor - [GitHub](https://github.com/LeandrodeLimaC)

## License
This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/aidias/gelb-repository) file for details.
