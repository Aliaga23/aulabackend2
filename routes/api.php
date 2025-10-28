<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CoordinadorController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::post('/docentes', [DocenteController::class, 'store']);
Route::post('/coordinadores', [CoordinadorController::class, 'store']);

Route::middleware(['api'])->group(function () {
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::patch('/{id}/toggle-status', [UserController::class, 'toggleStatus']);
    });
    
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{id}', [RoleController::class, 'show']);
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
        Route::get('/{id}/permisos', [RoleController::class, 'getPermissions']);
        Route::post('/{id}/permisos', [RoleController::class, 'assignPermission']);
        Route::delete('/{id}/permisos', [RoleController::class, 'removePermission']);
    });
    
    Route::prefix('permisos')->group(function () {
        Route::get('/', [PermisoController::class, 'index']);
        Route::get('/{id}', [PermisoController::class, 'show']);
        Route::post('/', [PermisoController::class, 'store']);
        Route::put('/{id}', [PermisoController::class, 'update']);
        Route::delete('/{id}', [PermisoController::class, 'destroy']);
        Route::get('/{id}/roles', [PermisoController::class, 'getRoles']);
    });
    
    Route::prefix('docentes')->group(function () {
        Route::get('/', [DocenteController::class, 'index']);
        Route::get('/{id}', [DocenteController::class, 'show']);
        Route::put('/{id}', [DocenteController::class, 'update']);
        Route::delete('/{id}', [DocenteController::class, 'destroy']);
        Route::get('/search/especialidad', [DocenteController::class, 'searchByEspecialidad']);
    });
    
    Route::prefix('coordinadores')->group(function () {
        Route::get('/', [CoordinadorController::class, 'index']);
        Route::get('/{id}', [CoordinadorController::class, 'show']);
        Route::put('/{id}', [CoordinadorController::class, 'update']);
        Route::delete('/{id}', [CoordinadorController::class, 'destroy']);
    });
});

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint no encontrado'
    ], 404);
});

Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API funcionando correctamente',
        'timestamp' => now()
    ]);
});