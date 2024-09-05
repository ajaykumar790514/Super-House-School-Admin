<!DOCTYPE html>
<html>
<head>
	<title>Bill Invoice</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/fav-icon.png'); ?>">
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css'); ?>" rel="stylesheet">
	<style type="text/css">
        @page {
		  size: A4 portrait;
		}
		@page {
		  size: A4 portrait;
		}

		@page :first {
			margin-top: 35pt;
		}
		@page :left {
			margin-right: 30pt;
		}
		@page :right {
			margin-left: 30pt;
		}
		@media print {
			footer {
				display: none;
				position: fixed;
				bottom: 0;
			}
			header {
				display: none;
				position: fixed;
				top: 0;
			}
            .fa-download{
                display: none;
            }
		}
		table, figure {
			page-break-inside: avoid;
		}
		
		* { 
			margin: 0;
			padding: 0;
		}
		body {
			width: 100%;
			display: block;
		}
		#page-wrap { 
			width: 800px;
			margin: 0 auto;
			page-break-before: always;
		}
		#header { 
			width: 100%;
			text-align: center;
			color: black;
			text-transform: uppercase;
			padding: 2px 0px;
/*			page-break-before: always;*/
		}
	
		#company-logo {
			margin: 10px;
			max-width: 140px;
			max-height: 140px;
			overflow: none;
/*			position: absolute;*/
		}
		#company-logo > img {
			width: 100%;
			height: 100%;
		}
		#logo-header {
/*			margin-left: 200px;*/
/*			position: absolute;*/
/*			max-width: 600px;*/
            margin-top: 10px;
		}
		.copy {
			text-align:right;
			resize: none;	
			padding: 2px;
            font-family:  Helvetica, Sans-Serif;
		}

		#customer {
			overflow: hidden;
            width:40%;
            text-align: left;
            float: left;
            margin-bottom: 1rem;
		}
        #customers {
			overflow: hidden;
            width:50%;
            text-align: left;
            float: right;
            margin-bottom: 1rem;
		}
		#customer-data {
			position: relative;
		}
        #customer-datas {
			position: relative;
		}
		#customer-ship-to { 
			font-size: 13px;
			font-weight: bold;
			float: left; 
		}
		.customer-details {
			padding-top: 3px;
			font-size: 14px;
			font-weight: lighter;
			float: left; 	
		}
		#meta { 
			margin-left: 500px;
			margin-top: 1px;
			width: 300px;
			float: right;
		}

		#meta td {
			text-align: right;
		}
		#meta td.meta-head {
			text-align: left;
			background: #eee;
		}
		#meta td p {
			width: 100%;
			height: 20px;text-align: right;
		}

		p { border: 0; font: 14px, Serif; overflow: hidden; resize: none; }
		table { border-collapse: collapse; }
		table td, table th { border: 1px solid black; padding: 5px; }

		#items p { width: 80px; height: 50px; }
		
		
		#items th.description p, #items td.item-name p { width: 100%;border: none; }
		#items td.total-line { border-right: 0; text-align: right; }
		
		#items td.total-value { border-left: 0; padding: 10px; }
		
		#items td.total-value p { height: 20px; background: none; }
		#items td.balance { background: #eee; }
		#items td.blank { border: 0; }

		#total-amount { margin: 20px 0 0 5px; font-family:  Arial, Helvetica, sans-serif}

		#shop-details{
            text-align : center;
        }
        #invoice {
			overflow: hidden;
			margin-top: 20px;
		}
        #customer-name{
            font-size: 16px; 
            margin-top: 0.5rem;
        }
        #customer-names{
            font-size: 16px; 
            margin-top: 0.5rem;
        }
        #customer-text{
            font-size: 16px;
            margin-top: 3px;    
        }
        #customer-texts{
            font-size: 16px;
            margin-top: 3px;    
        }
		hr{
            border: 1px solid black;
            margin-top:15px;
        }
      	hr.tax{
            border: 1px solid black;
            margin-top:10px;
            margin-bottom:3px;
        }
         	hr.bottom{
            border: 1px solid black;
            margin-top:-0.00001px;
        }
      
        #shop-contact{
            margin-top:5px
        }
        #authorised
        {
            margin: 11px;
            margin-top: 1rem;
            font-family:  Arial, Helvetica, sans-serif;
        }
         #head
         {
            margin-top: 2rem;
         }
        .row #logo
        {
            float: left;
        }
        .row #data
        {
            float:right;
            text-align: left;
            margin-top: 2rem;
        }
        .row #data h2
        {
            text-align: right;
            font-family:  Arial, Helvetica, sans-serif;
        }
        .row #data p
        {
            text-align: right;
            font-family:  Helvetica, Sans-Serif;
            line-height: 20px;
            color: #000;
        }
       #tax
         {
       font-size: 1.2rem;font-weight:bold;font-family: Arial, Helvetica, sans-serif;
         }
         .vl {
  border-left: 2px solid black;
  height: 150px;
  position: absolute;
  left: 46.6%;
  margin-left: -3px;
  top: 18.7rem;
}

 	</style>
