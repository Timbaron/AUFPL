@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')

<!-- form to add new club -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Club</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('admin.clubs.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Club Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Club Name" required>
                        </div>
                        <div class="form-group">
                            <label for="manager">Club Manager</label>
                            <input type="text" name="manager" id="manager" class="form-control" placeholder="Club Manager" required>
                        </div>
                        <div class="form-group">
                            <label for="owner">Club Owner</label>
                            <input type="text" name="owner" id="owner" class="form-control" placeholder="Club Owner" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Club</button>
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
