# SRAMITROY/SOCIAL Directory

Implementation of Social Authentication for php

## Install

Via Composer

``` bash
$ composer require sramitroy/social
```

## Usage

``` php
// FIRST STEP 
  use Soft\Google;
 
  $gObject = new Google([
  	 'client_id'=>'YOUR_CLIENT_ID',
  	 'redirect_uri'=>'YOUR_REDIRECT_URL',
  	 'client_secret'=>'YOUR_CLIENT_SECREAT',
  ]);
  $url= $gObject->LogInUr(); //return Google Login URL
```

``` php
// SECOND STEP 
// DEFINE THESE SCRIPTS ONTO CALL BACK FILE
  use Soft\Google;
 
  $gObject = new Google([
  	 'client_id'=>'YOUR_CLIENT_ID',
  	 'redirect_uri'=>'YOUR_REDIRECT_URL',
  	 'client_secret'=>'YOUR_CLIENT_SECREAT',
  ]);

  $AccessToken = $gObject->AccessToken($_GET['code']);

  $profile     = $gObject->UserProfile(
                     $AccessToken['access_token'],
                     ['name','email','gender,id','picture','verified_email']
                 ); // return google profile information
```

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/sramitroy/social/LICENSE) for more information.
