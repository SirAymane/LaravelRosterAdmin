<?php

namespace App\Http\Controllers;

/**
 * The PlayerController class is used to manage Player-related requests
 * It includes functions for creating, updating, and deleting players.
 * This file contains the PlayerController class.
 * @author @SirAymane
 * @numMembers Controllers
 * @package  App\Http\Controllers
 */


use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * The PlayerController class is responsible for handling operations related to Players.
 *
 * @numMembers Controllers
 * @package  App\Http\Controllers
 */
class PlayerController extends Controller
{


    /**
     * Populates a Player object with data from a request, excluding CSRF token and player ID.
     *
     * This method iterates over request data, assigning values to the Player model's properties,
     * except for the CSRF token and the player ID to avoid assignment issues and accidental ID overwrite.
     * It streamlines model updates from form submissions.
     *      
     * @param Request $request - The HTTP request object
     * @param Player $obj - The Player object to update with new values
     * @return Player - The updated Player object
     */
    private function createPlayerFromRequest(Request $request, Player $obj): Player
    {
        // Iterate over all the fields in the HTTP request
        foreach ($request->all() as $key => $value) {
            // Skip fields that should not be updated
            if ($key !== "_token" && $key !== "player_id") {
                // Update the corresponding field in the Player object with the new value
                $obj->$key = $value;
            }
        }

        // Return the updated Player object
        return $obj;
    }


    /**
     * Create a new Players object from the request data.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @return \App\Models\Player The newly created Team object.
     */
    private function requestValuesToPlayer(
        Player $obj,
        Request $request
    ): Player {
        foreach ($request->all() as $key => $value) {
            if ($key !== "_token" && $key !== "player_id") {
                $obj->$key = $value;
            }
        }
        return $obj;
    }


    /**
     * Get error message for a specific error code.
     *
     * @param int $errorCode The error code to get message for.
     * @return string The error message for the specified error code.
     */
    private function getErrorMessage(int $errorCode): string
    {
        // Use a match expression to return a message for the specified error code.
        return match ($errorCode) {
            // Duplicate entry error.
            1062 => "An entity with the provided name already exists.",

            // Database server error.
            2022 => "There was a temporary issue with our database server. Please try again later.",

                // Default error message for any other error code.
            default => "An internal error has occurred. Please try again later.",
        };
    }


    /**
     * Returns a view that displays all players, including any error or deletion messages.
     *
     * @param Request $request The request object.
     * @return \Illuminate\View\View The view to display.
     */
    public function index(Request $request): \Illuminate\View\View
    {
        // Check if there was an error and retrieve its custom message.
        $errorCode = $request->error;
        $error = $errorCode ? $this->getErrorMessage($errorCode) : null;

        // Check if there was a player deletion and retrieve the result.
        $deletionResult = $request->deletionResult ? (bool) $request->deletionResult : null;

        try {
            // Retrieve all players from the database.
            $players = Player::all();
        } catch (\Illuminate\Database\QueryException $e) {
            // If there was an error retrieving the players, set $players to null.
            $players = null;
        }

        // Return the view, passing in the players, error, and deletion result as variables.
        return view("players.index", compact("players", "error", "deletionResult"));
    }

    /**
     * Displays the form for adding a new player, pre-filling any existing input from the request to maintain form state.
     *
     * @param Request $request The incoming request instance, potentially containing previous form data or error/result indicators.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The view for the player addition form, with data for form fields, mode, and messages.
     */
    public function displayAddPlayerForm(Request $request)
    {
        // Initialize a new Player instance for form data binding,
        // enabling pre-fill of the form with previous inputs upon form submission failure.
        $player = new Player();

        // Define form operation mode as 'add' to tailor the form view for player addition.
        $mode = "add";

        // Retrieve a custom error message if an error code is present, enhancing user feedback.
        $error = $request->error ? $this->getMessageErrorForCode($request->error) : null;

        // Assess if there's a result flag within the request, indicating the outcome of a previous operation.
        $result = $request->result ?? false;

        // Render 'player_form' view, passing necessary data including the player instance, mode, and any operation messages.
        return view('players.player_form', compact('player', 'mode', 'error', 'result'));
    }


