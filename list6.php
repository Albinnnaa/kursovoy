<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:masters,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string'
        ]);
        
        $exists = Appointment::where('master_id', $validated['master_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();
        
        if ($exists) {
            return back()->with('error', 'Это время уже занято');
        }
        
        Appointment::create($validated);
        return redirect()->route('appointment.success');
    }
    
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'confirmed']);
        return back()->with('success', 'Запись подтверждена');
    }
    
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Запись отменена');
    }
    
    public function statistics(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        
        $statistics = DB::table('services')
            ->leftJoin('appointments', 'services.id', '=', 'appointments.service_id')
            ->select(
                'services.name',
                DB::raw('COUNT(appointments.id) as total'),
                DB::raw('SUM(services.price) as revenue')
            )
            ->whereBetween('appointments.appointment_date', [$startDate, $endDate])
            ->whereIn('appointments.status', ['confirmed', 'completed'])
            ->groupBy('services.id')
            ->get();
        
        return view('statistics', compact('statistics'));
    }
}