@extends('layouts.noref')
@section('title',"ClickMetrix | DataCollection")

@section('content')
 
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="mb-0 text-center">ClickMetrix</h1>
      </div><!-- /.col -->
      <!-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v1</li>
        </ol>
      </div> --><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Main row -->
    <div class="row mt-3 h-100 justify-content-center align-items-center">
        <!-- Left col -->
        <section class="col-lg-6">

          <!-- Customer Information-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                Edit Data
              </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0">
              <form action="{{ route('data-update',$user->id) }}" method="POST">
                  @csrf
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row"> 
                          <div class="col-sm-6">
                            <div class="form-group">
                                <strong>Please Select Asset Types</strong>
                                <select class="form-control select2 select2-success" data-dropdown-css-class="select2-success" id="asset" name="asset" style="width: 100%;">
                                  <option value="">Please Select</option>
                                  <option value="1">Add New Asset</option>
                                  @foreach($asset as $key=>$val)
                                    @if($user->asset == $val['name'])
                                    <option value="{{$val['name']}}" selected>{{$val['name']}}</option>
                                    @else
                                    <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    @endif
                                  @endforeach
                                </select>  
                            </div>
                          </div>
                          <div class="col-sm-6"  style="display:none;" id="addnewasset">
                              <div class="form-group">
                                <strong>Or Add New Asset Type</strong>
                                <input type="text" id="addnewasset" name="addnewasset" class="form-control" placeholder="Enter Asset Name">
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Live Location</strong>
                              <button type="button" class="btn btn-success green-btn mb-1" onclick="getLocation()">Click here</button>
                              <input type="hidden" id="latitude" name="latitude" class="form-control mb-1" placeholder="Latitude" value="{{ $user->latitude }}">
                              <input type="hidden" id="longitude" name="longitude" class="form-control" placeholder="Longitude" value="{{ $user->longitude }}">
                              <p id="demo"></p>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Address</strong>
                              <textarea class="form-control" name="autoaddress" id="autoaddress" placeholder="Address" row="2">{{ $user->autoaddress }}</textarea>
                          </div>
                      </div>
                      
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Add Address Manually (optional)</strong>
                              <textarea class="form-control" name="address" placeholder="Address" row="2">{{ $user->address }}</textarea>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Quantity<span class="red">*</span></strong>
                              <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="{{ $user->quantity }}" required >
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Condition</strong>
                              <select class="form-control select2 select2-success" data-dropdown-css-class="select2-success" id="condition" name="condition" style="width: 100%;">
                                <option value="Like New" {{ $user->condition=="Like New" ? 'Selected' : '' }}>Like New</option>
                                <option value="Fair" {{ $user->condition=="Fair" ? 'Selected' : '' }}>Fair</option>
                                <option value="Used" {{ $user->condition=="Used" ? 'Selected' : '' }}>Used</option>
                                <option value="Damaged" {{ $user->condition=="Damaged" ? 'Selected' : '' }}>Damaged</option>
                              </select>  
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                            <strong>Tagged</strong>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="tagged" value="1" {{ $user->tagged=="1" ? 'checked' : '' }}>
                              <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="tagged" value="0" {{ $user->tagged=="0" ? 'checked' : '' }}>
                              <label class="form-check-label">No</label>
                            </div>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Description</strong>
                              <textarea class="form-control" name="description" placeholder="Description" row="3">{{ $user->description }}</textarea>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Color (optional)</strong>
                              <input type="text" id="color" name="color" class="form-control" placeholder="Color" value="{{ $user->color }}">
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Photo</strong>
                              <button type="button" id="imgCapture" class="btn btn-success green-btn">Click here capture your photo</button>  
                              
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <img id="imgCaptureImg" @if($user->photo) src="<?php echo asset("storage/dist/img/photo/$user->photo")?>" @else style="display:none;" @endif width="300" height="270"/>
                              <input id="photoData" type="hidden" name="photo" value="{{ $user->photo }}"/>
                              <div id="webcam" class="mt-2" style="width:400px; height:400px;display:none;"></div>
                              <button type="button" style="display:none;" id="btnCapture" class="btn btn-success green-btn">capture photo</button>  
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-success green-btn">Submit</button>
                        <a class="btn btn-success green-btn" href="{{ route('datacollection') }}"> Cancel</a>
                      </div>
                  </div>
            
              </form>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.Customer Information -->

        </section>
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
