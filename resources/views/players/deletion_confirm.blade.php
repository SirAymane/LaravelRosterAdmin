@extends('layout')
@section('content')
    <!-- Confirmation message container -->
    <div class="row" style="height: 35rem;">
        <!-- Confirmation message header -->
        <div class="d-flex justify-content-center align-items-center">
            <h3 class="">Confirm Deletion</h3>
        </div>
        <!-- Confirmation buttons -->
        <div class="d-flex justify-content-center gap-5">
            <!-- Delete player form -->
            <form action="/player/delete" method="post">
                @csrf
                <!-- Hidden input with player ID -->
                <input type="hidden" name="player_id" value="{{ $player->id }}">
                <!-- "Yes" button to confirm deletion -->
                <button name="player_id" value="{{ $player->id }}" class="btn btn-lg btn-success">Yes, Delete "{{ $player->first_name . ' ' . $player->last_name }}"</button>
            </form>
            <!-- "No" button to cancel deletion -->
            <div>
                <button class="btn btn-lg btn-danger"><a class="no-style text-white"
                        href="{{ route('player.manage') }}">No, Cancel</a></button>
            </div>
        </div>
    </div>
@endsection
