@extends('layout')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            @if ($mode === 'add')
            <h3 class="mb-5">Add new team</h3>
            @elseif($mode === 'update')
            <h3 class="mb-5">Update team</h3>
            @endif

            @if (!empty($error))
            <p class="text-danger text-lg">{{ $error }}</p>
            @endif
            @if (!empty($result) && empty($errors->messages()))
            @if ($result)
            @if ($mode === 'add')
            <p class="text-success text-lg">Successfully added new team!</p>
            @elseif($mode === 'update')
            <p class="text-success text-lg">Successfully modified team!</p>
            @endif
            @else
            <p class="text-danger text-lg">Internal error has occurred, please contact one of the admins.</p>
            @endif
            @endif

            @if ($mode === 'add')
            <form action="/team/add" method="post">
                @elseif($mode === 'update')
                <form action="/team/update" method="post">
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" id="id" name="team_id" class="form-control" value="{{ $team->id }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $team->name) }}" required>
                        @if ($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="stadium" class="form-label">Stadium</label>
                        <input type="text" id="stadium" name="stadium" class="form-control" value="{{ old('stadium', $team->stadium) }}" required>
                        @if ($errors->has('stadium'))
                        <p class="text-danger">{{ $errors->first('stadium') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="numMembers" class="form-label">Number of Members</label>
                        <input type="text" id="numMembers" name="numMembers" class="form-control" value="{{ old('numMembers', $team->numMembers) }}" required>
                        @if ($errors->has('numMembers'))
                        <p class="text-danger">{{ $errors->first('numMembers') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" id="budget" name="budget" class="form-control" value="{{ old('budget', $team->budget) }}" required>
                        @if ($errors->has('budget'))
                        <p class="text-danger">{{ $errors->first('budget') }}</p>
                        @endif
                    </div>

                    @if ($mode === 'add')
                    <button type="submit" class="btn btn-primary">Add Team</button>
                    @elseif($mode === 'update')
                    <button type="submit" class="btn btn-primary">Update Team</button>
                    @endif
                    <a href="/teams/manage" class="btn btn-secondary mt-2">Cancel</a>

                </form>
                <!-- This Cancel button is outside the form and directly links back to the manage page, ensuring no form submission occurs -->
        </div>
    </div>
</div>


@if ($mode === 'update')
<div class="container my-5">
    <h3>Current players</h3>
    <div class="row">
        <div class="d-flex gap-3">
            <form action="/team/enrol-player-table" method="get" class="my-3">
                <button name="team_id" value="{{ $team->id }}" class="btn btn-primary">
                    <a class="no-style text-white">
                        Enrol players
                    </a>
                </button>
            </form>
            <form action="/team/unenrol-confirmation" method="post" class="my-3">
                @csrf
                <input type="hidden" name="apply_all" value="true">
                <button name="team_id" value="{{ $team->id }}" class="btn btn-danger">
                    <a class="no-style text-white">
                        Unenrol all
                    </a>
                </button>
            </form>
        </div>
        @if (empty($players))
        <p class="text-danger">There are no players to display!</p>
        @else
        @if (!empty($unenrollmentResult))
        @if ($unenrollmentResult)
        <h6 class="text-success my-5">Successfully unenrolled player!</h6>
        @else
        <h6 class="text-danger my-5">{{ $error }}</h6>
        @endif
        @endif

        @if (!empty($unsubAllResult))
        @if ($unsubAllResult === true)
        <h6 class="text-success my-5">Successfully unenrold all players!</h6>
        @else
        <h6 class="text-danger my-5">{{ $error }}</h6>
        @endif
        @endif



        <table class="table table-hover filterable-table paginated-table">
            <thead>
                <tr class="table-primary">
                    <th class="text-center" scope="col">First name</th>
                    <th class="text-center" scope="col">Last name</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($players as $player)
                <tr class="table-light">
                    <td class="text-center">{{ $player->first_name }}</td>
                    <td class="text-center">{{ $player->last_name }}</td>
                    <td class="d-flex justify-content-center gap-3">
                        <form action="/team/unenrol-confirmation" method="post">
                            @csrf
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
                            <button type="submit" name="player_id" value="{{ $player->id }}" class="btn btn-danger">Unenrol</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endif
@endsection