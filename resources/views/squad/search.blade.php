@extends('layouts.app')

@section('title', 'Select Squad')

@section('content')
<p class="squadSelectInfo">You can select maximum on 3 players from a Team
    <a href="{{route('cart')}}">
        <button type="button" class="btn btn-primary">
            Cart <span class="badge badge-light">{{$cart}}</span>
        </button>
    </a>
</p>
<p class="squadSelectInfo">Transfer Balance: ${{auth()->user()->balance}}</p>
<form method="post" action="{{route('player.search')}}">
    @csrf
    <div class="squadSelectSearch">
        <div class="squadSelectSearchItem">
            <input type="text" name="search_term" class="form-control" placeholder="Search..." size="60" required>
        </div>
        <select name="search_by" class="form-control squadSelectSearchItem">
            <option value="" selected>Search By</option>
            <option value="name">Player Name</option>
            <option value="club">Player Club</option>
            <option value="position">Player Position</option>
            <option value="price">Player Price</option>
        </select>
        <button class="btn">Search</button>
    </div>
</form>
<div id="kt-datatable">
    <table class="table mt-3" role="grid" style="color:white">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Player Name</th>
                <th>Player Club</th>
                <th>Player Position</th>
                <th>Player Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$player->name}}</td>
                <td>{{$player->club->name}}</td>
                <td>{{$player->position}}</td>
                <td>${{$player->price}}</td>
                <form action="{{route('cart.add')}}" method="post">
                    @csrf
                    <input type="hidden" name="player_id" value="{{$player->player_id}}">
                    <input type="hidden" name="player_price" value="{{$player->price}}">
                    <input type="hidden" name="player_position" value="{{$player->position}}">
                    <input type="hidden" name="player_club" value="{{$player->club->name}}">
                    <td><button class="btn" type="submit">Add</button></td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$players->links()}}
</div>


@endsection
