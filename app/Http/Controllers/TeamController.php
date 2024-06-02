<?php

namespace App\Http\Controllers;

/**
 * The TeamController class manages requests related to teams,
 * including creating, updating, and deleting them.
 *
 * @package App\Http\Controllers
 * @numMembers Controllers
 * @author @SirAymane
 */

 use App\Models\Team;
 use App\Models\Player;
 use Illuminate\Http\Request;
 use Illuminate\Http\RedirectResponse;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Validator;
 use Illuminate\Support\Facades\Log;
 use Illuminate\Database\QueryException;
 use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * The TeamController class is responsible for handling operations related to Teams.
 *
 * @numMembers Controllers
 * @package  App\Http\Controllers
 */
class TeamController extends Controller
{

    /**
     * Populates a Team object with data from a request, excluding CSRF token and team ID.
     *
     * This method iterates over request data, assigning values to the Team model's properties,
     * except for the CSRF token and the team ID to avoid assignment issues and accidental ID overwrite.
     * It streamlines model updates from form submissions.
     * 
     * @param Team $obj The Team object to populate with values.
     * @param Request $request The Request object containing the values to populate.
     * @return Team The populated Team object.
     **/
    private function requestValuesToTeam(Team $obj, Request $request): Team
    {
        // Assign request values to model, excluding '_token' and 'team_id'
        foreach ($request->all() as $key => $value) {
            // Exclude CSRF token and team_id from being assigned.
            if ($key !== "_token" && $key !== "team_id") {
                $obj->$key = $value; // Assign value to the corresponding property.
            }
        }
        return $obj;  // Return the populated object.
    }

    /**
     * Returns a user-friendly error message corresponding to a specific database error code.
     *
     * This method translates common database error codes into more understandable messages, 
     * aiding in the communication of issues to the user. It covers scenarios such as 
     * unique constraint violations, server issues, and referential integrity constraints.
     *
     * @param int $errorCode The numeric error code from the database operation.
     * @return string A descriptive error message tailored to the encountered issue.
     * */
    private function getMessageErrorForCode(int $errorCode): string
    {
        // Match known database error codes to custom messages
        return match ($errorCode) {
            1062 => "Entity with the following name already exists!",
            2022 => "Temporary issue with our database server. Please, try again later.",
            1451 => "Team has players enrold to it.  First you need to delete all players from it, before eliminating the team!",
            default => "An internal error has occured. Please, try again later.",
        };
    }

    /**
     * Display a listing of all teams.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request object.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check for any error code in the request object
        $errorCode = $request->input('error', null);

        // Get the custom error message for the error code, if any
        $error = $errorCode ? $this->getMessageErrorForCode($errorCode) : null;

        // Check if a deletion result was returned in the request object, cast it to a boolean
        $deletionResult = $request->input('deletionResult') ? true : false;

        try {
            // Retrieve all teams
            $teams = Team::all();
        } catch (QueryException $e) {
            // If an exception occurred, set teams to null
            $teams = null;
        }

        // Render the view with the teams, error message, and deletion result
        return view("teams.index", compact("teams", "error", "deletionResult"));
    }

    /**
     * Displays the form for adding a new team, pre-filling any existing input from the request to maintain form state.
     *
     * @param Request $request The incoming request instance, potentially containing previous form data or error/result indicators.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The view for the team addition form, with data for form fields, mode, and messages.
     */
    public function displayAddTeamForm(Request $request)
    {
        // Create a new team instance as a basis for form bindings, making it possible
        // to pre-fill the form with previous inputs if the form submission was unsuccessful.
        $team = new Team();

        // The form operation mode is set to 'add', influencing form rendering and logic within the view.
        $mode = "add";

        // Attempt to fetch a custom error message if an error code is present in the request.
        $error = $request->error ? $this->getMessageErrorForCode($request->error) : null;

        // Check if there is a result flag within the request, indicating the outcome of a previous add operation.
        $result = $request->result ?? false;

        // Return the 'team-form' view with compacted variables for use, including the new team instance, mode, and any message indicators.
        return view('teams.team-form', compact('team', 'mode', 'error', 'result'));
    }



    /**
     * Processes the form submission for adding a new team to the database.
     * Validates the input, creates a new team entity, and attempts to persist it to the database.
     *
     * @param Request $request The HTTP request object containing form data for the new team.
     * @return \Illuminate\Http\RedirectResponse Redirects to the team addition form, along with operation results (success or error).
     */
    public function addTeam(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Convert the request data into a new Team model instance.
        // This includes validating the data and setting model properties accordingly.
        $team = $this->requestValuesToTeam(new Team(), $request);

        try {
            // Attempt to save the new team to the database using Eloquent's save method.
            $team->save();

            // If save is successful, prepare a success message.
            $resultMessage = 'Team added successfully.';
            $error = null;
        } catch (\Exception $e) {
            $resultMessage = null;
            $error = 'An error occurred while adding the team. Please try again.';
        }

        // Redirect back to the team addition form with the new team's ID (if added successfully) 
        // or the attempted team's ID, and any transaction results (error or success message).
        return redirect()->route('team.add.form', [
            'team_id' => $team->id ?? $request->input('team_id'),
            'error' => $error,
            'result' => $resultMessage,
        ]);
    }



