
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Category Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Days</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            
            <?php
             $i=0;
             $tmp=array();
            if(!empty($rows)){
            foreach($rows as $value)
            {
            if($value->is_parent=="0")
              {
              ?>
              <tr class="jsgrid-filter-row">
              <th class="jsgrid-cell  jsgrid-align-center"><?=++$i?></th>
              <td class="jsgrid-cell"><strong class="float-left"><?php echo $value->name;?>  ( level <?=$value->level;?> )</strong> </td>
              <td class="jsgrid-cell  jsgrid-align-center"><?=$value->days;?> days</td>
              <td class="jsgrid-cell  jsgrid-align-center"> <a href="javscript:void(0)" onclick="delete_map(<?php echo $value->id;?>)">
                        <i class="fa fa-trash"></i>
                    </a></td>
              </tr>
            <?php 
            $level2 = $this->master_model->get_categories_return_level2();
            foreach($level2 as $cat)
            {
                   if($cat->is_parent==$value->id)
                   { 
                    array_push($tmp,$cat->id);
                    ?>
                    <tr class="jsgrid-filter-row">
                 <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                  <td class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><i class="fas fa-arrow-right ml-3"></i> <?php echo $cat->name;?>   ( level <?=$cat->level;?> ) </p></td>
                  <td class="jsgrid-cell  jsgrid-align-center"><?=$cat->days;?> days</td>
                  <td class="jsgrid-cell  jsgrid-align-center"> <a href="javscript:void(0)" onclick="delete_map(<?php echo $cat->id;?>)">
                        <i class="fa fa-trash"></i>
                    </a></td>
           <?php 
                $level3 = $this->master_model->get_categories_return_level3();
                foreach($level3 as $subcat)
                {
                    if($subcat->is_parent == $cat->id)
                    { 
                        array_push($tmp,$subcat->id);
                        ?>
                        <tr class="jsgrid-filter-row">
              <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
              <td class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><i class="fas fa-arrow-right ml-5"></i> <?php echo $subcat->name;?>   ( level <?=$subcat->level;?> )</p></td>
              <td class="jsgrid-cell  jsgrid-align-center"><?=$subcat->days;?> days</td>
              <td class="jsgrid-cell  jsgrid-align-center"> <a href="javscript:void(0)" onclick="delete_map(<?php echo $subcat->id;?>)">
                        <i class="fa fa-trash"></i>
                    </a></td>
              <?php 
                }
               } 
               
              }   
             }
            }
            }
           }
           
           
            $level2 = $this->master_model->get_categories_return_level2();
            if(!empty($level2)){
            foreach($level2 as $cat)
            { 
                if(!in_array($cat->id,$tmp))
                {
                    array_push($tmp,$cat->id);
                ?>
                <tr class="jsgrid-filter-row">
                 <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                  <th class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><?php echo $cat->name;?>   ( level <?=$cat->level;?> )</p></th>
                  <td class="jsgrid-cell  jsgrid-align-center"><?=$cat->days;?> days</td>
                  <td class="jsgrid-cell  jsgrid-align-center"> <a href="javscript:void(0)" onclick="delete_map(<?php echo $cat->id;?>)">
                        <i class="fa fa-trash"></i>
                    </a></td>
           <?php 
                $level3 = $this->master_model->get_categories_return_level3();
                foreach($level3 as $subcat)
                {
                    if($subcat->is_parent == $cat->id)
                    { 
                        array_push($tmp,$subcat->id);
                        ?>
                        <tr class="jsgrid-filter-row">
              <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
              <td class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><i class="fas fa-arrow-right ml-5"></i> <?php echo $subcat->name;?>   ( level <?=$subcat->level;?> ) </p></td>
              <td class="jsgrid-cell  jsgrid-align-center"><?=$subcat->days;?> days</td>
              <td class="jsgrid-cell  jsgrid-align-center"> <a href="javscript:void(0)" onclick="delete_map(<?php echo $subcat->id;?>)">
                        <i class="fa fa-trash"></i>
                    </a></td>
              <?php 
                }
              } 
            }  
             }
           }

            $level3 = $this->master_model->get_categories_return_level3();
                foreach($level3 as $subcat)
                {
                    if(!in_array($subcat->id,$tmp))
                    {
                    ?>
                        <tr class="jsgrid-filter-row">
              <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
              <th class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><?php echo $subcat->name;?>   ( level <?=$subcat->level;?> )</p></th>
              <td class="jsgrid-cell  jsgrid-align-center"><?=$subcat->days;?> days</td>
              <td class="jsgrid-cell  jsgrid-align-center"> <a href="javscript:void(0)" onclick="delete_map(<?php echo $subcat->id;?>)">
                        <i class="fa fa-trash"></i>
                    </a></td>
              <?php 
            }
              } 
           
        
            ?>      
        </table>

            
    </div>
</div>
<script>
//    $(document).ready(function () {
    function delete_map(id) {
        if(confirm('Do you want to delete?') == true)
        {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>return-policy-master/map_remove',
            data: {id:id},
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.res === 'success') {
                    $('#showModal').modal('hide');
                    loadtb();
                }
                alert(response.msg);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
  }
}
//    });
</script>