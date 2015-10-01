<?php /** @var \App\Models\Promotions $promotions */ use SSFrame\Facades\Auth; use SSFrame\Form; ?>
<div class="container">
    <div class="row">

        <div class="col-md-3">
            <p class="lead">Categories</p>
            <div class="list-group">
                <?php
                $list = [];
                foreach ($categories as $category) {
                    if($category['id'] == $currentCategory){$active = "active";}
                    $list[$category['id']] = $category['name'];
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
            <?php if(Auth::user()->role < 3 && Auth::user()) { ?>
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#cat_add"><i class="glyphicon glyphicon-plus"></i></a>
            <?php } ?>

            <div class="row" id="sortable">
            <?php
                foreach ($data as $item) {

                    $promotion = $promotions->getProductPromotion($item['id']);
                    $newPrice = round($item['price'] * ((100-$promotion) / 100), 2);
                    $price = "$".$item['price'];

                    if($promotion) {
                        $price = "<span class='red'>$".$newPrice."</span> <small class='strike'>$".$item['price']."</small>";
                    }
            ?>

            <div class="col-sm-4 col-lg-4 col-md-4" id="product-<?=$item['id'];?>">
                <div class="thumbnail">
                    <?php if($promotion) { ?>
                        <h1 class="discount discount-small">-<?=$promotion;?>% </h1>
                    <?php } ?>
                    <?php if($item['photo'] != "") { ?>
                        <img src="<?= asset('/user_data/products/'.$item['photo'])?>" alt="">
                    <?php }else{ ?>
                        <img src="http://placehold.it/320x150" alt="">
                    <?php } ?>
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

                    <div>
                        <?php if(Auth::user()->role == 0 && Auth::user()) { ?>
                            <a href="#cat_edit" class="btn btn-warning" data-id="<?=$item['id'];?>" data-title="<?=$item['name'];?>" data-description="<?=$item['description'];?>" data-price="<?=$item['price'];?>" data-quantity="<?=$item['quantity'];?>"  data-category="<?=$item['category_id'];?>" data-toggle="modal" data-target="#cat_edit"><i class="glyphicon glyphicon-pencil"></i></a>
                        <?php } ?>
                        <?php if(Auth::user()->role < 3 && Auth::user()) { ?>
                            <a href="#cat_delete" class="btn btn-danger" data-toggle="modal" data-id="<?=$item['id'];?>" data-target="#cat_delete"><i class="glyphicon glyphicon-trash"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>


            </div>

        </div>

    </div>

</div>



<?php if(Auth::user()->role < 3 && Auth::user()) { ?>
    <div class="modal fade" id="cat_add" tabindex="-1" role="dialog" aria-labelledby="cat_add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add category</h4>
                </div>
                <?=Form::open(asset('/product/add'), 'POST', ['class'=>'form', 'role'=>'form'], true); ?>
                <div class="modal-body">
                    <?=Form::csrf();?>
                    <div class="form-group">
                        <?=Form::label('title', 'Title');?>
                        <?=Form::text('title', '', ['class'=>'form-control']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('description', 'Description');?>
                        <?=Form::textarea('description', '', ['class'=>'form-control']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('price', 'Price');?>
                        <?=Form::text('price', '', ['class'=>'form-control']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('quantity', 'Quantity');?>
                        <?=Form::text('quantity', '', ['class'=>'form-control']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('category', 'Category');?>
                        <?=Form::select('category', $list, null, ['class'=>'form-control']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('photo', 'Photo');?>
                        <?=Form::file('photo', ['class'=>'form-control']); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
                <?=Form::close(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php if(Auth::user()->role == 0 && Auth::user()) { ?>
    <div class="modal fade" id="cat_edit" tabindex="-1" role="dialog" aria-labelledby="cat_edit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit category</h4>
                </div>
                <?=Form::open(asset('/product/edit/'), 'POST', ['class'=>'form', 'role'=>'form'], true); ?>
                <div class="modal-body">
                    <?=Form::csrf();?>
                    <div class="form-group">
                        <?=Form::label('title', 'Title');?>
                        <?=Form::text('title', '', ['class'=>'form-control', 'id'=>'input-title']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('description', 'Description');?>
                        <?=Form::textarea('description', '', ['class'=>'form-control', 'id'=>'input-description']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('price', 'Price');?>
                        <?=Form::text('price', '', ['class'=>'form-control', 'id'=>'input-price']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('quantity', 'Quantity');?>
                        <?=Form::text('quantity', '', ['class'=>'form-control', 'id'=>'input-quantity']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('category', 'Category');?>
                        <?=Form::select('category', $list, null, ['class'=>'form-control', 'id'=>'input-category']); ?>
                    </div>
                    <div class="form-group">
                        <?=Form::label('photo', 'Photo');?>
                        <?=Form::file('photo', ['class'=>'form-control']); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                <?=Form::close(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php if(Auth::user()->role < 3 && Auth::user()) { ?>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="cat_delete" aria-labelledby="cat_delete">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                Are you sure you want to delete the product?

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="#" id="delete_button" class="btn btn-danger">Delete</a>
            </div>

        </div>
    </div>
<?php } ?>

<?php if(Auth::user()->role < 3 && Auth::user()) { ?>
    <script type="text/javascript">
        $('#cat_edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var price = button.data('price');
            var quantity = button.data('quantity');
            var category = button.data('category');
            var description = button.data('description');

            var modal = $(this);
            modal.find('#input-title').val(title);
            modal.find('#input-price').val(price);
            modal.find('#input-quantity').val(quantity);
            modal.find('#input-description').val(description);
            modal.find('#input-category option[value='+category+']').prop('selected', true);
            modal.find('form').attr('action', '<?=asset('/admin/product');?>/' + id);
        });

        $('#cat_delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modal = $(this);
            modal.find('#delete_button').attr('href', '<?=asset('/admin/product/delete');?>/' + id);
        });

        $(function() {
            $( "#sortable" ).sortable({
                update: function (event, ui) {
                    var data = $(this).sortable('serialize');
                    data+="&csrf_token=<?= \SSFrame\CSRF::getInstance()->token();?>";

                    $.ajax({
                        data: data,
                        type: 'POST',
                        url: '<?=asset("/products/sort");?>'
                    });
                }
            });
        });
    </script>
<?php } ?>