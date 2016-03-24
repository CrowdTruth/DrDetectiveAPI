# DrDetectiveAPI
API for communication between [Dr. Detective](https://github.com/CrowdTruth/DrDetective) and [CrowdTruth](https://github.com/CrowdTruth/CrowdTruth).

## Package installation
The API is available as a plugin for CrowdTruth, which can be installed via [Packagist](https://packagist.org/packages/crowdtruth/ddgameapi). To install the API in CrowdTruth, edit your *composer.json* file to include *crowdtruth/ddgameapi*:

```
{
  "name": "laravel/laravel",
  "description": "The Laravel Framework.",
  ...
  "require": {
    ...
    "crowdtruth/ddgameapi": "*",
    ...
  },
  ...
}

```

Use composer to install the package:

```
[CrowdTruth]$ composer update
```

Add the *DDGameapiServiceProvider* to the list of providers in your *app/config/app.php* file:

```
...
'providers' => array(
  ...
  'CrowdTruth\DDGameapi\DDGameapiServiceProvider',
  ...
),
...
```

Run the package migrations to add the required software components to the CrowdTruth database:

```
[CrowdTruth]$ php artisan db:seed --class="CrowdTruth\DDGameapi\DDGameAPISeeder"
```

Next, package needs to be configured to communicate with the Dr. Detective game. For this, you must first export the configuration file:

```
[CrowdTruth]$ php artisan config:publish crowdtruth/ddgameapi
```

and afterwards edit the URL field on the configuration file *app/config/packages/crowdtruth/ddgameapi/config.php*:

```
return array(
	'URL' => 'http://<your-game-url>/admin-games/api',
);
```

set the URL to the location where your game instance is installed, for example *http://localhost:8080/admin-games/api*.

Last but not least, go to the instructions for configuring this API specific to your game instance. For example https://github.com/CrowdTruth/BioCrowd/wiki/Configurations-for-using-the-DrDetectiveAPI

If everything went well, the API has been succesfully installed.

## API description

The API enables a webhook on the following URL: *http://\<your-CrowdTruth-instance\>/game/detective/*. This webhook is called from Dr. Detective to send judgments to CrowdTruth. API requests must contain 3 elements (in a JSON structure)

 - *signal* -- Signal to be processed. 'new_judgments' for new judgments
 - *payload* -- a JSON structure with the judgments
 - *signature* -- SHA1(payload + API_KEY)

Example:
```
{
  "signal": "new_judgments",
  "payload": [
    {
      ...
    },
  ],
  "signature": "f04d10c"
}
```

The response to such call is also a JSON structure containing:
 - *signal* -- Signal received
 - *status* -- Return status (ok or error)
 - *message* -- Message with additional information.

```
{
  "signal": "new_judgments",
  "status": "ok",
  "message": "1 processed"
}
```
