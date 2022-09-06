@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')

<!-- table that display all clubs -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Clubs</h3>
                    <!-- button to add new club -->
                    <a href="{{route('admin.clubs.add')}}" class="btn btn-primary float-right">Add New Club</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Club Name</th>
                                <th>Club Manager</th>
                                <th>Club Owner</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clubs as $club)
                            <tr>
                                <td>{{$club->name}}</td>
                                <td>{{$club->manager}}</td>
                                <td>{{$club->owner}}</td>
                                <td>
                                    <a href="{{route('admin.clubs.edit', $club->id)}}" class="btn btn-primary mb-2">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