    /**
     * Handles the submission of the player addition form. Validates input, constructs a Player model instance, and attempts database persistence.
     *
     * @param Request $request The HTTP request containing the new player's form data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the player addition form with operation results (success or error messages).
     */
    public function addPlayer(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Translate request data into a Player model instance,
        // encompassing validation and property assignment.
        $player = $this->requestValuesToPlayer(new Player(), $request);

        try {
            // Attempt to save the new Player object to the database using Eloquent's save method.
            $player->save();

            // If save is successful, prepare a success message.
            $resultMessage = 'Player added successfully.';
            $error = null;
        } catch (\Exception $e) {
            $resultMessage = null;
            $error = 'An error occurred while adding the player. Please try again.';
        }

        // Redirect back to the player add form with the new player's ID (if added successfully) 
        // or the attempted player's ID, and any results (error or success message).
        return redirect()->route('player.add.form', [
            'player_id' => $player->id ?? $request->input('player_id'),
            'error' => $error,
            'result' => $resultMessage,
        ]);
    }


    /**
     * Shows a confirmation page before deleting a player.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function confirmDeletion(Request $request): \Illuminate\Contracts\View\View
    {
        // Get player object to delete
        $player = Player::findOrFail($request->player_id);
        return view("players.deletion_confirm", compact("player"));
    }


    /**
     * Deletes a player from the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePlayer(Request $request): \Illuminate\Http\RedirectResponse
    {
        $error = null;
        $deletionResult = null;

        // Get player object to delete
        $playerToDelete = Player::findOrFail($request->player_id);

        // Begin transaction to ensure atomicity
        $connection = $playerToDelete->getConnection();
        $connection->beginTransaction();

        try {
            // Delete player from DB
            $deletionResult = $playerToDelete->delete();
            $connection->commit();
        } catch (\Illuminate\Database\QueryException $e) {
            // Roll back transaction in case of error
            $connection->rollBack();
            $deletionResult = false;
            $error = $e->errorInfo[1];
        }

        // Redirect user to player index page with error and deletion result status
        return redirect()->action(
            [PlayerController::class, "index"],
            compact("error", "deletionResult")
        );
    }


    /**
     * Displays the form to update an existing player.
     * 
     * Retrieves the player's details based on the provided player ID and sends them to the view.
     * If the player does not exist, redirects back with an error message.
     *
     * @param Request $request The incoming request object.
     * @param int $playerId The ID of the player to be updated.
     * @return \Illuminate\Http\Response Returns the player form view or redirects if the player is not found.
     */
    public function displayUpdatePlayerForm(Request $request, $playerId)
    {
        // Set the form mode to update, indicating this is an update operation (view has update and add modes)
        $mode = "update";

        // Retrieve any error or result message stored in the session.
        $error = session('error');
        $result = session('result');

        try {
            // Attempt to find the player by ID, or fail with a ModelNotFoundException.
            $player = Player::findOrFail($playerId);
        } catch (ModelNotFoundException $e) {
            // Redirect with an error message if player not found
            return redirect()->route('player.manage')->with('error', 'Player not found.');
        }
        // Return the update player form view with the necessary data.
        return view("players.player_form", compact("player", "mode", "result", "error"));
    }


    /**
     * Handles the submission of the player update form.
     * Validates and updates the player's details in the database based on the provided request data.
     * Redirects with a success message upon successful update or with an error message upon failure.
     *
     * @param Request $request The request containing the player's updated information.
     * @param int $playerId The ID of the player to update.
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate route with a success or error message.
     */
    public function updatePlayer(Request $request, $playerId)
    {
        try {
            // Find the player by ID or fail with ModelNotFoundException.
            $player = Player::findOrFail($playerId);
            // Update the player's attributes with the request data.
            $this->requestValuesToPlayer($player, $request);
            // Persist the changes to the database.
            $player->save();

            // Redirect back to the player form with a success message.
            return redirect()->route('player.update.form', ['player' => $player->id])
                ->with('result', 'Player updated successfully.');
        } catch (ModelNotFoundException $e) {
            // Redirect with an error message if the player is not found.
            return redirect()->route('player.manage')->with('error', 'Player not found.');
        } catch (\Exception $e) {
            // Handle any other exceptions by redirecting back with an error message.
            return redirect()->route('player.update.form', ['player' => $request->input('player_id')])
                ->with('error', 'An unexpected error occurred while updating the player.');
        }
    }
}