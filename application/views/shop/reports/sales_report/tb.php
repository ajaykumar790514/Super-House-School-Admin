<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
.jsgrid-table
{
    width:202%;
}
h4
{
    color:blue;
}
#reset-data
{
    background-color:red;
}
</style>
<div class="row">
    <div class="col-md-6 text-left">
        <!-- <span>Showing <?//=$page+1?> to <?//=$page+count($sales_report)?> of <?//=$total_rows?> entries</span> -->

    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
            <!-- <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?//=$search?>" placeholder="Search..."> -->
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <!-- <?//=$links?> -->
        </div>
       
    </div>
</div>
<div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">From date:</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="<?php if(!empty($from_date)){echo $from_date; }?>">
            </div>
            <div id="msg"></div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label class="control-label">To date:</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($to_date)){echo $to_date; }?>" onchange="filter_sales_report(this.value)">
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Payment Mode:</label>
            <select class="form-control" style="width:100%;" name="pm_id" id="pm_id" onchange="filter_by_payment_mode(this.value)">
                <option value="">Select</option>
                <option value="cod" <?php if(!empty($pmid)){if($pmid == 'cod'){echo "selected";} }?>>COD</option>
                <option value="online" <?php if(!empty($pmid)){if($pmid == 'online'){echo "selected";} }?>>Online</option>
                
            </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Status:</label>
                <select class="form-control" style="width:100%;" name="status_id" id="status_id" onchange="filter_by_status(this.value)">
                    <option value="">Select</option>
                    <?php foreach ($order_status as $status) { ?>
                    <option value="<?php echo $status->id; ?>" <?php if(!empty($status_id)) { if($status_id==$status->id) {echo "selected"; } }?>>
                        <?php echo $status->name; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Search:</label>
                <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search...">
            </div>
        </div>
        <div class="col-1 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
        <div class="col-4 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Import Invoice No by Excel</button>
            </div>
        </div>

</div>
<div id="datatable">

    <?php if(!empty($to_date)) { 
         $total_value_with_tax_sum = @$sales_result->total_value;
         $total_value_without_tax_sum = $total_value_with_tax_sum - @$sales_result->total_tax;
        ?>
        <div class="row">
            <div class="col-md-2">
            <button type="button"  id="button-excel" class="btn btn-sm btn-primary"><i class="fas fa-arrow-down"></i> Export to Excel</button>
            <!-- <a href="<?//= base_url('reports/sales_report/export_to_excel/'.$from_date.'/'.$to_date.'/'.$pmid.'/'.$search.'/'.$status_id); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a> -->
            </div>
            <div class="col-md-3 mt-1">
                <h4>Total without tax = ₹ <?=@ round($total_value_without_tax_sum,2); ?></h4>
            </div>
            <div class="col-md-3 mt-1">
                <h4>Total tax = ₹ <?= @round($sales_result->total_tax,2); ?></h4>
            </div>
            <div class="col-md-3 mt-1">
                <h4>Total with tax = ₹ <?= @round($total_value_with_tax_sum,2); ?></h4>
            </div>  
        </div>
    <div id="grid_table" class="table-responsive">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Order date</th>
                 <th class="jsgrid-header-cell jsgrid-align-center table-heading">Order ID.</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Customer name</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Customer number</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total without tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total value with tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Payment Method</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Razorpay OrderId</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Invoice No.</th>
            </tr>
            
            <?php $i=$page; foreach($sales_report as $value){ 
                $getItem = $this->reports_model->getAllItem($value->order_id);
                $total_without_tax =$value->total_value;
                
                $total_tax = $value->tax;
                $total_value_with_tax = $total_without_tax + $total_tax;

                ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i;?>.</th>
                <td class="jsgrid-cell jsgrid-align-center"><?= date_format_func($value->order_date);?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?=$value->orderid;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->name; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->mobile; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($total_without_tax,2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($total_tax,2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($total_value_with_tax,2); ?></td>
                
                <td class="jsgrid-cell jsgrid-align-center">
                <?php if($value->payment_method == 'cod')
                {
                    echo 'COD';
                }
                else
                {
                    echo "Razorpay";
                } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->razorpay_order_id; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->erp_invoice; ?></td>
                
            </tr> 
            <tr style="height:40px;">
                <td class="jsgrid-cell jsgrid-align-center" colspan="10">    </td>
            </tr>
            <?php 
            $asciiValue = ord('A');
            foreach($getItem as $item):
            ?>
            <tr>
                <th  style="text-align:center;margin-left:2rem"><?=chr($asciiValue);?>.</th>
                <td class="jsgrid-cell jsgrid-align-center" colspan="2"><?=$item->name;?></td> 
                <td class="jsgrid-cell jsgrid-align-center"><?=$item->product_code;?></td> 
                <td class="jsgrid-cell jsgrid-align-center">₹ <?=$item->price_per_unit;?></td> 
                <td class="jsgrid-cell jsgrid-align-center"><?=$item->qty;?></td> 
                <td class="jsgrid-cell jsgrid-align-center">₹ <?=$item->total_price;?></td>
                <td class="jsgrid-cell jsgrid-align-center" colspan="4"></td>   
            </tr>
            <?php $asciiValue++; ?>
            <?php endforeach; ?> 
            <tr style="height:40px;">
                <td  class="jsgrid-cell jsgrid-align-center" colspan="10">    </td>
            </tr>
            <?php } ?>    
           

        </table>

    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($sales_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<?php } ?>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form  id="myForm" class="ajaxsubmit"  action="<?=base_url('reports/ImportInvoiceNo');?>" method="post" enctype= multipart/form-data>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Invoice No by Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
       <div class="row">
       <div class="col-12">
       <div class="form-group">
       <label for="">Select Excel</label>
       <input type="file" name="import_file" id="import_file" required class="form-control" >
       </div>
       </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btnsubmit"  class="btn btn-primary">Import</button>
      </div>
      </form>
    </div>
  </div>
</div>




<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
    $(document).ready(function(){
    let button = document.querySelector("#button-excel");

button.addEventListener("click", e => {
  let table = document.querySelector("#tb");

let currentDate = new Date();

const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
let day = currentDate.getDate();
let monthIndex = currentDate.getMonth();
let year = currentDate.getFullYear();
let formattedDate = `${day}-${monthNames[monthIndex]}-${year}`;

  let fileName = `sales_report_export_${formattedDate}.xlsx`;

  TableToExcel.convert(table, { name: fileName });
});
})

$(document).ready(function () {
        $("#btnsubmit").on("click", function() {
            // Trigger form validation
            if ($("#myForm").valid()) {
                $("#btnsubmit").prop('disabled', true);
                var formData = new FormData($("#myForm")[0]);
                $.ajax({
                    url: $("#myForm").attr("action"),
                    type: $("#myForm").attr("method"),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log("Success Data:", data);

                        try {
                            var parsedData = JSON.parse(data);
                            console.log("Parsed Data:", parsedData);

                            if (parsedData.res.trim() == 'success') {
                                $("#btnsubmit").prop('disabled', false);

                                // Show SweetAlert success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: parsedData.msg,
                                    timer: 2000,  // Optional timer to auto-close the alert after 2 seconds
                                    showConfirmButton: false
                                });
                                $('#exampleModal').modal('hide');
                                $('.bundle_details').removeClass('d-none');
                                $("#myForm")[0].reset();
                            } else {
                                // Show SweetAlert error message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: parsedData.msg
                                });
                            }
                        } catch (e) {
                            console.error("Error parsing JSON: ", e);
                            alert("Error parsing server response.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                        alert("AJAX Error: " + status);
                    }
                });
            }
        });
    });
</script>
<script type="text/javascript">
    
   function filter_sales_report(to_date)
   {
    if(document.getElementById('from_date').value == 0)
    {
        alert('Please Select From Date');
        document.getElementById('from_date').focus();
        $('#to_date').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var from_date = $("#from_date").val();
    var pm_id = $("#pm_id").val();
    var status_id  = $('#status_id').val();
    var search  = $('#tb-search').val();
    if(from_date>to_date)
    {
        msg = "From date should be less than to date";
        document.getElementById('msg').style.color='red';
        document.getElementById('msg').innerHTML=msg;
        return;
    }
    $.ajax({
        url: "<?php echo base_url('sales-report/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            pm_id:pm_id,
            status_id:status_id,
            search:search,
        },
        success: function(data){
            $("#tb").html(data);

         
        },
    });
   }
</script>


<script type="text/javascript">
   function filter_by_payment_mode(pm_id)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var from_date = $("#from_date").val();
    var to_date = $('#to_date').val();
    var status_id  = $('#status_id').val();
    var search  = $('#tb-search').val();
    $.ajax({
        url: "<?php echo base_url('reports/sales_report/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            pm_id:pm_id,
            status_id:status_id,
            search:search,
        },
        success: function(data){
            $("#tb").html(data);
            if($("#subscription_value").val() == 'true')
            {
                $("#plan_type_id").prop('disabled',false);
                $("#subscription").prop('checked', true);
            }
            else
            {
                $("#plan_type_id").prop('disabled',true);
                $("#subscription").prop('checked', false);
            }
        },
    });
   };
   function filter_by_status(status_id)
   {
       $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
        var from_date = $("#from_date").val();
        var to_date = $('#to_date').val();
        var pm_id = $("#pm_id").val();
        var search  = $('#tb-search').val();
        $.ajax({
            url: "<?php echo base_url('reports/sales_report/tb'); ?>",
            method: "POST",
            data: {
                from_date:from_date,
                to_date:to_date,
                pm_id:pm_id,
                status_id:status_id,
                search:search,
            },
            success: function(data){
                $("#tb").html(data);
                if($("#subscription_value").val() == 'true')
                {
                    $("#plan_type_id").prop('disabled',false);
                    $("#subscription").prop('checked', true);
                }
                else
                {
                    $("#plan_type_id").prop('disabled',true);
                    $("#subscription").prop('checked', false);
                }
            },
        });
   };
   
     
   $('#reset-data').click(function(){
        location.reload();
    })
</script>
<script type="text/javascript">


  
   $('#reset-data').click(function(){
        location.reload();
    })
</script>

