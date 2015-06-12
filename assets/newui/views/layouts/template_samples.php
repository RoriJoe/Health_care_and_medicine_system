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
    
<body class="wp-theme-3 body-bg-2">
          <div class="wrapper lw boxed" style="box-shadow: 0px 0px 50px #000000">
          
		  <div class="row">
		  <div class="col-md-12">
                    <div class="">
						<img style="width: 100%; margin: 0;" src="<?php echo base_url(); ?>assets/newui/images/jember/logo-kab-fixed.jpg" />
					</div>
					</div>
				</div>
      <!--header start-->
        <div class="top-header" >
				
            <!--<div class="container">-->
                <div class="row">
                    <div class="col-sm-12">
                        <section id="slider-wrapper" class="layer-slider-wrapper">
                        <div id="layerslider" style="width:100%;height:200px;">        
                            <div class="ls-slide" data-ls="transition2d:1;timeshift:-1000;" >
                                    <!-- slide background -->
                                <img src="<?php echo base_url(); ?>assets/newui/images/jember/pemkab3.jpg" class="ls-bg" alt="Slide background"/>
            
                            </div>

                            <div class="ls-slide" data-ls="transition2d:1;timeshift:-1000;">
                                    <!-- slide background -->
                                <img src="<?php echo base_url(); ?>assets/newui/images/jember/sumbersari.jpg" class="ls-bg" alt="Slide background"/>
            
                            </div>
                        </div>
                    </section>
                    </div>
                </div>
            <!--</div>-->
        </div>
<!-- Header: Logo and Main Nav -->
      <header class="header">
          <div id="navTwo" class="navbar navbar-wp navbar-contrasted" role="navigation">
              <div class="container">
                  <div class="row">
                      <div class="col-lg-8">
                          <?php echo $template['partials']['top_navbar']; ?>
                      </div>
                      <div class="col-lg-4">
                          <div class="top-nav hr-top-nav" style="margin-top: 10px" >
                      <ul class="nav pull-right top-menu">
                          <!-- user login dropdown start-->
                          <li class="dropdown">
                              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                  <span class="username"><?php echo $this->session->userdata['telah_masuk']["namauser"] ?></span>
                                  <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu extended logout">
                                  <li><a href="<?php echo base_url().'index.php/account/updateOwnAccount'; ?>"><i class=" fa fa-suitcase"></i>Profil</a></li>
                                  <li><a href="<?php echo base_url() ?>index.php/login/logout"><i class="fa fa-key"></i> Log Out</a></li>
                              </ul>
                          </li>
                          <!-- user login dropdown end -->
                      </ul>
                  </div>
                      </div>
                      
                  </div>
                  
                  
              </div>
          </div>
      </header>
      <!--header end-->
      <!--main content start-->
      
      <!--main content start-->      
      <section id="main-content" >
          <section class="wrapper" style="background: white; min-height: 307px;">
				<div class="pg-opt pin">
				        <div class="container">
				            <div class="row">
				                <div class="col-md-12">
				                    <h2><?php echo $this->session->userdata['telah_masuk']['hakakses']?> - 
				                    <?php echo $this->session->userdata['telah_masuk']['namagedung'] ?></h2>
				                </div>            
				            </div>
				        </div>
				</div>&nbsp;
				<?php echo $template['body'];  ?>
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <footer class="footer">
          <div class="container">
              <?php echo $template['partials']['footer']; ?>
          </div>
          
      </footer>
          </div>
      <!--footer end-->

  <!-- Placed js at the end of the document so the pages load faster -->
<?php echo $template['partials']['script_footer']; ?>
  

  </body>
</html>