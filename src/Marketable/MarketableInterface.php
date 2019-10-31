<?php

namespace Marketable;

interface MarketableInterface
{
    /**
     * @return int|string
     */
    public function getMarketableId();

    /**
     * @return string
     */
    public function getMarketableType(): string;

    /**
     * @return string
     */
    public function getMarketableDescription(): string;

    public function getMarketablePrice(): float;

}
