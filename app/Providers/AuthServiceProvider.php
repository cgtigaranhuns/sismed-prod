<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Discente;
use App\Models\MedidaDisciplinar;
use App\Models\Modalidade;
use App\Models\Penalidade;
use App\Models\Periodo;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Turno;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\CategoriaPolicy;
use App\Policies\CursoPolicy;
use App\Policies\DiscentePolicy;
use App\Policies\MedidaDisciplinarPolicy;
use App\Policies\ModalidadePolicy;
use App\Policies\PenalidadePolicy;
use App\Policies\PeriodoPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\TurnoPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class, 
        Categoria::class => CategoriaPolicy::class,
        Curso::class => CursoPolicy::class,
        Discente::class => DiscentePolicy::class,
        MedidaDisciplinar::class => MedidaDisciplinarPolicy::class,
        Modalidade::class => ModalidadePolicy::class,
        Penalidade::class => PenalidadePolicy::class,
        Periodo::class => PeriodoPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Turno::class => TurnoPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
