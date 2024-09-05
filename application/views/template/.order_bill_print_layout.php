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
            border: 1px solid;
		}
		#header { 
			height: 15px;
			width: 100%;
			margin: 20px 0;
			background: #3b3b3e;
			text-align: center;
			color: white;
			font: bold 15px Helvetica, Sans-Serif;
			text-transform: uppercase;
			letter-spacing: 20px;
			padding: 8px 0px;
			page-break-before: always;
		}
		#shop-header { 
			height: 15px;
			width: 100%;
			margin: 20px 0;
			background: #eee ;
			text-align: center;
			color: black;
			font: bold 15px Helvetica, Sans-Serif;
			text-transform: uppercase;
			padding: 8px 0px;
			/* page-break-before: always; */
            margin-top: 0px;
            font-size: 17px;
		}
		#company-details {
			
		}
		#company-logo {
			margin: 10px;
			max-width: 140px;
			max-height: 140px;
			overflow: none;
			position: absolute;
		}
		#company-logo > img {
			width: 100%;
			height: 100%;
		}
		#logo-header {
			margin-left: 200px;
			position: absolute;
			max-width: 600px;
            margin-top: 47px;
		}
		.copy {
			font: bolder 15px Helvetica, Sans-Serif;
			width: 600px;
			text-transform: uppercase;
			text-align: center;
			resize: none;	
			padding-top: 5px;
/*			margin-left: 5rem;*/
            margin-right: 1rem !important;
			text-align: right;
		}

		#customer {
			overflow: hidden;
			margin-top: 26px;
            margin-bottom:10rem;
            margin-left: 19px;
		}
		#customer-data {
			position: absolute;
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

		#items {
			clear: both;
			width: 100%;
			margin: 30px 0 0 0;
			border: 1px solid black;
            text-align:center;
		}
		#items th {
			background: #eee;
		}
		
		#items th#cost { 
			width: 90px;
		}
		#items th#discount { 
			width: 120px;
		}
		#items th#qty { 
			width: 90px;
		}
		#items th#tax { 
			width: 90px;
		}
		#items th#price { 
			width: 90px;
		}
		#items tr#item-row td {
			border: 0;
			vertical-align: top;
		}

		p { border: 0; font: 14px, Serif; overflow: hidden; resize: none; }
		table { border-collapse: collapse; }
		table td, table th { border: 1px solid black; padding: 5px; }

		#items p { width: 80px; height: 50px; }
		
		
		#items th.description p, #items td.item-name p { width: 100%; }
		#items td.total-line { border-right: 0; text-align: right; }
		
		#items td.total-value { border-left: 0; padding: 10px; }
		
		#items td.total-value p { height: 20px; background: none; }
		#items td.balance { background: #eee; }
		#items td.blank { border: 0; }

		#total-amount { margin: 20px 0 0 5px; }

		#shop-details{
            text-align : center;
        }
        #invoice {
			overflow: hidden;
			margin-top: 190px;
		}
        #customer-name{
            font-size: 16px; 
        }
        #customer-text{
            font-size: 16px;
            margin-top: 3px;    
        }
		hr{
            border: 1px solid black;
            margin-top:15px;
        }
        #shop-contact{
            margin-top:5px
        }
        #authorised
        {
            margin: 11px;
            margin-bottom: 2rem;
            padding-top: 1rem;
        }
	</style>
