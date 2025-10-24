<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepositoryInterface
{
    public function list();

    public function store();
    public function update(int $userId, array $data): Model | null;
    public function delete(int $id) :bool;
}
