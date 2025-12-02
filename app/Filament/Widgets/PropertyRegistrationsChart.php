<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;

class PropertyRegistrationsChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    public function getHeading(): string|Htmlable|null
    {
        return 'Properties registered in '.now()->year;
    }

    protected function getData(): array
    {
        $result = $this->getPropertyCreationLineChartData();

        $labels = array_keys($result);
        $values = array_values($result);

        return [
            'datasets' => [
                [
                    'label' => 'Properties Registered',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'precision' => 0, // Ensures integer values on the y-axis
                    ],
                ],
            ],
        ];
    }

    protected function getPropertyCreationLineChartData(): array
    {
        $result = Property::whereYear('created_at', now()->year)
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($property) {
                return Carbon::parse($property->created_at)->format('Y-m');
            })
            ->mapWithKeys(function ($properties, $month) {
                $label = Carbon::parse($month.'-01')->format('M');

                return [$label => $properties->count()];
            })
            ->toArray();

        return $result;
    }
}
