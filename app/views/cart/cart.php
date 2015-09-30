<?php use \SSFrame\Form; ?>
<div class="row">

    <h1>Shopping Cart</h1>
<?php if(is_array($items) && count($items) > 0) { ?>
    <?php if($errors) { ?>
        <div class="alert alert-danger">
            <?php
            foreach ($errors as $error) {
                echo "$error <br>";
            }
            ?>
        </div>
    <?php } ?>

    <?=Form::open(asset('/cart/update'), 'POST'); ?>
    <?=Form::csrf();?>
    <table class="table table-responsive" role="table">
        <tr>
            <th></th>
            <th>Product/Category</th>
            <th>Quantity</th>
            <th>Price</th>
            <th></th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($items as $item) { ?>
        <tr>
            <td></td>
            <td>
                <a href="<?=asset('/products/product/'.$item['id']); ?>"><?=$item['product_name']; ?></a>
                <br><a href="<?=asset('/products/category/'.$item['category_id']); ?>"><i><?=$item['category_name']; ?></i></a></td>
            <td>
                <?php
                $price = $item['price'];
                $newPrice = round($price * ((100-$item['discount']) / 100), 2);

                if($item['discount']){
                    $price = "<span class='red'>$".$newPrice."</span> <small class='strike'>$".$item['price']."</small>";
                }
                ?>
                <?=Form::number('quantity['.$item['id'].']', $session_cart[$item['id']], null, null, ['class'=>'form-control', 'style'=>'width:60px; display:inline-block']); ?>
                x <?=$price;?>
            </td>
            <td>
                $<?= $session_cart[$item['id']]*$newPrice;?>
            </td>
            <td class="text-center"><a href="<?=asset('/cart/delete/'.$item['id']); ?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a></td>
        </tr>

        <?php $total += $session_cart[$item['id']]*$item['price']; } ?>

        <tr>
            <td colspan="2"></td>
            <td><?=Form::submit(null, 'Update', ['class'=>'btn btn-warning']); ?></td>
            <td><b>$<?=$total;?></b></td>
            <td class="text-center"><button type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger">Empty</button></td>
        </tr>
    </table>
    <?=Form::close();?>

    <a href="<?= asset('/cart/checkout'); ?>" class="btn btn-info btn-block">Checkout</a>


</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to empty your cart?</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="<?=asset('/cart/emptyCart'); ?>" class="btn btn-danger">Empty</a>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
    <h3>Cart is empty.</h3>
<?php } ?>
