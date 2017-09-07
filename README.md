# LaraFlash: Improved Flash Messaging in Laravel

I have always felt that flash messaging could be improved in Laravel. The basic `Session::flash` wasn't terrible, but considering how much we all rely on flash notifications in our applications, I just constantly thought "There has to be a better way". **LaraFlash** is that way.

More importantly than letting you output flash messages, I wanted a more succinct way to work with a flash messaging object. I think the flash messaging object should be treated like an Eloquent Collection, and that is why **LaraFlash** was built.

You can use **LaraFlash** just for the LaraFlash object and manage messages yourself, or you can let this package handle everything for you, including outputting the messages to the users.

It supports several ways to work with it, to match your coding style. There are basic helper functions like `flash('Something went wrong')` and you can use basic facades `LaraFlash::add('Something Went Wrong')` or you can use a fluent syntax like: `LaraFlash::new()->content('Hello World')->title('Welcome')->type('info')->priority(5);`. Its up to you!

## Installation

Installation is straightforward, setup is similar to every other Laravel Package.

#### 1. Install via Composer

Begin by pulling in the package through Composer:

```
composer require devmarketer/laraflash
```

#### 2. Define the Service Provider and alias

Next we need to pull in the alias and service providers.

**Note:** This package supports the new _auto-discovery_ features of Laravel 5.5, so if you are working on a Laravel 5.5 project, then your install is complete, you can skip to step 3.

Inside of your `config/app.php` define a new service provider

```
'providers' => [
	//  other providers

	DevMarketer\LaraFlash\LaraFlashServiceProvider::class,
];
```

Then we want to define an alias in the same `config/app.php` file.

```
'aliases' => [
	// other aliases

	'LaraFlash' => DevMarketer\LaraFlash\LaraFlashFacade::class,
];
```

#### 3. Publish Config File

The config file allows you to override default settings of this package to meet your specific needs.

To generate a config file type this command into your terminal:

```
php artisan vendor:publish --tag=laraflash
```

## Usage

Using LaraFlash is easy. It extends the built in Laravel Session. Think about it as built-in, but with powerful new features.

### Adding Notifications to the Session

We can break usage into two parts. First is adding to the session and the second part is extracting from the session.

There are several ways you can choose to add to the LaraFlash session. First, you can use the `LaraFlash` facade.

```
use LaraFlash;

class PageController extends Controller
{
	public function save(Request $request)
	{
		$post = Post::create($request);

		// flash message to let user know it was successful
		LaraFlash::add('Successfully Saved Post');

		return redirect(route('index'));
	}
}
```

That is it. You can use several methods to add a new Flash message. First you can use the `add()` or `push()` methods and pass in a string of the message you want to send.

But this only scratches the surface of what LaraFlash can do. LaraFlash is powerful because it also stores more information than just the main message. By default it also stores a priority, a type, a title, and the main message. You can pass these other options in as an 	`$options` array in the second parameter.

```
LaraFlash::add('You Post was Successfully Saved', array('title' => 'Congratulations! ', 'priority' => 3, 'type' => 'success'));
```

Now you see why this is getting awesome. Later on you can access your advanced Flash message like a record from a database. For example `LaraFlash::first()->type;` or `LaraFlash::first()->priority;`. Cool, we will talk more about rendering out your messages later, but I wanted to show you why this is cool.

#### Supports Multiple Flash Notifications per Request

One of the main reasons I built this package was because I often find myself needing to add multiple messages to the session. With LaraFlash you can do that, without worrying about anything.

```
LaraFlash::add('Message1');
LaraFlash::add('Message2');
LaraFlash::add('Message3');
```

Now three messages can get shown to the user. Awesome!

But don't worry. As you will see later, displaying them to users is painless thanks to the fact that it is handled as a native Laravel Collection.

#### Laravel Fluent Builder

Laravel is a fluent beautiful framework, so you can build your Flash notifications in the same way. Here is the fluent chainable way to create a new LaraFlash message.

`LaraFlash::new()->content('Hello World')->title('Welcome')->type('info')->priority(5);`

Its getting even better right? So easy to read and still very powerful.

You can omit properties that you do not care about, and only set the ones that are important to you. There are also shortcuts depending on the type of message you are making.

```
LaraFlash::success('Congratulations, we did it');
LaraFlash::info('We are using cookies');
LaraFlash::warning('Something went wrong');
LaraFlash::danger('Something just blew up');
```

Of course you can also chain these and multiple messages can be added to the same LaraFlash collection per request.

#### Helper Function

Ok so you don't have enough cool ways to add Flash Notifications to the session. I will give you one more. The helper function is often extremely popular, because it is easy to write and easy to read.

```
flash('Something went wrong');
```

That's it! Super easy to work with. Just like with the `LaraFlash::add()` method, you can also pass in an array of `$options` if you want to declare other properties. Also, multiple flash messages all go to the same `LaraFlash` collections, so you can mix and match any of these techniques however you want.

```
flash('Something went wrong', array('title' => 'Oops! ', 'type' => 'danger', 'priority' => 5));
flash('We did it!');
flash('One small problem occurred', ['type' => 'warning']);
```

### Displaying Notifications from the Session

Of course setting notifications is easy, but at some point we need to display them to the users.

You have access to `LaraFlash` is any of your blade files. You can easily get all of your Flash objects with:

```
{{ LaraFlash::all() }} 	// All notifications
{{ LaraFlash::notifications() }}    // All notifications (same as all())
{{ LaraFlash::first() }}
{{ LaraFlash::last() }}
```

And you can loop through it like this:

```
@foreach (LaraFlash::notifications as $notification)
	<div class="alert alert-{{ $notification->type }}" role="alert">
		<h4>{{ $notification->title }}</h4>
		<p>{{ $notification->content }}</p>
	</div>
@endforeach
```

Super easy huh!

Future versions of this package will actually render out the messages for you, making it even easier. But all in due time.

#### Collections make life easy

Just like how I mentioned that LaraFlash extends the built-in Laravel session for storing its messages, it also extends the Laravel `collection()` for managing all of the messages.

Why is this important?

Because you can treat a `LaraFlash::all()` notification just like an Eloquent object returned from the database. You have access to all of the same methods like `->first()`, `->last()`, `->nth()`, `->where()`, `->sortBy()` and tons more. As of Laravel 5.5 there are 83 built in functions for collections that LaraFlash supports.

This means you not only have powerful data stored in your Notifications, but you can also manage, sort, re-order them, all using commands you are already familiar with, when working with your models. In fact, LaraFlash acts identical to a model or collection of records from the database.

Like I said, we just want to make Laravel flash messaging like it should be in Laravel.

Want to check out all 83 methods you can use on your LaraFlash objects? See the list of native collection methods here: https://laravel.com/docs/5.4/collections#available-methods

## Contribute

I encourage you to contribute to this package to improve it and make it better. Even if you don't feel comfortable with coding or submitting a pull-request (PR), you can still support it by submitting issues with bugs or requesting new features, or simply helping discuss existing issues to give us your opinion and shape the progress of this package.

[Read the full Contribution Guide](https://github.com/DevMarketer/LaraFlash/blob/master/CONTRIBUTING.md)

## Contact

I would love to hear from you. I run the DevMarketer channel on YouTube, where we discuss how to _"Build and Grow Your Next Great Idea"_ please subscribe and check out the videos.

I am always on Twitter, and it is a great way to communicate with me or follow me. [Check me out on Twitter](https://twitter.com/_jacurtis).

You can also email me at hello@jacurtis.com for any other requests.
