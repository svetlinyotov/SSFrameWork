<?php use SSFrame\Form; ?>

<h1 class="page-header">
    Users
</h1>

<?=Form::open(asset('/admin/users/add'), 'POST', ['class'=>'form-inline', 'role'=>'form']); ?>
<?=Form::csrf();?>
<div class="form-group">
    <?=Form::label('email', 'Email'); ?>
    <?=Form::email('email', null, ['class'=>'form-control']); ?>
</div>
<?=Form::submit('', 'Ban', ['class'=>'btn btn-danger']); ?>
<?=Form::close();?>

<hr>
<div class="row">
    <div class="col-lg-3">
        <table class="table">
            <tr>
                <th>Users</th>
                <th></th>
            </tr>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?=$user['email'];?></td>
                    <td>
                        <a href="<?=asset('/admin/user/delete/'.$user['id']);?>" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-2x"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

