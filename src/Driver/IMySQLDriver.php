<?php

namespace App\Driver;

interface IMySQLDriver
{
    /**
     * @param string $id
     * @return null|array
     */
    public function findProduct(string $id): ?array;
}