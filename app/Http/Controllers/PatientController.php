<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Patient;

class PatientController extends Controller
{
    public function create(Request $request)
    {
        $patient = new Patient();
        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->phone = $request->input('phone');
        $patient->gender = $request->input('gender');
        $patient->birthday = $request->input('birthday');
        $patient->email = $request->input('email');
        $patient->save();

        // or
        // DB::table('patient') ->insert(
        // array(
        //     $request->all()
        //  ));
        // return response()->json([
        //      'id' => DB::getPdo()->lastInsertId()
        // ]);

        return response()->json([
            'id' => $patient->id,
        ]);
    }

    public function edit($patient_id)
    {
        $patient = Patient::find($patient_id);
        
        if (empty($patient)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        $data = request()->all();
        if (isset($data['phone'])) {
            $patient->phone = $data['phone'];
        }
        if (isset($data['first_name'])) {
            $patient->first_name = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $patient->last_name = $data['last_name'];
        }
        if (isset($data['gender'])) {
            $patient->gender = $data['gender'];
        }
        if (isset($data['bithday'])) {
            $patient->birthday = $data['birthday'];
        }
        if (isset($data['email'])) {
            $patient->email = $data['email'];
        }
        $patient->save();

        return response()->json([
            'patient' => $patient,
        ]);
    }

    public function delete($patient_id)
    {
        $patient = Patient::find($patient_id);

        if (empty($patient)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $appointments = DB::table('APPOINTMENT')
            ->select('*')
            ->where('PATIENT_id', '=', $patient_id)
            ->get();

        foreach ($appointments as $appointment) {
            DB::table('APPOINTMENT')->where('id', '=', $appointment->id)
                ->delete();
        }

        DB::table('PATIENT')->where('id', '=', $patient_id)
             ->delete();

        return response()->json([
            'id' => $patient_id,
        ]);
    }

    public function read($patient_id)
    {
        $patient = DB::table('PATIENT')
            ->select('*')
            ->where('id', '=', $patient_id)
            ->get();

        if (empty($patient)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json([
            'patient' => $patient,
        ]);
    }

    public function getAppointments($patient_id)
    {
        $appointments = DB::table('APPOINTMENT')
            ->select('*')
            ->join('PATIENT', 'PATIENT.id', '=', 'APPOINTMENT.patient_id')
            ->where('APPOINTMENT.patient_id', '=', $patient_id)
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

    public function getAppointment($patient_id, $appointment_id)
    {
        $appointment = DB::table('APPOINTMENT')
                     ->select('*')
                     ->where('id', '=', $appointment_id)
                     ->where('patient_id', '=', $patient_id)
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

    public function getAppointmentByDate(Request $request, $patient_id)
    {
        $date = $request->input('date');

        $appointments = DB::table('APPOINTMENT')
                     ->select('APPOINTMENT.id', 'APPOINTMENT.DOCTOR_id', 'APPOINTMENT.PATIENT_id', 'APPOINTMENT.date', 'APPOINTMENT.duration')
                     ->join('PATIENT', 'PATIENT.id', '=', 'APPOINTMENT.patient_id')
                     ->where('APPOINTMENT.patient_id', '=', $patient_id)
                     ->whereDate('APPOINTMENT.date', '=', $date)
                     ->get();

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function getAppointmentBySpeciality($patient_id, Request $request)
    {
        $specialityId = $request->input('speciality_id');

        $appointments = DB::table('APPOINTMENT')
                     ->select('APPOINTMENT.id', 'APPOINTMENT.DOCTOR_id', 'APPOINTMENT.PATIENT_id', 'APPOINTMENT.date', 'APPOINTMENT.duration')
                     ->join('PATIENT', 'PATIENT.id', '=', 'APPOINTMENT.patient_id')
                     ->join('DOCTOR', 'DOCTOR.id', '=', 'APPOINTMENT.doctor_id')
                     ->where('APPOINTMENT.patient_id', '=', $patient_id)
                     ->where('DOCTOR.speciality_id', '=', $specialityId)
                     ->get();

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    public function getPatients()
    {
        $patients = DB::table('PATIENT')
                     ->select('*')
                     ->get();

        return response()->json([
            'patients' => $patients,
        ]);
    }
}
