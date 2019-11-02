<?php

namespace Dsisconeto\LaravelPayment\Cart;

use BenSampo\Enum\Traits\CastsEnums;
use Dsisconeto\LaravelPayment\Customer\CustomerInterface;
use Dsisconeto\LaravelPayment\Marketable\MarketableInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * @package Dsisconeto\LaravelPayment\Cart
 * @property int id
 * @property int customer_id
 * @property string customer_type
 * @property float price
 */
class Cart extends Model
{
    use  CastsEnums;

    public $enumCasts = [
        'status' => CartStatus::class,
    ];

    protected $fillable = [
        'customer_id',
        'customer_type'
    ];

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
        return $this->create(
            $this->prepareCartToCreate($customer, $attributes)
        );
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

    public function getSessionAttribute(): bool
    {

    }
}
