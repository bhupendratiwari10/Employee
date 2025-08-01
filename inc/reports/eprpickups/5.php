<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
</head>

<body style="margin: 0;">

<div id="p5" style="overflow: hidden; position: relative; background-color: white; width: 909px; height: 1286px;">

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

#t1_5{left:103px;bottom:599px;letter-spacing:0.04px;}
#t2_5{left:100px;bottom:1144px;letter-spacing:-0.05px;word-spacing:0.09px;}

.s0_5{font-size:32px;font-family:Montserrat-Medium_2f;color:#000;}
</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts5" type="text/css" >

@font-face {
	font-family: Montserrat-Medium_2f;
	src: url("fonts/Montserrat-Medium_2f.woff") format("woff");
}

#certificate-loaded {
    left: 50px;
    bottom: 90px;
}

#certificate-empty {
    top: 136px;
    left: 50px;
}
</style>
<!-- End embedded font definitions -->

<div id="pg5" style="-webkit-user-select: none;"><object width="909" height="1286" data="5/5.svg" type="image/svg+xml" id="pdf5" style="width:909px; height:1286px; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->


<!-- Begin text definitions (Positioned/styled in CSS) -->
<div class="text-container"><span id="t1_5" class="t s0_5">Delivery Challan </span>
<span id="t2_5" class="t s0_5">Truck reciept </span>

<span id="certificate-loaded" class="t s1_1">
		<img src="https://zwindia.in/sub/epr/<?php echo $rowdata['lorry_bill']; ?>" style="height: 450px;">
	</span>
	<span id="certificate-empty" class="t s1_1">
		<img src="https://zwindia.in/sub/epr/<?php echo $rowdata['truck_receipt']; ?>" style="height: 440px;">
	</span>

</div>
<!-- End text definitions -->


</div>
</body>
</html>
