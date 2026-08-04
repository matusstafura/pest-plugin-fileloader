# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.4.0] - 2026-08-04

### Added
- `Exceptions\FileLoaderException` — common base class for all exceptions thrown by this package, so callers can catch any loader error with a single `catch` block.
- `Exceptions\InvalidJsonException` — replaces the previous dependency on the internal `PHPUnit\Util\InvalidJsonException`.
- `Exceptions\InvalidXmlException` — thrown when `xmlToArray()` is given malformed XML, with the underlying libxml error messages included.
- `json()` now rejects top-level JSON scalars (e.g. a bare string or number) with a clear `InvalidJsonException`, since the method's documented return type is `array|null`.

### Changed
- **BREAKING:** `json()` no longer throws `PHPUnit\Util\InvalidJsonException` (an internal PHPUnit class outside its BC promise). It now throws `MatusStafura\PestPluginFileLoader\Exceptions\InvalidJsonException`. Update any `->throws(...)` / `expectException(...)` assertions accordingly.
- **BREAKING:** `json()` now throws `InvalidJsonException` for valid JSON whose top-level value is not an object/array (previously this would have returned a scalar despite the `array|null` return type).
- `json()` no longer misidentifies a file containing the JSON literal `null` as invalid; it now checks `json_last_error()` instead of a `null` result check.
- Minimum PHP constraint changed from `^8.1 || ^8.2 || ^8.3 || ^8.4` to `>=8.1`, so newer PHP releases (8.5+) are supported automatically without a version bump.

### Fixed
- `getFileContents()` no longer throws an uncaught `TypeError` when the target path is a directory or is otherwise unreadable; it now throws `FileNotFoundException` in both cases.
- `xmlToArray()` no longer silently returns malformed or empty data when given invalid XML; parse errors are now caught and raised as `InvalidXmlException` with the libxml diagnostic messages.
- `xmlToArray()` no longer risks a `TypeError` from passing a failed `json_encode()` result (`string|false`) into `json_decode()`.

### Developer tooling
- Added `laravel/pint` (PSR-12 preset) with `composer lint` / `composer lint:fix` scripts.
- Simplified `phpstan.neon` to use `phpstan/phpstan` alone at `level: max`, dropping the `ergebnis/phpstan-rules` and `thecodingmachine/phpstan-strict-rules` dependencies.

## [0.3.0] - 2025-09-23

_See [GitHub releases](https://github.com/matusstafura/pest-plugin-fileloader/releases) for details of this and earlier versions._
