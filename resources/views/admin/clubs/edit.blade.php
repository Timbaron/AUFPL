@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')

<!-- form to edit club -->

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Club</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('admin.clubs.update', $club->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Club Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Club Name" value="{{$club->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="manager">Club Manager</label>
                            <input type="text" name="manager" id="manager" class="form-control" placeholder="Club Manager" value="{{$club->manager}}" required>
                        </div>
                        <div class="form-group">
                            <label for="owner">Club Owner</label>
                            <input type="text" name="owner" id="owner" class="form-control" placeholder="Club Owner" value="{{$club->owner}}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Club</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
@endsection
