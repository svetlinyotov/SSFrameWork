<?php use SSFrame\Facades\Auth; use SSFrame\Facades\View; ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=asset('/css/bootstrap.min.css');?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=asset('/css/shop-homepage.css');?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">My shop</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=asset('/products');?>">Products</a>
                </li>
                <li>
                    <a href="<?=asset('/contact');?>">Contact us</a>
                </li>
                <?php if(Auth::user() == false) { ?>
                    <li>
                        <a href="<?=asset('/login');?>">Login</a>
                    </li>
                <?php }else{ ?>
                    <li>
                        <a href="<?=asset('/logout');?>">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>-->
</nav>

<div class="container">
    <?=View::getLayoutData('body');?>

</div>

<div class="container">

    <hr>

    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; <?=date("Y");?></p>
            </div>
        </div>
    </footer>

</div>

<script src="<?= asset('/js/jquery.js');?>"></script>
<script src="<?= asset('/js/bootstrap.min.js');?>"></script>

</body>

</html>
