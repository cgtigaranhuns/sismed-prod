<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Penalidade extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        
        'nome'
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    } 

    public function MedidaDisciplinar() {
        return $this->hasMany(MedidaDisciplinar::class);
    }
    
}
