# PHPQuery

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Nobody really wants to do imperative dom manipulation on the back end, but sometimes you have to. 
Given that you've probably done a lot of dom manipulation in javascript, maybe it would be nice to use the same api on the back end.
Use cases for this project include:
- DOM Crawlers
- Integration testing
- [Link previews](https://github.com/jclyons52/page-preview)

## Install

Via Composer

``` bash
$ composer require jclyons52/php-query
```

## Usage

``` php
$html = <div class="row">
            <div class="col-sm-3" id="div-1"> First Div </div>
            <div class="col-sm-3" id="div-2"> Second Div </div>
            <div class="col-sm-3 third" id="div-3" data-last-value="43" data-hidden="true" data-options='{"name":"John"}'> Third Div </div>
        </div>';
$dom = new jclyons52\Document($html);

$elements = $dom->querySelector('.col-sm-3');

$element->attr('styles', 'display: block;');

echo $element->attr('styles'); // 'display: block'

echo $element->text(); // 'First Div'

echo $element->hasClass('col-sm-3); // true

$element->css(); // ["color" => "blue", "display" => "none"];

$div3 = $this->document->querySelectorAll('.col-sm-3')[2];

$div3->data(); // ["last-value" => 43, "hidden" => true, "options" => '{"name":"John"}']

echo $element->toString(); // '<div class="col-sm-3" id="div-1"> First Div </div>'
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email jclyons52@gmail.com instead of using the issue tracker.

## Credits

- [Joseph Lyons][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jclyons52/php-query.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jclyons52/php-query/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jclyons52/PHPQuery.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jclyons52/PHPQuery.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jclyons52/php-query.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jclyons52/php-query
[link-travis]: https://travis-ci.org/jclyons52/php-query
[link-scrutinizer]: https://scrutinizer-ci.com/g/jclyons52/PHPQuery/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/jclyons52/PHPQuery
[link-downloads]: https://packagist.org/packages/jclyons52/php-query
[link-author]: https://github.com/jclyons52
[link-contributors]: ../../contributors

