<?php

namespace App\Controllers\Products;


use App\Bindings\UpdateReviewBindingModel;
use App\Controllers\BaseController;
use App\Models\Reviews;

class ReviewsController extends BaseController
{
    /**
     * @param $product_id
     * @param UpdateReviewBindingModel $input
     * @param Reviews $reviews
     * @return $this->redirect
     */
    public function update($product_id, UpdateReviewBindingModel $input, Reviews $reviews)
    {
        if($reviews->hasCurrentUserReviewed($product_id)){
            $reviews->update($product_id, $this->auth->user()->id, $input->getStars(), $input -> getReview());
        }else{
            $reviews->add($product_id, $this->auth->user()->id, $input->getStars(), $input -> getReview());
        }
        return $this->redirect->to('/products/product/'.$product_id)->withSuccess(['Review is updated successfully'])->go();
    }

}