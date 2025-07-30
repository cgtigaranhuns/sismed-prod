<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MedidaDisciplinar extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'discente_id',
        'grupo_discente_id',
        'user_id',
        'data',
        'hora',
        'penalidade_id',
        'nivel',
        'categoria_id',
        'descricao',
    ];

   

    protected $casts = [
        'grupo_discente_id' => 'array',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    } 

    public function Discente() {
        return $this->belongsTo(Discente::class);
    }

    public function GrupoDiscente() {
        return $this->belongsTo(Discente::class);
    }

    
    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Penalidade() {
        return $this->belongsTo(Penalidade::class);
    }

    public function Categoria() {
        return $this->belongsTo(Categoria::class);
    }

}
