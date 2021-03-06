<?php
/** @var \App\Models\Reviews $reviews_model
 * @var \App\Models\Products $product_model */
use SSFrame\Facades\Auth; use \SSFrame\Form; ?>

<?php
    if($product_model->checkQuantity($product['id']) <= $cart[$product['id']]){
        $disabled = "disabled";
    }
?>

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
            <?php if($promotion) { ?>
                <h1 class="discount">-<?=$promotion;?>% </h1>
            <?php } ?>
            <?php if($product['photo'] != "") { ?>
                <img src="<?= asset('/user_data/products/'.$product['photo'])?>" alt="">
            <?php }else{ ?>
                <img src="http://placehold.it/800x300" alt="">
            <?php } ?>
            <div class="caption-full">
                <?php if($disabled == null) { ?>
                    <h4 class="pull-right text-right">
                        <span class="label label-default"><?=$product['quantity'];?> left in our store</span><br>
                        <?php
                            $price = $product['price'];
                            $newPrice = round($price * ((100-$promotion) / 100), 2);
                            $price = "$".$price;

                            if($promotion) {
                                $price = "<span class='red'>$".$newPrice."</span> <small class='strike'>$".$product['price']."</small>";
                            }
                        ?>
                        <?php if(array_key_exists($product['id'], $cart)) { ?>
                            <a href="<?=asset('/cart/add/'.$product['id']);?>" class="btn btn-info <?=$disabled;?>">Add another one for <?=$price;?></a><br>
                            <small>Currently <?=$cart[$product['id']];?> added in cart.</small>
                        <?php }else{ ?>
                            <a href="<?=asset('/cart/add/'.$product['id']);?>" class="btn btn-info <?=$disabled;?>">Buy for $<?=$price;?></a>
                        <?php } ?>
                    </h4>
                <?php }else{ ?>
                    <h4 class="pull-right text-right">
                        Out of stock.<br>
                        <small>Currently <?=$cart[$product['id']];?> added in cart.</small>
                    </h4>
                <?php } ?>
                <h1><a href="#"><?=$product['name'];?></a>
                </h1>
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