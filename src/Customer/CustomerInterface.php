<?php

namespace Dsisconeto\LaravelPayment\Customer;

interface CustomerInterface
{
    /**
     * @return int|string
     */
    public function getCustomerId();

    /**
     * @return string
     */
    public function getCustomerType(): string;
}
