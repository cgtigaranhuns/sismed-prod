<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Categoria extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'codigo',
        'nome'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['nome', 'text']);
        // Chain fluent methods for configuration options
    }

    public function MedidaDisciplinar() {
        return $this->hasMany(MedidaDisciplinar::class);
    }
}
