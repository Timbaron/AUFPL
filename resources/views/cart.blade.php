@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
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
            @foreach($cartItems as $player)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ getPlayerNameById($player->player_id)}}</td>
                <td>{{$player->player_club}}</td>
                <td>{{$player->player_position}}</td>
                <td>${{$player->player_price}}</td>
                <form action="{{route('cart.remove')}}" method="post">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{$player->id}}">
                    <td><button class="btn" type="submit">Remove</button></td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
