<style>

   #spinner-div {

  position: fixed;

  display: none;

  width: 100%;

  height: 100%;

  top: 0;

  left: 0;

  text-align: center;

  background-color: rgba(255, 255, 255, 0.8);

  z-index: 2;

}

   

</style>

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

            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data/'.$menu_id); ?>">Master Data</a></li>

            <li class="breadcrumb-item active">Product Inventory</li>

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

    <div class="col-lg-12 col-md-12">

        <div class="card">

            <div class="card-body">

                <div class="row">

                    <div class="col-12">

                        <div class="d-flex flex-wrap">

                            <div class="float-left col-md-6 col-lg-6 col-sm-6">

                                <h3 class="card-title" id="test">Product Inventory Data</h3>

                                <h6 class="card-subtitle"></h6>

                            </div>

                        </div>

                    </div>



                    <div class="col-12">

                    

                        <div class="row">

                        <div id="spinner-div" class="pt-5">

                      <div class="spinner-border text-primary" role="status">

                       </div>

                      </div>

                      <div class="col-4"></div> 

                            <div class="col-2  bg-info">

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

                            <div class="col-2  bg-info">

                                <div class="form-group">

                                    <label class="control-label">Shop:</label>

                                    <select class="form-control shop_id" style="width:100%;" name="offer_created_by" id="shop_id">

                                    

                                    </select>

                                </div>

                            </div>

                           </div>

                            <div class="row">

                                <div class="col-4"></div>

                            <div class="col-4  bg-info">

                                <div class="form-group">

                                    <label class="control-label">Search Product Code / Name:</label>

                                   <input type="text" oninput="showAlert()" name="search" id="search" class="form-control search" placeholder="Search......."  style="height:50px;">

                                </div>

                            </div>

                            </div>

                            <div class="row">

                            <div class="col-4"></div>

                             <div class="col-4  bg-info">

                                <div class="form-group"><label></label>

                                   <input type="button" class="btn btn-primary mb-4  float-right" onclick="fetchProduct()" value="Filter" style="margin-top: 4  px;height:40px;width:80px;font-size:1.3rem">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 mt-5 detail_div" id="detail-div" style="display: none;">

                        <div class="row">

                           <div class="col-12 pt-2"><h4 class="text-center text-primary">Product Details</h4></div> 

                            <table class="table table-bordered">

                             <tr>

                                <td>Product Image:</td>

                                <td><label class="product_img"></label></td>

                                <td>Product Name:</td>

                                <td><label class="product_name"></label> <span class="text-danger flavour"></span> <span class="product_value"></span> </td>

                             </tr>

                             <tr>

                                <td>Product Code:</td>

                                <td><label class="product_code"></label></td>

                                <td> Search Keywords:</td>

                                <td><label class="product_keyword"></label></td>

                             </tr>

                             <tr>

                                <td colspan='4'><h4 class="text-center text-primary">Current Quantity</h4></td>

                             </tr>

                             <tr>

                                <td>Product Qty:</td>

                                <td><label class="qty"></label></td>

                                <td>Selling Rate:</td>

                                <td><label class="selling_rate"></label></td>

                                <!-- <td>MRP:</td>

                                <td><label class="mrp"></label></td> -->

                             </tr>

                             <tr>

                                <td> Purchase Rate:</td>

                                <td><label class="purchase_rate"></label>

                                <input type="button" id="sub_inventory" style="float:right" class="btn btn-sm btn-danger ml-2" value="Subtract Inventory">

                                <input type="button" id="add_inventory" style="float:right" class="btn btn-sm btn-primary" value="Add More Inventory">

                               

                            </td>

                                

                             </tr>

                            </table>

                        </div>

                    </div>

                    <div class="col-12 mt-5" id="add_inventory_form" style="display: none;">

                    <h4 class="text-primary">Add Inventory</h4>

                    <form class="ajaxsubmit needs-validation  redirect-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>

                        <div class="row">

                           

                        <div class="col-6">

                        <div class="form-group">

                            <input type="hidden" name="product_id" class="product_id">

                            <input type="hidden" name="inventory_id" class="inventory_id">

                            <input type="hidden" name="shopid" class="shp_id">

                            <input type="hidden" name="exist_qty" id="exist_qty" class="exist_qty">

                            <label for="recipient-name" class="control-label">Stock Quantity ( Existing Quantity :- <span class="text-danger" id="qty"></span>  ):</label>

                            <input type="number" id="s_qty" class="form-control" name="s_qty" min="0" placeholder="enter add more inventory"   required>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">

                            <label for="recipient-name" class="control-label">Purchase Rate:</label>

                            <input type="text" onkeypress="return isNumberKey(this, event);" class="form-control" name="purchase_rate" step="0.01" min="0.00" id="purchase_rate" >

                        </div>

                    </div>

                

                    <div class="col-6">

                        <div class="form-group">

                            <label for="recipient-name" class="control-label">Selling Rate :</label>

                            <input type="text" onkeypress="return isNumberKey(this, event);" class="form-control" name="selling_rate"  id="selling_rate"  >

                        </div>

                    </div>

                    <div class="col-2">

                    <div class="form-group"></div>

                    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>

                    </div>

                        </div>

                    </form>

                    </div>   

                    <div class="col-12 mt-5" id="sub_inventory_form" style="display: none;">

                    <h4 class="text-primary">Subtract Inventory</h4>

                    <form class="ajaxsubmit needs-validation  redirect-page" action="<?=$sub_action_url?>" method="post" enctype= multipart/form-data>

                        <div class="row">

                           

                        <div class="col-6">

                        <div class="form-group">

                            <input type="hidden" name="product_id" class="subproduct_id">

                            <input type="hidden" name="inventory_id" class="subinventory_id">

                            <input type="hidden" name="shopid" class="subshp_id">

                            <input type="hidden" name="exist_qty" id="subexist_qty" class="exist_qty">

                            <label for="recipient-name" class="control-label">Stock Quantity ( Existing Quantity :- <span class="text-danger subqty" id="subqty"></span>  ):</label>

                            <input type="number" id="s_qty" class="form-control" name="s_qty" min="0" placeholder="enter subtract inventory"   required>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">

                            <label for="recipient-name" class="control-label">Purchase Rate:</label>

                            <input type="text" onkeypress="return isNumberKey(this, event);" class="form-control" name="purchase_rate" step="0.01" min="0.00" id="subpurchase_rate" >

                        </div>

                    </div>

                

                    <div class="col-6">

                        <div class="form-group">

                            <label for="recipient-name" class="control-label">Selling Rate :</label>

                            <input type="text" onkeypress="return isNumberKey(this, event);" class="form-control" name="selling_rate"  id="subselling_rate"  >

                        </div>

                    </div>

                    <div class="col-2">

                    <div class="form-group"></div>

                    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Subtract</button>

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

