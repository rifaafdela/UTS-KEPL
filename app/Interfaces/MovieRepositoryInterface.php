<?php

namespace App\Interfaces;

interface MovieRepositoryInterface
{
    public function getAll($search = null);

    public function find($id);

    public function store($data);

    public function update($data, $id);

    public function delete($id);
}