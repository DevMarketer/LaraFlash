# LaraFlash Change Log

All features, bug fixes, and changes in the code base will be updated and documented here.

##### 0.1.1 [beta]

**Improved:**

1. Improved documentation, especially the "usage" section

**Fixes:**

1. `DevMarketer\LaraFlash\LaraFlash::flash()` is now a protected function.

---

##### 0.1.0 [beta]

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
