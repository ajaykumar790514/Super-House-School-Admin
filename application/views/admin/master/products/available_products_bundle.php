<style>



    input[type=number]:focus {



     border: 3px solid #555;



     color:red;



    }



    input[type=number] {



        /* width: 100%; */



        padding: 10px 0px;



        /* margin: 8px 0; */



        box-sizing: border-box;



        border: 2px solid #555;



        font-size : 17px;



        text-align : center;



    }



</style>

<input type="hidden" value=<?php echo $product_id; ?> id="product_id">



<table class="table table-striped table-bordered base-style" style="border:1px solid black">

<thead>



    <tr style="border:1px solid black">



        <th class="text-center">Image</th>



        <th class="text-center">Product Name</th>



        <th class="text-center">Product Code</th>

        <th class="text-center">Price Per Product</th>

        <th class="text-center">Product Quantity</th>

        <th class="text-center">Total</th>

        <th class="text-center">Action</th>



    </tr>



    </thead>



    <tbody>



        <?php



        $flg=0;



        



        $Ttotal=$TQty=0;  foreach($available_products as $products) {?>



    <tr>



        <td class="text-center"><img src="<?php echo displayPhoto($products->thumbnail); ?>" alt="image" height="100"></td>



        <td class="text-center"><?= $products->name.'('.$products->unit_value.' '.$products->unit_type.')';?></td>



        <td class="text-center"><?= $products->product_code;?></td>





        <?php foreach($product_mapping as $mapping) 



        {



             if($mapping->bundle_id == $products->id || $mapping->pro_id == $products->id)



             {



                     $flg=1;  

                     $Ttotal = $Ttotal+$mapping->amount;

                     $TQty = $TQty+$mapping->qty; 

                   

             }



        }



        ?>

         <?php if($flg==1)



{ ?>

   <td class="text-center"><?=$mapping->purchase_rate;?></td>

  <td class="text-center"><?=$mapping->qty;?></td>

  <td class="text-center"><?=$mapping->price;?></td>

<?php }else{?>

    <td class="text-center"></td>

    <td class="text-center"></td>

  <td class="text-center"></td>

    <?php }?>

       <td id="changeaction23<?= $products->id ?>">

        <?php if($products->id ==$product_id){}else{?>

        

        <?php if($flg==1)



            { ?> 

            <button type="button" class="btn btn-sm btn-danger" onclick="remove_map_product(<?= $products->id ?>);" id="pcheckbox<?= $products->id ?>" >UnMap</button>

            <label for="pcheckbox<?= $products->id ?>"></label>



        <?php }  



            else { ?>

            <button type="button" class="btn btn-sm btn-success mapsubmit" onclick="map_product(<?= $products->id ?>);" id="box<?= $products->id ?>">Map</button>

            <label for="box<?= $products->id ?>"></label>

            <?php } }?>



        </td>



       



    </tr>



    <?php $flg=0; }?>

                      <tr>

                        <td colspan="4"></td>

                        <td align="center"><?=@$TQty;?></td>

                        <td align="center">Rs.<?=@$Ttotal;?></td>

                        <td></td>

                      </tr>



    </tbody>



</table>

<style>

    .your-custom-class {

    z-index: 9999; /* Adjust this value as needed */

}



</style>

<!-- SweetAlert -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.css" integrity="sha512-8uD0a7yjAZOAcAKV5z9luuu2M3FW2tKt5S8ZILcO19zAt12OvRwVfbXCCfdjAwraK6bWd4bVnFOVWzlNzMltDQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js" integrity="sha512-M1+MUsqI6bkw3XT4Idrmz8uH93sPSSnY5ZOiic4wZq6KHzdU5c1t8psTdhlXK45wUKu6YlTAIF6XqjFIzLcGpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script type="text/javascript">



   function map_product(pid)



   {

    var product_id = $('#product_id').val();

    Swal.fire({

                title: 'Enter Quantity',

                input: 'number',

                inputValue: 1,

                inputAttributes: {

                    autocapitalize: 'off'

                },

                showCancelButton: true,

                confirmButtonText: 'Submit',

                showLoaderOnConfirm: true,

                preConfirm: (quantity) => {

                    // Send quantity to the server using Ajax

                    $.ajax({

                        type: 'POST',

                        url: "<?php echo base_url('master-data/products/map_bundle_product'); ?>",

                        data: { qty: quantity, pid:pid,product_id:product_id, },

                        success: function(data){

                            toastr.success('Product Mapped Successfully..');

                            $("#changeaction23"+pid).html(data);

                        },

                        error: function (xhr, status, error) {

                            // Handle error

                            Swal.fire('Error', 'Something went wrong!', 'error');

                        }

                    });

                },

                allowOutsideClick: () => !Swal.isLoading(),

                customClass: {

                    popup: 'your-custom-class', // Add your custom class here

                },

            });

        



   }



</script>







   <script type="text/javascript">



   function remove_map_product(pid)



   {



    if(confirm('Do you want to remove this?') == true)



    {



        var product_id = $('#product_id').val();



        $.ajax({



            url: "<?php echo base_url('master-data/products/remove_map_bundle_product'); ?>",



            method: "POST",



            data: {



                pid:pid,



                product_id:product_id



            },



            success: function(data){

                toastr.success('Product Unmapped Successfully..');

                $("#changeaction23"+pid).html(data);



            },



        });



    }



   }



</script>