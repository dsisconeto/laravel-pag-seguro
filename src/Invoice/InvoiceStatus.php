<?php

namespace Dsisconeto\LaravelPayment\Invoice;

use BenSampo\Enum\Enum;

class InvoiceStatus extends Enum
{
    public const WAITING = 'WAITING';
    public const ANALYZE = 'ANALYZE';
    public const CANCELED = 'CANCELED';
    public const PAID = 'PAID';

    public function isWaiting(): bool
    {
        return $this->value === self::WAITING;
    }

    public function isAnalyze(): bool
    {
        return $this->value === self::ANALYZE;
    }

    public function isCanceled(): bool
    {
        return $this->value === self::CANCELED;
    }

    public function isPaid(): bool
    {
        return $this->value === self::PAID;
    }

}
