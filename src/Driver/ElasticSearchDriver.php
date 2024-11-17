<?php

namespace App\Driver;

class ElasticSearchDriver implements IElasticSearchDriver
{
    /**
     * This function pretends to search the ElasticSearch
     * database and randomly returns null or an array.
     *
     * @param string $id
     * @return null|array
     */
    public function findById(string $id): ?array
    {
        return (rand(0,1)) ? ['id' => $id, 'name' => 'Example Product (ElasticSearch)'] : null;
    }
}
