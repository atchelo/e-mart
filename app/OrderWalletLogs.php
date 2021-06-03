<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderWalletLogs extends Model
{
    protected $fillable = ['wallet_txn_id', 'note', 'type', 'amount', 'balance'];
}
