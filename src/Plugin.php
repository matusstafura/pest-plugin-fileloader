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

        if (json_last_error() === 0) {
            return $result;
        }

        return null;
    }

    public function plaintext(string $filepath): bool|string
    {
        return $this->getFileContents($filepath);
    }

    private function getFileContents(string $filepath): bool|string
    {
        return file_get_contents($filepath);
    }
}
