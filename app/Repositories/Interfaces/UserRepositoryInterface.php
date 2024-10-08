<?php

namespace App\Repositories\Interfaces;


/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findById(int $id);
    public function create(array $payload = []);
    public function update(int $id, array $payload = []);
    public function delete(int $id);
    public function forceDelete(int $id);
}
