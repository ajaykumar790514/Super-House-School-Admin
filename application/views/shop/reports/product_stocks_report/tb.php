<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
#reset-data
{
    background-color:red;
}
h4
{
    color:blue;
}
</style>
<div class="row">
    <div class="col-md-6 text-left">
        <!-- <span>Showing <?//=$page+1?> to <?//=$page+count($stock_report)?> of <?//=$total_rows?> entries</span> -->
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <?//=$links?>
        </div>
    </div>
</div>

<div class="row">
<div class="col-3">
            <div class="form-group">
                <label class="control-label">Parent Categories:</label>
                <?php 
                // print_r($parent_cat); die; 
                ?>
                <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
                <option value="">Select</option>
                <?php foreach ($parent_cat as $parent) { ?>
                <option value="<?php echo $parent->id; ?>" <?php if(!empty($parent_id)) { if($parent_id==$parent->id) {echo "selected"; } }?>>
                    <?php echo $parent->name; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Sub Categories:</label>
                
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" value="<?=$cat_id?>" onchange="fetch_products(this.value)">
                    <option value="">Select</option>
                    <?php if($cat_id!=='null') { ?>
                        <?php foreach ($sub_cat as $scat) { ?>
                        <option value="<?php echo $scat->id; ?>" <?php if(!empty($cat_id)) { if($cat_id==$scat->id) {echo "selected"; } }?>>
                            <?php echo $scat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Categories:</label>
                
                <select class="form-control child_cat_id" style="width:100%;" name="cat_id" id="cat_id" value="<?=$cat_id?>" onchange="fetch_products_by_cat(this.value)">
                    <option value="">Select</option>
                    <?php if($child_cat_id!=='null') { ?>
                        <?php foreach ($child_cat as $ccat) { ?>
                        <option value="<?php echo $ccat->id; ?>" <?php if(!empty($child_cat_id)) { if($child_cat_id==$ccat->id) {echo "selected"; } }?>>
                            <?php echo $ccat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
              
        <div class="col-md-3">
            <div class="form-group" >
                <label class="control-label">Search</label>
                <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search...">
            </div>
        </div>
        <div class="col-2 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-md-3">
        <a href="<?= base_url('reports/product_stock_report/export_to_excel/'.$cat_id.'/'.$search); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
    </div>
    <div class="col-md-3 mt-1">
        <h4>Total Value = ₹ <?=@round($stock_result->total_purchase,2); ?></h4>
    </div>
    <div class="col-md-3 mt-1">
        <h4>Total Stock = ₹ <?=@round($stock_result->total_stock,2); ?></h4>
    </div>
</div>
<div id="datatable">
    <div id="grid_table" class="table-responsive">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Purchase Rate</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Sale Price</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                    <th class="jsgrid-header-cell jsgrid-align-center">Invoice No</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Pack Size</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Stock</th>
            </tr>
            
            <?php  $i=$page; foreach($stock_report as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><b> <?php 
                    foreach ($cat_pro_map as $cat) {
                        if($cat->pro_id == $value->prod_id){
                            echo '('.$cat->name.') ';
                        } 
                        
                    };?></b></td>
                <td class="jsgrid-cell jsgrid-align-center"><b><?php echo $value->prod_name;?></b></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?php echo $value->purchase_rate;?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?php echo $value->selling_rate;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->product_code;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->invoice_no;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->unit_value.' '.$value->unit_type;?></td>
                <th class="jsgrid-cell jsgrid-align-center"><?php echo $value->qty;?></th>
                
            </tr> 
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($stock_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script type="text/javascript">
      function fetch_sub_categories(parent_id)
   {
    $.ajax({
        url: "<?php echo base_url('reports/fetch_sub_categories'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id //cat1 id
        },
        success: function(data){
            $(".parent_cat_id").html(data);

            var cat_id = $('#parent_cat_id').val(); //cat2 id
            if(parent_id)
            {
                $.ajax({
                    url: "<?php  echo base_url('product-stock-report/tb'); ?>",
                    method: "POST",
                    data: {
                        cat_id:cat_id,
                        parent_id:parent_id,
                    },
                    success: function(data){
                    $("#tb").html(data);
                    },
                });
            }
        },
    });
   };
   function fetch_products(cat_id) 
   {
    var parent_id = $('#parent_id').val();
    var search = $('#tb-search').val();
        $.ajax({
            url: "<?php echo base_url('product-stock-report/tb'); ?>",
            method: "POST",
            data: {
                cat_id:cat_id,  //cat2 id
                parent_id:parent_id,    //cat1 id
                search:search,
            },
            success: function(data){
                // console.log(data);
                $("#tb").html(data);
                //ajax method for loading child categories
                var parent_cat_id = $('#parent_cat_id').val();
                    $.ajax({
                        url: "<?php echo base_url('reports/fetch_cat'); ?>",
                        method: "POST",
                        data: {
                            parent_cat_id:parent_cat_id
                        },
                        success: function(data){
                            $(".child_cat_id").html(data);
                        },
                    });
            },
        });
        
   }
   function fetch_products_by_cat(child_cat_id)
   {
    var parent_id = $('#parent_id').val();
    var search = $('#tb-search').val();
    var parent_cat_id = $('#parent_cat_id').val();
        $.ajax({
            url: "<?php echo base_url('product-stock-report/tb'); ?>",
            method: "POST",
            data: {
                child_cat_id:child_cat_id,
                parent_id:parent_id,
                search:search,
                cat_id:parent_cat_id,
            },
            success: function(data){
                $("#tb").html(data);
               
            },
        });
    }
//    }
//    function fetch_category(parent_id)
//    {
//     $.ajax({
//         url: "<?php echo base_url('reports/fetch_category'); ?>",
//         method: "POST",
//         data: {
//             parent_id:parent_id
//         },
//         success: function(data){
//             $(".parent_cat_id").html(data);
//         },
//     });
//    }
// </script>
 <script type="text/javascript">
//    function fetch_data(cat_id)
//    {
//     $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
//     var parent_id = $('#parent_id').val();
//     var search = $('#tb-search').val();

//     $.ajax({
//         url: "<?php echo base_url('reports/product_stock_report/tb'); ?>",
//         method: "POST",
//         data: {
//             cat_id:cat_id,
//             parent_id:parent_id,
//             search:search
//         },
//         success: function(data){
//             $("#tb").html(data);
//         },
//     });
//    }
</script>
<script>
           $('#reset-data').click(function(){
                location.reload();
            })
    </script>

