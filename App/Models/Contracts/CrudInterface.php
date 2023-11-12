<?php

namespace App\Models\contracts;

interface CrudInterface
{

    // create
    public function create(array $data): ?int;

    // read
    public function find(int $id): ?object;
    public function get($columns, array $where): array;

    // update

    public function update(array $columns, array $where): int;
    // delete
    public function delete(array $where): int;
}
