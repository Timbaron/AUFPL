@extends('layouts.app')

@section('title', 'Select Squad')

@section('content')
<p class="squadSelectInfo">You can select maximum on 3 players from a Team</p>
<p class="squadSelectInfo">Transfer Balance: ${{auth()->user()->balance}}</p>

<div class="squadSelectSearch">
    <div class="squadSelectSearchItem">
        <input type=" text" class="form-control" placeholder="Search..." size="60">
    </div>
    <select name="search_by" class="form-control squadSelectSearchItem">
        <option value="" selected>Search By</option>
        <option value="name">Player Name</option>
        <option value="name">Player Club</option>
        <option value="name">Player Position</option>
        <option value="name">Player Price</option>
    </select>
    <button class="btn">Search</button>
</div>
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
                <td><button class="btn">Add</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$players->links()}}
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#playersTable').DataTable();
    });
</script>

@endsection
