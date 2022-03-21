# ![laravel-evidence](https://socialify.git.ci/XNXKTech/laravel-evidence/image?font=Bitter&language=1&logo=https://avatars.githubusercontent.com/u/94216091?s=200&v=4&owner=1&pattern=Circuit%20Board&theme=Light)

[![Tests](https://github.com/XNXKTech/laravel-evidence/actions/workflows/tests.yml/badge.svg)](https://github.com/XNXKTech/laravel-evidence/actions/workflows/tests.yml)
![PHP from Packagist](https://img.shields.io/packagist/php-v/xnxktech/laravel-evidence?style=flat-square)
![Packagist Version](https://img.shields.io/packagist/v/xnxktech/laravel-evidence?style=flat-square)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/xnxktech/laravel-evidence?style=flat-square)
![GitHub last commit (branch)](https://img.shields.io/github/last-commit/xnxktech/laravel-evidence/main?style=flat-square)
![GitHub Release Date](https://img.shields.io/github/release-date/xnxktech/laravel-evidence?style=flat-square)
[![LICENSE](https://img.shields.io/badge/License-Anti%20996-blue.svg?style=flat-square)](https://github.com/996icu/996.ICU/blob/master/LICENSE)
[![LICENSE](https://img.shields.io/badge/License-Apache--2.0-green.svg?style=flat-square)](LICENSE-APACHE)
[![996.icu](https://img.shields.io/badge/Link-996.icu-red.svg?style=flat-square)](https://996.icu)


## Installation

```bash
$ composer require xnxktech/laravel-evidence
```

## Configuration

generate config file

```bash
$ php artisan vendor:publish --provider="XNXK\LaravelEvidence\ServiceProvider"
```

## Document

https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fmourn5&namespace=opendoc%2Fevidence

## Usage

The package will auto use environment variables, Put them in your .env as the following, obviously and respectively.

```env
EVIDENCE_APPID=
EVIDENCE_SECRET=
EVIDENCE_SERVER=
ESIGN_SERVER=
```

Lastly, you can using Evidence class in controller use namespace top of that file

```php
use XNXK\LaravelEvidence\Evidence;

$data = (new Evidence)->temp()->createBusiness();
```

or if you want a simple, you can use evidence function:

```php
evidence()->temp()->createBusiness();
```

## License

The code in this repository, unless otherwise noted, is under the terms of both the [Anti 996](https://github.com/996icu/996.ICU/blob/master/LICENSE) License and the [Apache License (Version 2.0)]().