</head>
<body onload="window.print()">
	 <!-- onload="window.print()" -->
	<div id="page-wrap">
		<p id="header" > INVOICE</p>
		<div id="company-details">
			<div id="company-logo">
            	<img id="image" src="<?= IMGS_URL.$invoice->logo; ?>" alt="logo"/>
            </div>
            <div id="logo-header">
            	<p class="copy">
                INVOICE NO.: <?= $invoice->orderid ?>
            	</p>
            	<p class="copy">
                DATE: <?= uk_date($invoice->order_date); ?>
            	</p>
            	<p class="copy">
                TIME: <?= uk_time($invoice->order_date); ?>
            	</p>
            </div>
		</div>
		
		<div id="invoice">
            <p id="shop-header"><?= $invoice->shop_name; ?></p>
            <div id="shop-details">
            	<!-- <p><?= $invoice->address;?></p> -->
            	<p id="shop-contact"><b>Contact:</b> <?= $invoice->alternate_contact; ?> | <b>Email:</b> <?=$invoice->email; ?></p>       	<br><b>Website:</b> www.30minutesvape.co.uk</p>
            	<!-- <p id="shop-contact"><b>GSTIN:</b> <?//= $invoice->gstin; ?></p> -->
            </div>
		</div>
       <hr>
       <?php 
            $address = $invoice->cust_house_no.'  '.$invoice->address2.'  '.$invoice->address3.' '.$invoice->cust_state.'  '.$invoice->cust_city.'  '.$invoice->cust_pincode;
            $name = $invoice->contact_name;
            
             if(!empty($invoice->cust_contact))
            {
            	$mobile = $invoice->cust_contact;
            }else{
            	$mobile="NA";
            }
            if(!empty($invoice->instructions))
            {
            	$instructions = $invoice->instructions;
            }else{
            	$instructions="NA";
            }
        
         $billing_address = $invoice->billing_house_no.'  '.$invoice->billing_address_line_2.'  '.$invoice->billing_address_line_3.' '.$invoice->billing_state.'  '.$invoice->billing_city.'  '.$invoice->billing_pincode;
       
        ?>

		<div id="customer">
                <div id="customer-data">
                    <p id="customer-name"><strong>Name - <?= $name; ?></strong></p>
                    <p id="customer-text">Billing Address - <?= $billing_address; ?></p>
                    <p id="customer-text">Delivery Address - <?= $address; ?></p>
                    <p id="customer-text">Phone - <?=$mobile; ?></p>
                    <p id="customer-text">Instructions - <?=$instructions; ?></p>
                    <!-- <p id="customer-text">Email- <?= $invoice->cust_email; ?></p> -->
                </div>
               
		</div>
		
		<table id="items">
			<tr>
				<th id="item-name">Particular(s)</th>
				<th id="qty">Qty</th>
				<th id="cost">Rate</th>
				<th id="discount">Discount</th>
				<th id="price">Amount</th>
			</tr>
			<?php 
			$subtotal=$selling_rate = 0;
			foreach($invoice_details as $details):
				$selling_rate = $details->total_price;
                $subtotal = $subtotal+$selling_rate;
                $rs = $this->order_items_model->get_value($details->product_id);

           $inclusive_tax = $details->total_value - ($details->total_value * (100/ (100 + $details->tax_value)));   
            $rate =($details->total_value/$details->item_qty) - $inclusive_tax;
        ?>
          <?php if($details->is_igst == '1')
        {
            $igst = $details->order_tax * $details->item_qty;
            $cgst = '0';
            $sgst = '0';
            $igst_per = $details->tax_value;
            $cgst_per = '0';
            $sgst_per = '0';
        }
        else
        {
            $igst = '0';
            $cgst = ($details->order_tax * $details->item_qty)/2;
            $sgst = ($details->order_tax * $details->item_qty)/2;
            $igst_per = '0';
            $cgst_per = $details->tax_value/2;
            $sgst_per = $details->tax_value/2;
        } 
        ?>
        <?php
					$vat_per = $sgst_per + $cgst_per;
					$vat = $sgst + $cgst;
				?>
            <tr>
                <td><?= $details->product_name; ?>  <br>( <span style="color:red"><?php if(!empty($details->flavour)){ echo @$details->flavour.' , ';} ?> <?=@$rs->value;?></span> )</td>
                <td><?= $details->item_qty; ?></td>
                <td><?= $invoice->currency; ?><?=bcdiv($details->purchase_rate, 1, 2);?></td>
                <td>
                	<?php  if($details->discount_type==1){ echo $details->offer_applied.'% OFF';}elseif($details->discount_type==0){ echo $shop_currency.''.$details->offer_applied.' FLAT OFF';}elseif($details->discount_type==2){echo $details->offer_applied;}else{echo $details->offer_applied; };?>
                </td>
                <td><?= $invoice->currency; ?><?=bcdiv(($selling_rate), 1, 2);?></td>
            </tr>
		  <?php endforeach;?>
		</table>
      
		<table id="items">
			
			<tr>
				<th id="item-name">Total</th>
                <td><?= $invoice->currency; ?><?=bcdiv(($subtotal), 1, 2);?></td>
			</tr>
				<tr>
				<th id="item-name">Total Savings</th>
                <td><?= $invoice->currency; ?><?=bcdiv(($invoice->total_savings), 1, 2);?></td>
			</tr>
			<!-- <tr>
				<th id="item-name">SGST @ <?= round($sgst_per,2).'%'; ?></th>
                <td><?= $invoice->currency; ?> <?= round($sgst,2); ?></td>
			</tr>
			<tr>
				<th id="item-name">CGST @ <?= round($cgst_per,2).'%'; ?></th>
                <td><?= $invoice->currency; ?> <?= round($cgst,2); ?></td>
			</tr> -->
			<tr>
				
		<!-- 		<th id="item-name">VAT @ <?= round($vat_per,2).'%'; ?></th>
                <td><?= $invoice->currency; ?> <?= round($vat,2); ?></td> -->
			</tr>
			<!-- <tr>
				<th id="item-name">IGST @ <?= round($igst_per,2).'%'; ?></th>
                <td><?= $invoice->currency; ?> <?= round($igst,2); ?></td>
			</tr> -->
			<tr>
				<th id="grand-total">Grand Total (Inclusive of VAT)</th>
                <th><?= $invoice->currency; ?><?=bcdiv($subtotal, 1, 2);?></th>
			</tr>
		  	
		</table>
		<!-- <div id="total-amount">
		  	<h3>Total Amount (EURO - in words) : <?= number_to_word($details->total_value); ?></h3>
		</div> -->
        <hr>
        <div>
		  <!--	<h3 id="authorised">Authorised Signatory</h3>-->
		</div>
	</div>
</body>
</html>
