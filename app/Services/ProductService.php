<?php

namespace App\Services;

use App\Models\Production;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService
{

    public function __construct(Production $production)
    {
        $this->production = $production;
    }

    /**
     * @param array $params
     * @return Production
     * @throws Throwable
     */
    public function create(array $params = []): Production
    {
        DB::beginTransaction();
        try {
            $products = $this->createByParams($params);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $products;
    }

    /**
     * @param array $params
     * @return Production
     * @throws Throwable
     */
    public function update(array $params = []): Production
    {
        DB::beginTransaction();
        try {
            $products = $this->updateByParams($params);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $products;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function createByParams($params)
    {
        // return $products;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function updateByParams($params)
    {
        // return $products;
    }
}
