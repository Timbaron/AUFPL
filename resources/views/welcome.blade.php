@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')
<?php
$settings = getSettings();
?>
<div class="jumbotron mt-3 jumbo">
    <h1 class="display-8">Gameweek {{$settings['current_gameweek']}}</h1>

    <p class="lead">
        <a class="btn btn-secondary btn-lg" href="/my-players" role="button">My Players</a>
        @auth
        @if(auth()->user()->is_admin)
    <div class="row">
        <div class="col mb-2">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.players.points')}}" role="button">Players Point</a>
        </div>
        <div class="col mb-2">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.players.all')}}" role="button">Players</a>
        </div>
        <div class="col mb-2">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.clubs.all')}}" role="button">Clubs</a>
        </div>
        <div class="col mb-2">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.settings')}}" role="button">Settings</a>
        </div>
    </div>
    <div class="row">
        <div class="col mb-2">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.users')}}" role="button">Users</a>
        </div>
        <div class="col mb-2">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.leaders')}}" role="button">Leader's Board</a>
        </div>
    </div>
    @endif
    @endauth
    </p>

    <div class="infos">
        <div class="row">
            <div class="col mb-2">
                <div class="info">
                    Highest Points: {{getHightestPoints()}}
                </div>
            </div>
            {{--
            <div class="col mb-2">
                <div class="info">
                    Averaged Points: {{getAveragePoints()}}
                </div>
            </div>
            <div class="col mb-2">
                <div class="info">
                    Most Captained:
                    {{getMostCaptained()['name']}} <br>
                    {{ getMostCaptained()['times']}} Time(s)
                </div>
            </div> --}}
        </div>

    </div>
    <!-- <div class="info">
        MOTW:
        Akiode Timothy
    </div> -->
</div>
@endsection
