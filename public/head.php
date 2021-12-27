<?php
    session_start();
    include "config/config.php";
    if (!isset($_SESSION['user_id'])&& $_SESSION['user_id']==null) {
        header("location: index.php");
    }
?>
<?php 
    $id=$_SESSION['user_id'];
    $query=mysqli_query($con,"SELECT * from user_login where id_user=$id");
    while ($row=mysqli_fetch_array($query)) {
        $username = $row['USERNAME'];
        $name = $row['NOMBRE'];
        $email = $row['EMAIL'];
        $profile_pic = $row['ID_DPTO'];
        $created_at = $row['ID_DPTO'];
        $IsAdmin = $row['ADMIN_PRIV'];
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title." ".$name; ?> </title>

        <!-- Material Design -->
        <link rel="stylesheet" type="text/css" href="assets/fonts/iconic/css/material-design-iconic-font.min.css">
        <!-- Bootstrap -->
        <link href="assets/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="assets/css/nprogress/nprogress.css" rel="stylesheet">
          <!-- iCheck -->
       <link href="assets/css/iCheck/skins/flat/green.css" rel="stylesheet">
       <!-- Datatables -->
        <link href="assets/css/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link href="assets/css/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

        <!-- bootstrap-daterangepicker -->
        <link href="assets/css/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="assets/css/custom.min.css" rel="stylesheet">
	    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

        <!-- MICSS button[type="file"] -->
        <link rel="stylesheet" href="assets/css/micss.css">
        <!-- JQuery files -->
        <script language="JavaScript" type="text/javascript" src="assets/js/jquery/dist/jquery.min.js"></script>



    </head>

    <body class="nav-sm">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                          <a href="#" class="site_title"><i class="zmdi zmdi-8tracks"></i> <span>OASIS</span></a>
                        </div>
                        <div class="clearfix"></div>

                            <!-- menu profile quick info -->
                                <div class="profile clearfix">
                                    <div class="profile_pic">
                                        <img src="assets/images/profiles/1.png" alt="<?php echo $name;?>" class="img-circle profile_img">
                                    </div>
                                    <div class="profile_info">
                                        <span>Bienvenido,</span>
                                        <h2><?php echo $name;?></h2>
                                    </div>
                                </div>
                            <!-- /menu profile quick info -->

                        <br />