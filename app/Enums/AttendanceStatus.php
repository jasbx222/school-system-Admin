<?php

namespace App\Enums;

enum AttendanceStatus
{
    const PRESENT = 'مجاز';
    const ABSENT = 'غائب';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::PRESENT,
        self::ABSENT,
    ];
}
