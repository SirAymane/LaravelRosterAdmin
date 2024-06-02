<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;

// Define the web routes for the application
Route::get('/', function () {
    return view('welcome');
});

/*************************** Player related routes /***************************/

// Show the player management dashboard
Route::get('/players/manage', [PlayerController::class, 'index'])->name('player.manage'); 

// Display the form to add a new player
Route::get('/player/add', [PlayerController::class, 'displayAddPlayerForm'])->name('player.add.form');

// Process the form submission for adding a new player
Route::post('/player/add', [PlayerController::class, 'addPlayer'])
    ->name('player.add')
    ->middleware('validate.player.form'); // Apply custom middleware for validation on player add

// Display the form to update a player
Route::get('/player/update/{player}', [PlayerController::class, 'displayUpdatePlayerForm'])->name('player.update.form');

// Process the form submission for updating a player
Route::post('/player/update/{player}', [PlayerController::class, 'updatePlayer'])
    ->name('player.update')
    ->middleware('validate.player.form'); // Apply custom middleware for validation on player update
    
// Confirm the deletion of a player
Route::post('/player/confirm-deletion', [PlayerController::class, 'confirmDeletion']); 

// Delete a player
Route::post('/player/delete', [PlayerController::class, 'deletePlayer']); 




/*************************** Team related routes /***************************/

// Show the team management dashboard
Route::get('/teams/manage', [TeamController::class, 'index'])->name('team.manage'); 
Route::get('/team/add', [TeamController::class, 'displayAddTeamForm'])->name('team.add.form');
// Apply the middleware to team add and update routes
Route::post('/team/add', [TeamController::class, 'addTeam'])
    ->name('team.add')
    ->middleware('validate.team.form'); // Apply custom middleware for validation on team add
    
// Show the form to update a team
Route::get('/team/update', [TeamController::class, 'displayUpdateTeamForm'])->name('team.update.form');
// Process the form submission for updating a team
Route::post('/team/update', [TeamController::class, 'updateTeam'])->name('team.update')
    ->middleware('validate.team.form'); // Apply custom middleware for validation on team update

// Confirm the unenrollment of players from a team
Route::post('/team/unenrol-confirmation', [TeamController::class, 'confirmUnenrol']); 
// Unenroll a player from a team
Route::post('/team/unenrol-player', [TeamController::class, 'unenrolPlayer']); 
// Unenroll all players from a team
Route::post('/team/unenrol-all', [TeamController::class, 'unenrolAll']); 
// Show the enrollment table for players
Route::get('/team/enrol-player-table', [TeamController::class, 'enrolPlayerTable'])->name('team.enrolPlayerTable'); 
// Enroll a player to a team
Route::post('/team/enrol-player', [TeamController::class, 'enrolPlayer']); 
// Confirm the deletion of a team
Route::post('/team/confirm-deletion', [TeamController::class, 'confirmDeletion']); 
// Delete a team
Route::post('/team/delete', [TeamController::class, 'deleteTeam']); 

