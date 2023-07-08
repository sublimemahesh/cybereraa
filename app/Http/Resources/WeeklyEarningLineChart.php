<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WeeklyEarningLineChart extends JsonResource
{

    public function toArray($request)
    {
        $today = Carbon::now()->shortEnglishDayOfWeek;
        $data = [];
        switch ($today) {
            case 'Sat':
                $data['Sat'] = 0;
            case 'Fri':
                $data['Fri'] = 0;
            case 'Thu':
                $data['Thu'] = 0;
            case 'Wed':
                $data['Wed'] = 0;
            case 'Tue':
                $data['Tue'] = 0;
            case 'Mon':
                $data['Mon'] = 0;
            case 'Sun':
                $data['Sun'] = 0;
                break;
            default:
                break;
        }
        $line_chart_data = [
            //'labels' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // DAYNAME(created_at)
            'labels' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], // DAYOFWEEK(created_at)
            'datasets' => [],
        ];
        $packageData = [
            'label' => 'PACKAGE',
            'data' => $data,
            'borderWidth' => 1,
            'borderColor' => 'rgb(255, 99, 132,0.2)',//red
            'backgroundColor' => 'rgb(255, 99, 132,0.5)',
            'pointBackgroundColor' => 'rgb(255, 99, 132)',
        ];
        $directData = [
            'label' => 'DIRECT',
            'data' => $data,
            'borderWidth' => 1,
            'borderColor' => 'rgb(54, 162, 235,0.2)',//blue
            'backgroundColor' => 'rgb(54, 162, 235,0.5)',
            'pointBackgroundColor' => 'rgb(54, 162, 235)',
        ];
        $indirectData = [
            'label' => 'INDIRECT',
            'data' => $data,
            'borderWidth' => 1,
            'borderColor' => 'rgb(75, 192, 192,0.2)',//green
            'backgroundColor' => 'rgb(75, 192, 192,0.5)',
            'pointBackgroundColor' => 'rgb(75, 192, 192)',
        ];
        $p2pData = [
            'label' => 'P2P',
            'data' => $data,
            'borderWidth' => 1,
            'borderColor' => 'rgb(255, 205, 86,0.2)', //yellow
            'backgroundColor' => 'rgb(255, 205, 86,0.5)',
            'pointBackgroundColor' => 'rgb(255, 205, 86)',
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
