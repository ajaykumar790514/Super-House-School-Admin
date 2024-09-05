<div class="modal-header">
    <b>Add Offer</b>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">

<table class="table" style="border:1px solid black">
<thead class="thead-light">
    <tr style="border:1px solid black">
        <th class="text-center">Title</th>
        <th class="text-center">Value</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php $flg=0;
        foreach($offers as $offer) { if($offer->active == '1') {?>
    <tr>
        <td class="text-center"><?= $offer->title;?></td>
        <td class="text-center"><?= $offer->value; if($offer->discount_type == '1') {echo "%";} else{echo " ₹";} ?></td>
        <?php foreach($offer_list as $val) 
        {
             if($val->product_id == $prod_id && $val->offer_assosiated_id == $offer->id)
             {
                     $flg=1;   
             }
        }
        ?>
        <td class="text-center" id="changeaction<?= $offer->id ?>">
        <?php /*if($flg==1)
            {?> 
      <a class="btn btn-sm btn-success" data-dismiss="modal" href="javascript:void(0)" onclick="remove_offer(<?= $offer->id.','.$offer->value.','.$offer->discount_type;?>)">Apply</a>
        <?php } 
            else { ?>
      <a class="btn btn-sm btn-success" href="javascript:void(0)" onclick="add_offer_all_var(<?= $offer->id.','.$offer->value.','.$offer->discount_type;?>)" >Apply</a>
      <?php } */ ?>
        <a class="btn btn-sm btn-success" href="javascript:void(0)" onclick="add_offer_all_var(<?= $offer->id.','.$offer->value.','.$offer->discount_type;?>)" >Apply</a>
        </td>
       
    </tr>
    
    <?php $flg=0; } }?>
    </tbody>
</table>
<input type="hidden" value="<?php echo $prod_id; ?>" id="prod_id">
<input type="hidden" value="<?php echo $shop_id; ?>" id="shop_id">

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
</div>
        
<script type="text/javascript">
   function add_offer_all_var(oid,value,discount_type)
   {
    if(confirm('If you are applying offer on category it will replace offers existing on products.') == true)
        {
            var prod_id = $('#prod_id').val();
            var shop_id = $('#shop_id').val();
            $.ajax({
                url: "<?php echo base_url('offers-coupons/add_offer_all_var'); ?>",
                method: "POST",
                data: {
                    oid:oid,
                    prod_id:prod_id,
                    shop_id:shop_id,
                    value:value,
                    discount_type:discount_type
                },
                success: function(data){
                    if(data == 'false') 
                    {
                        alert('Offer is already exist on all varients .Kindly remove existing offer.');
                    }
                    else
                    {
                        $("#changeaction"+oid).html(data);
                           $.ajax({
                            url: "<?php echo base_url('offers-coupons/fetch_products_load'); ?>",
                            method: "POST",
                            data: {
                                prod_id:prod_id,
                                shop_id:shop_id,
                            },
                            success: function(data){
                                    $("#available_products").html(data);
                                
                            },
                        });
                    }
                    
                },
            });
        }
   }
</script>
<script type="text/javascript">

   function remove_offer_all_var(oid,value,discount_type)
   {
    if(confirm('Are you sure?') == true)
    {
        var prod_id = $('#prod_id').val();
        var shop_id = $('#shop_id').val();
        $.ajax({
            url: "<?php echo base_url('offers-coupons/remove_offer_all_var'); ?>",
            method: "POST",
            data: {
                oid:oid,
                prod_id:prod_id,
                value:value,
                discount_type:discount_type,
                shop_id:shop_id
            },
            success: function(data){
                $("#changeaction"+oid).html(data);
                  $.ajax({
                            url: "<?php echo base_url('offers-coupons/fetch_products_load'); ?>",
                            method: "POST",
                            data: {
                                prod_id:prod_id,
                                shop_id:shop_id,
                            },
                            success: function(data){
                                    $("#available_products").html(data);
                                
                            },
                        });
            },
        });
    }
   }
   

</script>