    /**
     * This function serves to display the team form to update an existing team in the database or
     * handle the submission of the form to modify the team.
     *
     * @param Request $request The HTTP request object containing the form data (if submitted).
     * @return View|RedirectResponse Returns a view to display the form or a redirect to the "displayUpdateTeamForm" page with parameters.
     */
    public function displayUpdateTeamForm(Request $request)
    {
        // Specifies that this form is for updating an existing team (we have the same template for add for instance)
        $mode = "update";

        // Initializes a new Team object. This might be replaced if a teamId is provided.
        $team = new Team();

        // Tries to get 'team_id' from the request; if not present, attempts to find it in the session.
        // This supports scenarios where 'team_id' might be passed around in different ways.
        $teamId = $request->input('team_id', session('team_id'));


        if ($teamId) {
            try {
                // Attempts to find an existing team by its ID. If found, the team object is populated with its data.
                $team = Team::findOrFail($teamId);
                // If no team is found with this ID, a ModelNotFoundException is thrown.
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Handle the team not found situation informing back with the error.
                $error = 'Team not found.';
            }
        }

        // Retrieve error and result messages from the session, set by previous operations
        $error = session('error', null);
        $result = session('result', null);

        // Renders the 'team-form' view, passing in the team data, form mode, and any messages as variables.
        // This allows the view to be populated with existing team data for editing, and to display relevant feedback messages.


        // Fetch players associated with the team, this is important for the enrollment functionality.
        $players = Player::where('team_id', $team->id)->get();  

        // We are passing $players to the view, it's an important step son that later we can view the players enrolled to a team.
        return view('teams.team-form', compact('team', 'mode', 'error', 'result', 'players'));
    }

