@extends('layouts.app')

@section('title', 'Select Squad')

@section('content')
<?php
$settings = getSettings();
?>

<!-- table to display all players -->

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Players</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Purchase Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $player)
                            <tr>
                                <td>{{getPlayerNameById($player->player_id)}}</td>
                                <td>{{$player->player_position}}</td>
                                <td>{{$player->player_price}}</td>
                                <td>
                                    <form action="{{route('my.player.sell')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="player_id" value="{{$player->player_id}}">
                                        <button type="submit" class="btn btn-info">Sell</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
