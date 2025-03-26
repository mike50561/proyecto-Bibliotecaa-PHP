<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;


class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6',
            'tipo_usuario' => 'required|in:admin,estudiante,profesor',
        ]);
    
        // Verificar si ya existe un admin
        if ($request->tipo_usuario === 'admin') {
            $adminExistente = Usuario::where('tipo_usuario', 'admin')->first();
            if ($adminExistente) {
                return response()->json([
                    'message' => 'Ya existe un administrador registrado en el sistema.'
                ], 403);
            }
        }
    
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'tipo_usuario' => $request->tipo_usuario,
        ]);
    
        return response()->json($usuario, 201);
    }
    

    public function show($id)
    {
        return Usuario::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'correo' => "required|email|unique:usuarios,correo,$id",
            'tipo_usuario' => 'required|in:admin,estudiante,profesor',
        ]);
    
        $usuario = Usuario::findOrFail($id);
        $usuario->update($request->all());
        return response()->json($usuario, 200);
    }

    public function destroy($id)
    {
        Usuario::destroy($id);
        return response()->json(null, 204);
    }

    public function historial($id)
{
    $usuario = Usuario::findOrFail($id);

    $historial = $usuario->prestamos()
        ->with('libro') // para que traiga los datos del libro
        ->orderByDesc('created_at')
        ->get();

    return response()->json($historial);
}
public function historialPdf($id)
{
    $usuario = Usuario::findOrFail($id);
    $historial = $usuario->prestamos()->with('libro')->get();

    $pdf = Pdf::loadView('historial_pdf', [
        'usuario' => $usuario,
        'historial' => $historial
    ]);

    return $pdf->download("historial_{$usuario->nombre}.pdf");
}


}
