<!-- <p id="success" class="text-success"></p> -->



<table class="table" style="border:1px solid black">

<thead class="thead-light">

    <tr style="border:1px solid black">

        <th class="text-center">Image</th>

        <th class="text-center">Product Name</th>

        <th class="text-center">Product Code</th>

        <th class="text-center">Action</th>

    </tr>

    </thead>

    <tbody>

        <?php

        foreach($available_products as $products) { 

            $rs = $this->master_model->get_property_val_new($products->id);

            ?>

    <tr>

        <td class="text-center"><img src="<?php echo IMGS_URL.$products->img; ?>" alt="image" height="100"></td>



        <?php   $offer_name = '';

        foreach($offer_products as $val) { if($val->prod_id == $products->prod_id) { $offer_name = "[".$val->title."]"; } }?>

        <td class="text-center"><?= $products->name;?> <strong style="color: red;"><?= $offer_name;?></strong><br><?php if(!empty($rs)){?><strong class="text-danger"> [ <?php foreach($rs as $r){echo $r->value.",";};?> ] </strong><?php }?></td>

        <td class="text-center"><?= $products->product_code;?></td>

        <td class="text-center">

        

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#" data-target="#available_offers" onclick="available_offers(<?= $products->id;?>)">Apply Offer</a>



      

        </td>

       <input type="hidden" id="shop_id"  value="<?=$shop_id;?>">

    </tr>

    <div id="available_offers" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                                                        <div class="modal-dialog  modal-lg">

                                                            <div class="modal-content" id="available_offers_list">

                                                                

                                                                

                                                            </div>

                                                        </div>

                                                    </div> 

    <?php $flg=0; } ?>

    </tbody>

</table>

<script type="text/javascript">

   function available_offers(pid)

   {

    var shop_id=$('#shop_id').val();

    $.ajax({

        url: "<?php echo base_url('offers-coupons/available_offers'); ?>",

        method: "POST",

        data: {

            pid:pid,shop_id:shop_id

        },

        success: function(data){

            $("#available_offers_list").html(data);

        },

    });

   }

</script>

<script type="text/javascript">

   function available_offers_cat()

   {

    var parent_cat_id = $('#sub_parent_cat_id').val();

    var shop_id=$('#shop_id').val();

    $.ajax({

        url: "<?php echo base_url('offers-coupons/available_offers_cat'); ?>",

        method: "POST",

        data: {

            parent_cat_id:parent_cat_id,shop_id:shop_id

        },

        success: function(data){

            $("#available_offers_list_cat").html(data);

        },

    });

   }

   function remove_offers_cat()

   {

    if(confirm('Are you sure?') == true)

    {

    var parent_cat_id = $('#sub_parent_cat_id').val();

    var shop_id=$('#shop_id').val();

    $.ajax({

        url: "<?php echo base_url('offers-coupons/remove_on_cat'); ?>",

        method: "POST",

        data: {

            parent_cat_id:parent_cat_id,shop_id:shop_id

        },

        success: function(data){

                //$("#changeaction"+oid).html(data);

                  $.ajax({

                            url: "<?php echo base_url('offers-coupons/fetch_products'); ?>",

                            method: "POST",

                            data: {

                                parent_cat_id:parent_cat_id,

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