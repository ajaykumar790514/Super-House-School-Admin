
<!-- <p id="success" class="text-success"></p> -->
<input type="hidden" value=<?php echo $headerid; ?> id="headerid">
<table  style="border:1px solid black"     width="770px" style="width: 870px !important;">
<thead class="thead-light">
    <tr  align='center' style="border:1px solid black">
        <th class="text-center">Image</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Product Code</th>
        <th class="text-center">Group</th>
        <th class="text-center">Class</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $flg=0;
        foreach($available_products as $products) {
            $rs = $this->master_model->get_property_val_new($products->prod_id); ?>
    <tr align='center'>
        <td class="text-center"><img src="<?php echo displayPhoto($products->thumbnail); ?>" alt="image" height="100"></td>
        <td class="text-center"><?= $products->name;?><br><?php if(!empty($rs)){?><strong class="text-danger"> [ <?php foreach($rs as $r){echo $r->value.",";};?> ] </strong><?php }?></td>
        <td class="text-center"><?= $products->product_code;?></td>
        <td class="text-center">  <?php 

                        $RS = $this->master_model->getDistinctRowByGroupId($products->prod_id);

                        if(!empty(@$RS)){

                        foreach($RS as $R)

                        {

                            echo $R->group_name."</br>";

                        }

                    }
             ?></td>
        <td class="text-center">
             <?php 

                    

                    foreach ($class_pro_map as $class) {

                        if($class->pro_id == $products->prod_id){

                            if(!empty(@$class->name)){

                            echo $class->name."<br>";

                        } 

                    }

                        

                    }

                    ?>
            </td>     
        <?php foreach($headers_mapping as $mapping) 
        {
             if($mapping->value == $products->id)
             {
                     $flg=1;   
             }
        }
        ?>
        <td class="btn btn-primary btn-sm" id="changeaction2<?= $products->id ?>" style="margin-top: 29px;">
        <?php if($flg==1)
            {?> 
            <a href="javascript:void(0)" onclick="remove_map_product(<?= $products->id ?>);" style="color:white;"> Remove </a>
        <?php } 
            else { ?>
            <a href="javascript:void(0)" onclick="map_product(<?= $products->id ?>);" style="color:white;">Map</a>
            <?php } ?>
        </td>
       
    </tr>
    <?php $flg=0; }?>
    </tbody>
</table>