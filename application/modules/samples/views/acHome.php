<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <strong>Menu Utama - Kepala Puskesmas</strong>
                    </header>
                    <div class="panel-body">

                        <ul id="filters" class="media-filter">
                            <li><a href="#" data-filter="*"> Semua</a></li>
                            <li><a href="#" data-filter=".images">Laporan Obat</a></li>
                            <li><a href="#" data-filter=".audio">Stok Obat</a></li>
                            <li><a href="#" data-filter=".video">Distribusi Obat</a></li>
                            <li><a href="#" data-filter=".documents">Dashboard</a></li>
                        </ul>
                        <div id="gallery" class="media-gal">
                            <div class="images item " >
                                <a href="#myModal" data-toggle="modal">
                                <img src="<?php echo base_url(); ?>assets/uistuff/images/gallery/image1.jpg" alt="" />
                                    </a>
                                <strong><p>LPLPO</p></strong>
                            </div>

                            <div class="images item " >
                                <a href="#myModal" data-toggle="modal">
                                <img src="<?php echo base_url(); ?>assets/uistuff/images/gallery/image2.jpg" alt="" />
                                    </a>
                                <strong><p>Laporan Pemakaian</p></strong>
                            </div>

                            <div class=" video item " >
                                <a href="#myModal" data-toggle="modal">
                                <img src="<?php echo base_url(); ?>assets/uistuff/images/gallery/image3.jpg" alt="" />
                                    </a>
                                <strong><p>Poli Umum</p></strong>
                            </div>

                            <div class=" audio audio item " >
                                <a href="#myModal" data-toggle="modal">
                                <img src="<?php echo base_url(); ?>assets/uistuff/images/gallery/image4.jpg" alt="" />
                                    </a>
                                <strong><p>Stok Gudang</p></strong>
                            </div>

                            <div class=" documents documents item " >
                                <a href="#myModal" data-toggle="modal">
                                <img src="<?php echo base_url(); ?>assets/uistuff/images/gallery/image5.jpg" alt="" />
                                    </a>
                                <strong><p>Dashboard</p></strong>
                            </div>

                        </div>

                        <div class="col-md-12 text-center clearfix">
                            <ul class="pagination">
                                <li><a href="#">«</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Sub Menu</h4>
                                    </div>

                                    <div class="modal-body row">

                                        <div class="col-md-5 img-modal">
                                            <img src="<?php echo base_url(); ?>assets/uistuff/images/gallery/image1.jpg" alt="">
<!--                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit Image</a>
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> View Full Size</a>

                                            <p class="mtop10"><strong>File Name:</strong> contoh.jpg</p>
                                            <p><strong>File Type:</strong> jpg</p>
                                            <p><strong>Resolution:</strong> 300x200</p>
                                            <p><strong>Uploaded By:</strong> <a href="#">aa</a></p>-->
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-warning btn-block">Laporan Pemakaian Obat</button>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success btn-block">Laporan Peneriamaan Obat</button>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-danger btn-block">Laporan Obat Per Unit</button>
                                            </div>
<!--                                            <div class="pull-right">
                                                <button class="btn btn-danger" type="button">Delete</button>
                                                <button class="btn btn-primary" type="button">Save changes</button>
                                            </div>-->
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- modal -->

                    </div>
                </section>
            </div>
        </div>