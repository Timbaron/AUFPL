@extends('layouts.app')

@section('title', 'Select Squad')

@section('content')
<div class="main mt-3">
    <form action="{{route('select.confirm')}}" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="goalkeepers">
                    <div class="row justify-content-center  m-3">
                        <div class="col-md-5" style="text-align: center; border-radius:9px;">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Goalkeeper</label>
                                <select class="form-control" name="goalkeeper[]">
                                    @foreach($goalkeepers as $gk)
                                    <option value="{{$gk->player_id}}">{{getPlayerNameById($gk->player_id)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="defenders">
                    <div class="row justify-content-center  m-3">
                        <label for="exampleFormControlSelect1" style="text-align:center">Select Defenders</label><br>
                    </div>
                    <div class="row justify-content-center  m-3">
                        @foreach($defenders as $df)
                        <div class="col" style="text-align: center">
                            <select class="form-control" name="defenders[]">
                                <option value="" selected>---------</option>
                                <option value="{{$df->player_id}}">{{getPlayerNameById($df->player_id)}}</option>
                            </select>
                        </div>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="midfielders">
                    <div class="row justify-content-center  m-3">
                        <label for="exampleFormControlSelect1" style="text-align:center">Select Midfielders</label><br>
                    </div>
                    <div class="row justify-content-center  m-3">
                        @foreach($midfielders as $mf)
                        <div class="col" style="text-align: center">
                            <select class="form-control" name="midfielders[]">
                                <option value="" selected>---------</option>
                                <option value="{{$mf->player_id}}">{{getPlayerNameById($mf->player_id)}}</option>
                            </select>
                        </div>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="forwards">
                    <div class="row justify-content-center  m-3">
                        <label for="exampleFormControlSelect1" style="text-align:center">Select Forwards</label><br>
                    </div>
                    <div class="row justify-content-center  m-3">
                        @foreach($forwards as $fw)
                        <div class="col" style="text-align: center">
                            <select class="form-control" name="forwards[]">
                                <option value="" selected>---------</option>
                                <option value="{{$fw->player_id}}">{{getPlayerNameById($fw->player_id)}}</option>
                            </select>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center  m-3">
            <div class="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Captain</label>
                    <select class="form-control" name="captain">
                        @foreach($goalkeepers as $gk)
                        <option value="{{$gk->player_id}}">{{getPlayerNameById($gk->player_id)}}</option>
                        @endforeach
                        @foreach($defenders as $df)
                        <option value="{{$df->player_id}}">{{getPlayerNameById($df->player_id)}}</option>
                        @endforeach
                        @foreach($midfielders as $mf)
                        <option value="{{$mf->player_id}}">{{getPlayerNameById($mf->player_id)}}</option>
                        @endforeach
                        @foreach($forwards as $fw)
                        <option value="{{$fw->player_id}}">{{getPlayerNameById($fw->player_id)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Vice Captain</label>
                    <select class="form-control" name="vice_captain">
                        @foreach($goalkeepers as $gk)
                        <option value="{{$gk->player_id}}">{{getPlayerNameById($gk->player_id)}}</option>
                        @endforeach
                        @foreach($defenders as $df)
                        <option value="{{$df->player_id}}">{{getPlayerNameById($df->player_id)}}</option>
                        @endforeach
                        @foreach($midfielders as $mf)
                        <option value="{{$mf->player_id}}">{{getPlayerNameById($mf->player_id)}}</option>
                        @endforeach
                        @foreach($forwards as $fw)
                        <option value="{{$fw->player_id}}">{{getPlayerNameById($fw->player_id)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Bench Boost?</label>
                    <select class="form-control" name="bench_boost">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Triple Captain?</label>
                    <select class="form-control" name="triple_captain">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center m-3">
            <button class="btn mb-2">Confirm Selection</button>
        </div>
    </form>
</div>

@endsection
