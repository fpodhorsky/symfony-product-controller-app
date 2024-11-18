<?php

namespace App\Controller;

use App\Driver\IElasticSearchDriver;
use App\Driver\IMySQLDriver;
use App\Service\ICache;
use App\Service\IQueryCounter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly IElasticSearchDriver $elasticSearchDriver,
        private readonly IMySQLDriver         $mySQLDriver,
        private readonly ICache               $cache,
        private readonly IQueryCounter        $queryCounter,
    )
    {
    }

    /**
     * @param string $id
     * @return Response
     */
    #[Route("/product/{id}")]
    public function detail(string $id): Response
    {
        $cacheKey = 'product_detail_' . $id;

        if ($this->cache->has($cacheKey)) {
            $productData = $this->cache->get($cacheKey);
        } else {
            $productData = $this->elasticSearchDriver->findById($id);

            if (is_null($productData)) {
                $productData = $this->mySQLDriver->findProduct($id);
            }

            $this->cache->set($cacheKey, $productData, 10);
        }

        $this->queryCounter->increase($id);
        $productData['query_counter'] = $this->queryCounter->getCount($id);

        return $this->json($productData);
    }
}