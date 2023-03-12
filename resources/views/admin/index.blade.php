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
        background-color: #10523a; 
        width: 200px; 
        height: 200px; 
        display: flex; 
        justify-content: center; 
        align-items: center;
        margin: 20px;
        color: white;
        font-size: 25px;
        text-align: center;
    }

</style>
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row mt-3">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <a class="big-btn-a" href="{{ route('data-form') }}">
                    <div class="big-btn">
                        Data Collection Tool
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <a class="big-btn-a" href="#"> 
                    <div class="big-btn">
                        Sorting
                    </div>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <a class="big-btn-a" href="#">
                    <div class="big-btn">
                        Reports
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
