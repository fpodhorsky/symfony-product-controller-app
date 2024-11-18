<?php

namespace App\Service;

class PlainTextCache implements ICache
{
    /**
     * Constructor accepts cache directory as an argument
     * from DI and creates it if it doesn't exist
     */
    public function __construct(private readonly string $cacheDir)
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get(string $key): mixed
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return null;
        }

        $data = $this->getData($filePath, $key);

        return (!empty($data)) ? $data['value'] : null;
    }

    public function set(string $key, mixed $value, int $ttl): void
    {
        $filePath = $this->getFilePath($key);

        $data = [
            'value' => $value,
            'expires_at' => time() + $ttl
        ];

        file_put_contents($filePath, json_encode($data));
    }

    public function delete(string $key): void
    {
        $filePath = $this->getFilePath($key);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Function to check if given cache key exists.
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool
    {
        $filePath = $this->getFilePath($key);

        if (!file_exists($filePath)) {
            return false;
        }

        $data = $this->getData($filePath, $key);

        return (!empty($data));
    }

    /**
     * Functions loads data from filePath and check expiration date
     *
     * @param string $filePath
     * @param string $key
     * @return array|null
     */
    public function getData(string $filePath, string $key): ?array
    {
        $data = json_decode(file_get_contents($filePath), true);

        if (time() > $data['expires_at']) {
            $this->delete($key);
            return null;
        }

        return $data;
    }

    /**
     * Returns file path based on given key.
     *
     * For security and special chars support,
     * the key is hashed with md5.
     *
     * @param string $key
     * @return string
     */
    private function getFilePath(string $key): string
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . md5($key) . '.cache';
    }
}
