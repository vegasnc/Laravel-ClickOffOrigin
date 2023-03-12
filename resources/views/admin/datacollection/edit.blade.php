@extends('layouts.noref')
@section('title',"ClickMetrix | DataCollection")

@section('content')

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
              <form id="data-add" action="{{ route('data-update',$user->id) }}" method="POST">
                  @csrf
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row"> 
                          <div class="col-sm-6">
                            <div class="form-group">
                                <strong>Asset Types</strong>
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
                              <strong>Live Location<span class="red">*</span></strong>
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
                        <div class="row"> 
                          <div class="col-sm-6">
                            <div class="form-group">
                                <strong>Status Types</strong>
                                <select class="form-control select3 select2-success" data-dropdown-css-class="select2-success" id="status" name="status" style="width: 100%;">
                                  <option value="">Please Select</option>
                                  <option value="1">Add New Status</option>
                                  @foreach($status as $key=>$val)
                                    @if($user->status == $val['name'])
                                    <option value="{{$val['name']}}" selected>{{$val['name']}}</option>
                                    @else
                                    <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    @endif
                                  @endforeach
                                </select>  
                            </div>
                          </div>
                          <div class="col-sm-6"  style="display:none;" id="addnewstatus">
                              <div class="form-group">
                                <strong>Or Add New Status Type</strong>
                                <input type="text" id="addnewstatus" name="addnewstatus" class="form-control" placeholder="Enter Status Name">
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Quantity</strong>
                              <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Quantity" value="{{ $user->quantity }}">
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row"> 
                          <div class="col-sm-6">
                            <div class="form-group">
                                <strong>Service or Action<span class="red">*</span></strong>
                                <select class="form-control select4 select2-success" data-dropdown-css-class="select2-success" id="action" name="action" style="width: 100%;">
                                  <option value="">Please Select</option>
                                  <option value="1">Add New Action</option>
                                  @foreach($action as $key=>$val)
                                    @if($user->action == $val['name'])
                                    <option value="{{$val['name']}}" selected>{{$val['name']}}</option>
                                    @else
                                    <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    @endif
                                  @endforeach
                                </select>  
                            </div>
                          </div>
                          <div class="col-sm-6"  style="display:none;" id="addnewaction">
                              <div class="form-group">
                                <strong>Or Add New Action Type</strong>
                                <input type="text" id="addnewaction" name="addnewaction" class="form-control" placeholder="Enter Action Name">
                              </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <strong>Client Name</strong>
                                <select class="form-control select5 select2-success" data-dropdown-css-class="select2-success" id="client" name="client" style="width: 100%;">
                                  <option value="">Please Select</option>
                                  <option value="1">Add New Client</option>
                                  @foreach($client as $key=>$val)
                                    @if($user->client == $val['name'])
                                    <option value="{{$val['name']}}" selected>{{$val['name']}}</option>
                                    @else
                                    <option value="{{$val['name']}}">{{$val['name']}}</option>
                                    @endif
                                  @endforeach
                                </select>  
                              </div>
                            </div>
                            <div class="col-sm-6" style="display:none;" id="addnewclient">
                              <div class="form-group">
                                <strong>Or Add New Client Name</strong>
                                <input type="text" id="addnewclient" name="addnewclient" class="form-control" placeholder="Enter Client Name">
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Description</strong>
                              <textarea class="form-control" name="description" placeholder="Description" row="3">{{ $user->description }}</textarea>
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-6 col-md-3">
                          <div class="form-group">
                              <strong>Color (optional)</strong>
                              <input type="text" id="color" name="color" class="form-control" placeholder="Color" value="{{ $user->color }}">
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group" style="display: flex; margin-top: 15px;">
                              <button type="button" id="btn_capture" class="btn btn-success green-btn" style="margin: auto;">Tap here to Capture Photos</button>  
                              <input id="btn_ios_capture" type="file" accept="image/*" onchange="handleImageSelect(event)" hidden multiple>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                            <div class="display-cover" id="photosection" style="display:none;"> 
                                <video autoplay></video>
                                <canvas class="d-none"></canvas> 
                                <div class="controls">
                                    <input type="button" id="btn_screenshot" class="btn btn-outline-success screenshot d-none" value="ScreenShot"/>
                                </div>
                            </div>
                            <div class="display-cover" id="iosphotosection" style="display:none;">
                            
                            </div>
                          </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <div class="row" id="gallery">
                                  <?php $x = 0;?>
                                  @foreach($photo_arr as $key=>$val)
                                    <div class="col-6 col-sm-6 col-md-3 image-item" style="margin-bottom: 2px; padding:2px !important; background-color: #333333; display:flex;">
                                        <img class="image-template" alt="" style="margin:auto;" src="<?php echo asset("storage/dist/img/photo/$val")?>">
                                        <input class="photoData" type="hidden" name="photo<?= $x ++?>" value="<?=$val?>"/>
                                    </div>
                                  @endforeach
                                  <input type="hidden" id="photo_num" name="photo_num" value="{{ $x }}"/>
                              </div>
                          </div>
                      </div>
                      <div class="col-6 col-sm-6 col-md-3" id="image_template">
                      </div>
                      <div class="col-12 col-sm-12 col-md-12 text-center submit-div">
                            <button type="submit" id="btn_submit_real" class=" d-none"></button>
                            <input type="button" id="btn_submit_temp" class="btn btn-success green-btn" value="Save Data" />
                            <a class="btn btn-success green-btn" href="/firstpage"> Cancel</a>
                      </div>
                  </div>
              </form>
              </div>
              <div id="temp_gallery" class="d-none">
                <div class="col-6 col-sm-6 col-md-3 image-item" style="margin-bottom: 2px; padding:2px !important; background-color: #333333; display:flex;">
                    <img class="image-template" alt="" style="margin:auto;">
                    <input class="photoData" type="hidden" name="photo"/>
                </div>
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
