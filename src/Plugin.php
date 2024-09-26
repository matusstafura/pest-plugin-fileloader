<?php

declare(strict_types=1);

namespace MatusStafura\PestPluginFileLoader;

use MatusStafura\PestPluginFileLoader\Exceptions\FileNotFoundException;
use PHPUnit\Util\InvalidJsonException;

final class Plugin
{
    /**
     * @param string $filepath
     * @return array<string>|null
     * @throws \Exception
     */
    public function json(string $filepath): array|null
    {
        $result = json_decode($this->getFileContents($filepath), true);

        if ($result === null) {
            throw new InvalidJsonException("file $filepath does not contain valid JSON");
        }

        return $result;
    }

    /**
     * @param string $filepath
     * @return bool|string
     * @throws \Exception
     */
    public function plaintext(string $filepath): string
    {
        return $this->getFileContents($filepath);
    }

    /**
     * @param string $filepath
     * @return array
     * @throws \Exception
     */
    public function xmlToArray(string $filepath): array
    {
        $xml = $this->getFileContents($filepath);
        return json_decode(json_encode(simplexml_load_string($xml)),TRUE);
    }

    /**
     * @param string $filepath
     * @return string
     * @throws \Exception
     */
    public function getFileContents(string $filepath): string
    {
        if (!file_exists($filepath)) {
            throw new FileNotFoundException("File not found");
        }
        return file_get_contents($filepath);
    }
}
