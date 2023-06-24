<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YealyIncomeBarChartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $filledYearlyIncome = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [],
        ];
        $packageData = [
            'label' => 'PACKAGE',
            'data' => [],
            'borderColor' => 'rgb(255, 99, 132)',//red
            'backgroundColor' => 'rgb(255, 99, 132,0.5)',
        ];
        $directData = [
            'label' => 'DIRECT',
            'data' => [],
            'borderColor' => 'rgb(54, 162, 235)',//blue
            'backgroundColor' => 'rgb(54, 162, 235,0.5)',
        ];
        $indirectData = [
            'label' => 'INDIRECT',
            'data' => [],
            'borderColor' => 'rgb(75, 192, 192)',//green
            'backgroundColor' => 'rgb(75, 192, 192,0.5)',
        ];
        $p2pData = [
            'label' => 'P2P',
            'data' => [],
            'borderColor' => 'rgb(255, 205, 86)', //yellow
            'backgroundColor' => 'rgb(255, 205, 86,0.5)',
        ];

        foreach ($this->resource as $earning) {

            if ($earning->type === 'PACKAGE') {
                $packageData['data'][$filledYearlyIncome['labels'][--$earning->month]] = $earning->monthly_income;
            } elseif ($earning->type === 'DIRECT') {
                $directData['data'][$filledYearlyIncome['labels'][--$earning->month]] = $earning->monthly_income;
            } elseif ($earning->type === 'INDIRECT') {
                $indirectData['data'][$filledYearlyIncome['labels'][--$earning->month]] = $earning->monthly_income;
            } elseif ($earning->type === 'P2P') {
                $p2pData['data'][$filledYearlyIncome['labels'][--$earning->month]] = $earning->monthly_income;
            }

        }
        $filledYearlyIncome['datasets'][] = $packageData;
        $filledYearlyIncome['datasets'][] = $directData;
        $filledYearlyIncome['datasets'][] = $indirectData;
        //$filledYearlyIncome['datasets'][] = $p2pData;
        return $filledYearlyIncome;
    }
}
