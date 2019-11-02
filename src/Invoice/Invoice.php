<?php

namespace Dsisconeto\LaravelPayment\Invoice;

use BenSampo\Enum\Traits\CastsEnums;
use Dsisconeto\LaravelPayment\Cart\Cart;
use Dsisconeto\LaravelPayment\Cart\CartItem;
use Dsisconeto\LaravelPayment\Marketable\MarketableInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * @package Dsisconeto\LaravelPayment\Invoice
 * @property InvoiceStatus status
 */
class Invoice extends Model
{
    use CastsEnums;

    public $enumCasts = [
        'status' => InvoiceStatus::class,
    ];

    public function customer()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function createByCart(Cart $cart)
    {
        /** @var static $invoice */
        $invoice = $this->create([
            'cart_id' => $cart->id,
            'customer_id' => $cart->customer_id,
            'customer_type' => $cart->customer_type
        ]);

        /** @var CartItem $item */
        foreach ($cart->items() as $item) {
            $this->addItem($item->marketable, $item->quantity);
        }

        $this->attributes['amount'] = $invoice->calculateAmount();

        return $invoice;
    }

    public function addItem(MarketableInterface $marketable, int $quantity)
    {
        $this->items()->forceCreate(
            $this->prepareItemToAdd($marketable, $quantity)
        );
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

    protected function calculateAmount(): float
    {
        return $this->items()->sum('amount');
    }

    public function getIsWaitingAttribute()
    {
        return $this->status->isWaiting();
    }

    public function getIsAnalyzeAttribute()
    {
        return $this->status->isAnalyze();
    }

    public function getIsCanceledAttribute()
    {
        return $this->status->isCanceled();
    }

    public function getIsPaidAttribute()
    {
        return $this->status->isPaid();
    }
}
