<?php

declare(strict_types=1);

namespace MatusStafura\PestPluginFileLoader;

use MatusStafura\PestPluginFileLoader\Exceptions\FileNotFoundException;
use MatusStafura\PestPluginFileLoader\Exceptions\InvalidJsonException;
use MatusStafura\PestPluginFileLoader\Exceptions\InvalidXmlException;

final class Plugin
{
    /**
     * @param string $filepath
     * @return array<array-key, mixed>|null
     * @throws FileNotFoundException
     * @throws InvalidJsonException
     */
    public function json(string $filepath): array|null
    {
        $result = json_decode($this->getFileContents($filepath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException("File $filepath does not contain valid JSON: " . json_last_error_msg());
        }

        return $result;
    }

    /**
     * @param string $filepath
     * @return string
     * @throws FileNotFoundException
     */
    public function plaintext(string $filepath): string
    {
        return $this->getFileContents($filepath);
    }

    /**
     * @param string $filepath
     * @return array<array-key, mixed>
     * @throws FileNotFoundException
     * @throws InvalidXmlException
     */
    public function xmlToArray(string $filepath): array
    {
        $contents = $this->getFileContents($filepath);

        $useInternalErrors = libxml_use_internal_errors(true);
        libxml_clear_errors();
        $xml = simplexml_load_string($contents);

        if ($xml === false) {
            $errors = array_map(
                static fn (\LibXMLError $error): string => trim($error->message),
                libxml_get_errors()
            );
            libxml_clear_errors();
            libxml_use_internal_errors($useInternalErrors);

            throw new InvalidXmlException(
                "File $filepath does not contain valid XML" . ($errors === [] ? '' : ': ' . implode('; ', $errors))
            );
        }

        libxml_use_internal_errors($useInternalErrors);

        /** @var array<array-key, mixed> $result */
        $result = json_decode(json_encode($xml), true);

        return $result;
    }

    /**
     * @param string $filepath
     * @return string
     * @throws FileNotFoundException
     */
    public function getFileContents(string $filepath): string
    {
        if (!file_exists($filepath) || is_dir($filepath)) {
            throw new FileNotFoundException("File not found: $filepath");
        }

        $contents = @file_get_contents($filepath);

        if ($contents === false) {
            throw new FileNotFoundException("File could not be read: $filepath");
        }

        return $contents;
    }
}
