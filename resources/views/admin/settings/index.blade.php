@extends('layouts.app')

@section('title', 'Anchor University Premier League')

@section('content')

<!-- form to add new admin settings -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Admin Settings</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('admin.settings.update')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Current Gameweek</label>
                            <input type="number" name="current_gameweek" id="name" value="1" class="form-control" placeholder="Current Gameweek" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="manager">Transfer Window</label>
                            <select name="transfer_window_open" class="form-control" required>
                                <!-- select yes if settings transfer window is open -->

                                <option value="1" @if($settings->transfer_window_open == '1') selected @endif
                                    >Open</option>
                                <option value="0">Closed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="manager">Squad Selection</label>
                            <select name="squad_selection_open" class="form-control" required>
                                <option value="1">Open</option>
                                <option value="0">Closed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Setting</button>
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
