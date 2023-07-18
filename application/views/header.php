<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/grocery_crud/css/cs-skin-elastic.css')?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/grocery_crud/css/style.css')?>">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <?php
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <style>
        #weatherWidget .currentDesc {
            color: #ffffff!important;
        }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

    </style>
</head>

<body>
<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li class="menu-title">Management</li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Employee</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-list"></i><a href="<?php echo site_url('employees/management')?>">Active list</a></li>
                        <?php if (isset($_SESSION['employee']) && $_SESSION['employee']->job_id == 0) { ?>
                            <li><i class="menu-icon fa fa-plus"></i><a href="<?php echo site_url('employees/management/add')?>">Add</a></li>
                        <?php } ?>
                        <li><i class="menu-icon fa fa-times"></i><a href="<?php echo site_url('employees/inactive')?>">Inactive list</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['employee']) && $_SESSION['employee']->job_id == 0) { ?>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Job</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-list"></i><a href="<?php echo site_url('jobs/management')?>">List</a></li>
                            <li><i class="menu-icon fa fa-plus"></i><a href="<?php echo site_url('jobs/management/add')?>">Add</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-male"></i>Gender</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-list"></i><a href="<?php echo site_url('genders/management')?>">List</a></li>
                            <li><i class="menu-icon fa fa-plus"></i><a href="<?php echo site_url('genders/management/add')?>">Add</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
<!-- /#left-panel -->
<!-- Right Panel -->
<div id="right-panel" class="right-panel">
    <!-- Header-->
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href="./"><img src="<?php echo site_url('assets/grocery_crud/images/logo.png')?>" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="<?php echo site_url('assets/grocery_crud/images/logo2.png')?>" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">


                <div class="user-area dropdown float-right">

                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fa-user"></i><?php if(isset($_SESSION['employee'])) {
                            echo ' '.$_SESSION['employee']->first_name . ' ' . $_SESSION['employee']->last_name . ' - ' . $_SESSION['employee']->job;
                        } else {
                            echo ' Guest ';
                        } ?>
                        </span>
                        <img class="user-avatar rounded-circle" src="<?php echo site_url('assets/grocery_crud/images/admin.jpg')?>" alt="User Avatar">
                    </a>

                    <div class="user-menu dropdown-menu">
                        <?php if(isset($_SESSION['employee'])) { ?>
                        <a class="nav-link" href="<?php echo site_url('employees/signout')?>"><i class="fa fa-sign-out"></i>Logout</a>
                        <?php } else { ?>
                            <a class="nav-link" href="<?php echo site_url('employees/signin')?>"><i class="fa fa-sign-in"></i>Sign In</a>
                        <a class="nav-link" href="<?php echo site_url('employees/signup')?>"><i class="fa fa-plus-circle"></i>Sign Up</a>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </header>
    <!-- /#header -->