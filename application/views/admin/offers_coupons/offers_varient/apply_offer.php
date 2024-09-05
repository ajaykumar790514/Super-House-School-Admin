            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
            <div class="container-fluid" style="max-width: 100% !important;">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('offers-coupons/'.$menu_id); ?>">Offers & Coupons</a></li>
                            <li class="breadcrumb-item active">Apply Offer All Varient</li>
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
                                                <h3 class="card-title" id="test">Apply Offer All Varient</h3>
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
                                    <!-- <form class="needs-validation" action="" method="post"> -->
    <div class="row">
    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-2">
            <div class="form-group">
                <label class="control-label">Business:</label>
                <select class="form-control" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
                <option value="">Select Business</option>
                <?php foreach ($business as $busi) { ?>
                <option value="<?php echo $busi->id; ?>">
                    <?php echo $busi->title; ?>(<?php echo $busi->owner_name; ?>)
                </option>
                <?php } ?>
                </select>
            </div>
        
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Shop:</label>
                <select class="form-control shop_id" onchange="fetch_offer_tab(this.value)" style="width:100%;" name="offer_created_by" id="shop_id">
                
                </select>
            </div>
        </div>
        <div class="col-8">
       <div class="row d-none apllyofferstab">
        <div class="col-6">
                <label class="control-label">Search:</label>
                <input type="search" class="form-control" id="prod-search" placeholder="Search" aria-controls="DataTables_Table_0" >
            </div>
            <div class="col-3">
            <a data-toggle="modal" class="float-right btn btn-primary" style="margin-top: 33px;margin-left:-2rem" href="#" data-target="#apply-category1" onclick="available_offers_all_var()">Apply on All Varients</a >
            </div>
            <div class="col-3">
            <a class="float-right btn btn-primary text-white" style="margin-top: 33px;margin-left:-2rem"  onclick="remove_all_var()">Remove All Varients</a >
            </div>
        </div>
        </div>
        <!--Add property modal-->
        <div id="apply-category1" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content" id="available_offers_list_cat">
                                                        
                                                    </div>
                                                </div> 
                                            </div>
                                            <!--/Add property modal-->
        <div class="col-12 mt-3" id="available_products">
            
        </div>
    </div>
<!-- </form> -->
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
    
<script type="text/javascript">
function fetch_shop(business_id)
{
$.ajax({
    url: "<?php echo base_url('offers-coupons/fetch_shop'); ?>",
    method: "POST",
    data: {
        business_id:business_id
    },
    success: function(data){
        $(".shop_id").html(data);
    },
});
}

function fetch_offer_tab(shop_id)
{
    if(shop_id !='')
    {
      $('.apllyofferstab').removeClass('d-none');
    }
}
</script>
<script>
$(document).on('keyup', '#prod-search', function(event){
    if(event.keyCode == 13)
    {
        $("#available_products").html('<div class="text-center"><img src="loader.gif"></div>');
        var psearch  = $('#prod-search').val();
        $.ajax({
                url: "<?php echo base_url('offers-coupons/fetch_products_search'); ?>",
                method: "POST",
                data: {
                    psearch:psearch,
                },
                success: function(data){
                        $("#available_products").html(data);
                },
            });
        return false;
    }
})
</script>