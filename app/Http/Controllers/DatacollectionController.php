<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Datacollection;
use App\Models\Asset;
use App\Models\Status;
use App\Models\Action;
use App\Models\Client;
use Carbon\Carbon;
use Storage;

class DatacollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = datacollection::all();
    
        return view('admin.datacollection.index',compact('users'));
            // ->with('i', (request()->input('page', 1) - 1) * 5)
            // return view('admin.datacollection');
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataform()
    {
        $asset = asset::all();
        $status = status::all();
        $action = action::all();
        $client = client::all();
        return view('admin.datacollection.create',compact('asset', 'status', 'action', 'client'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataadd(Request $request)
    {
        $request->validate([
            'asset' => 'required',
            'status' => 'required',
            'action' => 'required',
            'quantity' => 'required',
            'client' => 'required',
        ]);
        
        $data = $request->all();

        $photo_cnt = 0;
        $photo_datas = "";
        if( isset( $data['photo_num'] ) && $data['photo_num'] != "" ) {
            $photo_cnt = $data['photo_num'];
        }

        for($x = 0; $x < $photo_cnt; $x ++) {
            $base64_str = substr($data['photo'.$x], strpos($data['photo'.$x], ",")+1);
            $image = base64_decode($base64_str);
            $current_date_time = Carbon::now()->timestamp;
            $safeName = $current_date_time.'_'.$x.'.'.'png';    
            Storage::disk('public')->put('dist/img/photo/'.$safeName, $image);
            if( $photo_datas == '' )
                $photo_datas = $safeName;
            else
                $photo_datas = $photo_datas.",".$safeName;
        }

        $data['photo'] = $photo_datas;

        if(isset($data['addnewasset']) && $data['addnewasset'] != ""){
            $array_new_asset = array(
                'name'=>$data['addnewasset'],
            );
            Asset::create($array_new_asset);
            $data['asset'] = $data['addnewasset'];
        }

        if(isset($data['addnewstatus']) && $data['addnewstatus'] != ""){
            $array_new_status = array(
                'name'=>$data['addnewstatus'],
            );
            Status::create($array_new_status);
            $data['status'] = $data['addnewstatus'];
        }

        if(isset($data['addnewaction']) && $data['addnewaction'] != ""){
            $array_new_action = array(
                'name'=>$data['addnewaction'],
            );
            Action::create($array_new_action);
            $data['action'] = $data['addnewaction'];
        }

        if(isset($data['addnewclient']) && $data['addnewclient'] != ""){
            $array_new_client = array(
                'name'=>$data['addnewclient'],
            );
            Client::create($array_new_client);
            $data['client'] = $data['addnewclient'];
        }

        $user = Datacollection::create($data);

        if ($user) {
            return redirect()->route('datacollection')->with('success', 'Data created successfully.');
        }
        else {
            return redirect()->route('datacollection')->with('failed', 'Failed! Data not created');
        }
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.datacollection.show',compact('user'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function dataedit($id)
    {   
        $asset = asset::all();
        $status = status::all();
        $action = action::all();
        $client = client::all();
        $user = DB::table('datacollection')->where('id', $id)->first();
        $photos = $user->photo;
        $photo_arr = array();
        $photo_token = strtok($photos, ",");
        while( $photo_token !== false ) {
            array_push($photo_arr, $photo_token);
            $photo_token = strtok(",");
        }
        return view('admin.datacollection.edit',compact('user','asset','status','action', 'client', 'photo_arr'));
    }
    function is_base64($str)
    {
        return (bool)preg_match('`^[a-zA-Z0-9+/]+={0,2}$`', $str);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function dataupdate(Request $request, Datacollection $user,$id)
    {
        $request->validate([
            'quantity' => 'required',
        ]);
        
        $data = $request->all();
        
        $photo_cnt = 0;
        $photo_datas = "";
        if( isset( $data['photo_num'] ) && $data['photo_num'] != "" ) {
            $photo_cnt = $data['photo_num'];
        }

        for($x = 0; $x < $photo_cnt; $x ++) {
            $base64_str = substr($data['photo'.$x], strpos($data['photo'.$x], ",")+1);
            if($this->is_base64($base64_str) == true){
                $image = base64_decode($base64_str);
                $current_date_time = Carbon::now()->timestamp;
                $safeName = $current_date_time.'_'.$x.'.'.'png';
                Storage::disk('public')->put('dist/img/photo/'.$safeName, $image);
            }else{
                $safeName = $data['photo'.$x];   
            }
            
            if( $photo_datas == '' )
                $photo_datas = $safeName;
            else
                $photo_datas = $photo_datas.",".$safeName;
        }

        $array_data = array(
            "asset" => $data['asset'],
            "address" => $data['address'],
            "quantity" => $data['quantity'],
            "action" => $data['action'],
            "status" => $data['status'],
            "client" => $data['client'],
            "color" => $data['color'],
            "latitude" => $data['latitude'],
            "longitude" => $data['longitude'],
            "description" => $data['description'],
            "photo" => $photo_datas,
            "autoaddress" => $data['autoaddress'],
        );
       
        if(isset($data['addnewasset']) && $data['addnewasset'] != ""){
            $array_new_asset = array(
                'name'=>$data['addnewasset'],
            );
            Asset::create($array_new_asset);
            $array_data['asset'] = $data['addnewasset'];
            Datacollection::where('id', $id)->update($array_data);
        }else{
            Datacollection::where('id', $id)->update($array_data);
        }

        if ($user) {
            return redirect()->route('datacollection')->with('success', 'Data edited successfully.');
        }
        else {
            return redirect()->route('datacollection')->with('failed', 'Failed! Data not edited');
        }                        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('datacollection')->where('id', $id)->delete();

        if ($delete) {
            return redirect()->route('datacollection')->with('success', 'Data deleted successfully.');
        }
        else {
            return redirect()->route('datacollection')->with('failed', 'Failed! Data not deleted');
        }
    }
}