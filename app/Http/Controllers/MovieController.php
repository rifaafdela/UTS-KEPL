<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = $this->movieService->getAll(request('search'));
        return view('homepage', compact('movies'));
    }

    public function detail($id)
    {
        $movie = $this->movieService->find($id);
        return view('detail', compact('movie'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('input', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required','string','max:255', Rule::unique('movies','id')],
            'judul' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'sinopsis' => 'required|string',
            'tahun' => 'required|integer',
            'pemain' => 'required|string',
            'foto_sampul' => 'required|image'
        ]);

        if ($validator->fails()) {
            return redirect('movies/create')
                ->withErrors($validator)
                ->withInput();
        }

        $this->movieService->store($request);

        return redirect('/')->with('success','Data berhasil disimpan');
    }

    public function data()
    {
        $movies = $this->movieService->getAll();
        return view('data-movies', compact('movies'));
    }

    public function form_edit($id)
    {
        $movie = $this->movieService->find($id);
        $categories = Category::all();
        return view('form-edit', compact('movie','categories'));
    }

    public function update(Request $request, $id)
    {
        $this->movieService->update($request, $id);

        return redirect('/movies/data')->with('success','Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->movieService->delete($id);

        return redirect('/movies/data')->with('success','Data berhasil dihapus');
    }
}