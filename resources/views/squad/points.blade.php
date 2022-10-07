@extends('layouts.app')

@section('title', 'Squad Points')

@section('content')
<?php
$total_points = 0;
$current_gameweek = cache()->remember('current_gameweek',20, function (){
    getSettings()['current_gameweek'];
});
$points = getAllPlayerPoints($current_gameweek,json_decode($selection->starters), $selection);
?>
<div class="main m-3 justify-content-center ">
    <div class="row justify-content-center  m-3">
        <div class="col player mt-4" style="text-align:center;">
            Total Points <br>
            <?php
                foreach ($points as $point){
                    $total_points += $point;
                }
            ?>
                {{$total_points}}
        </div>
    </div>
    <div class="row justify-content-center  m-3">
        <div class="col mt-2" style="border-right: 1px solid #000">
            <div class="goalkeepers">
                <div class="row justify-content-center m-3">
                    <div class="col-md-4 player">
                        @if($selection['captain'] == $data['goalkeeper']->pluck('player_id'))
                        <span class="badge" style="height:fit-content; color:blue">C</span>
                        @endif
                        @if($selection['vice_captain'] == $data['goalkeeper']->pluck('player_id'))
                        <span class="badge" style="height:fit-content; color:#d61212">V</span>
                        @endif
                        <div style="text-align:center;" class="">
                            {{$data['goalkeeper']->pluck('name')[0]}} <br>
                            {{$points[$data['goalkeeper']->pluck('player_id')[0]] ?? 0}}

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="defenders">
                <div class="row justify-content-center  m-3">
                    @foreach($data['defenders'] as $defender)
                    <div class="col mt-2 player">
                        @if($selection['captain'] == $defender['player_id'])
                        <span class="badge" style="height:fit-content; color:blue">C</span>
                        @endif
                        @if($selection['vice_captain'] == $defender['player_id'])
                        <span class="badge" style="height:fit-content; color:#d61212">V</span>
                        @endif
                        <div style="text-align:center">
                            {{$defender['name']}} <br>
                            <div class="points">
                                {{$points[$defender['player_id']] ?? 0}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="midfielders">

                <div class="row justify-content-center  m-3">
                    @foreach($data['midfielders'] as $midfielder)
                    <div class="col mt-2 player">
                        @if($selection['captain'] == $midfielder['player_id'])
                        <span class="badge" style="height:fit-content; color:blue">C</span>
                        @endif
                        @if($selection['vice_captain'] == $midfielder['player_id'])
                        <span class="badge" style="height:fit-content; color:#d61212">V</span>
                        @endif
                        <div style="text-align:center" data-toggle="tooltip" data-placement="top" title="">
                            {{$midfielder['name']}} <br>
                            <div class="points">
                                {{$points[$midfielder['player_id']] ?? 0}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="forwards">
                <div class="row justify-content-center  m-3">
                    @foreach($data['forwards'] as $forward)
                    <div class="col mt-2 player">
                        @if($selection['captain'] == $forward['player_id'])
                        <span class="badge" style="height:fit-content; color:blue">C</span>
                        @endif
                        @if($selection['vice_captain'] == $forward['player_id'])
                        <span class="badge" style="height:fit-content; color:#d61212">V</span>
                        @endif
                        <div style="text-align:center">
                            {{$forward['name']}} <br>
                            <div class="points">
                                {{$points[$forward['player_id']] ?? 0}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div class="row justify-content-center">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Subtitute</label>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach($bench as $sub)
        @foreach($sub as $player)
        <div class="col-sm-3 mt-2 player">
            @if($selection['captain'] == $player['player_id'])
            <span class="badge" style="height:fit-content; color:blue">C</span>
            @endif
            @if($selection['vice_captain'] == $player['player_id'])
            <span class="badge" style="height:fit-content; color:blue">C</span>
            @endif
            <div style="text-align:center">
                {{$player['name']}} <br>
                <div class="points">
                    {{$points[$player['player_id']] ?? 0}}
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
</div>
</div>

@endsection
