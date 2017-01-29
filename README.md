#Configurator

###Installation

Via Composer
```shell
composer require assada/configurator
```

###Requirements

PHP: >= **7.0**

symfony/yaml: >= 3.2

Instead of symfony/yaml suggest install PECL yaml extension.

###Usage

```php
$config = new Config(['./configs/test.json', './configs/test2.json']);
$config->add('./test3.json');
$config->set('test.set', 'newData');

file_put_contents('export.json', $config->dump('json'));

var_dump($config->all());
```