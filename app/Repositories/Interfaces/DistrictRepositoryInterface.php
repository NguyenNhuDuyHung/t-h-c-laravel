<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface DistrictRepositoryInterface
{
    public function all();
    public function findDistrictByProvinceId(int $province_id);
    public function findById(int $id, array $column = ['*'], array $relation = []);
}