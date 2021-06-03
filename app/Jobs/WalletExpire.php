<?php

namespace App\Jobs;

use App\UserWalletHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WalletExpire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::reconnect('mysql');
        $histories = UserWalletHistory::with('wallet')->where('expired', '=', '0')->where('expire_at', '!=', null)->where('expire_at', '=', date('Y-m-d'))->where('type', '=', 'credit')->get();

        if (count($histories) > 0) {

            $histories->each(function($history){
                
                if ($history->expired == 0 && $history->type == 'Credit' && $history->wallet->status == 0) {

                    $newbalance = $history->wallet->balance - $history->amount;

                    DB::table('user_wallets')->where('user_id', $history->wallet->user->id)->update(['balance' => $newbalance]);

                    DB::table('user_wallet_histories')->where('id', '=', $history->id)->update(['expired' => 1]);

                    DB::table('user_wallet_histories')->insert([
                        'wallet_id' => $history->wallet->id,
                        'type' => 'Debit',
                        'log' => 'Points expired',
                        'amount' => $history->amount,
                        'txn_id' => 'WALLET_POINT_EXPIRED_' . uniqid(),
                        'expire_at' => null,
                    ]);

                }
            });

        }

        \DB::disconnect('mysql');
    }
}
