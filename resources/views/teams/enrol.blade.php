@extends('layout')
@section('content')
<div class="container my-5">
    <h3 class="my-5">Enrol players to team "{{ $team->name }}"</h3>
    <div class="row">
        <div class="my-3">
            <button class="btn btn-md btn-primary"><a class="no-style text-white" href="{{ route('team.update', ['team_id' => $team->id]) }}">Back to team</a></button>
        </div>
        {{-- Display error message if there are no players --}}
        @if (empty($players))
        <h6 class="text-danger my-5">There are no players to display!</h6>
        {{-- Display error message if there is an error --}}
        @elseif (!empty($error))
        <h6 class="text-danger my-5">{{ $error }}</h6>
        {{-- Display success message if a player has been enrolled --}}
        @elseif (!empty($result) && $result === true)
        <h6 class="text-success my-5">
            Successfully enrolled player to team "{{ $team->name }}!"
        </h6>
        @endif
        {{-- Player table --}}
        <table class="table table-hover filterable-table paginated-table">
            <thead>
                <tr class="table-primary">
                    <th class="text-center" scope="col">First name</th>
                    <th class="text-center" scope="col">Last name</th>
                    <th class="text-center" scope="col">Team</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                <tr class="table-light">
                    <td class="text-center">{{ $player->first_name }}</td>
                    <td class="text-center">{{ $player->last_name }}</td>
                    <td class="text-center">{{ $player->team ? $player->team->name : 'None' }}</td>
                    {{-- Enrol player button --}}
                    <td class="d-flex justify-content-center gap-3">
                        <form action="/team/enrol-player" method="post">
                            @csrf
                            <input type="hidden" name="player_id" value="{{ $player->id }}">
                            <button type="submit" name="team_id" value="{{ $team->id }}" class="btn btn-success">Enrol</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection