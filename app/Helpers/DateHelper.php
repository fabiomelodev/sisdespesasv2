<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getYears(): array
    {
        return [
            2023 => '2023',
            2024 => '2024',
            2025 => '2025',
            2026 => '2026',
            2027 => '2027',
            2028 => '2028',
        ];
    }

    public static function getMonths(): array
    {
        return [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];
    }

    public static function getMonthCurrent(): string
    {
        $month = Carbon::now()->month;

        return static::getMonths()[$month];
    }

    public static function getMonth($month): string
    {
        return static::getMonths()[$month];
    }

    public static function getDays(): array
    {
        return [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
            20,
            21,
            22,
            23,
            24,
            25,
            26,
            27,
            28,
            29,
            30,
            31
        ];
    }
}