    /**
     * Update an existing team in the database based on the data submitted via a HTTP POST request.
     * Assumes that the form data validation has already been performed by middleware before this method is called.
     *
     * @param Request $request The HTTP request object containing the form data.
     * @return RedirectResponse A redirect to the "displayUpdateTeamForm" page with parameters of the result.
     */
    public function updateTeam(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            // Attempts to find a Team model by its 'team_id' from the request input. 
            $team = Team::findOrFail($request->input('team_id'));
            // Calls a method to update the $team model with values from the request.
            $this->requestValuesToTeam($team, $request);
            // If any attributes have been changed, this will update the corresponding row in the teams table.
            $team->save();

            // Redirect with success message
            return redirect()->route('team.update.form')->with([
                'team_id' => $team->id, // Ensuring team_id is available for redirection
                'result' => 'Team updated successfully.'
            ]);
            // If the model is not found, throws a ModelNotFoundException, leading to a 404 error response.
        } catch (ModelNotFoundException $e) {
            // Team not found
            return redirect()->route('team.update.form')->with('error', 'Team not found.');
        } catch (\Exception $e) {
            // Any other error
            return redirect()->route('team.update.form')->with('error', 'An unexpected error occurred while updating the team.');
        }
    }

    /**
     * Display the confirmation page after deleting a team.
     *
     * @param Request $request The request object containing the team ID.
     * @return View The deletion confirmation view.
     * @throws ModelNotFoundException If the team with the given ID is not found.
     */
    public function confirmDeletion(Request $request): \Illuminate\View\View
    {
        // Find the team with the given ID.
        $team = Team::findOrFail($request->team_id);

        // Return the view for confirming the team deletion.
        return view("teams.deletion_confirm", compact("team"));
    }

    /**
     * Delete a team from the database.
     *
     * @param Request $request The request object containing the team ID.
     * @return RedirectResponse The view to redirect to after deleting the team.
     * @throws ModelNotFoundException If the team with the given ID is not found.
     */
    public function deleteTeam(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Initialize variables for error and deletion result.
        $error = null;
        $deletionResult = null;

        try {
            // Find the team with the given ID and delete it from the database.
            $teamToDelete = Team::findOrFail($request->team_id);
            $deletionResult = $teamToDelete->delete();
        } catch (QueryException $e) {
            // If there was an error during the deletion, set the deletion result to false and store the error code.
            $deletionResult = false;
            $error = $e->errorInfo[1];
        }

        // Redirect to the team index page, passing in the deletion result and error variables.
        return redirect()->action(
            [TeamController::class, "index"],
            compact("error", "deletionResult")
        );
    }

    /**
     * Display the confirmation page for unenroling a player from a team.
     *
     * @param Request $request The HTTP request object containing the form data.
     * @return \Illuminate\View\View The view containing the confirmation page.
     */
    public function confirmUnenrol(Request $request): \Illuminate\View\View
    {
        // Initialize variables.
        $applyAll = null;
        $player = null;
        $team = null;

        try {
            // Retrieve the team and player to be unenroled.
            $team = Team::findOrFail($request->team_id);

            if (!(bool) $request->apply_all) {
                $player = Player::findOrFail($request->player_id);
            } else {
                $applyAll = $request->apply_all;
            }
        } catch (\Exception $e) {
            // If fails here, is probably because of the DB connection.
            // Forward the error message to the "displayUpdateTeamForm" page.
            return redirect()->action(
                [TeamController::class, "displayUpdateTeamForm"],
                ["team_id" => $team->id, "error" => 2022, "result" => false]
            );
        }

        // Render the confirmation view.
        return view(
            "teams.unenrol-confirmation",
            compact("applyAll", "team", "player")
        );
    }

    /**
     * Unenrol a player from a team.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unenrolPlayer(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Initialize variables for the operation
        $error = null;
        $result = false;

        // Retrieve the player to be unenroled
        $player = Player::findOrFail($request->player_id);

        // Retrieve the team that the player is currently enroled in
        $team = Team::findOrFail($request->team_id);

        try {
            // Attempt to unenrol the player from the team
            $player->team_id = null;
            $player->save();
            $result = true;

            // Get the updated list of players for the team
            $players = $team->players;
        } catch (\Illuminate\Database\QueryException $e) {
            // Get the updated list of players for the team
            $players = $team->players;
            // If an exception occurs, set the error message
            $error = $e->errorInfo[1];
        }

        // Redirect to the page to update the team, passing the necessary parameters
        return redirect()->action(
            [TeamController::class, "displayUpdateTeamForm"],
            ["team_id" => $team->id, "error" => $error, "unenrolResult" => $result]
        );
    }
    
    /**
     * Unenrolls all players from a team.
     *
     * @param Request $request The request object containing the team ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The view for the team form
     */
    public function unenrolAll(Request $request)
    {
        $mode = "update";
        $error = null;
        $unenrolAllResult = true;
        $team = null;
    
        try {
            // Retrieve the team and its players.
            $team = Team::findOrFail($request->team_id);
    
            // Use a transaction to ensure all or nothing is applied.
            DB::transaction(function () use ($team) {
                foreach ($team->players as $player) {
                    $player->team_id = null;
                    $player->save();
                }
            });
        } catch (ModelNotFoundException $e) {
            $error = 'Team not found.';
            $unenrolAllResult = false;
        } catch (\Exception $e) {
            // Log the error per the exception handling needs.
            $error = 'An unexpected error occurred while unenrolling the players.';
            $unenrolAllResult = false;
        }
    
        // In case of success, there's no need to modify players collection manually,
        // Eloquent handles relations upon saving.
        return view("teams.team-form", compact("unenrolAllResult", "error", "team", "mode"))
            ->with('players', $team ? $team->players : collect());
    }
    

    /**
     * Renders the enrollment form for a specified team and list of available players.
     *
     * @param  Request  $request - the incoming HTTP request object.
     * @return View - the rendered enrollment view.
     * @throws ModelNotFoundException if the specified team does not exist.
     */
    public function enrolPlayerTable(Request $request): \Illuminate\View\View
    {
        // If an error code is present in the request, get the corresponding error message.
        $errorCode = $request->error;
        $error = $errorCode ? $this->getMessageErrorForCode($errorCode) : null;

        // Determine whether the request resulted in a successful enrollment attempt.
        $result = (bool) $request->result;

        // Find the team associated with the specified team ID.
        $team = Team::findOrFail($request->team_id);

        // Get all players not associated with the current team, including those not enrolled in any team.
        $players = Player::where(function($query) use ($team) {
            $query->where("team_id", "!=", $team->id)
                ->orWhereNull("team_id");
        })->get();

        Log::debug($players);

        // Render the enrollment view with the team, players, and error/success information as data.
        return view("teams.enrol", compact("team", "players", "result", "error"));
    }

    /**
     * Enrol a player to a team or confirm their enrollment, if necessary.
     *
     * @param  $request The incoming HTTP request object containing the team ID, player ID and confirmation status.
     * @return View A redirection response or a confirmation view.
     * @throws ModelNotFoundException If the specified team or player does not exist.
     */
    public function enrolPlayer(Request $request)
    {
        // Initialize variables to hold the result and error messages.
        $result = null;
        $error = null;

        // Find the team and player associated with the specified IDs.
        $team = Team::findOrFail($request->team_id);
        $player = Player::findOrFail($request->player_id);

        // If the player is already enrolled in the team, set an error message.
        if ($player->team_id === $team->id) {
            $error = sprintf(
                "Player \"%s %s\" is already enrolled in team \"%s\"!",
                $player->first_name,
                $player->last_name,
                $team->name
            );
        }
        // If the player has been confirmed for enrolment, add them to the team and set a success message.
        elseif ((bool) $request->confirmed) {
            $player->team_id = $team->id;
            $result = $player->save();
        }
        // If the player has a team but hasn't been confirmed, show the confirmation view.
        elseif ($player->team_id) {
            return view(
                "teams.enrol-confirmation",
                compact("team", "player")
            );
        }
        // Otherwise, add the player to the team and set a success message.
        else {
            $player->team_id = $team->id;
            $result = $player->save();
        }

        // Redirect to the enrolment table view with the success/error information and team ID.
        return redirect()->action(
            [TeamController::class, "enrolPlayerTable"],
            ["result" => $result, "error" => $error, "team_id" => $team->id]
        );
    }
}
