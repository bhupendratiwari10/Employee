<?php
include('inc/function.php');

$con = dbCon();

if($_GET['fun']=='search_po'){
 
	$customer_id = $_GET['customer_id'];
	
	  $query = "select * from zw_epr_po where customer_id = $customer_id";
	  
	  $res = mysqli_query($con , $query);
	
	  $mainArray = [];
	  if(mysqli_num_rows($res) > 0){
	    while($row = mysqli_fetch_assoc($res)){
	      $temArray = [];
	      $temArray['id'] = $row['id'];
	      $mainArray[] = $temArray;
	    }
	    

	  }
	  echo json_encode($mainArray);

}else if($_GET['fun']=='get_qty'){
 
	$customer_id = $_GET['customer_id'];
	$po_no = $_GET['po_no'];
	$selectedCat = $_GET['selectedCat'];
	$selectedState=$_GET['selectedState'];
	$dateFrom = $_GET['dateFrom'];
	$dateTo = $_GET['dateTo'];
	
	$query = "select sum(net_quantity) as net_quantity from zw_pickups where client = $customer_id AND epr_invoice IS NULL AND po = $po_no AND category='$selectedCat' AND state LIKE '%$selectedState%' AND pickup_date BETWEEN '$dateFrom' AND '$dateTo'";
	  
	  $res = mysqli_query($con , $query);
	  $mainArray = [];
	  if(mysqli_num_rows($res) > 0){
	    while($row = mysqli_fetch_assoc($res)){
	      $temArray = [];
	      $temArray['net_quantity'] = $row['net_quantity'];
	      $mainArray[] = $temArray;
	    }
	    

	  }
	  echo json_encode($mainArray);

}else if($_GET['fun']=='get_invoice_id'){
 
	$query = "select id from zw_epr_invoices ORDER BY id DESC LIMIT 1";
	  $res = mysqli_query($con , $query);
	  $mainArray = [];
	   
	  if(mysqli_num_rows($res) > 0){
	    while($row = mysqli_fetch_assoc($res)){
	      $temArray = [];
	      $temArray['id'] = $row['id'];
	      $mainArray[] = $temArray;
	    }
	    

	  }else{
	    $temArray['id'] = 0;
	    $mainArray[] = $temArray;
	  }
	  echo json_encode($mainArray);

}else if($_GET['fun']=='download_cert'){
	$url = $_GET['url'];

	// Use cURL to fetch HTML content
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($ch);
	curl_close($ch);

	echo $html;
}

?>
