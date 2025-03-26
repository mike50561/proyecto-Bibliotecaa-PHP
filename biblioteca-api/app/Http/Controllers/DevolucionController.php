<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Support\Carbon;

class DevolucionController extends Controller
{
    public function index()
    {
        return Devolucion::with('prestamo')->get();
    }

    public function store(Request $request)
{
    $request->validate([
        'prestamo_id' => 'required|exists:prestamos,id',
        'fecha_real' => 'required|date'
    ]);

    // Obtener el préstamo con el usuario relacionado
    $prestamo = Prestamo::with('usuario')->findOrFail($request->prestamo_id);
    $usuario = $prestamo->usuario;

    // Convertir fechas a Carbon para manipulación
    $fechaDevolucion = Carbon::parse($prestamo->fecha_devolucion);
    $fechaReal = Carbon::parse($request->fecha_real);

    // Calcular días de atraso
    $diasAtraso = $fechaReal->gt($fechaDevolucion)
        ? $fechaReal->diffInDays($fechaDevolucion)
        : 0;

    // Calcular multa: $0.50 por día, excepto profesores
    $multa = $usuario->tipo_usuario === 'profesor' ? 0.00 : $diasAtraso * 0.5;

    // Registrar la devolución
    $devolucion = Devolucion::create([
        'prestamo_id' => $prestamo->id,
        'fecha_real' => $fechaReal,
        'multa' => $multa
    ]);

    return response()->json([
        'message' => 'Devolución registrada exitosamente.',
        'dias_atraso' => $diasAtraso,
        'multa' => $multa,
        'devolucion' => $devolucion
    ], 201);
}
    public function show($id)
    {
        return Devolucion::with('prestamo')->findOrFail($id);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'prestamo_id' => 'required|exists:prestamos,id',
        'fecha_real' => 'required|date',
        'multa' => 'nullable|numeric|min:0'
    ]);

    $devolucion = Devolucion::findOrFail($id);
    $devolucion->update($request->all());
    return response()->json($devolucion, 200);
}


    public function destroy($id)
    {
        Devolucion::destroy($id);
        return response()->json(null, 204);
    }
}
