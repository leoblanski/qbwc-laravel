# QBWC Laravel

**QBWC Laravel** is a Laravel-flavored QuickBooks Web Connector package that facilitates communication with QuickBooks Desktop through SOAP services.

## Installation

To install the package, run:

```bash
composer require aarongrtech/qbwc-laravel
```

Ensure that your `composer.json` includes the necessary autoload settings:

```json
"autoload": {
    "psr-4": {
        "AaronGRTech\\QbwcLaravel\\": "./src/AaronGRTech/QbwcLaravel"
    }
},
"extra": {
    "laravel": {
        "providers": [
            "AaronGRTech\\QbwcLaravel\\Providers\\SoapServiceProvider"
        ]
    }
}
```

After updating Composer, add the service provider to the `config/app.php` file:

```php
'providers' => [
    // Other Service Providers

    AaronGRTech\QbwcLaravel\Providers\SoapServiceProvider::class,
],
```

## Usage

### Setting Up WSDL File

Ensure that the WSDL file is available at `storage_path('app/wsdl/QBWebConnectorSvc.wsdl')`. You can publish the WSDL file to the storage directory using:

```bash
php artisan vendor:publish --provider="AaronGRTech\QbwcLaravel\Providers\SoapServiceProvider"
```

### Routes

This package provides routes to handle SOAP requests. These routes are automatically registered by the `SoapServiceProvider`.

### Controller

The `SoapController` handles various SOAP requests:

- **Server Version**
  - Route: `/soap/serverVersion`
  - Method: `serverVersion`
  - Request: `POST`

- **Client Version**
  - Route: `/soap/clientVersion`
  - Method: `clientVersion`
  - Request: `POST`

- **Authenticate**
  - Route: `/soap/authenticate`
  - Method: `authenticate`
  - Request: `POST`

- **Send Request XML**
  - Route: `/soap/sendRequestXML`
  - Method: `sendRequestXML`
  - Request: `POST`

- **Receive Response XML**
  - Route: `/soap/receiveResponseXML`
  - Method: `receiveResponseXML`
  - Request: `POST`

### Example

Here is an example of how to use the `Authenticate` service:

```php
use AaronGRTech\QbwcLaravel\ServiceType\Authenticate;
use AaronGRTech\QbwcLaravel\StructType\Authenticate as AuthenticateStruct;
use AaronGRTech\QbwcLaravel\StructType\AuthenticateResponse;

$options = [
    \WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_URL => storage_path('app/wsdl/QBWebConnectorSvc.wsdl'),
    \WsdlToPhp\PackageBase\AbstractSoapClientBase::WSDL_CLASSMAP => \AaronGRTech\QbwcLaravel\ClassMap::get(),
];

$service = new Authenticate($options);
$parameters = new AuthenticateStruct('username', 'password');
$response = $service->authenticate($parameters);

if ($response instanceof AuthenticateResponse) {
    // Handle the response
} else {
    // Handle the error
}
```
## Post-Installation Steps

After installing this package, please update your application's `composer.json` file to autoload the callbacks:

```json
{
    "autoload": {
        "psr-4": {
            "App\\Callbacks\\": "app/Callbacks/"
        }
    }
}

## Requirements

- PHP >= 7.4
- Laravel framework
- Extensions: `ext-dom`, `ext-mbstring`, `ext-soap`
- Dependency: `wsdltophp/packagebase` ~5.0

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

## Authors

- AaronGRTech - [aaron@goldenruleweb.com](mailto:aaron@goldenruleweb.com)

## Contributing

Please read the [CONTRIBUTING](CONTRIBUTING.md) file for details on our code of conduct, and the process for submitting pull requests.
