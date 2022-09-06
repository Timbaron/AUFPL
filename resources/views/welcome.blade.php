@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')
<?php
$settings = getSettings();
?>
<div class="jumbotron mt-3 jumbo">
    <h1 class="display-8">Gameweek {{$settings['current_gameweek']}}</h1>

    <p class="lead">
        <a class="btn btn-secondary btn-lg" href="/select-squad" role="button">My Squad</a>
        @auth
        @if(auth()->user()->is_admin)
    <div class="row">
        <div class="col">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.players.points')}}" role="button">Players Point</a>
        </div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.players.all')}}" role="button">Players</a>
        </div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.clubs.all')}}" role="button">Clubs</a>
        </div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" href="{{route('admin.settings')}}" role="button">Settings</a>
        </div>
    </div>
    @endif
    @endauth
    </p>

    <div class="infos">
        <div class="info">
            Highest Points: {{getHightestPoints()}}
        </div>
        <div class="info">
            Averaged Points: {{getAveragePoints()}}
        </div>
        <!-- <div class="info">
            MOTW:
            Akiode Timothy
        </div> -->
        <div class="info">
            Most Captained:
            {{getMostCaptained()['name']}} <br>
            {{ getMostCaptained()['times']}} Time(s)
        </div>
    </div>
</div>
@endsection
