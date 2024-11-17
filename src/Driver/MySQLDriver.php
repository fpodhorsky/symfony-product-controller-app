<?php

namespace App\Driver;

class MySQLDriver implements IMySQLDriver
{
    /**
     * @param string $id
     * @return array
     */
    public function findProduct(string $id): array
    {
        return ['id' => $id, 'name' => 'Example Product (MySQL)'];
    }
}
