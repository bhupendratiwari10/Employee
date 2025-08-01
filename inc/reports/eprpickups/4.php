<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="utf-8" />
</head>

<body style="margin: 0;">

<div id="p4" style="overflow: hidden; position: relative; background-color: white; width: 909px; height: 1286px;">

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

#t1_4{left:100px;bottom:600px;letter-spacing:-0.07px;word-spacing:0.12px;}
#t2_4{left:507px;bottom:604px;letter-spacing:-0.08px;}
#t3_4{left:100px;bottom:1144px;letter-spacing:-0.07px;word-spacing:0.12px;}
#t4_4{left:507px;bottom:1148px;letter-spacing:-0.09px;}

.s0_4{font-size:32px;font-family:Montserrat-Medium_2f;color:#000;}
.s1_4{font-size:23px;font-family:Montserrat-Medium_2f;color:#000;}
</style>
<!-- End inline CSS -->

<!-- Begin embedded font definitions -->
<style id="fonts4" type="text/css" >

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

<div id="pg4" style="-webkit-user-select: none;"><object width="909" height="1286" data="4/4.svg" type="image/svg+xml" id="pdf4" style="width:909px; height:1286px; -moz-transform:scale(1); z-index: 0;"></object></div>
<!-- End page background -->


<!-- Begin text definitions (Positioned/styled in CSS) -->
<div class="text-container">
<span id="t1_4" class="t s0_4" data-mappings='[[18,"fi"]]'>Weigh bridge certiﬁcate </span><span id="t2_4" class="t s1_4">(Loaded) </span>
<span id="t3_4" class="t s0_4" data-mappings='[[18,"fi"]]'>Weigh bridge certiﬁcate </span><span id="t4_4" class="t s1_4">(Empty) </span>

	<span id="certificate-loaded" class="t s1_1">
		<img src="https://zwindia.in/sub/epr/<?php echo $rowdata['loaded_weigh_bridge_certificate_picture']; ?>" style="height: 450px;">
	</span>
	<span id="certificate-empty" class="t s1_1">
		<img src="https://zwindia.in/sub/epr/<?php echo $rowdata['weigh_bridge_certificate_picture']; ?>" style="height: 440px;">
	</span>
</div>
<!-- End text definitions -->


</div>
</body>
</html>
