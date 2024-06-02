@extends('layout')
@section('content')
<!-- Player management container -->
<div class="container my-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <!-- Add or update player header -->
            @if ($mode === 'add')
            <h3 class="mb-5">Add New Player</h3>
            @elseif($mode === 'update')
            <h3 class="mb-5">Update Player</h3>
            @endif
            <!-- Error message -->
            @if (!empty($error))
            <p class="text-danger text-lg">{{ $error }}</p>
            @endif
            <!-- Result message -->
            @if (!empty($result) && empty($errors->messages()))
            @if ($result)
            @if ($mode === 'add')
            <p class="text-success text-lg">Player successfully added!</p>
            @elseif($mode === 'update')
            <p class="text-success text-lg">Player successfully updated!</p>
            @endif
            @else
            <p class="text-danger text-lg">Couldn't process your request. Please contact an admin.</p>
            @endif
            @endif
            <!-- Player form -->
            @if ($mode === 'add')
            <form action="{{ route('player.add') }}" method="post">
            @elseif($mode === 'update')
            <!-- Ensure the form action dynamically includes the player's ID -->
            <form action="{{ route('player.update', ['player' => $player->id]) }}" method="post">
            @endif
            @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" id="id" name="player_id" class="form-control" value="{{ $player->id }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $player->first_name) }}" class="form-control" required>
                        <!-- First name error message -->
                        @if ($errors->has('first_name'))
                        <p class="text-danger">{{ $errors->first('first_name') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $player->last_name) }}" class="form-control" required>
                        <!-- Last name error message -->
                        @if ($errors->has('last_name'))
                        <p class="text-danger">{{ $errors->first('last_name') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <select name="position" id="position" class="form-control" required>
                        <option value="">Select a position</option>
                        <option value="Point Guard"{{ old('position', $player->position) == 'Point Guard' ? ' selected' : '' }}>Point Guard</option>
                        <option value="Shooting Guard"{{ old('position', $player->position) == 'Shooting Guard' ? ' selected' : '' }}>Shooting Guard</option>
                        <option value="Small Forward"{{ old('position', $player->position) == 'Small Forward' ? ' selected' : '' }}>Small Forward</option>
                        <option value="Power Forward"{{ old('position', $player->position) == 'Power Forward' ? ' selected' : '' }}>Power Forward</option>
                        <option value="Center"{{ old('position', $player->position) == 'Center' ? ' selected' : '' }}>Center</option>
                    </select>
                    <!-- Position error message -->
                    @if ($errors->has('position'))
                    <p class="text-danger">{{ $errors->first('position') }}</p>
                    @endif
                </div>

                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" id="salary" name="salary" value="{{ old('salary', $player->salary) }}" class="form-control" required>
                        <!-- Salary error message -->
                        @if ($errors->has('salary'))
                        <p class="text-danger">{{ $errors->first('salary') }}</p>
                        @endif
                    </div>
                    <!-- Add or update player button -->
                    @if ($mode === 'add')
                    <button type="submit" class="btn btn-primary">Add Player</button>
                    @elseif($mode === 'update')
                    <button type="submit" class="btn btn-primary">Update Player</button>
                    @endif
                    <!-- Cancel button -->
                    <a href="/players/manage" class="btn btn-secondary">Cancel</a>
                </form>
        </div>
    </div>
</div>
@endsection