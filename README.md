# **Semaphore**
### Versioned routes for Laravel's API resources

### **Installation**
Require this package with composer:

    composer require kirillsimin/semaphore

Laravel 5.5+ uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

If you want to use the facade in your routes, add this to your facades in app.php:

`'VersionedRoute' => Kirillsimin\Semaphore\VersionedRoute::class,`

#### **Laravel 5.5+:**

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

`KirillSimin\Semaphore\ServiceProvider::class,`

Copy the package config to your local config with the publish command:

`php artisan vendor:publish --provider="Kirillsimin\Semaphore"`

### **Usage**

1. Create the default version of your API resource controller from an existing one:
- Create a folder with the name of the API resource controller you want to version. For example, if you are versioning `app/Http/Controllers/PhotosController.php`, create this folder: `app/Http/Controllers/PhotosController/`.
- Rename `PhotosController.php` into `PhotosController_v0.php`
- Change the class name to `PhotosController_v0`
- Update the namespace and include the base controller (`use App\Http\Controllers\Controller;`).

2. Create the next version:

- Create `PhotosController_v1.php` in the same folder
- Call the class `PhotosController_v1` and make sure it `extends PhotosController_v0`
- Overwrite any methods you wish to update. All other methods will be called from the previous version.

3. Update your routes file.

- In your routes/api.php, either include the package at the top (`use KirillSimin\Semaphore\VersionedRoute`), or use an alias in your `app.php`
- Replace `Route::apiResource('photos', 'PhotosController');` with `VersionedRoute::apiResource('photos', 'PhotosController')`

4. Make the call to the correct controller:

- The route accepts a custom `controller-version` header. If you do not pass it, it will default to `_v0`. If you pass a number, it will attempt to locate the correct version of the controller.
