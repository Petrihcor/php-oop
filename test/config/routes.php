<?php

use App\controllers\MainController;
use App\Kernel\Router\Route;
use App\controllers\CreatorController;
use App\controllers\RegisterController;
use App\controllers\LoginController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\GuestMiddleware;


return [
    Route::get('', [MainController::class, 'getAllUsers']),

    Route::get('roles', [MainController::class, 'getAllRoles']),
    Route::get('role/create', [CreatorController::class, 'addRole'], [AdminMiddleware::class]),
    Route::post('role/create', [CreatorController::class, 'saveRole']),
    Route::post('role/destroy', [CreatorController::class, 'deleteRole']),
    Route::get('role/edit', [CreatorController::class, 'editRole'], [AdminMiddleware::class]),
    Route::post('role/edit', [CreatorController::class, 'updateRole']),

    Route::get('register', [RegisterController::class, 'index'], [GuestMiddleware::class]),
    Route::post('register', [RegisterController::class, 'registration']),

    Route::get('user', [MainController::class, 'showUser']),
    Route::get('user/create', [CreatorController::class, 'addUser'], [AuthMiddleware::class]),
    Route::post('user/create', [CreatorController::class, 'saveUser']),
    Route::post('user/destroy', [CreatorController::class, 'deleteUser']),
    Route::get('user/edit', [CreatorController::class, 'editUser']),
    Route::post('user/edit', [CreatorController::class, 'updateUser']),

    Route::get('login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('login', [LoginController::class, 'login']),
    Route::post('logout', [LoginController::class, 'logout']),
];