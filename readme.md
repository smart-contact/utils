# Responses

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![License](https://poser.pugx.org/smart-contact/responses/license)](//packagist.org/packages/smart-contact/responses)


This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require smart-contact/responses
```

## Usage
Include Trait `SmartContact\Responses\Traits\HasResponses` on desired Controller

Extends App\Exceptions\Handler with:

``` bash
class Handler extends \SmartContact\Responses\Exceptions\Handler
{
    ...
    
    //only if you add custom exceptions
    public function register()
    {
        $this->setOverride(true);
        ...
        Other Report And Render
        ...
        $this->renderable(function (\ErrorException $e) {
            return response($this->retrieveResponse($e), 500);
        });
    }
}
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/smart-contact/responses.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/smart-contact/responses.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/smart-contact/responses
[link-downloads]: https://packagist.org/packages/smart-contact/responses
[link-author]: https://github.com/smart-contact
[link-contributors]: ../../contributors
