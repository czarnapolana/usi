<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Doctor;
use App\Appointment;

class DoctorController extends Controller
{
    public function create(Request $request)
    {
        $doctor = new Doctor();
        $doctor->first_name = $request->input('first_name');
        $doctor->last_name = $request->input('last_name');
        $doctor->speciality_id = $request->input('speciality_id');
        $doctor->phone = $request->input('phone');
        $doctor->gender = $request->input('gender');
        $doctor->birthday = $request->input('birthday');
        $doctor->email = $request->input('email');
        $doctor->room = $request->input('room');
        $doctor->save();

        // or
        // DB::table('doctor') ->insert(
        // array(
        //     $request->all()
        //  ));
        // return response()->json([
        //      'id' => DB::getPdo()->lastInsertId()
        // ]);

        return response()->json([
            'id' => $doctor->id,
        ]);
    }

    public function edit($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        
        if (empty($doctor)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $data = request()->all();
        if (isset($data['phone'])) {
            $doctor->phone = $data['phone'];
        }
        if (isset($data['first_name'])) {
            $doctor->first_name = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $doctor->last_name = $data['last_name'];
        }
        if (isset($data['gender'])) {
            $doctor->gender = $data['gender'];
        }
        if (isset($data['bithday'])) {
            $doctor->birthday = $data['birthday'];
        }
        if (isset($data['room'])) {
            $doctor->room = $data['room'];
        }
        if (isset($data['email'])) {
            $doctor->email = $data['email'];
        }

        $doctor->save();

        return response()->json([
            'doctor' => $doctor,
        ]);
    }

    public function delete($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);

        if (empty($doctor)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $appointments = DB::table('APPOINTMENT')
            ->select('*')
            ->where('DOCTOR_id', '=', $doctor_id)
            ->get();

        foreach ($appointments as $appointment) {
            DB::table('APPOINTMENT')->where('id', '=', $appointment->id)
                ->delete();
        }

        DB::table('DOCTOR')->where('id', '=', $doctor_id)
             ->delete();

        return response()->json([
            'id' => $doctor_id,
        ]);
    }

    public function read($doctor_id)
    {
        $doctor = DB::table('DOCTOR')
            ->select('*')
            ->where('id', '=', $doctor_id)
            ->get();

        if (empty($doctor)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json([
            'doctor' => $doctor,
        ]);
    }

    public function getAppointments($doctor_id)
    {
        $appointments = DB::table('APPOINTMENT')
            ->select('APPOINTMENT.id', 'APPOINTMENT.doctor_id', 'APPOINTMENT.patient_id', 'APPOINTMENT.date', 'APPOINTMENT.duration')
            ->join('DOCTOR', 'DOCTOR.id', '=', 'APPOINTMENT.doctor_id')
            ->where('APPOINTMENT.doctor_id', '=', $doctor_id)
            ->get();

        if (empty($appointments)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function getAppointment($doctor_id, $appointment_id)
    {
        $appointment = DB::table('APPOINTMENT')
                     ->select('*')
                     ->where('id', '=', $appointment_id)
                     ->where('doctor_id', '=', $doctor_id)
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

    public function getAppointmentByDate(Request $request, $doctor_id)
    {
        $date = $request->input('date');

        $appointments = DB::table('APPOINTMENT')
                     ->select('APPOINTMENT.id', 'APPOINTMENT.doctor_id', 'APPOINTMENT.PATIENT_id', 'APPOINTMENT.date', 'APPOINTMENT.duration')
                     ->join('DOCTOR', 'DOCTOR.id', '=', 'APPOINTMENT.doctor_id')
                     ->where('APPOINTMENT.doctor_id', '=', $doctor_id)
                     ->whereDate('APPOINTMENT.date', '=', $date)
                     ->get();

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function getDoctors()
    {
        $doctors = DB::table('DOCTOR')
                     ->select('*')
                     ->get();

        return response()->json([
        'doctors' => $doctors,
    ]);
    }

    public function getDoctorsBySpeciality($speciality_id)
    {
        $doctors = DB::table('DOCTOR')
                     ->select('*')
                     ->where('speciality_id', '=', $speciality_id)
                     ->get();

        return response()->json([
            'doctors' => $doctors,
        ]);
    }
}
