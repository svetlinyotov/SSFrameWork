<?php use SSFrame\Form; use SSFrame\Facades\Auth; ?>

<?php if($errors) { ?>
    <div class="alert alert-danger">
        <?php
        foreach ($errors as $error) {
            echo "$error <br>";
        }
        ?>
    </div>
<?php } ?>

<table class="table table-responsive" role="table">
    <tr>
        <th></th>
        <th>Product/Category</th>
        <th>Quantity</th>
        <th>Price</th>
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
                <?=$session_cart[$item['id']]; ?>
                x <?=$price;?>
            </td>
            <td>
                $<?= $session_cart[$item['id']]*$newPrice;?>
            </td>
        </tr>

        <?php $total += $session_cart[$item['id']]*$item['price']; } ?>

    <tr>
        <td colspan="2"><a href="<?=asset('/cart');?>" class="btn btn-default">Edit cart</a></td>
        <td></td>
        <td><b>$<?=$total;?></b></td>
    </tr>
</table>

<?=Form::open(asset('/cart/doCheckout'), 'POST', ['role'=>'form', 'class'=>'form']); ?>
    <?=Form::csrf();?>
    <div class="form-group">
        <?=Form::label('names', 'Names'); ?>
        <?=Form::text('names', $input['names']?:Auth::user()->names, ['class' => 'form-control']); ?>
    </div>
    <div class="form-group">
        <?=Form::label('email', 'Email'); ?>
        <?=Form::email('email', $input['email']?:Auth::user()->email, ['class' => 'form-control']); ?>
    </div>
    <div class="form-group">
        <?=Form::label('mobile', 'Mobile'); ?>
        <?=Form::text('mobile', $input['mobile']?:null, ['class' => 'form-control']); ?>
    </div>
    <div class="form-group">
        <?=Form::label('address', 'Address'); ?>
        <?=Form::textarea('address', $input['address']?:null, ['class' => 'form-control', 'rows' => 2, 'cols'=>40]); ?>
    </div>

    <?=Form::submit('', 'Order NOW', ['class' => 'btn btn-info btn-lg btn-block']);?>
<?=Form::close(); ?>
