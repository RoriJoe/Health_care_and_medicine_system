<section class="slice bg-3" style="background: transparent;">
    <div class="w-section inverse">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <div class="w-section inverse">                       
                        <div class="w-box sign-in-wr bg-5" style="border-radius: 25px;">

                            <div class="form-header" style="background-color: #0b86c3">
                                <img src="<?php echo base_url() ?>assets/newui/images/jember/logo-login.png" style="width: 100%">
                                <!--<h2>Please, sign in to your account</h2>-->
                            </div>
                            <div class="form-body">
                                <form method="post" role="form" class="form-light padding-15" action="<?php echo base_url(); ?>index.php/login/loginMultiAccount">
                                    <div class="pg-opt in">
                                        <center><h1>Login Sebagai</h1></center>
                                    </div>
                                    <div class="form-group">
                                        <label>Hak Akses</label>
                                        <select name="akses" class="form-control">
                                            <?php foreach ($result as $r) { ?>
                                                <option value="<?php echo $r->ID_HAKAKSES ?>"><?php if($r->NAMA_HAKAKSES == "Admin Puskesmas" || $r->NAMA_HAKAKSES == "Tata Usaha" || $r->NAMA_HAKAKSES == "Kepala Puskesmas" || $r->NAMA_HAKAKSES == "SIK") echo $r->NAMA_HAKAKSES; else echo $r->NAMA_UNIT ?> - <?php echo $r->NAMA_GEDUNG ?></option>
                                            <?php } ?>
                                        </select>
<!--<input type="text" class="form-control" name="noid" placeholder="Nomor Identitas">-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">                     
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-two pull-right">Masuk</button>                      
                                        </div>
                                    </div>
                                </form>

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