<?php

namespace App\Enums;

enum Payment
{
    const GAVE = 'دفع';
    const TAKE = 'قبض';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::GAVE,
        self::TAKE,
      
    ];
}
