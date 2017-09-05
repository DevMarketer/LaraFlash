# LaraFlash: Improved Flash Messaging in Laravel

I have always felt that flash messaging could be improved in Laravel. The basic `Session::flash` wasn't terrible, but considering how much we all rely on flash notifications in our applications, I just constantly thought "There has to be a better way". LaraFlash is that way.

More importantly than letting you output flash messages, I wanted a more succinct way to work with a flash messaging object. I think the flash messaging object should be treated like an Eloquent Collection, and that is why **LaraFlash** was built.

You can use **LaraFlash** just for the LaraFlash object and manage messages yourself, or you can let this package handle everything for you, including outputting the messages to the users.

## Installation

Installation is straightforward, setup is similar to every other Laravel Package.

#### 1. Install via Composer

Begin by pulling in the package through Composer:

```
composer require devmarketer/laraflash
```

#### 2. Define the Service Provider and alias

Next we need to pull in the alias and service providers.

**Note:** This package supports the new _auto-discovery_ features of Laravel 5.5, so if you are working on a Laravel 5.5 project, then your install is complete, you can start using this package.

Inside of your `config/app.php` define a new service provider

```
'providers' => [
		...
		DevMarketer\LaraFlash\LaraFlashServiceProvider::class,
		...
];
```

Then we want to define an alias in the same `config/app.php` file.

```
'aliases' => [
		...
		'LaraFlash' => DevMarketer\LaraFlash\LaraFlashFacade::class,
		...
];
```

## Usage
