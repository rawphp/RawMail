# RawMail - A Simple Wrapper around PHPMailer. [![Build Status](https://travis-ci.org/rawphp/RawMail.svg?branch=master)](https://travis-ci.org/rawphp/RawMail)

[![Latest Stable Version](https://poser.pugx.org/rawphp/raw-mail/v/stable.svg)](https://packagist.org/packages/rawphp/raw-mail) [![Total Downloads](https://poser.pugx.org/rawphp/raw-mail/downloads.svg)](https://packagist.org/packages/rawphp/raw-mail) [![Latest Unstable Version](https://poser.pugx.org/rawphp/raw-mail/v/unstable.svg)](https://packagist.org/packages/rawphp/raw-mail) [![License](https://poser.pugx.org/rawphp/raw-mail/license.svg)](https://packagist.org/packages/rawphp/raw-mail)

## Package Features
- Simple to use mailer
- SMTP support
- Supports attachments

## Installation

### Composer
RawMail is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-mail).

Add `"rawphp/raw-mail": "0.*@dev"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-mail": "0.*@dev"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-mail "0.*@dev"
```

### Tarball
Alternatively, just copy the contents of the RawMail folder into somewhere that's in your PHP `include_path` setting. If you don't speak git or just want a tarball, click the 'zip' button at the top of the page in GitHub.

## Basic Usage

```php
<?php

use RawPHP\RawMail\Mail;

// configuration
$config = array(
    'from_email'   => 'no-reply@rawphp.org',                // default from email to use in emails
    'from_name'    => 'RawPHP',                             // default from name to use in emails
    
    'smtp' => array( 'auth'     => TRUE ),                  // enable SMTP authentication
    'smtp' => array( 'host'     => 'smtp.gmail.com' ),      // main and backup SMTP servers
    'smtp' => array( 'username' => 'username' ),            // SMTP username
    'smtp' => array( 'password' => 'password' ),            // SMTP password
    'smtp' => array( 'security' => 'ssl' ),                 // Enable TLS encryption, 'ssl' also accepted
    'smtp' => array( 'port'     => '465' ),                 // SMTP port
);

// instantiate new mail instance
$mail = new Mail( );

// initialise mailer
$mail->init( $config );

// add recipient
$mail->addTo( array( 'email@example.com', 'John Smith' ) );

// set subject
$mail->setSubject( 'Demo Message' );

// set body
$mail->setBody( '<h2>Hello from Demo</h2>' );

// add attachment
$mail->addAttachment( '/path/to/file' );

$mail->send( );
```

## License
This package is licensed under the [MIT](https://github.com/rawphp/RawMail/blob/master/LICENSE). Read LICENSE for information on the software availability and distribution.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/rawphp/RawMail/issues).

## Changelog

#### 13-09-2014
- Initial Code Commit.
