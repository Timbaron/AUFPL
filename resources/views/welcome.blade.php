@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')
<div class="jumbotron mt-3 jumbo">
    <h1 class="display-8">Gameweek 1</h1>

    <p class="lead">
        <a class="btn btn-secondary btn-lg" href="/select-squad" role="button">My Squad</a>
        @auth
        @if(auth()->user()->is_admin)
        <a class="btn btn-secondary btn-lg" href="{{route('admin.players.points')}}" role="button">Players Point</a>
        <a class="btn btn-secondary btn-lg" href="{{route('admin.players.all')}}" role="button">Players</a>
        <a class="btn btn-secondary btn-lg" href="{{route('admin.clubs.all')}}" role="button">Clubs</a>
        <a class="btn btn-secondary btn-lg" href="{{route('admin.settings')}}" role="button">Settings</a>
        @endif
        @endauth
    </p>

    <div class="infos">
        <div class="info">
            Highest Points: 232
        </div>
        <div class="info">
            Averaged Points: 32
        </div>
        <div class="info">
            MOTW:
            Akiode Timothy
        </div>
        <div class="info">
            Most Captained:
            Donkeeng
        </div>
    </div>
</div>
@endsection
