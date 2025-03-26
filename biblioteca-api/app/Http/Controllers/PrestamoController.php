<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function index()
    {
        return Prestamo::with(['usuario', 'libro', 'devolucion'])->get();
    }

    public function store(Request $request)
{
    $request->validate([
        'usuario_id' => 'required|exists:usuarios,id',
        'libro_id' => 'required|exists:libros,id',
        'fecha_prestamo' => 'required|date',
        'fecha_devolucion' => 'required|date|after_or_equal:fecha_prestamo',
        'estado' => 'required|in:pendiente,devuelto,atrasado'
    ]);

    $prestamo = Prestamo::create($request->all());
    return response()->json($prestamo, 201);
}
    public function show($id)
    {
        return Prestamo::with(['usuario', 'libro', 'devolucion'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'libro_id' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'required|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|in:pendiente,devuelto,atrasado'
        ]);
    
        $prestamo = Prestamo::findOrFail($id);
        $prestamo->update($request->all());
        return response()->json($prestamo, 200);
    }
    public function destroy($id)
    {
        Prestamo::destroy($id);
        return response()->json(null, 204);
    }
}
