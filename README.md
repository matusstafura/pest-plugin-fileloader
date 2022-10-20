# A PHP Pest plugin to load file

This Pest plugin simplifies loading file for testing.

If you want to test response, save it as json, load file and test:

```php
use function MatusStafura\PestPluginFileLoader\fileLoader;
const FILEPATH_JSON = 'tests/response_dump.json';

test('response', function () {
    $json = fileLoader()->json(FILEPATH_JSON);
    expect($json)->toBeArray()
        ->and($json['id'])->toBe(1)
        ->and($json['title'])->toBe('Shirt Black');
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Matus Stafura](https://github.com/matusstafura)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
