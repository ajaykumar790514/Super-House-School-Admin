            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('coupons-offers'); ?>">Offers & Coupons</a></li>
                            <li class="breadcrumb-item active">Apply Offer</li>
                        </ol>
                    </div>
                </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- Row -->
                <div class="row">
                    <!-- Column -->
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h3 class="card-title" id="test">Apply Offer</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="apply-category" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Apply On Category</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                                <form class="needs-validation" action="<?php echo base_url('apply-category'); ?>" method="post">
                                                            <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">ABC</label>
                                                                                <input type="text" class="form-control" name="abc">
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    </div>
                                                            
                                                            </div> 
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="Apply">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <button class="float-right btn btn-primary" data-toggle="modal" data-target="#apply-category" >Apply On Category</button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                    <form class="needs-validation" action="" method="post">
    <div class="row">
    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
          
        <div class="col-3">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_category(this.value)">
            <option value="">Select</option>
            <?php foreach ($parent_cat as $parent) { ?>
            <option value="<?php echo $parent->id; ?>">
                <?php echo $parent->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
            <label class="control-label">Categories:</label>
            <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_products(this.value)">
            </select>                                                     
                    
            </div>
    
        </div>
        <div class="col-2 mt-4">
        <a data-toggle="modal" class="float-right btn btn-primary" href="#" data-target="#apply-category1" onclick="available_offers_cat()">Apply on category</a >
        </div>
        <!--Add property modal-->
        <div id="apply-category1" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content" id="available_offers_list_cat">
                                                        
                                                    </div>
                                                </div> 
                                            </div>
                                            <!--/Add property modal-->
        <div class="col-12" id="available_products">
            
        </div>
    </div>
</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <script type="text/javascript">
function fetch_category(parent_id)
{
$.ajax({
    url: "<?php echo base_url('coupons-offers/fetch_category'); ?>",
    method: "POST",
    data: {
        parent_id:parent_id
    },
    success: function(data){
        $(".parent_cat_id").html(data);
    },
});
}
</script>
<script type="text/javascript">
function fetch_products(parent_cat_id)
{
    $("#available_products").html('<div class="text-center"><img src="loader.gif"></div>');
$.ajax({
    url: "<?php echo base_url('coupons-offers/fetch_products'); ?>",
    method: "POST",
    data: {
        parent_cat_id:parent_cat_id
    },
    success: function(data){
        $("#available_products").html(data);
    },
});
}
</script>