</head>
<body onload="window.print()">
<!-- onload="window.print()" -->
	<div id="page-wrap">
		
		<div id="company-details">
            <div class="row" id="head">
                <div class="col-4" id="logo">
                <div id="company-logo">
            	<img id="image" src="<?= IMGS_URL.$invoice[0]['logo']; ?>" alt="logo"/>
                 </div>
                </div>
                <div class="col-8" id="data">
                <div id="company-data">
                <h2 style="text-transform: uppercase;letter-spacing:1px;font-size: 1.4rem"><?=$invoice[0]['shop_name'];?></h2>
                <p><?=$invoice[0]['address'];?> </p>
                <p> <?=$invoice[0]['state_name'].',&nbsp;'.$invoice[0]['city_name'].', &nbsp;'.$invoice[0]['pin_code'];?></p>
                <p>GSTIN: <b style="font-weight:bold;"><?=$invoice[0]['gstin'];?></b></p>
                 </div>
                </div>
            </div>
		</div>
        
         <p id="header" ><hr class="tax"> <center><span  id="tax" >TAX INVOICE</span></center><hr class="bottom"></p>
         <div id="logo-header">
            	<p class="copy">
                Invoice No.: <b><?=$invoice[0]['orderid']; ?></b>
            	</p>
            	<p class="copy">
                Date: <b><?php $now = new DateTime($invoice[0]['order_date']);
    echo $timestring = $now->format('d-m-Y');?></b>
            	</p>
            </div>
       <hr>
       <?php 
            $address = $invoice[0]['cust_house_no'].' &nbsp;'.$invoice[0]['address2'].' &nbsp;'.$invoice[0]['address3'].'&nbsp; '.$invoice[0]['floor'].' &nbsp;'.$invoice[0]['apartment_name'].' <br> '.$invoice[0]['cust_state'].'&nbsp;'.$invoice[0]['cust_city']  .' '. $invoice[0]['cust_pincode'];
            $bill_address = $invoice[0]['billing_house_no'].' &nbsp;'.$invoice[0]['billing_address_line_2'].' &nbsp;'.$invoice[0]['billing_address_line_3'].' <br> '.$invoice[0]['billing_state'].'&nbsp;'.$invoice[0]['billing_city']  .' '. $invoice[0]['billing_pincode'];
            $name = $invoice[0]['name'];
            //$mobile = $invoice[0]['mobile'].' , '.$invoice[0]['booking_contact'];
        
       
        ?>

        <table width="100%" height="190px">
        <tr>
            <td style="width:46.3%;border:2px solid black;border-top:2px !important;border-left:2px !important;border-bottom:2px !important" >
            <p style="margin-top: -0.01rem;margin-bottom:0.8rem;font-family:  Arial, Helvetica, sans-serif;"><b><u>BILL TO</u></b></p>
                    <p style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;" >Name: <strong><?= $name ?></strong></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;">Address: <?= $bill_address; ?> </p>
                   
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;"> Phone: <?=  $invoice[0]['booking_contact']; ?></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;">Email: <?php if($invoice[0]['order_email']==''){echo "N/A";}else{echo $invoice[0]['order_email'];} ?></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;">GSTIN: N/A</p>
        
          </td>
            <td style="width:53.7%;border:2px solid black;border-top:2px !important;border-right:2px !important;border-bottom:2px !important">
            <p style="margin-top: -0.9rem;margin-bottom:0.8rem;font-family:  Arial, Helvetica, sans-serif;"><b><u>SHIP TO</u></b></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;">Name: <strong><?= $name ?></strong></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;">Address: <?= $address; ?> </p>
                   
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;">Phone: <?= $invoice[0]['booking_contact']; ?></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;margin-bottom: 0.5rem;">Email: <?= $invoice[0]['order_email'] ?></p>
                    <p  style="font-family:  Arial, Helvetica, sans-serif;">GSTIN: N/A</p>
           </td>
        </tr>
        </table>
		<?php 
            $inclusive_tax = $invoice[0]['total_value'] - ($invoice[0]['total_value'] * (100/ (100 + $invoice[0]['tax_value'])));   
            $rate =($invoice[0]['total_value']/$invoice[0]['item_qty']) - $inclusive_tax;
        ?>
     
       <table width="100%">
        <tr>
        <th  style="border-left:5px !important;border:2px solid black;height:40px;width:7%;font-family:  Arial, Helvetica, sans-serif;">S.No.</th>
		<th style="border:2px solid black;height:40px;width:29.2%;font-family:  Arial, Helvetica, sans-serif;">Items</th>
		<th style="border:2px solid black;height:40px;width:10%;font-family:  Arial, Helvetica, sans-serif;">HSN</th>
		<th style="border:2px solid black;height:40px;width:40px;font-family:  Arial, Helvetica, sans-serif;">Qty.</th>
        <th style="border:2px solid black;height:40px;width:130px;font-family:  Arial, Helvetica, sans-serif;"><center style="margin-top: 0.7rem;">MRP <br>[Rs.Ps.]</center></th>
		<th style="border:2px solid black;height:40px;width:80px;font-family:  Arial, Helvetica, sans-serif;"><center style="margin-top: 0.7rem;">Disc. <br>[% / Rs.]</center></th>
        <th style="border-right:5px !important;border:2px solid black;height:40px;width:80px;font-family:  Arial, Helvetica, sans-serif;"><center style="margin-top:0.7rem;">Amount <br>[Rs.Ps.]</center></th>
        </tr> 
        <?php
          // discount
          
            $i=1;
            foreach($invoice as $row):
                if($row['discount_type']==0)
                {
                  $amount = ($row['selling_rate']-$row['offer_applied']);
                  $discount = "Rs".$row['selling_rate']-$amount;
                }elseif($row['discount_type']==1)
                {
                    $per = ($row['selling_rate']*$row['offer_applied'])/100;
                     $amount = $row['selling_rate']-$per; 
                    $discount = $row['offer_applied'];
                }
			?>
            <tr>
                <td style="border-left:5px !important;border:2px solid black;height:40px;width:7%;text-align:center;font-family:  Arial, Helvetica, sans-serif;"><?=$i?></td>
                <td style="border:2px solid black;height:40px;width:29.2%;text-align:center;font-family:  Arial, Helvetica, sans-serif;"><?= $row['product_name']; ?></td>
                <td style="border:2px solid black;height:40px;width:10%;text-align:center;font-family:  Arial, Helvetica, sans-serif;">N/A</td>
                <td style="border:2px solid black;height:40px;width:65.5px;text-align:center;font-family:  Arial, Helvetica, sans-serif;"><?=$row['item_qty'];?></td>
                <td  style="border:2px solid black;height:40px;width:130px;text-align:center;font-family:  Arial, Helvetica, sans-serif;">₹<?= $row['selling_rate']; ?>
                <td style="border:2px solid black;height:40px;width:80px;text-align:center;font-family:  Arial, Helvetica, sans-serif;"><?=round(($discount),2)?><?php if($row['discount_type']==1){echo " % OFF";}elseif($row['discount_type']==0){echo " OFF";}?></td>
                <td style="border-right:5px !important;border:2px solid black;height:40px;width:80px;text-align:center;font-family:  Arial, Helvetica, sans-serif;">₹<?php echo number_format((float)($amount*$row['item_qty']), 2, '.', ''); ?></td>
            </tr>
		  <?php
            $i=$i+1;
            endforeach;
            ?>
      </table>

       <?php
       //echo $invoice[0]['state_name'];
        if($invoice[0]['cust_state'] != $invoice[0]['state_name'])
        {
            $igst = $invoice[0]['order_tax'];
            $cgst = '0';
            $sgst = '0';
            $igst_per = $invoice[0]['tax_value'];
            $cgst_per = '0';
            $sgst_per = '0';
        }
        else
        {
            $igst = '0';
            $cgst = ($invoice[0]['order_tax'])/2;
            $sgst = ($invoice[0]['order_tax'])/2;
            $igst_per = '0';
            $cgst_per = ($invoice[0]['tax_value'])/2;
            $sgst_per = ($invoice[0]['tax_value'])/2;
        } 
      
        ?>
		<table width="100%">
          <!--   <tr>
				<td style="width:760px;border-top:3px !important;border-left:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">Freight Charges</td>
                <td style="width:150px;border-top:3px !important;border-right:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹<?=$invoice[0]['delivery_charges'];?></td>
			</tr> -->
       
			<tr>
				<td style="width:760px;border-top:3px !important;border-left:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">Delivery Charges</td>
                <td style="width:184px;border-top:3px !important;border-right:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹0.00</td>
			</tr>
			<tr>
				<td style="width:760px;border-top:3px !important;border-left:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">Total Taxable Value</td>
                <td style="width:184px;border-top:3px !important;border-right:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹<?php echo number_format((float)(($invoice[0]['total_value']-$invoice[0]['order_tax'])), 2, '.', '');?></td>
			</tr>
			<tr>
				<td style="width:760px;border-top:3px !important;border-left:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">CGST ( @ <?=$cgst_per;?>% ) </td>
                <td style="width:184px;border-top:3px !important;border-right:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹ <?php echo number_format((float)$cgst, 2, '.', ''); ?></td>
			</tr>
            <tr>
				<td style="width:760px;border-top:3px !important;border-left:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">SGST ( @ <?=$sgst_per;?>% )</td>
                <td style="width:184px;border-top:3px !important;border-right:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹ <?php echo number_format((float)$sgst, 2, '.', ''); ?></td>
			</tr>
			<tr>
				<td style="width:760px;border-top:3px !important;border-left:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">IGST ( @ <?=$igst_per;?>% )</td>
                <td style="width:184px;border-top:3px !important;border-right:3px !important;border-bottom:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹ <?php echo number_format((float)$igst, 2, '.', ''); ?></td>
			</tr>
			<tr>
				<th style="width:760px;border-top:3px !important;border-left:3px !important;border:2px solid black ;text-align:right;font-family:  Arial, Helvetica, sans-serif;">Grand Total (Rounded Off)</th>
                <th style="width:184px;border-top:3px !important;border-right:3px !important;border:2px solid black;text-align:right;font-family:  Arial, Helvetica, sans-serif;">₹<?php  echo number_format((float)($invoice[0]['total_value']), 2, '.', ''); ?></th>
			</tr>
		</table>
        <div id="total-amount">
		  	<p>Total Amount (in words) : <strong>INR <?= rupee_number_to_word($invoice[0]['total_value']); ?></strong></p>
		</div>
        <hr>
        <div style="text-align: end">
            <p id="authorised">For DrumTrum</p>
		  	<p id="authorised">Authorised Signatory</p>
		</div>
        <table>
        <h4 style="font-family:  Arial, Helvetica, sans-serif"><u> E&OE.:</u></h4>
            <tr style="font-family:  Arial, Helvetica, sans-serif">
           <th style="border:none">1.</th>
           <td style="border:none">This is a computer-generated invoice hence does not require any signature.</td>
           </tr>
            <tr style="font-family:  Arial, Helvetica, sans-serif">
           <th style="border:none;"><center style="margin-top:-17px !important;">2.</center></th>
           <td style="border:none">Goods once sold will be returned or replaced as per the return and refund policy listed in policies section of the app.</td>
           </tr>
           <tr style="font-family:  Arial, Helvetica, sans-serif">
           <th style="border:none">3.</th>
           <td style="border:none">All the disputes are subject to Kanpur Jurisdiction.</td>
           </tr>
        </table>
        <!-- <div style="text-align:center">
            <p><b>Add:.<?= $invoice[0]['address'].' , '.$invoice[0]['city_name'].' , '.$invoice[0]['state_name'].' , '.$invoice[0]['pin_code']; ?></b></p>
		</div> -->
	</div style="margin-botom:2rem">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</body>
</html>
