<?php use SSFrame\Form; ?>

<h1 class="page-header">
    Ban IP
</h1>

<?=Form::open(asset('/admin/ban/add'), 'POST', ['class'=>'form-inline', 'role'=>'form']); ?>
<?=Form::csrf();?>
    <div class="form-group">
        <?=Form::label('ip', 'IP Address'); ?>
        <?=Form::text('ip', null, ['class'=>'form-control']); ?>
    </div>
    <?=Form::submit('', 'Ban', ['class'=>'btn btn-danger']); ?>
<?=Form::close();?>

<hr>
<div class="row">
    <div class="col-lg-3">
        <table class="table">
            <tr>
                <th>IP</th>
                <th></th>
            </tr>
            <?php foreach ($bans as $ban) { ?>
                <tr>
                    <td><?=$ban['ip'];?></td>
                    <td>
                        <a href="<?=asset('/admin/ban/delete/'.$ban['id']);?>" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-2x"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

