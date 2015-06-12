<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dinas Kesehatan Pemerintah Daerah Jember">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/uistuff/images/favicon2.png">

    <title><?php echo $template['title'];?></title>
    <?php echo $template['partials']['script_header']; ?>
    
    
</head>
    
  <body class="full-width">
          
  <section id="container" class="hr-menu">
      <!--header start-->
      
      <header class="header ">
          <img src="<?php echo base_url(); ?>assets/uistuff/images/jember/pemkab3.jpg" style="width: 100%">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle hr-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="fa fa-bars"></span>
              </button>
              <!--logo start-->
<!--              <div class="brand ">
                  <a href="#" class="logo" >
                      <img src="<?php // echo base_url(); ?>assets/uistuff/images/jember/logo.png" alt="">
                  </a>
              </div>-->
              <!--logo end-->
              <?php echo $template['partials']['top_navbar']; ?>
              <div class="top-nav hr-top-nav">
                  <ul class="nav pull-right top-menu">
                      <!-- user login dropdown start-->
                      <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <img alt="" src="<?php echo base_url(); ?>assets/uistuff/images/avatar1_small.jpg">
                              <span class="username"><?php echo $this->session->userdata['telah_masuk']["namauser"] ?> - <?php echo $this->session->userdata['telah_masuk']["hakakses"] ?></span>
                              <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu extended logout">
                              <li><a href="<?php echo base_url() ?>index.php/account/control/updateAccount"><i class=" fa fa-suitcase"></i>Profil</a></li>
                              <li><a href="<?php echo base_url() ?>index.php/login/logout"><i class="fa fa-key"></i> Log Out</a></li>
                          </ul>
                      </li>
                      <!-- user login dropdown end -->
                  </ul>
              </div>
          </div>

      </header>
      <!--header end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <?php  echo $template['body']; ?>
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <footer class="footer-section">
          <?php echo $template['partials']['footer']; ?>
      </footer>
      <!--footer end-->
  </section>

  <!-- Placed js at the end of the document so the pages load faster -->
<?php echo $template['partials']['script_footer']; ?>
  

  </body>
</html>