<!-- ============================================================== -->

<!-- End PAge Content -->

<!-- ============================================================== -->

<script type="text/javascript">

    function isNumberKey(txt, evt) {

      var charCode = (evt.which) ? evt.which : evt.keyCode;

      if (charCode == 46) {

        //Check if the text already contains the . character

        if (txt.value.indexOf('.') === -1) {

          return true;

        } else {

          return false;

        }

      } else {

        if (charCode > 31 &&

          (charCode < 48 || charCode > 57))

          return false;

      }

      return true;

    }

  </script>

<script type="text/javascript">

    

     $(document).ready(function(){

        $("#add_inventory").click(function(){

          $("#add_inventory_form").show();

          $("#sub_inventory_form").hide();

        });

        $("#sub_inventory").click(function(){

          $("#add_inventory_form").hide();

          $("#sub_inventory_form").show();

        });

        

      });

function showAlert() {

        var inputValue = document.getElementById('search').value;

        if(document.getElementById('business_id').selectedIndex == 0)

{

    alert('Please Select Business');

    document.getElementById('business_id').focus();

    return false;

}

if(document.getElementById('shop_id').selectedIndex == 0)

{

    alert('Please Select Shop');

    document.getElementById('shop_id').focus();

    return false;

}

$('#spinner-div').show();

  //var search = $('.search').val();

  var shop_id = $('#shop_id').val();

  $.ajax({

            url: '<?= base_url('in-inventory/getProductDetails') ?>',

            type: 'POST',

            data: {search: inputValue,shop_id:shop_id},

            dataType: 'json',

            success: function(data) {

                $('#spinner-div').hide();

                // Update the result div with the retrieved data
                $("#detail-div").hide();
                if(data.error=='true'){ $("#detail-div").hide();   }else{

                $("#detail-div").show();    

                $('.product_name').html('<h6><b>'+data.data.name+'</b></h6>');
                if(data.data.thumbnail){
                $('.product_img').html('<img src="<?php echo IMGS_URL ;?>' + data.data.thumbnail + '" style="width:100px;height:70px" >');
                }else{
                    $('.product_img').html('<img src="<?php echo base_url() ;?>photo/noimg/No_books.png" style="width:100px;height:70px" >'); 
                }

                $('.product_code').html('<h6><b>'+data.data.product_code+'</b></h6>');

                $('.product_keyword').html('<h6><b>'+data.data.search_keywords+'</b></h6>');

                $('.qty').html('<h6><b>'+data.data.qty+'</b></h6>');

                $('.mrp').html('<h6><b>'+data.data.mrp+'</b></h6>');

                $('.purchase_rate').html('<h6><b>'+data.data.purchase_rate+'</b></h6>');

                $('.selling_rate').html('<h6><b>'+data.data.selling_rate+'</b></h6>');

                $('.inventory_id').val(data.data.inventory_id);

                $('.product_id').val(data.data.id);

                $('#qty').text(data.data.qty);

                $('#exist_qty').val(data.data.qty);

                $('#purchase_rate').val(data.data.purchase_rate);

                $('#selling_rate').val(data.data.selling_rate);

                $('#mrp').val(data.data.mrp);

                $('.shp_id').val(data.data.shop_id);

                // sub



                $('.subinventory_id').val(data.data.inventory_id);

                $('.subproduct_id').val(data.data.id);

                $('#subqty').text(data.data.qty);

                $('#subexist_qty').val(data.data.qty);

                $('#subpurchase_rate').val(data.data.purchase_rate);

                $('#subselling_rate').val(data.data.selling_rate);

                $('#submrp').val(data.data.mrp);

                $('.subshp_id').val(data.data.shop_id);



             

                getProductValue(data.data.id);

                }

              

            },

            error: function(error) {

                console.error('There was a problem with the AJAX request:', error);

            }

        });



    }

