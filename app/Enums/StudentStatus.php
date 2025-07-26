<?php

namespace App\Enums;

enum StudentStatus
{
    const CONTINUOUS = 'مستمر';
    const DISCONTINUOUS = 'منقطع';
    const DISMISSED = 'مفصول';
    const TRANSFERRED = 'منقول';

    /**
     * Array of available user types.
     *
     * @var array
     */
    const SET = [
        self::CONTINUOUS,
        self::DISCONTINUOUS,
        self::DISMISSED,
        self::TRANSFERRED,
    ];
}
