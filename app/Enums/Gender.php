<?php

namespace App\Enums;

enum Gender
{
    const MALE = 'ذكر';
    const FEMALE = 'أنثى';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::MALE,
        self::FEMALE,
    ];
}