function fetchProduct()

{

if(document.getElementById('business_id').selectedIndex == 0)

{

    alert('Please Select Business');

    document.getElementById('business_id').focus();

    return false;

}

if(document.getElementById('shop_id').selectedIndex == 0)

{

    alert('Please Select Shop');

    document.getElementById('shop_id').focus();

    return false;

}

$('#spinner-div').show();

  var search = $('.search').val();

  var shop_id = $('#shop_id').val();

  $.ajax({

            url: '<?= base_url('in-inventory/getProductDetails') ?>',

            type: 'POST',

            data: {search: search,shop_id:shop_id},

            dataType: 'json',

            success: function(data) {

                $('#spinner-div').hide();

                // Update the result div with the retrieved data

                if(data.error=='true'){  }else{

                $("#detail-div").show();    

                $('.product_name').html('<h6><b>'+data.data.name+'</b></h6>');

                if(data.data.thumbnail){
                $('.product_img').html('<img src="<?php echo IMGS_URL ;?>' + data.data.thumbnail + '" style="width:100px;height:70px" >');
                }else{
                    $('.product_img').html('<img src="<?php echo base_url() ;?>photo/noimg/No_books.png" style="width:100px;height:70px" >'); 
                }

                $('.product_code').html('<h6><b>'+data.data.product_code+'</b></h6>');

                $('.product_keyword').html('<h6><b>'+data.data.search_keywords+'</b></h6>');

                $('.qty').html('<h6><b>'+data.data.qty+'</b></h6>');

                $('.mrp').html('<h6><b>'+data.data.mrp+'</b></h6>');

                $('.purchase_rate').html('<h6><b>'+data.data.purchase_rate+'</b></h6>');

                $('.selling_rate').html('<h6><b>'+data.data.selling_rate+'</b></h6>');

                $('.inventory_id').val(data.data.inventory_id);

                $('.product_id').val(data.data.id);

                $('#qty').text(data.data.qty);

                $('#exist_qty').val(data.data.qty);

                $('#purchase_rate').val(data.data.purchase_rate);

                $('#selling_rate').val(data.data.selling_rate);

                $('#mrp').val(data.data.mrp);

                $('.shp_id').val(data.data.shop_id);

                // sub



                $('.subinventory_id').val(data.data.inventory_id);

                $('.subproduct_id').val(data.data.id);

                $('#subqty').text(data.data.qty);

                $('#subexist_qty').val(data.data.qty);

                $('#subpurchase_rate').val(data.data.purchase_rate);

                $('#subselling_rate').val(data.data.selling_rate);

                $('#submrp').val(data.data.mrp);

                $('.subshp_id').val(data.data.shop_id);




                getProductValue(data.data.id);

                }

              

            },

            error: function(error) {

                console.error('There was a problem with the AJAX request:', error);

            }

        });

}

function getProductValue(id)

{

    $.ajax({

            url: '<?= base_url('in-inventory/getProductValue') ?>',

            type: 'POST',

            data: {pro_id: id},

            dataType: 'json',

            success: function(data) {

                // Update the result div with the retrieved data

                if(data.error=='true'){  }else{

                $('.product_value').html('<h6 class="text-danger">( <b>'+data.data.value+'</b>)  </h6>');

                }

            },

            error: function(error) {

                console.error('There was a problem with the AJAX request:', error);

            }

        });

}



$(document).on("submit", '.ajaxsubmit', function(event) {

    //alert("Hello");

    var element = document.getElementById("loader");

        element.className = 'fa fa-spinner fa-spin';

        $("#btnsubmit").prop('disabled', true);

    event.preventDefault(); 

    $this = $(this);



    if ($this.hasClass("needs-validation")) {

        if (!$this.valid()) {

            return false;

        }

    }

    

    

    $.ajax({

      url: $this.attr("action"),

      type: $this.attr("method"),

      data:  new FormData(this),

      cache: false,

      contentType: false,

      processData: false,

      success: function(data){

        console.log(data);

        // return false;



        data = JSON.parse(data);

        

        if (data.res=='success') {

            var element = document.getElementById("loader");

                element.classList.remove("fa-spinner");

                $("#btnsubmit").prop('disabled', false);

                //fetchProduct();

                $(".detail_div").hide();

                $("#add_inventory_form").hide();

                $("#sub_inventory_form").hide();

                var search = document.getElementById('search');

                search.value = '';

                var s_qty = document.getElementById('s_qty');

                s_qty.value = '';

                search.focus();

        }

        alert(data.msg);

        // alert_toastr(data.res,data.msg);

      }

    })

    return false;

})

</script>

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

</script>