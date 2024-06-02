@extends('layout')
@section('content')

<div class="container my-5">
    <h3>Manage Basketball Teams</h3>
    <div class="row">
        <!-- Add team button -->
        <div class="my-3">
            <button class="btn btn-primary"><a class="no-style text-white" href="/team/add">Add team</a></button>
        </div>
        <!-- Show error message if there are no teams to display -->
        @if (empty($teams))
        <h6 class="text-danger my-5">There are no teams to display!</h6>

        <!-- Show error message if there was an error retrieving teams -->
        @else
        @if (!empty($error))
        <h6 class="text-danger my-5">{{ $error }}</h6>
        @endif

        <!-- Show success message if a team was successfully deleted -->
        @if (!empty($deletionResult))
        @if ($deletionResult === true)
        <h6 class="text-success"> Successfully deleted team!</h6>
        @endif
        @endif

        <!-- Table of teams -->
        <table class="table table-hover filterable-table paginated-table">
            <thead>
                <!-- Table header -->
                <tr class="table-primary">
                    <th class="text-center" scope="col">Team names</th>
                    <th class="text-center" scope="col">stadium</th>
                    <th class="text-center" scope="col">numMembers</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through teams and display them in the table -->
                @foreach ($teams as $team)
                <tr class="table-light">
                    <td class="text-center">{{ $team->name }}</td>
                    <td class="text-center">{{ $team->stadium }}</td>
                    <td class="text-center">{{ $team->numMembers }}</td>
                    <td class="d-flex justify-content-center gap-3">
                        <!-- Update team button -->
                        <form action="/team/update" method="get">
                            <button type="submit" name="team_id" value="{{ $team->id }}" class="btn btn-primary">Update</button>
                        </form>
                        <!-- Delete team button -->
                        <form action="/team/confirm-deletion" method="post">
                            @csrf
                            <button type="submit" name="team_id" value="{{ $team->id }}" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
</div>
</div>
@endsection