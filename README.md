# Software Engineer - getresi.com - filamentphp/laravel demo

Demo site created for <https://getresi.bamboohr.com/careers/40>

Current Live Site for Development: <https://getresi-filamentphp-demo-development-mgx1sn.laravel.cloud/>

## Getting Started On Local

1. Clone to your machine
2. Run `composer setup` (see: <https://getcomposer.org/download/>)
3. Running Server
    1. Run `./vendor/bin/sail up` or `./vendor/bin/sail up -d`
        - Make sure you have a Docker environment set up like Orbstack (see: <https://orbstack.dev/download>)
        - Sail scripts can be run using `composer sail` as well
    2. Alternatively, run `composer dev` to enable hot reload of views whenever a file is changed on 127.0.0.1:{port,default:8000}

## Composer Scripts

```bash
composer setup # Initial setup for repository

composer dev # Run local server w/ Vite hot reload

composer ide # Create/update laravel-ide-helper files

composer lint # Format backend and frontend files

composer test # Run Pest tests

composer sail # Run sail commands (e.g., composer sail up -d)
```

## Potential Problems

> I'm having issues with committing on Git.

Run `composer update` to trigger `whisky update`. That should refresh your Git hooks. If you've installed a fresh project, make sure to run `composer setup` before doing anything else.

## REST API

Login to an account with necessary personal access tokens permissions (super_admin role should have it). Create a personal access token and copy the result in the subsequent notification. The access token should be sent with the request as part of Bearer token authentication.

In your client of choice (e.g., curl, Postman), you can call the following endpoints:

- `GET /api/properties` - Get a paginated list of all properties (use 'page' and 'perPage' query params to control the content of the response)
- `GET /api/properties/{id}` - Get a specific property via id
- `POST /api/properties` - Create a new property using the following fields: name, owner_email (the email of a user you want to assign as owner of the property), type (see: [PropertyTypeEnum](app/Enum/PropertyTypeEnum.php) for list of options)
- `DELETE /api/properties/{id}` - Delete a specific property via id
