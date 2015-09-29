<div class="container">

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

            <div class="row">

                <?php foreach ($data as $item) { ?>

            <div class="col-sm-4 col-lg-4 col-md-4">
                    <div class="thumbnail">
                        <img src="http://placehold.it/320x150" alt="">
                        <div class="caption">
                            <h4 class="pull-right">$<?=$item['price'];?></h4>
                            <h4><a href="<?=asset('/products/product/'.$item['id']);?>"><?=$item['name'];?></a>
                            </h4>
                            <p><?=mb_substr($item['description'], 0, 100);?></p>
                        </div>
                        <div class="ratings">
                            <p class="pull-right"><?=$item['total_reviews']?:0;?> reviews</p>
                            <p>
                                <?php for($i = round($item['avg_stars']); $i > 0; $i--){ ?>
                                    <span class="glyphicon glyphicon-star"></span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>


            </div>

        </div>

    </div>

</div>