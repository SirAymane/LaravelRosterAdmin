@extends('layout')
@section('content')
<div class="container my-5">
    <h3>Unenrol Player</h3>
    <div class="row">
        <div class="my-5">
            @if (empty($applyAll))
            <h4 class="">Are you sure you want to unenrol player
                "{{ $player->first_name . ' ' . $player->last_name }}" from team "{{ $team->name }}"?</h4>
            @else
            <h4 class="">Are you sure you want to unenrol all players from team "{{ $team->name }}"?</h4>
            @endif
        </div>
        <div class="d-flex justify-content-center gap-5">
            @if (empty($applyAll))
            <form action="/team/unenrol-player" method="post">
                @csrf
                <input type="hidden" name="team_id" value="{{ $team->id }}">
                <button type="submit" name="player_id" value="{{ $player->id }}" class="btn btn-lg btn-success">Yes</button>
            </form>
            @else
            <form action="/team/unenrol-all" method="post">
                @csrf
                <button type="submit" name="team_id" value="{{ $team->id }}" 
                class="btn btn-lg btn-success">Yes</button>
            @endif
            </form>
            
            <div>
                <button class="btn btn-lg btn-danger"><a class="no-style text-white"
                        href="{{ route('team.update', ['team_id' => $team->id]) }}">No</a></button>
            </div>
        </div>
    </div>
</div>
@endsection