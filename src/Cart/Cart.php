<?php

namespace Dsisconeto\LaravelPagSeguro\Cart;

use Customer\CustomerInterface;
use Illuminate\Database\Eloquent\Model;
use Marketable\MarketableInterface;

/**
 * Class Cart
 * @package Dsisconeto\LaravelPagSeguro\Cart
 * @property int id
 * @property int customer_id
 * @property string customer_type
 * @property float price
 */
class Cart extends Model
{

    public function customer()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function createByCustomer(CustomerInterface $customer, array $attributes): Cart
    {
        $cart = $this->newInstance(
            $this->prepareCartToCreate($customer, $attributes)
        );

        $cart->save();
        return $cart;
    }

    protected function prepareCartToCreate(CustomerInterface $customer, array $attributes)
    {
        return $attributes + [
                'customer_id' => $customer->getCustomerId(),
                'customer_type' => $customer->getCustomerType(),
            ];
    }

    public function addItem(MarketableInterface $marketable, int $quantity): CartItem
    {
        $item = $this->items()
            ->forceCreate(
                $this->prepareItemToAdd($marketable, $quantity)
            );

        $this->attributes['amount'] = $this->calculateAmount();
        return $item;
    }

    protected function prepareItemToAdd(MarketableInterface $marketable, int $quantity): array
    {
        return [
            'marketable_id' => $marketable->getMarketableId(),
            'marketable_type' => $marketable->getMarketableType(),
            'quantity' => $quantity,
            'price' => $marketable->getMarketablePrice(),
        ];
    }

    public function calculateAmount()
    {
        return $this->items()->sum('amount');
    }
}
