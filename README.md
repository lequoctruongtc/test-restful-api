<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Mini Aspire API
## Installation
User docker and docker-compose to start application [docker](https://www.docker.com/get-started)

## Usage
```shell
chmod +x ./start.sh
./start.sh
```

## Run test
```shell
docker-compose exec php sh
php artisan test or vendor/bin/phpunit
```

## Flow
#### Login to user
#### Request loan
#### Approve loans
```shell
docker-compose exec php sh
php artisan loan:approve
```
#### Make loan payment

## Postman collection
Import file at "postman/mini-aspire-api.postman_collection.json"

## Api endpoints
This is api endpoints.
Instructions on how to use them in your own application are linked below.

| Name | Method | Params | URI |
| ------ | ------ | ------ | ------ |
| Login | POST | { "email": "example@gmail.com", "password": "password" } | /api/v1/auth/login |
| List Loan | GET |  | /api/v1/loans |
| Loan Detail | GET |  | /api/v1/loans/{id} |
| Store Loan | POST | { "amount": 100000, "term": 1, "term_type": "years" } | /api/v1/loans |
| List Loan Payment | GET |  | /api/v1/loan-payments |
| Loan Payment Detail | GET |  | /api/v1/loan-payments/{id} |
| Pay Loan Payment | PATCH | | /api/v1/loan-payments/{id}/pay |

## Account testing
email: example@gmail.com

password: password
