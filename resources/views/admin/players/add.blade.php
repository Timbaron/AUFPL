@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')
<!-- form to add players -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Player</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('admin.players.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter player name" required>
                        </div>
                        <div class="form-group">
                            <label for="club">Club</label>
                            <select name="club_id" id="club" class="form-control" required>
                                <option value="">Select Club</option>
                                @foreach ($clubs as $club)
                                <option value="{{$club->id}}">{{$club->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <select name="position" id="position" class="form-control" required>
                                <option value="">Select Position</option>
                                <option value="Goalkeeper">Goalkeeper</option>
                                <option value="Defender">Defender</option>
                                <option value="Midfielder">Midfielder</option>
                                <option value="Forward">Forward</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" step="any" id="price" class="form-control" placeholder="Enter player price" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Player</button>
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
