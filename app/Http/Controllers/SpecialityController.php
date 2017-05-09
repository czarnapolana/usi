<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Speciality;

class SpecialityController extends Controller
{
    public function edit($speciality_id)
    {
        $speciality = Speciality::find($speciality_id);
        $data = request()->all();

        if (isset($data['name'])) {
            $speciality->name = $data['name'];
        }
        if (isset($data['price_per_appointment'])) {
            $speciality->price_per_appointment = $data['price_per_appointment'];
        }
        $speciality->save();

        return response()->json([
            'speciality' => $speciality,
        ]);
    }

    public function read($speciality_id)
    {
        $speciality = DB::table('SPECIALITY')
            ->select('*')
            ->where('id', '=', $speciality_id)
            ->get();

        if (empty($speciality)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json([
            'speciality' => $speciality,
        ]);
    }

    public function getSpecialities()
    {
        $specialities = DB::table('SPECIALITY')
            ->select('*')
            ->get();

        return response()->json([
            'specialities' => $specialities,
        ]);
    }
}
