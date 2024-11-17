<?php

namespace App\Driver;

interface IElasticSearchDriver
{
    /**
     * @param string $id
     * @return null|array
     */
    public function findById(string $id): ?array;
}