@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')
<!-- table to display all players -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Players</h3>
                    <!-- button to add new player -->
                    <a href="{{route('admin.players.add')}}" class="btn btn-primary float-right">Add Player</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Club</th>
                                <th>Position</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($players as $player)
                            <tr>
                                <td>{{$player->id}}</td>
                                <td>{{$player->name}}</td>
                                <td>{{$player->club->name}}</td>
                                <td>{{$player->position}}</td>
                                <td>{{$player->price}}</td>
                                <td>
                                    <a href="{{route('admin.players.edit', $player->player_id)}}" class="btn btn-primary">Edit</a>
                                    <a href="{{route('admin.players.delete', $player->player_id)}}" class="btn btn-danger">Delete</a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{$players->links()}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
