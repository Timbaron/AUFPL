@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Players Points</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="users" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <th>GW Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($points as $point)
                            <tr>
                                <td>{{$point->user->name}}</td>
                                <td>{{$point->user->email}}</td>
                                <td>{{$point->user->balance}}</td>
                                <td>
                                    {{$point->points}}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$points->links()}}
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
