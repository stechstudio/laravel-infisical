# Laravel Infisical Secrets

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stechstudio/laravel-infisical.svg?style=flat-square)](https://packagist.org/packages/stechstudio/laravel-infisical)

[Infisical](https://infisical.com/)  helps you securely manage application secrets and share them with your team. This package integrates Infisical with Laravel, exporting secrets as environment variables.

- Leverages the [Infisical CLI](https://docs.infisical.com/cli/installation) to fetch and export secrets.
- Merges secrets onto your base `.env` file (optional).
- Provides an Artisan command to update secrets via CI/CD pipelines or composer `post-install-cmd` scripts.

## Instructions

### 1. Set up Infisical

This assumes you have a working Infisical account and have created a project with secrets.

1. Install the Infisical CLI tool on your device by following the instructions at [Infisical CLI Installation](https://docs.infisical.com/cli/installation).
2. Run `infisical login` to authenticate your CLI with your Infisical account.
3. Run `infisical init` to select the project and generate the `.infisical.json` file. We recommend committing this file to your repository.

### 2. Install this package

You know the drill:

```bash
composer require stechstudio/laravel-infisical
```

### 3. Specify your environment

Infisical needs to know which environment to pull secrets from. You can do this one of three ways:

- **Environment Variable**: Set the `INFISICAL_ENV` environment variable in a base `.env` file to the desired environment slug. 

   ```dotenv
   INFISICAL_ENV=prod
   ```
- **CLI Argument**: Pass the `--env` option when running the Artisan command.

   ```bash
   php artisan infisical:merge --env=prod
   ```

- **Custom Resolver**: If you want to dynamically resolve the environment slug, provide a callback in your application service provider.

    ```php
    use STS\LaravelInfisical\Facades\Infisical;
    
    Infisical::resolveEnvironmentUsing(function () {
         return 'prod'; // Replace with your logic to determine the environment slug
    });
    ```

> [!IMPORTANT]  
> You must provide the _slug_ of an existing environment. See your project Settings > Secrets Management page to view all your environments and slugs.

### 4. Run the command (manually or automatically)

You can run the command manually to merge secrets into your `.env` file, or add it to your deployment scripts.

```bash
php artisan infisical:merge
```

You can also add this to the `scripts` section of your `composer.json` file. This will automatically merge secrets from Infisical into your `.env` file after every composer install or update.

```json
"post-install-cmd": [
    "@php artisan infisical:merge"
],
```

### 5. Profit!

You should see "Environment [prod] variables merged successfully". If you look at your `.env` file you should see that all the secrets from Infisical have been added to it.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
