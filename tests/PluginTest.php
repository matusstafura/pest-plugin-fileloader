<?php

use MatusStafura\PestPluginFileLoader\Exceptions\FileNotFoundException;
use function MatusStafura\PestPluginFileLoader\fileLoader;
use MatusStafura\PestPluginFileLoader\Plugin;
use PHPUnit\Util\InvalidJsonException;

const FILEPATH_JSON = 'tests/response_dump.json';
const FILEPATH_PLAINTEXT = 'tests/plaintext.txt';
const FILEPATH_XML = 'tests/simplexml.xml';

it('reads a file and checks if json', function () {
    $plugin = new Plugin();
    $json = $plugin->json(FILEPATH_JSON);
    expect($json)->toBeArray()
        ->and($json['id'])->toBe(1)
        ->and($json['title'])->toBe('Shirt Black');
});

it('reads file via function', function () {
    $json = fileLoader()->json(FILEPATH_JSON);
    expect($json)->toBeArray()
        ->and($json['id'])->toBe(1)
        ->and($json['title'])->toBe('Shirt Black');
});

it('txt', function () {
    $txt = fileLoader()->plaintext(FILEPATH_PLAINTEXT);
    expect($txt)->toBeString();
});

it('throws error if file not found', function () {
    $plugin = new Plugin();
    $filename = "file_that_does_not_exist.txt";
    $plugin->getFileContents($filename);
})->throws(FileNotFoundException::class, "File not found");

it('throws error if file contains invalid json', function () {
    $plugin = new Plugin();
    $plugin->json(FILEPATH_PLAINTEXT);
})->throws(InvalidJsonException::class, "file ".FILEPATH_PLAINTEXT." does not contain valid JSON");

it('xml', function () {
    $xml = fileLoader()->xmlToArray(FILEPATH_XML);
    expect($xml)->toBeArray()
        ->and($xml["book"][0]["author"])->toBe("Gambardella, Matthew");
});
