<?php

namespace App\Enums;

enum TypeExam
{
    const DEAILY = 'day';
    const MONTHLAY = 'month';
    const YEARLY = 'year';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::DEAILY,
        self::YEARLY,
        self::MONTHLAY,
    ];
}
