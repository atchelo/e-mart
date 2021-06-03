<?php

use App\UserReview;

class ProductRating
{

    public static function getReview($pro)
    {

        $ratings_var = 0;
        $reviews = UserReview::where('pro_id', $pro->id)->where('status', '1')->get();
        
        if(count($reviews)>0){
            $review_t = 0;
            $price_t = 0;
            $value_t = 0;
            $sub_total = 0;
            $count = UserReview::where('pro_id', $pro->id)->count();

            foreach ($reviews as $review) {

                $review_t = $review->price * 5;
                $price_t = $review->price * 5;
                $value_t = $review->value * 5;
                $sub_total = $sub_total + $review_t + $price_t + $value_t;
            }

            $count = ($count * 3) * 5;
            $rat = $sub_total / $count;
            $ratings_var = ($rat * 100) / 5;

            return $ratings_var;
        }else{
            return $ratings_var;
        }

        

    }

}
