<?php

namespace App\Enums;

enum YesOrNoAnswer
{
    const YES = 'نعم';
    const NO = 'لا';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::YES,
        self::NO,
    ];
}
