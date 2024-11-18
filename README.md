# Symfony product controller app

This is a job interview project which contains:

- Product Controller
- Plaintext Caching system
- Query counter

## Prerequisites:

- **[PHP](https://www.php.net/)**
- **[Composer](https://getcomposer.org/)**
- **[Symfony CLI](https://symfony.com/download#step-1-install-symfony-cli)**

## How to run application:

1. clone this repository to your computer
2. install dependencies `composer install`
3. run Symfony server `symfony serve`

## About

The main purpose of this app is to show the work with PHP OOP. Main part is ProductController which can be accessed from
browser on route `/product/{id}`. You can add any id you wish, the controller tries to load product from cache if it is already cached, if not Controller will try to load it from ElasticSearch and then from MySQL.
The product will be then saved to cache, its query count will increase and data will be returned as JSON.

### Possible future updates

- better caching system by implementing ICache interface
- change of the query counts storage
- docker implementation with real MySQL and ElasticSearch connections


