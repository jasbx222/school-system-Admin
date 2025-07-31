<?php

namespace App\Enums;

enum StatusPaid
{
    const PAID = 'paid';
    const PENDING = 'pending';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::PAID,
        self::PENDING,
    ];
}
