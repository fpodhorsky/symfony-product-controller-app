<?php

namespace App\Service;

interface IQueryCounter
{

    /**
     * Returns a count of queries for given id
     *
     * @param string $id
     * @return int
     */
    public function getCount(string $id): int;

    /**
     * Increase a count by the given value
     *
     * @param string $id
     * @param int $increaseValue
     * @return void
     */
    public function increase(string $id, int $increaseValue = 1): void;
}