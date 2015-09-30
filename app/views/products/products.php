<?php /** @var \App\Models\Promotions $promotions */ ?>
<div class="container">
    <div class="row">

        <div class="col-md-3">
            <p class="lead">Categories</p>
            <div class="list-group">
                <?php foreach ($categories as $category) {
                    if($category['id'] == $currentCategory){$active = "active";}
                    echo '<a href="'.asset('/products/category/'.$category['id']).'" class="list-group-item '.$active.'">'.$category['name'].'</a>';
                    $active = "";
                } ?>

            </div>
        </div>

        <div class="col-md-9">
<!--
            <div class="row carousel-holder">

                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>

            </div>
-->
            <div class="row">

            <?php
                foreach ($data as $item) {

                    $promotion = $promotions->getProductPromotion($item['id']);
                    $newPrice = round($item['price'] * ((100-$promotion) / 100), 2);
                    $price = "$".$price;

                    if($promotion) {
                        $price = "<span class='red'>$".$newPrice."</span> <small class='strike'>$".$item['price']."</small>";
                    }
            ?>

            <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <?php if($promotion) { ?>
                        <h1 class="discount discount-small">-<?=$promotion;?>% </h1>
                    <?php } ?>
                    <img src="http://placehold.it/320x150" alt="">
                    <p class="label label-default pull-right"><?=$item['quantity'];?> left in our store</p>
                    <br class="clearfix">
                    <div class="title">
                        <h4 class="pull-right price"><?=$price;?></h4>
                        <h4><a href="<?=asset('/products/product/'.$item['id']);?>"><?=$item['name'];?></a></h4>
                        <p><?=mb_substr($item['description'], 0, 100);?></p>
                    </div>
                    <div class="caption">
                        <?php if(array_key_exists($item['id'], $cart)) { ?>
                            <a href="<?=asset('/cart/add/'.$item['id']);?>" class="btn btn-info btn-block <?=$disabled;?>">Add another one for <?=$price;?></a>
                            <small>Currently <?=$cart[$item['id']];?> added in cart.</small>
                        <?php }else{ ?>
                            <a href="<?=asset('/cart/add/'.$item['id']);?>" class="btn btn-info btn-block <?=$disabled;?>">Buy for <?=$price;?></a>
                        <?php } ?><br class="clearfix">
                    </div>

                    <div class="ratings">
                        <p class="pull-right"><?=$item['total_reviews']?:0;?> reviews</p>
                        <p>
                            <?php for($i = 0; $i < round($item['avg_stars']); $i++){ ?>
                                <span class="glyphicon glyphicon-star"></span>
                            <?php }  ?>
                            <?php for($i = $i; $i < 5; $i++){ ?>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            <?php }  ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>


            </div>

        </div>

    </div>

</div>