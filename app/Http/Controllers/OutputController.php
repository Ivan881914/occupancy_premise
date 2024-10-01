<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class OutputController extends Controller
{
    public function getHourlyLoad(): JsonResponse
    {
        $minuteLoads = $this->calculateMinuteLoad();
        $hourlyLoad = [];

        foreach ($minuteLoads as $minuteKey => $occupancy) {
            $hour = Carbon::createFromFormat('Y-m-d H:i', $minuteKey)->format('H');
            if (!isset($hourlyLoad[$hour])) {
                $hourlyLoad[$hour] = [];
            }
            $hourlyLoad[$hour][] = $occupancy;
        }

        $response = ['byHours' => []];

        foreach ($hourlyLoad as $hour => $loads) {
            $averageLoad = array_sum($loads) / count($loads);
            if ($averageLoad <= 5) {
                $response['byHours'][(int)$hour] = 'low';
            } elseif ($averageLoad >= 8) {
                $response['byHours'][(int)$hour] = 'high';
            } else {
                $response['byHours'][(int)$hour] = 'medium';
            }
        }

        return response()->json($response);
    }


    public function calculateMinuteLoad(): array
    {
        $occupancyData = DB::table('occupancy')
            ->orderBy('timestamp', 'asc')
            ->get();

        $currentOccupancy = 0;
        $minuteLoads = [];

        foreach ($occupancyData as $data) {
            $timestamp = $data->timestamp;
            $minuteKey = Carbon::createFromTimestamp($timestamp, 'Asia/Vladivostok')->format('Y-m-d H:i');

            // Обновляем текущее количество посетителей
            $currentOccupancy += $data->diff;

            // Записываем количество на конец текущей минуты
            $minuteLoads[$minuteKey] = $currentOccupancy;
        }

        return $minuteLoads;
    }


    public function getDailyLoad(): JsonResponse
    {
        $minuteLoads = $this->calculateMinuteLoad();
        $dailyLoad = [];

        foreach ($minuteLoads as $minuteKey => $occupancy) {
            $day = Carbon::createFromFormat('Y-m-d H:i', $minuteKey)->format('d');
            if (!isset($dailyLoad[$day])) {
                $dailyLoad[$day] = [];
            }
            $dailyLoad[$day][] = $occupancy;
        }

        $response = ['byDays' => []];

        foreach ($dailyLoad as $day => $loads) {
            $averageLoad = array_sum($loads) / count($loads);
            if ($averageLoad <= 5) {
                $response['byDays'][(int)$day] = 'low';
            } elseif ($averageLoad <= 8) {
                $response['byDays'][(int)$day] = 'medium';
            } else {
                $response['byDays'][(int)$day] = 'high';
            }
        }

        return response()->json($response);
    }


}

