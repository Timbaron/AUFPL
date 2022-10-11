@extends('layouts.app')

@section('title', 'Players Update')

@section('content')
<!-- Button/link to run artisan command -->
<div style="text-align:center; " class="m-3">
    <a href="{{ route('admin.players.Generalupdate') }}" class="btn btn-primary">General Points Update</a>
</div>

<div class="container" style="color:white">
    <div class="col-md-12">
        @foreach($clubs as $club)
        <div class="panel panel-default">
            <div class="panel-heading mt-3">
                {{$club->name}}
            </div>
            <div class="panel-body">
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Player Name</th>
                            <th>Player Price</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($club->players as $player)
                        <tr data-toggle="collapse" data-target="#player-{{$player->id}}" class="accordion-toggle">
                            <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                            <td>{{$player->name}}</td>
                            <td>{{$player->price}}</td>
                            <td>{{$player->position}}</td>
                        </tr>
                        <tr>
                            <td colspan="12" class="hiddenRow">
                                <div class="accordian-body collapse" id="player-{{$player->id}}">
                                    <form action="{{route('admin.players.update.points')}}" method="post">
                                        @csrf
                                        <?php
                                        $points = getFullPlayerPoints($player->player_id);
                                        ?>
                                        <div class="row">
                                            <input type="hidden" name="player_id" value="{{$player->player_id}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Own Goals</label>
                                                    <input type="number" class="form-control" value="{{$points['own_goal'] ?? 0}}" name="own_goal" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Number of Own Goals" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Minutes Played</label>
                                                    <input type="number" class="form-control" value="{{$points['minutes'] ?? 0}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="minutes" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Yellow Card</label>
                                                    <select class="form-control form-control-sm" name="yellow_card">
                                                        <!-- if true select yes -->
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Red Card</label>
                                                    <select class="form-control form-control-sm" name="red_card">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Goals</label>
                                                    <input type="number" class="form-control" value="{{$points['goals'] ?? 0}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Number of Goals" name="goal" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Assist</label>
                                                    <input type="number" class="form-control" value="{{$points['assist'] ?? 0}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Number of Assists" name="assist" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">MOTM</label>
                                                    <select class="form-control form-control-sm" name="motm">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Penalty Missed</label>
                                                    <input type="number" class="form-control" value="{{$points['penalty_missed'] ?? 0}}" name="penalty_missed" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter number of penalty missed" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if($player->position != 'FW' || $player->position != 'MF')
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Cleansheet</label>
                                                    <select class="form-control form-control-sm" name="cleansheet">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Goals Conceded</label>
                                                    <input type="number" name="goals_conceded" value="{{$points['goals_conceded'] ?? 0}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter total goals conceded" min="0" required>
                                                </div>
                                            </div>
                                            @endif
                                            @if ($player->position == 'GK')
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Penalty Saved</label>
                                                    <input type="number" name="penalty_saved" value="{{$points['penalty_saved'] ?? 0}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter number of penalty saved" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Saves</label>
                                                    <input type="number" name="saves" value="{{$points['saves'] ?? 0}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter total saves" min="0" required>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="row justify-content-center">
                                            <button type="submit" class="btn">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        @endforeach

    </div>
</div>


@endsection
