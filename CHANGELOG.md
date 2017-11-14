# LaraFlash Change Log

All features, bug fixes, and changes in the code base will be updated and documented here.

## Version 1: Official Release

##### 1.0.1 - 1.0.2

**Fixes:**

1. Removed Mockery and PHPUnit Dependencies. Should make life easier for most people.  _(v1.0.2)_
1. Tag added to config file to make it easier to publish. _(v1.0.1)_
1. Typo in `CONTRIBUTING.md` _(v1.0.1)_


##### 1.0.0

This update was focused on the core of LaraFlash package. This builds out the basic functions of LaraFlash and how it works. I rebuilt it to use collections() and a Notification object. It has many helpful functions and is compatible with all of the Laravel `Collections` functions.

This update includes the basic structure of the package, includes helper functions and the LaraFlash object that you can use to output flash messages to the users.

**New Features:***

1. Fluent Chainable Commands
	1. Start building a new LaraFlash object with the `LaraFlash::new()` command
	1. Now you can chain commands to customize it to your liking.
	1. `->content($content)`, `->title($title)`, `->priority(5)`, `->type($type)` all work.
	1. There are also shortcuts for the _type_ you can chain with: `->info()`, `->warning()`, `->success()`, `->danger()`
	1. It looks like this `LaraFlash::new()->title('Test: ')->content('Lorem Ipsum')->priority(10)->success();`
1. Shortcut methods with types allow for variable length parameters
	- `info()` - if you do not pass in parameters then it will treat it like a chainable command, like those shown above.
	- `LaraFlash::info(String $content | Array $options)` - one param will be treated as an `$options` array if an array is provided, or as the `$content` if a string is given
	- `LaraFlash::info(String $content, String $title | Array $options)` - two params given the first is assumed to be the content (must be string) and the second will either be treated as a title or an options array depending on type given.
	- `LaraFlash::info(String $content, String $title, Array $options)` - with three params given it is assumed that you are providing the content, the title, and then an options array in that order.
1. Publishable config file available with the `-tag=laraflash`
1. New Commands
	1. `clear()` to clear out all of the notifications from the LaraFlash object
	1. `first()` to get the first notification
	1. `last()` to get the last notification
	1. `keep()` to extend the flash session for another request
	1. `override($index)` to override the notification at that index with another notification
	1. `overrideLast()` to override the most recent notification with another notification
1. Every notification is now a `Notification` object. So the collection is a collection of Notification objects
	* public `title` - this allows you to add a title to a notification
	* public `message` - the main content of the notification
	* public `type` - this would be the type of notification such as _error_, _success_, _info_, or _general_
	* public `priority` - this is an arbitrary integer to indicate priority similar to how z-index css property is managed.


##### 0.1.1

**Improved:**

1. Improved documentation, especially the "usage" section

**Fixes:**

1. `DevMarketer\LaraFlash\LaraFlash::flash()` is now a protected function.

---

##### 0.1.0

This is the first stable release, although still tagged as beta for security reasons. This is the packages first initial release, feel free to download it, use it, and submit feedback.

**New Features:**

1. LaraFlash objects are now collection objects, enabling you to use any collection method you prefer, just like an eloquent model.
1. `LaraFlash` Facade available with several helpful methods
	1. `LaraFlash::notifications()` - This gives you the full LaraFlash notifications object. Great for use in your blade files.
	1. `LaraFlash::dump()` - An alias of `notifications()` method
	1. `LaraFlash::all()` - Gives you all of the notifications as an array, instead of as a `Collection()` object.
	1. `LaraFlash::add()` - The main method used to add a new notification to your LaraTrust object.
	1. `LaraFlash::push()` - An alias of `push()` method
1. Helper functions available for those used to other similar packages and/or don't want to use the facade
	1. `laraflash()` helper function available throughout your whole application. This performs the same function as `LaraFlash::add()` to add another notification to your LaraFlash object
	1. `flash()` is an alias of `laraflash()`. Use whichever you prefer.

**Fixes:**

1. Minimum stability for composer changed to "dev" to allow you to use the project in its beta form, in beta projects
1. Autoloading works properly now
1.
