<?php
    global $os, $site;
    $school_setting_data=$os->school_setting();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> <? echo $school_setting_data['school_name']  ?> <?php echo $os->wtospage['metaTitle'];?> </title>
   <meta name="keywords" content="<?php echo $os->getSettings('metaKey');?> <?php echo $os->wtospage['metaTag'];?>   "><!--eta copy korte hobe-->
    <meta name="description" content="<?php echo $os->getSettings('metaDescription');?> <?php echo $os->wtospage['metaDescription'];?> ">
  <!-- Favicons -->
  <link href="<? echo $site['themePath']?>assets/img/favicon.png" rel="icon">
  <link href="<? echo $site['themePath']?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<? echo $site['themePath']?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<? echo $site['themePath']?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="<? echo $site['url-library']?>wtos-1.1.js"></script>

<link rel="stylesheet" href="<? echo $site['themePath']?>css/uikit.css" >
    <link rel="stylesheet" href="<? echo $site['themePath']?>css/style.css">
    <script src="<? echo $site['themePath']?>js/uikit.min.js"></script>
    <script src="<? echo $site['themePath']?>js/uikit-icons.min.js"></script>
    <script src="<? echo $site['themePath']?>js/jquery-3.4.1.min.js"></script>
    <script src="<? echo $site['themePath']?>js/script.js"></script>
  <!-- Template Main CSS File -->
  <link href="<? echo $site['themePath']?>assets/css/style.css" rel="stylesheet">
    <?php echo $os->getSettings('Styles'); ?>


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="top_header">
      <div class="container">
        <div class="col-lg-10">
          <p>
            <span><i class="fa-solid fa-phone"></i> &nbsp; 8617369044</span> &nbsp;&nbsp;
            <span><i class="fa-solid fa-envelope"></i> &nbsp; apsjangipur2021@gmail.com</span>
          </p>
        </div>
        <div class="col-lg-2"></div>

      </div>
    </div>
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="<? echo $site['url'] ?>">
          <img src="<? echo $site['themePath']?>assets/img/logo.png" />
        </a></h1>


      <nav id="navbar" class="navbar">
        <ul>
          <?php include('wt_navigation.php'); ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
<style>
  #header .logo img {
  max-height: 80px;
}
  </style>
