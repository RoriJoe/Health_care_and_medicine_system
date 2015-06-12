<section class="slice bg-3" style="background: transparent;">
    <div class="w-section inverse">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <div class="w-section inverse">                       
                        <div class="w-box sign-in-wr bg-5" style="border-radius: 25px; box-shadow: 0px 0px 50px #000000">

                            <div class="form-header" style="background-color: #0b86c3">
                                <img src="<?php echo base_url() ?>assets/newui/images/jember/logo-login.png" style="width: 100%">
                                <!--<h2>Please, sign in to your account</h2>-->
                            </div>
                            <div class="form-body">
                                <div class="pg-opt in">
                                    <center><h1 >SISTEM DALAM PERBAIKAN</h1></center>
                                </div>
                            </div>
                            <div class="form-footer">
                                <?php if (!empty($error)) { ?>
                                    <div class="alert alert-danger fade in">
                                        <?php echo $error; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>