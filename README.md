> **Warning**
> We have decided to stop maintaining this package.
> 
> Consider migrating to [ZteF](https://github.com/walangkaji/ztef).
>
> Feel free to fork our code and adapt it to your needs.

# ZTE F670 UNOFFICIAL API

Library ini merupakan **Emboh**. TITIK

# Support me
- ![Paypal](https://raw.githubusercontent.com/walangkaji/emboh/master/img/paypal.png) Paypal: [Se-Ikhlasnya Saja](https://www.paypal.me/walangkaji)


## Install
#### Composer
```sh
$ composer require walangkaji/zte-f670-api
```
#### Clone
```sh
$ git clone https://github.com/walangkaji/zte-f670-api.git
$ cd zte-f670-api/
$ composer install
```

## Cara Pakai
```php
require 'vendor/autoload.php';

use walangkaji\ZteF670\ZteF670;

$ipModem  = '192.168.1.1';
$username = 'admin';
$password = 'password';
$debug    = false;

$zteF670  = new ZteF670($ipModem, $username, $password, $debug);
$login    = $zteF670->login();

var_dump($login);
// Terusno dewe

```
Jika pengen menggunakan proxy:
```php
$ipModem  = '192.168.1.1';
$username = 'admin';
$password = 'password';
$debug    = false;
$proxy    = 'xxx.xxx.xxx.xxx:xxxx'

$zteF670  = new ZteF670($ipModem, $username, $password, $debug, $proxy);
$login    = $zteF670->login();

var_dump($login);
// Terusno dewe

```

### Contoh Untuk Reboot / Restart modem

```php
$zteF670  = new ZteF670($ipModem, $username, $password);
$login    = $zteF670->login();

if (!$login) {
    echo 'Login gagal' . PHP_EOL;
    exit();
}

$reboot = $zteF670->reboot();
if ($reboot) {
    echo 'Berhasil reboot modem.' . PHP_EOL;
}
```
### Contoh Untuk Get Device Information

```php
$zteF670  = new ZteF670($ipModem, $username, $password);
$login    = $zteF670->login();
$info     = $zteF670->status->deviceInformation();

var_dump($info);
```
### Contoh Untuk Pon Information

```php
$zteF670  = new ZteF670($ipModem, $username, $password);
$login    = $zteF670->login();
$info     = $zteF670->status->NetworkInterface->ponInformation();

var_dump($info);
```

## Available Methods
```php
$zteF670->login();
$zteF670->reboot();
$zteF670->status->deviceInformation();
$zteF670->status->voIpStatus();
$zteF670->status->NetworkInterface->wanConnection();
$zteF670->status->NetworkInterface->wanConnection3Gor4G();
$zteF670->status->NetworkInterface->tunnelConnection4in6();
$zteF670->status->NetworkInterface->tunnelConnection6in4();
$zteF670->status->NetworkInterface->ponInformation();
$zteF670->status->NetworkInterface->mobileNetwork();
$zteF670->status->UserInterface->wlan();
$zteF670->status->UserInterface->ethernet();
$zteF670->status->UserInterface->usb();
```

## TODO
Masih buuuwanyak fitur yang bisa di masukkan. Nanti sambil nangis dikerjakan.
Pada dasarnya ini dibuat karena kebutuhan. Nek ra butuh yo ra dibuat.
Apabila kalian pengen nambahin ya monggo dengan senang hati akan diterima.


Cukup sekian dan Matursuwun.

Jangan lupa kalo mau support seikhlasnya bisa lewat sini:
- ![Paypal](https://raw.githubusercontent.com/walangkaji/emboh/master/img/paypal.png) Paypal: [Se-Ikhlasnya Saja](https://www.paypal.me/walangkaji)
