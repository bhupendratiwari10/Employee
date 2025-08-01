<?php 



?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
</head>

<body style="margin: 0;">

<div id="p1" style="overflow: hidden; position: relative; background-color: white; width: 909px; height: 1286px;">

<!-- Begin shared CSS values -->
<style class="shared-css" type="text/css" >
.t {
	transform-origin: bottom left;
	z-index: 2;
	position: absolute;
	white-space: pre;
	overflow: visible;
	line-height: 1.5;
}
.text-container {
	white-space: pre;
}
@supports (-webkit-touch-callout: none) {
	.text-container {
		white-space: normal;
	}
}
</style>
<!-- End shared CSS values -->


<!-- Begin inline CSS -->
<style type="text/css" >

#t1_1{left:112px;bottom:1026px;letter-spacing:0.01px;word-spacing:0.04px;}
#t2_1{left:154px;bottom:857px;letter-spacing:-0.13px;word-spacing:0.08px;}
#t3_1{left:154px;bottom:914px;letter-spacing:-0.14px;word-spacing:0.1px;}
#t4_1{left:151px;bottom:800px;letter-spacing:-0.15px;word-spacing:0.1px;}
#t5_1{left:151px;bottom:621px;letter-spacing:-0.03px;word-spacing:-0.01px;}
#t6_1{left:151px;bottom:565px;letter-spacing:-0.12px;word-spacing:0.08px;}
#t7_1{left:151px;bottom:740px;letter-spacing:-0.07px;word-spacing:0.03px;}
#t8_1{left:151px;bottom:683px;letter-spacing:-0.26px;word-spacing:0.21px;}
#t9_1{left:542px;bottom:95px;letter-spacing:-0.37px;word-spacing:0.08px;}
#ta_1{left:265px;bottom:95px;letter-spacing:-0.42px;}
#loadedTruck {
    left: 449px;
    bottom: 172px;
}
#Truck {
    left: 133px;
    bottom: 172px;
}
.s0_1{font-size:32px;font-family:Montserrat-Bold_3x;color:#000;}
.s1_1{font-size:23px;font-family:Montserrat-SemiBold_3-;color:#000;}
.s2_1{font-size:28px;font-family:Montserrat-Medium_2f;color:#000;}
</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts1" type="text/css" >

@font-face {
	font-family: Montserrat-Bold_3x;
	src: url("fonts/Montserrat-Bold_3x.woff") format("woff");
}

@font-face {
	font-family: Montserrat-Medium_2f;
	src: url("fonts/Montserrat-Medium_2f.woff") format("woff");
}

@font-face {
	font-family: Montserrat-SemiBold_3-;
	src: url("fonts/Montserrat-SemiBold_3-.woff") format("woff");
}

</style>
<!-- End embedded font definitions -->

<!-- Begin page background -->
<div id="pg1" style="-webkit-user-select: none;">
	<object width="909" height="1286" data="1/1.svg" type="image/svg+xml" id="pdf1" style="width:909px; height:1286px; -moz-transform:scale(1); z-index: 0;"></object>
</div>
<!-- End page background -->
<?php 
	//print_r($rowdata);exit;
?>
<!-- Begin text definitions (Positioned/styled in CSS) -->
<div class="text-container"><span id="t1_1" class="t s0_1"># <?php echo $rowdata['id']; ?>  </span>
<span id="t2_1" class="t s1_1">Customer : <?php echo $rowdata['company_name']; ?> </span>
<span id="t3_1" class="t s1_1">Date : <?php echo date('d/m/Y',strtotime($rowdata['pickup_date'])); ?></span>
<span id="t4_1" class="t s1_1">Vehicle registeration # : <?php echo $rowdata['truck_registration_number']; ?></span>
<span id="t5_1" class="t s1_1">District : <?php echo $rowdata['district']; ?></span>
<span id="t6_1" class="t s1_1">State : <?php echo $rowdata['state']; ?></span>
<span id="t7_1" class="t s1_1">Quantity : <?php echo $rowdata['net_quantity']; ?> Kg</span>
<span id="t8_1" class="t s1_1">Waste type : <?php echo $rowdata['title']; ?></span>
<span id="loadedTruck" class="t s1_1">
	<img src="https://zwindia.in/sub/epr/<?php echo $rowdata['loaded_truck_picture']; ?>" style="
	    border-radius: 50%;
	    height: 250px;
	">
</span>
<span id="Truck" class="t s1_1">
	<img src="https://zwindia.in/sub/epr/<?php echo $rowdata['truck_picture']; ?>" style="
	    border-radius: 50%;
	    height: 250px;
	">
</span>
<span id="t9_1" class="t s2_1">Loaded Truck </span><span id="ta_1" class="t s2_1">Truck </span></div>
<!-- End text definitions -->


</div>
</body>
</html>
