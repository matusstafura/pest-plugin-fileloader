# A PHP Pest plugin to load file

This Pest plugin simplifies loading file for testing.

If you want to test a response, save it as json, load a file and test:

```php
use function MatusStafura\PestPluginFileLoader\fileLoader;

test('response', function () {
    $json = fileLoader()->json('tests/response_dump.json');
    expect($json)->toBeArray()
        ->and($json['id'])->toBe(1)
        ->and($json['title'])->toBe('Shirt Black');
});
```

Available methods:
```php
json(string $filepath): array
// $json = fileLoader()->json('response.json');

plaintext(string $filepath): string
// fileLoader()->plaintext('response.txt');

xmlToArray(string $filepath): array
// fileLoader()->json('response.xml');
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
