<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    // Obtener todos los libros
    public function index()
    {
        return Libro::all();
    }

    // Crear un nuevo libro
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'autor' => 'required|max:100',
            'editorial' => 'nullable|max:100',
            'anio' => 'nullable|integer|min:1000|max:9999',
            'isbn' => 'nullable|max:50',
            'categoria' => 'nullable|max:50',
            'cantidad' => 'required|integer|min:1'
        ]);
    
        $libro = Libro::create($request->all());
        return response()->json($libro, 201);
    }

    // Mostrar un libro específico
    public function show($id)
    {
        return Libro::findOrFail($id);
    }

    // Actualizar un libro
    public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|max:255',
        'autor' => 'required|max:100',
        'editorial' => 'nullable|max:100',
        'anio' => 'nullable|integer|min:1000|max:9999',
        'isbn' => 'nullable|max:50',
        'categoria' => 'nullable|max:50',
        'cantidad' => 'required|integer|min:1'
    ]);

    $libro = Libro::findOrFail($id);
    $libro->update($request->all());
    return response()->json($libro, 200);
}

    // Eliminar un libro
    public function destroy($id)
    {
        Libro::destroy($id);
        return response()->json(null, 204);
    }
}
