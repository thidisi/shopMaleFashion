<?php

namespace App\Services;

use App\Models\Notify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class NotifyService
 * @package App\Services
 */
class NotifyService
{
    /**
     * @param array $params
     * @return Notify
     * @throws Throwable
     */
    public function create(array $params = []): Notify
    {
        DB::beginTransaction();
        try {
            $notifies = $this->createByParams($params);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $notifies;
    }

    /**
     * @param array $params
     * @return Notify
     * @throws Throwable
     */
    public function update(array $params = []): Notify
    {
        DB::beginTransaction();
        try {
            $notifies = $this->updateByParams($params);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $notifies;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function createByParams($params)
    {
        $notifies = Notify::create($params);
        return $notifies;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function updateByParams($params)
    {
        // return $notifies;
    }

    public function filter($params)
    {
        dd($params);
    }
}
