<div class="row">

    <?php foreach ($data as $cat) { ?>


    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="http://placehold.it/320x150" alt="">
            <div class="caption">
                <h4 class="pull-right">-$<?=$cat['discount'];?></h4>
                <h4><a href="<?= asset('/products/category/'.$cat['id']); ?>"><?=$cat['name'];?></a>
                </h4>
                <p><?=$cat['description']; ?></p>
            </div>
        </div>
    </div>

    <?php } ?>


</div>