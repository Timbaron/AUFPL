@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')

<!-- form to display pllayer details -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Player</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('admin.players.update', $player->player_id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{$player->name}}">
                        </div>
                        <div class="form-group">
                            <label for="club">Club</label>
                            <select name="club_id" id="club_id" class="form-control">
                                @foreach ($clubs as $club)
                                <option value="{{$club->id}}" @if($club->id == $player->club_id) selected @endif>{{$club->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <select name="position" id="position" class="form-control">
                                <option value="GK" @if($player->position == 'GK') selected @endif>Goal Keeper</option>
                                <option value="DF" @if($player->position == 'DF') selected @endif>Defender</option>
                                <option value="MF" @if($player->position == 'MF') selected @endif>Midfielder</option>
                                <option value="FW" @if($player->position == 'FW') selected @endif>Forward</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" step="any" id="price" class="form-control" value="{{$player->price}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection

