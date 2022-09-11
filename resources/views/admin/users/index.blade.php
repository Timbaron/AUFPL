@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')

<!-- View users table -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="users" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Balance</th>
                                <th>Approved?</th>
                                <th>Admin?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->balance}}</td>
                                <td>
                                    @if($user->approved)
                                    <form action="{{route('admin.users.disapprove')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="submit" class="btn btn-danger">Disapprove</button>
                                    </form>
                                    @else
                                    <form action="{{route('admin.users.approve')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_admin)
                                    <form action="{{route('admin.users.removeAdmin')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="submit" class="btn btn-danger">Remove Admin</button>
                                    </form>
                                    @else
                                    <form action="{{route('admin.users.makeAdmin')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <button type="submit" class="btn btn-success">Make Admin</button>
                                    </form>
                                    @endif

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
