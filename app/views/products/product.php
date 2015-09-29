<?php
/** @var \App\Models\Reviews $reviews_model */
use SSFrame\Facades\Auth; use \SSFrame\Form; ?>
<div class="row">

    <div class="col-md-3">
        <p class="lead">Categories</p>
        <div class="list-group">
            <?php foreach ($categories as $category) {
                echo '<a href="'.asset('/products/category/'.$category['id']).'" class="list-group-item">'.$category['name'].'</a>';
            } ?>
        </div>
    </div>

    <div class="col-md-9">

        <?php if($success) { ?>
            <div class="alert alert-success">
                <?php
                foreach ($success as $succes) {
                    echo "$succes <br>";
                }
                ?>
            </div>
        <?php } ?>

        <div class="thumbnail">
            <img class="img-responsive" src="http://placehold.it/800x300" alt="">
            <div class="caption-full">
                <h4 class="pull-right text-right">
                    <?php if(array_key_exists($product['id'], $cart)) { ?>
                        <a href="<?=asset('/cart/add/'.$product['id']);?>" class="btn btn-info">Add another one for $<?=$product['price'];?></a><br>
                        <small>Currently <?=$cart[$product['id']];?> added in cart.</small>
                    <?php }else{ ?>
                        <a href="<?=asset('/cart/add/'.$product['id']);?>" class="btn btn-info">Buy for $<?=$product['price'];?></a>
                    <?php } ?>
                </h4>
                <h4><a href="#"><?=$product['name'];?></a>
                </h4>
                <p><?=$product['description'];?></p>
            </div>
            <div class="ratings">
                <p class="pull-right"><?=$product['total_reviews']?:0;?> reviews</p>
                <p>
                    <?php for($i = 0; $i < round($product['avg_stars']); $i++){ ?>
                        <span class="glyphicon glyphicon-star"></span>
                    <?php }  ?>
                    <?php for($i = $i; $i < 5; $i++){ ?>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    <?php }  ?>
                    <?=round($product['avg_stars']);?> stars
                </p>
            </div>
        </div>

        <div class="well">
            <?php if(Auth::user()) { ?>
                <?php if($reviews_model->hasCurrentUserReviewed($product['id'])){$button="Edit review";}else{$button = "Leave a Review";} ?>
            <div class="text-right">
                <button type="button" data-toggle="modal" data-target="#addEditModal" class="btn btn-success" ><?=$button;?></button>
            </div>

            <hr>
            <?php } ?>

            <?php foreach ($reviews as $review) { ?>

            <div class="row">
                <div class="col-md-12">
                    <?php for($i = 0; $i < round($review['stars']); $i++){ ?>
                        <span class="glyphicon glyphicon-star"></span>
                    <?php }  ?>
                    <?php for($i = $i; $i < 5; $i++){ ?>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    <?php }  ?>
                    <?=$review['from'];?>
                    <span class="pull-right"><?= \SSFrame\Common::generateTimeAgo($review['time']); ?>
                    </span>
                    <p><?=nl2br($review['text']);?></p>
                </div>
            </div>

            <hr>

            <?php } ?>

        </div>

    </div>

</div>


<div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="addEditModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">My Review</h4>
            </div>
            <?= Form::open(asset('/review/'.$product['id']), 'POST'); ?>
                <div class="modal-body">
                    <?=Form::csrf();?>
                    <?=Form::label('stars', 'Stars');?>
                    <?=Form::selectRange('stars', 1, 5, $current_user_review['stars']?:5, 1, ['class'=>'form-control']);?>
                    <?=Form::label('review', 'Review');?>
                    <?=Form::textarea('review', htmlspecialchars_decode($current_user_review['text'])?:null, ['rows'=>3, 'cols'=>60, 'class'=>'form-control']);?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            <?=Form::close();?>
        </div>
    </div>
</div>