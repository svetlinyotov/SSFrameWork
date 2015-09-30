<?php use \SSFrame\Form; ?>
<a href="" class="btn btn-success" data-toggle="modal" data-target="#cat_add"><i class="glyphicon glyphicon-plus"></i></a>
<h1>Categories</h1>
<div class="row">
    <?php if($success) { ?>
        <div class="alert alert-success">
            <?php
            foreach ($success as $succes) {
                echo "$succes <br>";
            }
            ?>
        </div>
    <?php } ?>
    <?php foreach ($data as $cat) { ?>


    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <?php if($cat['photo'] != "") { ?>
                <img src="<?= asset('/user_data/categories/'.$cat['photo'])?>" alt="">
            <?php }else{ ?>
                <img src="http://placehold.it/320x150" alt="">
            <?php } ?>
            <div class="caption">
                <h4><a href="<?= asset('/products/category/'.$cat['id']); ?>"><?=$cat['name'];?></a>
                </h4>
                <p><?=$cat['description']; ?></p>
            </div>
            <div>
                <a href="#cat_edit" class="btn btn-warning" data-id="<?=$cat['id'];?>" data-title="<?=$cat['name'];?>" data-description="<?=$cat['description'];?>" data-toggle="modal" data-target="#cat_edit"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="#cat_delete" class="btn btn-danger" data-toggle="modal" data-id="<?=$cat['id'];?>" data-target="#cat_delete"><i class="glyphicon glyphicon-trash"></i></a>
            </div>
        </div>
    </div>

    <?php } ?>
</div>

<div class="modal fade" id="cat_add" tabindex="-1" role="dialog" aria-labelledby="cat_add">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add category</h4>
            </div>
            <?=Form::open(asset('/categories/add'), 'POST', ['class'=>'form', 'role'=>'form'], true); ?>
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

<div class="modal fade" id="cat_edit" tabindex="-1" role="dialog" aria-labelledby="cat_edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit category</h4>
            </div>
            <?=Form::open(asset('/categories/edit/'), 'POST', ['class'=>'form', 'role'=>'form'], true); ?>
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

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="cat_delete" aria-labelledby="cat_delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            Are you sure you want to delete the category?

            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="#" id="delete_button" class="btn btn-danger">Delete</a>
        </div>

    </div>
</div>


<script type="text/javascript">
    $('#cat_edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var title = button.data('title');
        var description = button.data('description');

        var modal = $(this);
        modal.find('#input-title').val(title);
        modal.find('#input-description').val(description);
        modal.find('form').attr('action', '<?=asset('/admin/category');?>/' + id);
    });

    $('#cat_delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('#delete_button').attr('href', '<?=asset('/admin/category/delete');?>/' + id);
    });
</script>