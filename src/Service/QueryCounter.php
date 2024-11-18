<?php

namespace App\Service;

class QueryCounter implements IQueryCounter
{
    private array $queryCounts;

    /**
     * Constructor creates a public query count directory if it does not exist yet
     */
    public function __construct(private readonly string $queryCounterFilePath)
    {
        if (!is_file($this->queryCounterFilePath)) {
            file_put_contents($queryCounterFilePath, json_encode([]));
        }

        $fileContent = json_decode(file_get_contents($this->queryCounterFilePath), true);
        $this->queryCounts = (is_null($fileContent)) ? [] : $fileContent;;
    }

    public function getCount(string $id): int
    {
        return array_key_exists($id, $this->queryCounts) ? $this->queryCounts[$id] : 0;
    }

    public function increase(string $id, int $increaseValue = 1): void
    {
        array_key_exists($id, $this->queryCounts) ? $this->queryCounts[$id] += $increaseValue : $this->queryCounts[$id] = $increaseValue;
        $this->save();
    }

    private function save(): void
    {
        ksort($this->queryCounts);
        unlink($this->queryCounterFilePath);
        file_put_contents($this->queryCounterFilePath, json_encode($this->queryCounts));
    }
}
