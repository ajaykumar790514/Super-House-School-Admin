<style>

    .modal-dialog

    {

        max-width: 80%;

    margin-left: 10%;

    margin-right: 10%;

    }

    .modal-body {

    overflow-x: scroll;

    }

</style>


        <!-- <form class="form ajaxsubmit needs-validation reload-tb" method="POST" novalidate> -->

    <div class="form-body">

        <div class="row">

            <div class="col-3">

            <div class="form-group">

                <label class="control-label">Parent Categories:</label>

                <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_category(this.value)">

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
                    <label class="control-label">Sub Categories:</label>
                    <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_bundle_products(this.value)">
                    </select>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label class="control-label">Categories:</label>
                    <select class="form-control cat_id" style="width:100%;" name="cat_id" id="cat_id" onchange="fetch_bundle_products_by_cat(this.value)">
                    </select>
                </div>
            </div>
            <div class="col-3">
                <label class="control-label">Search:</label>
                <input type="search" class="form-control" id="prod-search" placeholder="Search" aria-controls="DataTables_Table_0" >
            </div>

           <input type="hidden" value="<?= $product_id;?>" id="product_id">

            <div class="col-12" id="available_products_bundle">

            <?php if(!empty($products)) { ?>    

            <table class="table table-striped table-bordered base-style" style="border:1px solid black">

                <thead>

                    <tr style="border:1px solid black">

                        <th class="text-center">Product Image</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Product Code</th>
                        <th class="text-center">Price Per Product</th>
                        <th class="text-center">Product Quantity</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Action</th>

                    </tr>

                </thead>

                <tbody>
                <?php $TQty=$Ttotal=0;foreach($products as $product){?>
                    <tr>

                        <td class="text-center">
                            <img src="<?php echo displayPhoto($product->img); ?>" alt="cover" height="50">
                        </td>
                        <td class="text-center"><?= $product->product_name;?>
                             <p class="text-center">( <?=$product->search_keywords;?> )</p>
                        </td>

                        <td class="text-center"><?= $product->product_code;?></td>
                        <td class="text-center"><?= $product->purchase_rate/$product->qty;?></td>
                        <td class="text-center"><?= $product->qty;?></td>
                        <td class="text-center"><?= $product->price;?></td>
                        <td class="text-center">
                        <a href="javascript:void(0)" onclick="delete_map_product(<?= $product->pid ?>);" title="Delete" warning-msg="Do you really want to delete this Product?" ><i class="fa fa-trash"></i></a>

                        </td>

                    </tr>

                    <?php 
                      $Ttotal = $Ttotal+$product->price;
                      $TQty = $TQty+$product->qty;
                      } ?>
                      <tr>
                        <td colspan="4"></td>
                        <td align="center"><?=$TQty;?></td>
                        <td align="center">Rs.<?=$Ttotal;?></td>
                        <td></td>
                      </tr>

                </tbody>

</table>



<?php } else { ?> 

                        <h4 class="text-center">No Record Found</h4>

                    <?php } ?>







            </div>

        </div>

        

    </div>



    <div class="form-actions text-right">

        <button type="reset" class="btn btn-danger btn-sm mr-1" data-dismiss="modal">

            <i class="ft-x"></i> Cancel

        </button>


    </div>

<!-- </form> -->





<script type="text/javascript">

   function fetch_category(parent_id)
   {
    var product_id = $('#product_id').val();
    var psearch  = $('#prod-search').val();
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_category'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id
        },
        success: function(data){
            $(".parent_cat_id").html(data);

            $.ajax({
                url: "<?php echo base_url('master-data/products/fetch_bundle_products'); ?>",
                method: "POST",
                data: {
                    parent_id:parent_id,
                    product_id:product_id,
                    psearch:psearch
                },
                success: function(data){
                    $("#available_products_bundle").html(data);
                },
            });
        },
    });
   }

</script>

<script type="text/javascript">

   function fetch_bundle_products(parent_cat_id)
   {
    var product_id = $('#product_id').val();
    var psearch  = $('#prod-search').val();

    $.ajax({
        url: "<?php echo base_url('master-data/products/fetch_bundle_products'); ?>",
        method: "POST",
        data: {
            parent_cat_id:parent_cat_id,
            product_id:product_id,
            psearch:psearch
        },
        success: function(data){
            $("#available_products_bundle").html(data);
            //var parent_cat_id = $('#parent_cat_id').val();
                $.ajax({
                    url: "<?php echo base_url('master-data/fetch_cat'); ?>",
                    method: "POST",
                    data: {
                        parent_cat_id:parent_cat_id
                    },
                    success: function(data){
                        // console.log(parent_cat_id);
                        $(".cat_id").html(data);
                    },
                });
        },
    });
   }

 function fetch_bundle_products_by_cat(cat_id)
   {
    var product_id = $('#product_id').val();
    var search = $('#tb-search').val();
        $.ajax({
            url: "<?php echo base_url('master-data/products/fetch_bundle_products'); ?>",
            method: "POST",
            data: {
                search:search,
                cat_id:cat_id,
                product_id:product_id,
            },
            success: function(data){
                $("#available_products_bundle").html(data);
               
            },
        });
        
   }
  

</script>
<script type="text/javascript">

function delete_map_product(pid)

{

 if(confirm('Do you want to remove this?') == true)

 {
    var product_id = $('#product_id').val();
     $.ajax({

         url: "<?php echo base_url('master-data/products/delete_map_product'); ?>",

         method: "POST",

         data: {

            pid:pid,
            product_id:product_id,
         },

         success: function(data){
             toastr.success('Product Unmapped Successfully..');
             $("#showModal .modal-body").html(data);

         },

     });

 }

}

</script>
<script>
$(document).on('keyup', '#prod-search', function(event){
   
    if(event.keyCode == 13)
    {
        $("#available_products_bundle").html('<div class="text-center"><img src="loader.gif"></div>');
        var psearch  = $('#prod-search').val();
        var product_id = $('#product_id').val();
        $.ajax({
                url: "<?php echo base_url('master-data/products/fetch_bundle_products'); ?>",
                method: "POST",
                data: {
                    psearch:psearch,
                    product_id:product_id,
                },
                success: function(data){
                        $("#available_products_bundle").html(data);
                },
            });
        return false;
    }
})
</script>
