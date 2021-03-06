<?php use \SSFrame\Form; ?>
<br>
<?php if($errors) { ?>
<div class="alert alert-danger">
    <?php
        foreach ($errors as $error) {
            echo "$error <br>";
        }
    ?>
</div>
<?php } ?>


<div class="row">
    <div class="container" style="margin-top:30px">
        <div class="col-md-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title"><strong>Sign In </strong></h3></div>
                <div class="panel-body">
                    <?=Form::open(asset('/login'), "POST", ['role'=>'form']);?>
                        <?=Form::csrf();?>
                        <div class="form-group">
                            <?=Form::label('email', 'Email'); ?>
                            <?=Form::email('email', $input['email'], ['class'=>'form-control', 'id'=>'email', 'placeholder'=>'Enter email']); ?>
                        </div>
                        <div class="form-group">
                            <?=Form::label('password', 'Password'); ?>
                            <?=Form::password('password', ['class'=>'form-control', 'id'=>'password', 'placeholder'=>'Password']); ?>
                        </div>
                        <?=Form::submit('', 'Sign in', ['class' => 'btn btn-sm btn-default']); ?>
                    <?=Form::close();?>
                </div>
            </div>
        </div>
    </div>
</div>
