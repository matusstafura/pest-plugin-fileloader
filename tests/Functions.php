<?php

use function MatusStafura\PestPluginFileLoader\fileLoader;
use MatusStafura\PestPluginFileLoader\Plugin;

const FILEPATH_JSON = 'tests/response_dump.json';
const FILEPATH_PLAINTEXT = 'tests/plaintext.txt';

it('reads a file', function () {
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

it('checks if a json file is a json', function () {
    $json = fileLoader()->json(FILEPATH_PLAINTEXT);
    expect($json)->toBeNull();
});
