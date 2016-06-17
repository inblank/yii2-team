# Yii2 модуль inblank/yii2-team

[![Build Status](https://img.shields.io/travis/inblank/yii2-team/master.svg?style=flat-square)](https://travis-ci.org/inblank/yii2-team)
[![Packagist Version](https://img.shields.io/packagist/v/inblank/yii2-team.svg?style=flat-square)](https://packagist.org/packages/inblank/yii2-team)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/inblank/yii2-team/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/inblank/yii2-team/?branch=master)
[![Code Quality](https://img.shields.io/scrutinizer/g/inblank/yii2-team/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/inblank/yii2-team/?branch=master)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/inblank/yii2-team/master/LICENSE)

> The **[English version](https://github.com/inblank/yii2-team/blob/master/README.md)** of this document available [here](https://github.com/inblank/yii2-team/blob/master/README.md).

Модуль `yii2-team` для [Yii2](http://www.yiiframework.com/) позволяет

## Установка

Рекомендуется устанавливать модуль через [composer](http://getcomposer.org/download/).

Перейдите в папку проекта и выполните в консоли команду:

```bash
$ composer require inblank/yii2-team
```

или добавьте:

```json
"inblank/yii2-team": "~0.1"
```

в раздел `require` конфигурационного файла `composer.json`.

Добавьте следующий код в файл основной конфигурации приложения:
```php
'modules' => [
    'team'=>[
        'class' => 'inblank\team\Module',
    ],
],
```

## Настройка

## Использование