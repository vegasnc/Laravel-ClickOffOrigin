@extends('layouts.noref')
@section('title',"ClickMatrix | Dashboard")
@section('vuescript')
<script src="{{asset('js/dashboard.js')}}"></script>
@endsection
@section('content')
<style>
    .big-btn-a {
        display: flex;
        justify-content: center
    }
    .big-btn {
        background-color: green; 
        border-radius: 50%; 
        width: 200px; 
        height: 200px; 
        display: flex; 
        justify-content: center; 
        align-items: center;
        margin: 20px;
        color: white;
        font-size: 25px;
    }

</style>
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row mt-3">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <a class="big-btn-a" href="{{ route('datacollection') }}">
                    <div class="big-btn">
                        Collect Data
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <a class="big-btn-a" href="{{ route('datacollection') }}"> 
                    <div class="big-btn">
                        Sorting
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <a class="big-btn-a" href="{{ route('datacollection') }}">
                    <div class="big-btn">
                        Sorting Reports
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <a class="big-btn-a" href="{{ route('datacollection') }}"> 
                    <div class="big-btn">
                        Hello
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
