<?php

declare(strict_types=1);

namespace MatusStafura\PestPluginFileLoader;

final class Plugin
{
    /**
     * @param string $filepath
     * @return array<string>|null
     */
    public function json(string $filepath): array|null
    {
        $result = json_decode($this->getFileContents($filepath), true);

        if ($result === null) {
            throw new \Exception("file $filepath does not contain valid JSON");
        }

        return $result;
    }

    public function plaintext(string $filepath): bool|string
    {
        return $this->getFileContents($filepath);
    }

    public function getFileContents(string $filepath): string
    {
        if (!file_exists($filepath)) {
            throw new \Exception("File not found");
        }
        return file_get_contents($filepath);
    }
}
