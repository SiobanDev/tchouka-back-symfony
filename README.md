# TCHoUKA 
This application allows you to learn body drums by creating movements composition.
It's developed by SiobanDev.

## Technologies

- **Symfony** as a backend Framework
- **React.js** as a Frontend Framework
- **HTML 5**
- **CSS 3**pro
- **phpMyAdmin** for the database

## The project

The project is the end-of-year project of the web developement training program House Of Code (CNAM). 

## Features

* Create rhythmical scores
* Create movements compositions
* Save scores and compositions
* Watch body drums animation

## Hosting

*  VPS OVH


## Setup instructions

Before continuing, make sure to:

* install PHP
* install composer and symfony
* launch WAMP / MAMP / LAMP

#### Clone this repo 
``` git clone https://github.com/SiobanDev/tchouka-back-symfony.git```

#### Run Composer install
```compose install```

#### Create a .env.local file with the followings :

- **DATABASE_URL**=mysql://user-name:password@127.0.0.1:3306/DBName?serverVersion=5.7
- **JWT_PASSPHRASE**=*****
- **CORS_ALLOW_ORIGIN**=^https?://localhost:?[0-9]*$

#### Generate the JWT passphrase:

- ```mkdir -p config / jwt```

- Private key: 

```openssl genpkey -out config / jwt / private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits: 4096```

- Public key:

```openssl pkey -in config / jwt / private.pem -out config / jwt / public.pem -pubout```


#### Database
Create a new database with the informations specified in the DATABASE_URL constant.
Then enter in the project command prompt:

```php bin/console doctrine: migrations: migrate```


#### Start the server with symfony

```symfony server: start```

**Here is the front part of the site => [Front Repository](https://github.com/SiobanDev/tchouka-front-react.git)**