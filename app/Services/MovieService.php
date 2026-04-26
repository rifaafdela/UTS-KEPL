<?php
//refactor version

namespace App\Services;

use App\Interfaces\MovieRepositoryInterface;
use Illuminate\Support\Str;

class MovieService
{
    protected $movieRepo;

    public function __construct(MovieRepositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function getAll($search = null)
    {
        return $this->movieRepo->getAll($search);
    }

    public function find($id)
    {
        return $this->movieRepo->find($id);
    }

    public function store($request)
    {
        // generate nama file random
        $randomName = Str::uuid()->toString();

        // ambil ekstensi asli file
        $fileExtension = $request->file('foto_sampul')->getClientOriginalExtension();

        $fileName = $randomName . '.' . $fileExtension;

        // simpan file ke folder public/images
        $request->file('foto_sampul')->move(public_path('images'), $fileName);

        // simpan ke database
        return $this->movieRepo->store([
            'id' => $request->id,
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'sinopsis' => $request->sinopsis,
            'tahun' => $request->tahun,
            'pemain' => $request->pemain,
            'foto_sampul' => $fileName,
        ]);
    }

    public function update($request, $id)
    {
        $data = $request->all();

        // kalau ada upload foto baru
        if ($request->hasFile('foto_sampul')) {
            $randomName = Str::uuid()->toString();
            $fileExtension = $request->file('foto_sampul')->getClientOriginalExtension();
            $fileName = $randomName . '.' . $fileExtension;

            // simpan file baru
            $request->file('foto_sampul')->move(public_path('images'), $fileName);

            // update nama file di data
            $data['foto_sampul'] = $fileName;
        }

        return $this->movieRepo->update($data, $id);
    }

    public function delete($id)
    {
        return $this->movieRepo->delete($id);
    }
}