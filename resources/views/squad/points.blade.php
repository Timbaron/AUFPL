@extends('layouts.app')

@section('title', 'Squad Points')

@section('content')
<?php
$total_points = 0;
$sub_points = 0;
$current_gameweek = cache()->remember('current_gameweek', 20, function () {
    getSettings()['current_gameweek'];
});
// $points = getAllPlayerPoints($current_gameweek,json_decode($selection->starters), $selection);
?>
<div class="main m-3 justify-content-center ">
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
                            {{$pointers[$data['goalkeeper']->pluck('player_id')[0]]}}
                            <?php
                            $total_points += $pointers[$data['goalkeeper']->pluck('player_id')[0]];
                            ?>
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
                                {{$pointers[$defender['player_id']]}}
                                <?php
                                $total_points += $pointers[$defender['player_id']];
                                ?>
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
                                {{$pointers[$midfielder['player_id']]}}
                                <?php
                                $total_points += $pointers[$midfielder['player_id']];
                                ?>
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
                                {{$pointers[$forward['player_id']]}}
                                <?php
                                $total_points += $pointers[$forward['player_id']];
                                ?>
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
                    {{$pointers[$player['player_id']]}}
                    <?php
                    $sub_points += $pointers[$player['player_id']];
                    ?>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
    <div class="row justify-content-center  m-3">
        <div class="col player m-4" style="text-align:center; color:red; border:1px solid blue">
            Total Points <br>
            <?php
            // foreach ($points as $point){
            //     $total_points += $point;
            // }
            // dd($selection)
            if($selection->bench_boost){
                $total_points += $sub_points;
            }
            ?>
            {{$total_points}}
            @if($selection->bench_boost)
            (Bench Boost)
            @endif
        </div>
    </div>
</div>

@endsection
