parITech Advanced Form Bundle
================================

Powerful Symfony form components

## Prerequisites

This bundle requires Symfony 6.0 and jQuery.

## Installation

### Step 1: Install PartitechAdvancedFormBundle

The best way to install this bundle is to rely on [Composer](https://getcomposer.org/):

```bash
$ composer require partitech/advanced-form-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel

```php
<?php
// config/bundles.php

return [
    // ...
    Partitech\AdvancedFormBundle\PartitechAdvancedFormBundle::class => ['all' => true],
];
```

### Step 3: Configure the bundle

Import the routing in `config/routes.yml`

```yaml
Partitech_advanced_form:
    resource: "@PartitechAdvancedFormBundle/Resources/config/routing/all.yml"
```

### Step 4: Publish assets

You may use Webpack to import the JavaScript files or use the `assets` command.

```bash
$ php bin/console assets:install --symlink public
```

## Next steps

### Ajax uploader

[Create a single file upload form](Resources/doc/single_file_upload.md)

[Use the temporary upload mode](Resources/doc/temporary_upload.md)

[Multiple files upload form](Resources/doc/multiple_files_upload.md)

[Options overview](Resources/doc/options_overview.md)

### Dependent entity form type

[Overview](Resources/doc/dependent_entity.md)
