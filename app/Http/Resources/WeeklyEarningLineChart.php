<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyEarningLineChart extends JsonResource
{

    public function toArray($request)
    {
        $line_chart_data = [
            //'labels' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // DAYNAME(created_at)
            'labels' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], // DAYOFWEEK(created_at)
            'datasets' => [],
        ];
        $packageData = [
            'label' => 'PACKAGE',
            'data' => [],
            //'borderColor' => 'rgb(255, 99, 132)',//red
            'backgroundColor' => 'rgb(255, 99, 132,0.5)',
            'pointBackgroundColor' => 'rgb(255, 99, 132,0.5)',
        ];
        $directData = [
            'label' => 'DIRECT',
            'data' => [],
            //'borderColor' => 'rgb(54, 162, 235)',//blue
            'backgroundColor' => 'rgb(54, 162, 235,0.5)',
            'pointBackgroundColor' => 'rgb(54, 162, 235,0.5)',
        ];
        $indirectData = [
            'label' => 'INDIRECT',
            'data' => [],
            //'borderColor' => 'rgb(75, 192, 192)',//green
            'backgroundColor' => 'rgb(75, 192, 192,0.5)',
            'pointBackgroundColor' => 'rgb(75, 192, 192,0.5)',
        ];
        $p2pData = [
            'label' => 'P2P',
            'data' => [],
            //'borderColor' => 'rgb(255, 205, 86)', //yellow
            'backgroundColor' => 'rgb(255, 205, 86,0.5)',
            'pointBackgroundColor' => 'rgb(255, 205, 86,0.5)',
        ];
        foreach ($this->resource as $earning) {
            if ($earning->type === 'PACKAGE') {
                // $packageData['data'][$earning->day] = $earning->earnings; // DAYNAME(created_at)
                $packageData['data'][$line_chart_data['labels'][--$earning->day]] = $earning->earnings;
            } elseif ($earning->type === 'DIRECT') {
                $directData['data'][$line_chart_data['labels'][--$earning->day]] = $earning->earnings;
            } elseif ($earning->type === 'INDIRECT') {
                $indirectData['data'][$line_chart_data['labels'][--$earning->day]] = $earning->earnings;
            } elseif ($earning->type === 'P2P') {
                $p2pData['data'][$line_chart_data['labels'][--$earning->day]] = $earning->earnings;
            }

        }
        $line_chart_data['datasets'][] = $packageData;
        $line_chart_data['datasets'][] = $directData;
        $line_chart_data['datasets'][] = $indirectData;
        $line_chart_data['datasets'][] = $p2pData;

        return $line_chart_data;
    }
}
