[![Star](http://i.imgur.com/4qGWp0J.png)]()

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)](https://php.net/) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/35d38317bbb14f6789de06c580bdea1d)](https://www.codacy.com/app/Assada/configurator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Assada/configurator&amp;utm_campaign=Badge_Grade) [![Version](https://img.shields.io/packagist/v/assada/configurator.svg)](https://packagist.org/packages/assada/configurator) [![Packagist](https://img.shields.io/packagist/l/assada/configurator.svg)]() [![Gratipay User](https://img.shields.io/gratipay/user/Assada.svg)](https://gratipay.com/configurator/)
 [![Star](https://img.shields.io/github/stars/assada/configurator.svg?style=social&label=Star)](https://github.com/Assada/configurator)
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

## License

Configurator is released under the GPL3.0 Licence. See the bundled LICENSE file for details.

## Author

Alex Ilyenko (@Assada)
