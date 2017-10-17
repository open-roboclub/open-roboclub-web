# RoboClub Legacy
> Legacy RoboClub website built in PHP


## Installation

### PHP

Install PHP. Standalone or through standard WAMP or LAMP server.

To install standalone version in Linux, type the following commands:  
`sudo apt install php libapache2-mod-php php-mcrypt`

> Note that you may also need to need to install php-mysql for most servers, but not for this project

Now, enable these PHP extensions:
- sqlite
- curl

To do so in standalone version installation, type following commands:  
`sudo apt install php7.0-sqlite php-curl`

### Composer

Install composer for dependency management. The installation guide of composer is very comprehensive and hence its installation won't be covered here.  
Please follow this link for installation and further info - https://getcomposer.org/

Once you have installed composer either locally or globally, run `composer install` in the root directory of the project and wait for dependencies to download

### Starting the server

In the WAMP or MAMP version, it should work by accessing the default `www` directory address, and hence is skipped.  
In the standalone PHP version, you just need to run this command in the project root:  
`php -S localhost:7000 -t public_html`

And then access `localhost:7000` in your browser to surf the site. Of course you can change the port to whatever you like.

## Author

[@iamareebjamal](https:/github.com/iamareebjamal)