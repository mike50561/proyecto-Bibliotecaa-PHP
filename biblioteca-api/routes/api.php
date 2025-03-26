<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\DevolucionController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin autenticación)
|--------------------------------------------------------------------------
*/

// LOGIN
Route::post('/login', function (Request $request) {
    $request->validate([
        'correo' => 'required|email',
        'password' => 'required'
    ]);

    $usuario = Usuario::where('correo', $request->correo)->first();

    if (!$usuario || !Hash::check($request->password, $usuario->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $usuario->createToken('token-personal')->plainTextToken;

    return response()->json([
        'token' => $token,
        'usuario' => $usuario
    ]);
});

// REGISTRO (opcional)
Route::post('/register', [UsuarioController::class, 'store']);



/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Con token Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    });

    // CRUDs protegidos
    Route::apiResource('libros', LibroController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('prestamos', PrestamoController::class);
    Route::apiResource('devoluciones', DevolucionController::class);
    Route::get('/usuarios/{id}/historial', [UsuarioController::class, 'historial']);
    Route::get('/usuarios/{id}/historial/pdf', [UsuarioController::class, 'historialPdf']);

});
