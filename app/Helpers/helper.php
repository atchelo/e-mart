<?php

function getPlanStatus()
{

    if (auth()->user()->activeSubscription && date('Y-m-d h:i:s') <= auth()->user()->activeSubscription->end_date && auth()->user()->activeSubscription->status == 1) {

        return 1;

    } else {

        if(auth()->user()->activeSubscription){

            auth()->user()->activeSubscription()->update([
                'status' => 0
            ]);
        }

        return 0;
    }

}
