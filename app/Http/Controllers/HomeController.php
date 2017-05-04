<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Doctor;

class HomeController extends Controller
{
    //
    public function index(){
        return view("welcome");
        
        
    }
    
  
    public function show ()
    {
    $doctors = Doctor::all();
    return response()->json($doctors);
    
    }
    
    public function get()
    {
        $id = request()->route("id");
        $doctor = Doctor::find($id);
        return response()->json($doctor);
        
        
    }
        public function getAppointments()
    {
        $id = request()->route("id");
        $doctor = Doctor::find($id);
        $doctor->appointmnts;
        return response()->json($doctor->appointmnts);
        
        
    }

}
