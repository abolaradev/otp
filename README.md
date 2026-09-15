# Package Skeleton Laravel Livewire

This repository is a customized Laravel package skeleton based on the excellent [Spatie Laravel Package Skeleton](https://github.com/spatie/package-skeleton-laravel).

It is designed to provide a convenient starting point for developing Laravel packages, with additional support and tooling for Livewire, Blade components, and Workbench.

> This is a customized version of Spatie's Laravel Package Skeleton with additional features and development tools.

## Customizations

This skeleton keeps the original structure and workflow of Spatie's package skeleton while adding several features specifically for Laravel package development.

### What's Included

* **Package Routes**
  Added support for defining and loading package routes.

* **Livewire Support**
  Added Livewire as a package dependency and registered a dedicated Livewire view namespace.

* **Blade Component Support**
  Added Blade component namespace registration for package view-based components.

* **Customized `SkeletonServiceProvider`**
  Rewritten and extended the package service provider to handle package routes, views, Livewire components, Blade components, publishing, and other package-specific functionality.

* **Workbench Integration**
  Added a Workbench environment for developing and testing the package inside a Laravel application.

* **`abolaradev` CLI**
  Added a custom CLI helper that acts as an alias for `vendor/bin/testbench`, making it easier to run Artisan commands inside the Workbench.

* **Package Component Scaffolding**
  Added custom commands for generating Livewire components, Livewire layouts, and view-based Blade components directly inside the package.

* **Workbench Component Scaffolding**
  Added support for creating package components directly inside the Workbench by using the `--workbench` or `-w` option.

* **Documentation Directory**
  Added the `make:docs` command for creating a `docs` directory in the package root. This directory can be used to store screenshots and other package documentation.

* **Automatic README Generation**
  Added support for generating the final package `README.md` from `README_PACKAGE.md` during the configuration process.

* **Package Assets**
  Added support for creating, linking, generating Tailwind scripts, and publishing package assets.

* **Helper Functions**
  Added support for easily creating and registering package helper functions.

The goal is to provide a package skeleton that preserves the simplicity of the original Spatie template while offering a more convenient development workflow for packages that use Livewire and Blade components.

## Getting Started

Follow these steps to create a new Laravel package using this skeleton.

### 1. Create a new repository

Click the "Use this template" button at the top of this repository.

Then select "Create a new repository" and create a new repository for your package.

### 2. Clone the repository

Clone the newly created repository to your local machine:

```bash
git clone https://github.com/your-username/your-package.git
```

Then navigate into the package directory:

```bash
cd your-package
```

### 3. Configure the package

Run the configuration script:

```bash
php configure.php
```

The script will ask for the required information and replace the placeholders throughout the package.

To see all available options:

```bash
php configure.php --help
```

### 4. Start creating your package

That's it! Your package is now ready for development.

Have fun creating your Laravel package. 🚀

## Workbench

This skeleton includes a Workbench environment for developing and testing your package inside a Laravel application.

To start the Workbench development environment, run:

```bash
composer run serve
```

This command builds the Workbench environment and starts the Laravel development server.

### `abolaradev`

The `abolaradev` command acts as an alias for `vendor/bin/testbench`.

Instead of running:

```bash
vendor/bin/testbench make:model User
```

you can simply use:

```bash
php abolaradev make:model User
```

This allows you to run Testbench and Laravel Artisan commands inside the Workbench environment and create files such as models, migrations, factories, seeders, commands, and other supported Laravel files.

> **Note:** Commands executed through `abolaradev` create files inside the Workbench environment.

### Creating Components

This skeleton provides custom commands for generating Livewire components, Livewire layouts, and Blade components.

By default, these commands create the components inside the package.

You can also create these components directly inside the Workbench by adding the `--workbench` or `-w` option.

### Livewire Components

Create a Livewire component with:

```bash
php abolaradev make:livewire test
```

To create the component inside the Workbench:

```bash
php abolaradev make:livewire test -w
```

### Livewire Layouts

Create a Livewire layout with:

```bash
php abolaradev livewire:layout admin
```

To create the layout inside the Workbench:

```bash
php abolaradev livewire:layout admin -w
```

### Blade Components

Create a view-based Blade component with:

```bash
php abolaradev make:component test
```

To create the component inside the Workbench:

```bash
php abolaradev make:component test -w
```

## Documentation

The skeleton provides a dedicated `docs` directory for storing package documentation.

To create the documentation directory in the package root, run:

```bash
php abolaradev make:docs
```

The command creates:

```text
docs/
```

You can use this directory to store screenshots, images, examples, and other documentation related to your package.

For example:

```text
docs/
├── screenshots/
├── examples/
└── ...
```

## Helper Functions

With this feature, you can easily create and register Helper Functions for your package.

To create a helper file, simply run:

```bash
php abolaradev make:helper
```

The command creates the helper file at:

```text
src/helpers/helpers.php
```

Normally, after creating the helper file, you need to register it in the `autoload.files` section of your `composer.json`:

```json
"autoload": {
    "files": [
        "src/helpers/helpers.php"
    ]
}
```

Then, you need to regenerate the Composer autoloader:

```bash
composer dump-autoload
```

> You don't need to perform these steps manually!

The `make:helper` command automatically handles the entire process:

1. Creates the `src/helpers/helpers.php` file.
2. Registers the helper file in the `autoload.files` section of `composer.json`.
3. Regenerates the Composer autoloader.

As a result, the helper functions defined in `src/helpers/helpers.php` will be automatically available throughout your package.

## Assets

Packages may require different types of assets such as CSS, JavaScript, images, and fonts. This skeleton provides a simple way to create, manage, access, and publish package assets during development and after installation.

### Creating Package Assets

Before creating the package assets, you need to create the package helper file:

```bash
php abolaradev make:helper
```

Then, create the package asset directories by running:

```bash
php abolaradev make:assets
```

This command creates the following directory structure inside `resources/dist`:

```text
resources/
└── dist/
    ├── css/
    ├── js/
    ├── images/
    └── font/
```

Each directory is intended for a specific type of package asset.

If your package does not require some of these asset types, you can exclude them using the `--except` option.

For example, to exclude images:

```bash
php abolaradev make:assets --except=images
```

You can exclude multiple asset types by separating them with commas:

```bash
php abolaradev make:assets --except=images,font
```

### `package_asset()` Helper

When `make:assets` is executed, it also automatically adds a `package_asset()` helper function to:

```text
src/helpers/helpers.php
```

This helper is used to generate the appropriate URL for package assets.

Therefore, the helper file must exist before running `make:assets`. If you have not created it yet, run:

```bash
php abolaradev make:helper
```

### Tailwind CSS

The skeleton provides a command for generating the Tailwind CSS script used by package assets.

Run:

```bash
php abolaradev assets:tailwind
```

This command creates the Tailwind script at:

```text
resources/dist/js/tailwind.js
```

You can then load Tailwind CSS inside your package component views using the `package_asset()` helper:

```html
<script src="{{ package_asset('js/tailwind.js') }}"></script>
```

This allows package components developed inside the Workbench to use Tailwind CSS without requiring the Tailwind script to be created manually.

### Accessing Assets in the Workbench

Package assets stored in `resources/dist` cannot be accessed directly from package views through a browser because `resources` is not the public directory.

To solve this during development, the skeleton provides an asset linking mechanism.

#### 1. Link Package Assets

Run:

```bash
php abolaradev assets:link
```

This creates a link inside the Workbench public directory so that the package assets from:

```text
resources/dist
```

are available through:

```text
workbench/public/
```

This allows changes made to the package assets to be reflected in the Workbench without manually copying the files.

#### 2. Serve Assets Through the Workbench

Because these assets are intended for package development, the Workbench automatically provides an `assets/{path}` route.

The route resolves the requested asset from the Workbench public directory and returns it with the appropriate MIME type.

For example:

```php
public function boot(): void
{
    Route::get('assets/{path}', function (string $path) {
        $assetUrl = workbench_path("public\\$path");

        $mimeTypes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'json'   => 'application/json',
            'svg'    => 'image/svg+xml',
            'png'    => 'image/png',
            'jpg'    => 'image/jpeg',
            'jpeg'   => 'image/jpeg',
            'webp'   => 'image/webp',
            'woff'   => 'font/woff',
            'woff2'  => 'font/woff2',
        ];

        $extension = pathinfo($assetUrl, PATHINFO_EXTENSION);

        return is_file($assetUrl)
            ? response()->file($assetUrl, [
                'Content-Type' => $mimeTypes[$extension],
            ])
            : abort(404);
    })->where('path', '.*');
}
```

This route is intended for the Workbench development environment and is not required when the package is installed in a real Laravel application.

### Using `package_asset()`

Once the assets have been linked and the Workbench asset route is available, you can access package assets from your package views using the `package_asset()` helper:

```html
<script src="{{ package_asset('js/script.js') }}"></script>
```

For example:

```html
<link rel="stylesheet" href="{{ package_asset('css/app.css') }}">

<script src="{{ package_asset('js/script.js') }}"></script>

<img src="{{ package_asset('images/logo.png') }}" alt="Logo">
```

The helper generates the appropriate asset URL for the current environment.

### Publishing Assets

When your package is installed in a Laravel application, its assets must first be published to the application's public directory.

For example, if the package uses the `skeleton-assets` publish tag:

```bash
php artisan vendor:publish --tag=skeleton-assets
```

The assets will be published to:

```text
public/vendor/skeleton/
```

After publishing, `package_asset()` can resolve the package assets from the application's public directory.

This means the same helper can be used in both environments:

```text
Workbench
    ↓
workbench/public/

Installed Package
    ↓
public/vendor/skeleton/
```

Therefore, package views do not need to know whether the package is running inside the Workbench or inside a real Laravel application.

## Installation

You can install the package via Composer:

```bash
composer require :vendor_slug/:package_slug
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag=":package_slug-migrations"
```

Then run the migrations:

```bash
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=":package_slug-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag=":package_slug-views"
```

## Usage

```php
$variable = new VendorName\Skeleton();

echo $variable->echoPhrase('Hello, VendorName!');
```

## Testing

Run the test suite with:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) for information on how to report security vulnerabilities.

## Credits

* [Abolaradev](https://github.com/abolaradev)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
