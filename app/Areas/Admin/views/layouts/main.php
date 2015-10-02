<?php use SSFrame\Facades\View; use SSFrame\Facades\Auth; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Shop ADMIN</title>

    <link href="<?=asset('/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?=asset('/css/sb-admin.css');?>" rel="stylesheet">
    <link href="<?=asset('/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">

    <script src="<?= asset('/js/jquery.js');?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">My Shop Admin</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= Auth::user()->email; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/"><i class="fa fa-arrow-circle-o-left"></i> Back</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="<?=asset('/admin/users');?>"><i class="fa fa-fw fa-dashboard"></i> Users</a>
                </li>
                <li>
                    <a href="<?=asset('/admin/ban');?>"><i class="fa fa-fw fa-bar-chart-o"></i> Ban IP</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <?=View::getLayoutData('body');?>

                </div>
            </div>

        </div>

    </div>

</div>

<script src="<?= asset('/js/bootstrap.min.js');?>"></script>

</body>

</html>
