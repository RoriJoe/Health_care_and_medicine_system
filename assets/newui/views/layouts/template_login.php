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
          <div class="wrapper lw boxed">
      <!--header start-->
<!-- Header: Logo and Main Nav -->
      <header class="header">
      </header>
      <!--header end-->
      <!--main content start-->
      <section id="main-content" >
          <section class="wrapper" >
              <?php  echo $template['body']; ?>
          </section>
      </section>
                      
      <!--main content end-->
      <!--footer start-->
<!--      <footer class="footer">
          <div class="container">
              <?php echo $template['partials']['footer']; ?>
          </div>
          
      </footer>-->
          </div>
      <!--footer end-->

  <!-- Placed js at the end of the document so the pages load faster -->
<?php echo $template['partials']['script_footer']; ?>
  

  </body>
</html>