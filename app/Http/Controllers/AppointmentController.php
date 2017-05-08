<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Appointment;

class AppointmentController extends Controller
{
    public function create(Request $request)
    {
        $appointment = new Appointment();
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->patient_id = $request->input('patient_id');
        $appointment->date = $request->input('date');
        $appointment->duration = $request->input('duration');
        $appointment->save();

        return response()->json([
             'id' => $appointment->id,
        ]);
    }

    public function edit($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        $data = request()->all();

        if (isset($data['doctor_id'])) {
            $appointment->doctor_id = $data['doctor_id'];
        }
        if (isset($data['patient_id'])) {
            $appointment->patient_id = $data['patient_id'];
        }
        if (isset($data['date'])) {
            $appointment->date = $data['date'];
        }
        if (isset($data['duration'])) {
            $appointment->duration = $data['duration'];
        }

        $appointment->save();

        return response()->json([
            'appointment' => $appointment,
        ]);
    }

    public function delete($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);

        if (empty($appointment)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        DB::table('appointment')->where('id', '=', $appointment_id)
             ->delete();

        return response()->json([
            'id' => $appointment_id,
        ]);
    }

    public function read($appointment_id)
    {
        $appointment = DB::table('appointment')
            ->select('*')
            ->where('id', '=', $appointment_id)
            ->get();

        if (empty($appointment)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json([
            'appointment' => $appointment,
        ]);
    }

    public function getAppointments()
    {
        $appointments = DB::table('appointment')
            ->select('*')
            ->get();

        return response()->json([
            'appointments' => $appointments,
        ]);
    }
}
