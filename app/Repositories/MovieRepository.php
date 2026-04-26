<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAll($search = null)
    {
        $query = Movie::latest();

        if ($search) {
            $query->where('judul','like',"%$search%")
                  ->orWhere('sinopsis','like',"%$search%");
        }

        return $query->paginate(6)->withQueryString();
    }

    public function find($id)
    {
        return Movie::findOrFail($id);
    }

    public function store($data)
    {
        return Movie::create($data);
    }

    public function update($data, $id)
    {
        $movie = Movie::findOrFail($id);
        return $movie->update($data);
    }

    public function delete($id)
    {
        $movie = Movie::findOrFail($id);
        return $movie->delete();
    }
}