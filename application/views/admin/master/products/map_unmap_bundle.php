<?php if($flg==1)

            {?> 
            <button type="button" class="btn btn-sm btn-danger" onclick="remove_map_product(<?= $pid ?>);" id="pcheckbox<?= $pid?>" >UnMap</button>
            <label for="pcheckbox<?= $pid ?>"></label>

        <?php } 

            else { ?>
              <button type="button" class="btn btn-sm btn-success mapsubmit" onclick="map_product(<?= $pid ?>);" id="box<?= $pid ?>">Map</button>
            <label for="box<?= $pid ?>"></label>
            <?php } ?>
