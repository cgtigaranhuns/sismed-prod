<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Discente extends Model
{
    use HasFactory, LogsActivity;

    protected $ldapGuid = 'guid';

    protected $fillable = [
        'name',
        'username',
        'mail',
        'data_nascimento',
        'periodo',
        'curso_id',
        'turno_id',
        'modalidade_id',
        'guid',
        'domain',
        'password',

    ];

    public function setLdapDomain($domain)
    {
        return $this->domain = $domain;
    }

    public function getLdapDomainColumn()
    {
        return 'domain';
    }

    public function setLdapGuid($ldapGuid)
    {
        // lógica para definir o valor do ldapGuid
        $this->ldapGuid = $ldapGuid;
       // dd($this->ldapGuid);
    }

    public function getLdapGuidColumn()
    {
        return  $this->ldapGuid;
        
    }

   public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    } 

    public function Curso() {

        return $this->belongsTo(Curso::class);
    }

    public function Modalidade() {

        return $this->belongsTo(Modalidade::class);
    }

    public function Turno() {

        return $this->belongsTo(Turno::class);
    }

    public function Periodo() {

        return $this->belongsTo(Periodo::class);
    }

    public function MedidaDisciplinar() {
        return $this->hasMany(MedidaDisciplinar::class);
    }
}

