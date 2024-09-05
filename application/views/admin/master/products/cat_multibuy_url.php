<div class="modal-header">
    <h3>MultiBuy Deal Apply all category of (  <?=$category->name;?>  )</h3>
</div>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">        
    <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Quantity Price:</label>
                    <input type="number" class="form-control" name="qty" value="0"  required>
                </div>
            </div>
          
            <div class="col-6">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Price:</label>
                    <input type="number" class="form-control" name="price" value="0" required>
                </div>
            </div>
     
        </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

            

