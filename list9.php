<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Модель для таблицы услуг
class Service extends Model
{
    protected $fillable = ['name', 'description', 'price', 'duration'];
    
    // Одна услуга может быть во многих записях
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

// Модель для таблицы мастеров
class Master extends Model
{
    protected $fillable = ['name', 'specialization', 'bio', 'photo'];
    
    // Один мастер может иметь много записей
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}