<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_name', 
        'client_phone', 
        'client_email',
        'service_id', 
        'master_id', 
        'appointment_date',
        'appointment_time', 
        'status', 
        'notes'
    ];
    
    // Связь с таблицей услуг
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    // Связь с таблицей мастеров
    public function master()
    {
        return $this->belongsTo(Master::class);
    }
}