@extends('layout')
@section('content')
    <!-- Player management container -->
    <div class="container my-5">
        <!-- Page header -->
        <!-- Add player button -->
        <div class="row">
        <h3>Manage Players</h3>

            <div class="my-3">
                <button class="btn btn-primary"><a class="no-style text-white" href="/player/add">Add New Player</a></button>
            </div>
            <!-- No players message -->
            @if (empty($players))
                <h6 class="text-danger my-5">There are currently no players to display!</h6>
            <!-- Error message -->
            @elseif (!empty($error))
                <h6 class="text-danger my-5">{{ $error }}</h6>
            <!-- Deletion result message -->
            @elseif (!empty($deletionResult) && $deletionResult === true)
                <h6 class="text-success">Player successfully deleted!</h6>
            @endif

            <!-- Player table -->
            <table class="table table-hover filterable-table paginated-table">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center" scope="col">First Name</th>
                        <th class="text-center" scope="col">Last Name</th>
                        <th class="text-center" scope="col">Position</th>
                        <th class="text-center" scope="col">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($players as $player)
                        <tr class="table-light">
                            <td class="text-center">{{ $player->first_name }}</td>
                            <td class="text-center">{{ $player->last_name }}</td>
                            <td class="text-center">{{ $player->position }}</td>
                            <td class="d-flex justify-content-center gap-3">
                                <!-- Update player button -->
                                <form action="/player/update">
                                    @csrf
                                    <a href="{{ route('player.update.form', ['player' => $player->id]) }}" class="btn btn-primary">Update</a>
                                </form>
                                <!-- Confirm deletion button -->
                                <form action="/player/confirm-deletion" method="post">
                                    @csrf
                                    <button type="submit" name="player_id" value="{{ $player->id }}"
                                        class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
