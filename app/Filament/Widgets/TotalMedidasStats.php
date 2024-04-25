<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TotalMedidasStats extends BaseWidget
{

    public static function canView(): bool
    {

        /** @var \App\Models\User */
        $authUser =  auth()->user();

        if ($authUser->hasRole(['Administrador','TI','CAEE'])) {
            return true;
        } else {
            return false;
        }
    }

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $mes = date('m');
        $ano = date('Y');
        $dia = date('d');
        return [
            Stat::make('Medidas Disciplinares - Hoje', number_format(DB::table('medida_disciplinars')->whereYear('data', $ano)->whereMonth('data', $mes)->whereDay('data', $dia)->count('id')))
                ->description('total')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(' Medidas Disciplinares - Este Mês', number_format(DB::table('medida_disciplinars')->whereYear('data', $ano)->whereMonth('data', $mes)->count('id')))
                ->description('total')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Medidas Disciplinares - Este Ano', number_format(DB::table('medida_disciplinars')->whereYear('data', $ano)->count('id')))
                ->description('total')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Medidas Disciplinares - Total', number_format(DB::table('medida_disciplinars')->count('id')))
                ->description('total')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
           


        ];
    }
}
