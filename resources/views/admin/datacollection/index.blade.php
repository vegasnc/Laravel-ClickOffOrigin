@extends('layouts.noref')
@section('title',"ClickMetrix | DataCollection")
@section('vuescript')
<script src="{{asset('js/dashboard.js')}}"></script>
@endsection
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
    <div class="row mt-3">
        <!-- Left col -->
        <section class="col-lg-12">

          <!-- Customer Information-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                Listing
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                  <a class="btn btn-success" href="{{ route('data-form') }}"> Add Data</a>
                  </li>
                </ul>
              </div>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0 table-resp">
              <table id="datacollection" class="table table-bordered table-striped yajra-datatable">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Asset</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Action</th>
                        <th>Client</th>
                        <th>Color</th>
                        <th>Asset Picture</th>
                        <th>Created</th>
                        <th width="280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $id = 1;?>
                  @foreach ($users as $user)
                    <tr>
                        <td>{{ $id ++ }}</td>
                        <td>{{ $user->asset }}</td>
                        <td>{{ $user->status }}</td>
                        <td>{{ $user->quantity }}</td>
                        <td>{{ $user->action }}</td>
                        <td>{{ $user->client }}</td>
                        <td>{{ $user->color }}</td>
                        <td>
                          <?php 
                            $photos = $user->photo;
                            $photo_arr = array();
                            $photo_token = strtok($photos, ",");
                            while( $photo_token !== false ) {
                                array_push($photo_arr, $photo_token);
                                $photo_token = strtok(",");
                            }
                          ?>
                          @foreach($photo_arr as $key=>$val)
                            <img src="<?php echo asset("storage/dist/img/photo/$val")?>" width="30" height="30"/>
                          @endforeach
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                               
                                <form action="{{route('data-delete',$user->id)}}" method="POST">
                                @csrf
                                <a class="btn btn-success green-btn" href="{{route('data-edit',$user->id)}}"><i class="fas fa-edit"></i></a>
                                <button type="submit" class="btn btn-success green-btn"><i class="fas fa-trash"></i></button>
                                </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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
