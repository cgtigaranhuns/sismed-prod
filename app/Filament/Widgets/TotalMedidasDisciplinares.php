<?php

namespace App\Filament\Widgets;

use App\Models\MedidaDisciplinar;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TotalMedidasDisciplinares extends ChartWidget
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

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Medidas Disciplinares por Mês';

    
    protected function getData(): array
    {

        $data = Trend::model(MedidaDisciplinar::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Medidas Disciplinares por Mês',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
