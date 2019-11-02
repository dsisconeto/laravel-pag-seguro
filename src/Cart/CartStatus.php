<?php

namespace Dsisconeto\LaravelPayment\Cart;

use BenSampo\Enum\Enum;

class CartStatus extends Enum
{
    public const SESSION = 'SESSION';
    public const EXPIRED = 'EXPIRED';
    public const FINISH = 'FINISH';

    public function isSession()
    {
        return $this->value === self::SESSION;
    }

    public function isExpired()
    {
        return $this->value === self::EXPIRED;
    }

    public function isFinish()
    {
        return $this->value === self::FINISH;
    }
}
