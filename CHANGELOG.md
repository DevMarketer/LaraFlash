# LaraFlash Change Log

All features, bug fixes, and changes in the code base will be updated and documented here.

## Version 1: Official Release

##### 1.3.0

**New Features:**

1. New Helper Method: `LaraFlash::snackbar('Hello World')` will work just like the other type methods `LaraFlash::success('Success!')` and `LaraFlash::danger()` and so forth, but it will set the type to be `"snackbar"`. This is helpful for those that prefer the snackbar message type.
1. New Method: `LaraFlash::allByPriority($order = 'desc')`. This method will sort all of the notifications in the current session by priority as defined by the priority attribute. The priority attribute is an arbitrary numeric attribute you can set however you wish. This can be set by passing in `priority` into an options object when creating a notification or using the `->priority(10)` fluent syntax. So `LaraFlash::success('Hello World')->priority(10)` creates a success notification with the _"hello world"_ message and a priority of 10. Each notification is given a priority even if ommitted. This default priority can be set in the configuration file (but is 5 by default). The new `LaraFlash::allByPriority('asc')` method will sort all notifications by this priority attribute. Options for sorting is either "ascending" (`asc`) meaning lowest priority value (by int value) will be first, up to the highest. The default of "descending" (`desc`) will sort from highest priority to lowest. Within a tie (multiple notifications with the same priority value) will be ordered by the order they were flashed to the session. The first notification with that tied priority value that was flashed will be the first to display once that priority value is reached in the sorting (higher and lower values will still sort around it as expected and order it was flashed only accounts for ordering notificiations that share the same priority value).
1. New Method: `LaraFlash::allByType($order='desc', $sortOthersLast = true)`. This method is great for displaying all notifications sorted by type. You may choose the order it is sorted in by passing in an argument. Accepted arguments are either `asc` for ascending, `desc` for descending (the default), or an array representing the order you want them sorted. By default notifications will be sorted _danger, warning, info, success_ which is represented by the `desc` order argument. Supplying instead `asc` will reverse the above order moving from success to danger. Also passing in an array will customize this order. An example array might look like: `["info", "danger", "success"]`. A second argument is optional and will dictate how non-matching types are sorted. By default they will be added to the end after other types have been sorted. But passing in a `false` value in this argument will force any type other than those in the `$order` array to display first, followed by the other notifications sorted by the selected `$order`. A type of `"others"` can be added to the `$order` array to customize where non-matching types are sorted. So `["success", "others", "danger"]` will sort all "success" notifications first, all non-danger notifications second, followed finally by "danger" notifications last. As with the _allByPriority()_ method explained above, in the case of a tie (multiple of the same type) the sorted order within that type will be determined by the first notification to be flashed to the session, followed by the next one, and so forth. All other sorting outside of that type will be honored.

**Fixes:**

1. The `keep()` method is now a `public` function so it can be called from Views or Controllers if you wish to keep the _laraflash_ notifications for another session.  
You can simply call `LaraFlash::keep()` to keep any _LaraFlash_ notifications for another session. However, you can also pass in an array of session keys if you want to keep other session values in addition to those managed by _LaraFlash_.

##### 1.2.0

**New Features:**

1. New Method `LaraFlash::allByPriority()` allows you to get all notifications sorted by priority. By default it will sort from highest priority to lowest priority (descending or `desc`). But you can also pass in `asc` to sort in ascending order or from lowest to highest priority.

##### 1.1.0

**New Features:**

1. New Method `LaraFlash::exists()` returns `TRUE` if 1 or more notifications exist in the current session and `FALSE` if there are no notifications in the session.
1. New Method `LaraFlash::count()` returns an `Integer` of how many notifications are in the current session. Will return 0 if none exist.

**Fixed:**

1. Resolves `LaraFlash::all()` bug where it would return `null` if no notifications exist. It now returns an empty array if no notifications exist in the session. This makes more sense since if notifications exists it will return an array of all the notification objects. Now you can always expect an array to be returned. Use `LaraFlash::dump()` or `LaraFlash::notifications()` which will return the array object if exists or `null` if empty. This will give the same effect as the previous `LaraFlash::all()` method previously did.

##### 1.0.1 - 1.0.2

**Fixed:**

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
