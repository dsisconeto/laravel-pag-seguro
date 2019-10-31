<?php

namespace Dsisconeto\LaravelPagSeguro\Cart;

use Illuminate\Database\Eloquent\Model;
use Marketable\MarketableInterface;

/**
 * Class CartItem
 * @package Dsisconeto\LaravelPagSeguro\Cart
 * @property int id
 * @property int cart_id
 * @property float price
 * @property int quantity
 * @property float amount
 * @property int marketable_id
 * @property string marketable_type
 * @property-read Cart cart
 * @property-read MarketableInterface|Model|mixed marketable
 */
class CartItem extends Model
{

    protected $fillable = [
        'cart_id',
        'price',
        'quantity',
        'amount'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'int',
        'amount' => 'float',
    ];

    public function marketable()
    {
        return $this->morphTo();
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function create(array $attributes)
    {
        $cartItem = $this->newInstance($attributes);
        $cartItem->attributes['amount'] = $this->calculateAmount();
        $this->save();
        return $cartItem;
    }

    function calculateAmount()
    {
        return $this->price * $this->quantity;
    }
}
