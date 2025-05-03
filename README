# Resellme PHP SDK

The Resellme PHP SDK provides an easy-to-use interface for interacting with the Resellme API. It allows resellers to manage domains, hosting, VPS, nameservers, and contacts programmatically.

---

## Features

- **Domain Management**: Search, register, transfer, and renew domains.
- **Hosting Management**: Create, provision, suspend, unsuspend, update, and terminate hosting accounts.
- **VPS Management**: Create and manage VPS instances.
- **Nameserver Management**: List, update, add, and delete nameservers.
- **Contact Management**: Create, update, and retrieve domain contacts.
- **Centralized Request Handling**: All API requests are handled through a centralized `RequestHandler` for consistency and error handling.

---

## Installation

Install the SDK via Composer:

```bash
composer require resellme/rm-php-sdk
```

---

## Usage

### Initialize the Client

```php
require 'vendor/autoload.php';

use Resellme\Client;

$client = new Client('your-api-token');
```

---

### Domain Management

#### Search for a Domain
```php
$domain = $client->domain()->search('example.com');
```

#### Register a Domain
```php
$response = $client->domain()->register([
    'domain' => 'example.com',
    'years' => 1,
    'contact_id' => 'contact-id',
]);
```

#### Transfer a Domain
```php
$response = $client->domain()->transfer([
    'domain' => 'example.com',
    'auth_code' => 'auth-code',
    'contact_id' => 'contact-id',
]);
```

#### Renew a Domain
```php
$response = $client->domain()->renew('domain-id', [
    'years' => 1,
]);
```

---

### Hosting Management

#### Create a Hosting Account
```php
$response = $client->hosting()->create([
    'domain' => 'example.com',
    'plan' => 'basic',
]);
```

#### List Hosting Accounts
```php
$hostings = $client->hosting()->list();
```

#### Get Hosting Details
```php
$hosting = $client->hosting()->get('hosting-id');
```

#### Update a Hosting Account
```php
$response = $client->hosting()->update('hosting-id', [
    'plan' => 'premium',
]);
```

#### Suspend a Hosting Account
```php
$response = $client->hosting()->suspend('hosting-id');
```

#### Unsuspend a Hosting Account
```php
$response = $client->hosting()->unsuspend('hosting-id');
```

#### Terminate a Hosting Account
```php
$response = $client->hosting()->terminate('hosting-id');
```

---

### VPS Management

#### Create a VPS
```php
$response = $client->vps()->create([
    'package_id' => 1,
    'hostname' => 'vps.example.com',
]);
```

#### Manage a VPS
```php
$response = $client->vps()->manage('vps-id', 'reboot');
```

---

### Nameserver Management

#### List Nameservers
```php
$nameservers = $client->nameserver()->list('domain-id');
```

#### Update Nameservers
```php
$response = $client->nameserver()->update('domain-id', [
    'ns1.example.com',
    'ns2.example.com',
]);
```

#### Add a Nameserver
```php
$response = $client->nameserver()->add('domain-id', 'ns3.example.com');
```

#### Delete a Nameserver
```php
$response = $client->nameserver()->delete('domain-id', 'ns3.example.com');
```

---

### Contact Management

#### Create a Contact
```php
$response = $client->contact()->create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'phone' => '+1234567890',
    'address' => '123 Main St',
    'city' => 'Example City',
    'country' => 'US',
]);
```

#### Update a Contact
```php
$response = $client->contact()->update('contact-id', [
    'email' => 'new.email@example.com',
]);
```

#### Get Contact Details
```php
$contact = $client->contact()->get('contact-id');
```

---

## Error Handling

The SDK throws exceptions for API errors. You can catch and handle these exceptions as follows:

```php
use Resellme\Exceptions\ApiException;
use Resellme\Exceptions\ServerException;

try {
    $domain = $client->domain()->search('example.com');
} catch (ApiException $e) {
    echo "API Error: " . $e->getMessage();
} catch (ServerException $e) {
    echo "Server Error: " . $e->getMessage();
} catch (\Exception $e) {
    echo "Unexpected Error: " . $e->getMessage();
}
```

---

## Testing

Run unit tests using PHPUnit:

```bash
vendor/bin/phpunit
```

---

## Contributing

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Submit a pull request with a detailed description of your changes.

---

## License

This SDK is licensed under the MIT License. See the `LICENSE` file for details.