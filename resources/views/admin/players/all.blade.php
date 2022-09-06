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
                                    <button type="button" class="btn btn-danger mt-2" data-id="{{$player->player_id}}" data-toggle="modal" data-target="#player-{{$player->player_id}}">
                                        Delete
                                    </button>
                                    <!-- <a href="{{route('admin.players.delete', $player->player_id)}}" class="btn btn-danger">Delete</a> -->
                                </td>

                            </tr>
                            <div class="modal fade" id="player-{{$player->player_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this user?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- get data-id from button -->
                                            <form action="{{route('admin.players.delete')}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="player_id" id="player_id" value="{{$player->player_id}}">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Yes, Delete</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>
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
