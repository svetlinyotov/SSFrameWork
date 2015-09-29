<?php

namespace App\Controllers\Products;


use App\Bindings\UpdateReviewBindingModel;
use App\Models\Reviews;
use SSFrame\Facades\Auth;
use SSFrame\Facades\Redirect;

class ReviewsController
{
    /**
     * @param $product_id
     * @param \App\Bindings\UpdateReviewBindingModel $input
     * @param \App\Models\Reviews $reviews
     * @return mixed
     */
    public function update($product_id, UpdateReviewBindingModel $input, Reviews $reviews)
    {
        if($reviews->hasCurrentUserReviewed($product_id)){
            $reviews->update($product_id, Auth::user()->id, $input->getStars(), $input -> getReview());
        }else{
            $reviews->add($product_id, Auth::user()->id, $input->getStars(), $input -> getReview());
        }
        return Redirect::to('/products/product/'.$product_id)->withSuccess(['Review is updated successfully'])->go();
    }

}