<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{

    public function scopeCurrentClient($query)
    {
        return $query->where('notifiable_id', authClient()->user()->id);
    }

    public function scopeUpdateAsRead($query)
    {
        return $query->whereNull('read_at')->update(['read_at' => now()]);
    }

    public function scopeUpdateAsReadByMainId($query, $main_id)
    {
        return $query->whereNull('read_at')
            ->where('main_id', $main_id)
            ->update(['read_at' => now()]);
    }

    public function scopeDeleteByMainId($query, $main_id)
    {
        return $query->where('main_id', $main_id)->delete();
    }

    public function scopeDeleteByDataId($query, $id)
    {
        return $query->where('data->id', $id)->delete();
    }

    public function scopeShipments($query)
    {
        return $this->whereTypeStartsWith($query, 'Shipments');
    }

    public function scopeShipmentComments($query)
    {
        return $this->whereTypeStartsWith($query, 'Shipments\\\\Comments');
    }

    public function scopePurchaseOrders($query)
    {
        return $this->whereTypeStartsWith($query, 'PurchaseOrders');
    }

    public function scopePurchaseOrderComments($query)
    {
        return $this->whereTypeStartsWith($query, 'PurchaseOrders\\\\Comments');
    }

    public function scopeMoneyTransfers($query)
    {
        return $this->whereTypeStartsWith($query, 'MoneyTransfers');
    }

    public function scopeShippingAddresses($query)
    {
        return $this->whereTypeStartsWith($query, 'ShippingAddresses');
    }

    public function scopePosts($query)
    {
        return $this->whereTypeStartsWith($query, 'Posts');
    }

    public function scopeCustomers($query)
    {
        return $this->whereTypeStartsWith($query, 'Customers');
    }
    public function scopeWallet($query)
    {
        return $this->whereTypeStartsWith($query, 'Wallet\\Deopnoti');
    }

    public function scopeWithdrawal($query)
    {
        return $this->whereTypeStartsWith($query, 'Wallet\\Withdrawal');
    }

    protected function whereTypeStartsWith($query, $type)
    {
        return $query->where('type', 'like', "App\\\\Notifications\\\\$type%");
    }

}
