<?php


namespace App\Http\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function getAll(): Collection;

    public function getAllOrderedByName(): Collection;

    public function getAllOrderedByNamePaginated(int $number_per_page): LengthAwarePaginator;

    public function getById(int $id): Model;

    public function getByNamePaginated(string $search_string, int $number_per_page): LengthAwarePaginator;

    public function newInstance(): Model;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): bool;

    public function delete(int $id): int;

    public function getCount(): int;
}
