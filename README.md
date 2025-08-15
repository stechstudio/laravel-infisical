<img width="1492" height="676" alt="infisical-banner" src="https://github.com/user-attachments/assets/90534b28-65ff-4376-87fc-679d04161de3" />

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stechstudio/laravel-infisical.svg?style=flat-square)](https://packagist.org/packages/stechstudio/laravel-infisical)

[Infisical](https://infisical.com/) is an all-in-one platform to securely manage application secrets and share them with your team. This package integrates Infisical with Laravel, exporting secrets as environment variables.

- Leverages the [Infisical CLI](https://docs.infisical.com/cli/installation) to fetch and export secrets.
- Merges secrets onto your base `.env` file (optional).
- Provides an Artisan command to update secrets via CI/CD pipelines or composer `post-install-cmd` scripts.

## Instructions

### 1. Set up Infisical

- Set up an Infisical account if you haven't already. Create a project with secrets.
- Install the Infisical CLI tool on your device by following the instructions at [Infisical CLI Installation](https://docs.infisical.com/cli/installation).

### 2. Authenticate and configure your project

You can authenticate and configure your project in one of two ways:

- **Login with identity**:

  Run [`infisical login`](https://infisical.com/docs/cli/commands/login) to authenticate with a user identity or a machine identity. 

  Then run [`infisical init`](https://infisical.com/docs/cli/commands/init) to select the project and generate the `.infisical.json` file. We recommend committing this file to your repository.


- **Use a service token**:

  Create a Service Token scoped for your designed environment.

  Copy your specific Project ID from your Infisical settings page.

    Set the following environment variables in your base `.env` file:
    
     ```dotenv
     INFISICAL_PROJECT_ID=your-project-id
     INFISICAL_TOKEN=your-service-token
     ```

### 3. Install this package

You know the drill:

```bash
composer require stechstudio/laravel-infisical
```

### 4. Specify your environment

Infisical needs to know which environment to pull secrets from. You can do this one of three ways:

- **Environment Variable**: Set the `INFISICAL_ENVIRONMENT` environment variable in a base `.env` file to the desired environment slug. 

   ```dotenv
   INFISICAL_ENVIRONMENT=prod
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

### 5. Run the command (manually or automatically)

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

### 6. Profit!

You should see "Environment [prod] variables merged successfully". If you look at your `.env` file you should see that all the secrets from Infisical have been added to it.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
