<?php

namespace App\Repository\Contracts;

interface PaidInstallmentRepositoryInterface
{
    // public function findAll(): object;
    // public function paginate(int $page = 1): PaginationInterface;
    public function create(array $data): object;
    public function findById(int $id): ?object;
    public function update(int $id, array $data): object;
    public function delete(int $id): bool;
}
