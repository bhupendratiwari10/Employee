<?php

include('inc/function.php');

$con = dbCon();  
$fun = $_GET['fun']; 
//$cond = $_GET['cond'];


if($fun=='getusers'){

    $query = "SELECT id, username, first_name, last_name, email, phone_no FROM zw_user";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getjournal'){

    $query = "SELECT * FROM zw_journal";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getcategories'){

    $query = "SELECT * FROM zw_pickup_categories";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getcerts'){

    $query = "SELECT id, username, first_name, last_name, email, phone_no FROM zw_user";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getcompany'){

    $query = "SELECT * FROM zw_company";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='expense'){

    $query = "SELECT * FROM zw_expense";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
    
        $row['account'] = namebyAid($row['acc'],"account_name","zw_accounts");
        $row['paid_throw'] = namebyAid($row['paid_throw'],"account_name","zw_accounts");

        $data[] = $row;
    }
    
    
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getcustomers'){

    $query = "SELECT * FROM zw_customers where status=1";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getitems'){

    $query = "SELECT id, name, selling_price_description, sku, selling_price, hsn_code, unit FROM zw_items";  
    $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
   
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getprice'){

    $query = "SELECT id, name, item_rate, description FROM zw_price";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getulbs'){

    $query = "SELECT id,title, monthly_waste, state, district, mrfs FROM zw_ulb";  $result = mysqli_query($con, $query);
    
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getInvoice'){
    error_reporting(E_ALL);
ini_set('display_errors', '1');


    $query = "SELECT * FROM zw_invoices";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
      $row['customer_name'] = namebyAid($row['customer_id'],"customer_display_name","zw_customers");
      if($row['customer_name'] == null || $row['customer_name'] ==''){
          $row['customer_name']="No Details";
      }
      
      $row['salesPerson_name'] = getUserDetails($row['sales_person']);
       $data[] = $row;
    }
    mysqli_close($con);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
    echo json_encode(['data' => $data]);
}

elseif($fun=='getEPRInvoice'){
    error_reporting(E_ALL);
ini_set('display_errors', '1');


    $query = "SELECT * FROM zw_epr_invoices";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
      $row['customer_name'] = namebyAid($row['customer_id'],"customer_display_name","zw_customers");
      if($row['customer_name'] == null || $row['customer_name'] ==''){
          $row['customer_name']="No Details";
      }
       if($row['status'] == "1"){$row['status'] ="Unpaid";}else{$row['status'] ="Paid";}
       $row['invoice_date']= date('d/m/Y',strtotime($row['invoice_date']));
       $row['due_date']= date('d/m/Y',strtotime($row['due_date']));
       $data[] = $row;
    }
    mysqli_close($con);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
    echo json_encode(['data' => $data]);
}

elseif($fun=='getQuotes'){

    $query = "SELECT * FROM zw_Quote";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
        
      $row['customer_name'] = namebyAid($row['customer_id'],"customer_display_name","zw_customers");
      
      $row['salesPerson_name'] = getUserDetails($row['sales_person']);
       $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
    
} elseif($fun=='getBills'){

    $query = "SELECT * FROM zw_Bill";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
        
      $row['customer_name'] = namebyAid($row['customer_id'],"company_name","zw_company");
      
      $row['salesPerson_name'] = getUserDetails($row['sales_person']);
       $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}


elseif($fun=='getPickups'){

    $query = "SELECT * FROM zw_pickups";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
        
      $row['supervisor'] = getUserDetails($row['supervisor']); 
      
      $row['client'] = namebyAid($row['client'],"customer_display_name","zw_customers");
      
      $row['ulbname'] = namebyAid($row['ulb'],"title","zw_ulb");
     
      $row['states'] = namebyAid($row['ulb'],"state","zw_ulb");
      
      $row['truck_registration_number'] = $row['truck_registration_number'];
      
      $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getAccounts'){

    $query = "SELECT * FROM zw_accounts";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
        
      $row['account_type'] = namebyAid($row['account_type'],"title","zw_account_types");
      
      $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getAccountsx'){

    $query = "SELECT * FROM zw_accounts WHERE account_type='4' OR account_type='9' OR account_type='3'";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
        
      $row['account_type'] = namebyAid($row['account_type'],"title","zw_account_types").", Type: ".namebyAid($row['account_type'],"collection","zw_account_types");
      
      $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getOrders'){

    $query = "SELECT * FROM zw_epr_po";  $result = mysqli_query($con, $query);
    
    $data = array();
	
    while ($row = mysqli_fetch_assoc($result)) {
        
      $row['po_date'] = $formattedDate = date('d-m-Y', strtotime($row['po_date']));
      $row['customer_id'] = namebyAid($row['customer_id'],"customer_display_name","zw_customers");
      
       $data[] = $row;
    }
    mysqli_close($con);
    echo json_encode(['data' => $data]);
}

elseif($fun=='getEPRInvoiceforReport'){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $period = $_GET['period'];
    $customer_id = $_GET['customer_id'];
    $pickup_categories = $_GET['pickup_categories'];
    // Determine the appropriate date range based on the selected period
    switch ($period) {
        case 'quarterly':
            // Get data for the current quarter
            $start_date = date('Y-m-d', strtotime('first day of this quarter'));
            $end_date = date('Y-m-d', strtotime('last day of this quarter'));
            break;
        case 'half_yearly':
            // Get data for the current half-year
            $start_date = date('Y-m-d', strtotime('first day of January'));
            $end_date = date('Y-m-d', strtotime('last day of June'));
            break;
        case 'yearly':
            // Get data for the current year
            $start_date = date('Y-m-d', strtotime('first day of January'));
            $end_date = date('Y-m-d', strtotime('last day of December'));
            break;
        default:
            // Default to yearly data
            $start_date = date('Y-m-d', strtotime('first day of January'));
            $end_date = date('Y-m-d', strtotime('last day of December'));
    }

    if($pickup_categories > 0){
    	$query = "SELECT zw_epr_invoices.* FROM zw_epr_invoices INNER JOIN zw_epr_invoice_items ON zw_epr_invoices.id = zw_epr_invoice_items.invoice_id WHERE zw_epr_invoices.customer_id='$customer_id' AND zw_epr_invoices.invoice_date BETWEEN '$start_date' AND '$end_date' AND zw_epr_invoice_items.category='$pickup_categories' ";

    }else{
    	$query = "SELECT * FROM zw_epr_invoices WHERE customer_id='$customer_id' AND invoice_date BETWEEN '$start_date' AND '$end_date'";

    }
    
    $result = mysqli_query($con, $query);
    
    $data = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
      $row['customer_name'] = namebyAid($row['customer_id'],"customer_display_name","zw_customers");
      if($row['customer_name'] == null || $row['customer_name'] ==''){
          $row['customer_name']="No Details";
      }
       $row['invoice_date']= date('d/m/Y',strtotime($row['invoice_date']));
       $row['due_date']= date('d/m/Y',strtotime($row['due_date']));
       $data[] = $row;
    }
    mysqli_close($con);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
    echo json_encode(['data' => $data]);
}

?>