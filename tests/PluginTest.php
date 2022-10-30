<?php

use function MatusStafura\PestPluginFileLoader\fileLoader;
use MatusStafura\PestPluginFileLoader\Plugin;

const FILEPATH_JSON = 'tests/response_dump.json';
const FILEPATH_PLAINTEXT = 'tests/plaintext.txt';

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
})->throws(\Exception::class)->expectErrorMessage("File not found");

it('throws error if file contains invalid json', function () {
    $plugin = new Plugin();
    $x = $plugin->json(FILEPATH_PLAINTEXT);
})->throws(\Exception::class)->expectErrorMessage("file ".FILEPATH_PLAINTEXT." does not contain valid JSON");
