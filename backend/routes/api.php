<?php

use App\Http\Controllers\Api\LeadCallController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ManagerLeadController;
use Illuminate\Support\Facades\Route;

Route::post('/leads', [LeadController::class, 'store']);
Route::post('/leads/{lead}/calls', [LeadCallController::class, 'store']);
Route::get('/managers/{manager}/leads', [ManagerLeadController::class, 'index']);
