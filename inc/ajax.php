 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
  function dbCon()
  {
    $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
    //mysqli_set_charset($con,"utf-8");
    return $con;
  }


function namebyAid($id, $var, $tb)
{
    $con = dbCon();
    $query = "SELECT $var FROM $tb WHERE `id`='$id'";
    $k = mysqli_query($con, $query);
    $ax = mysqli_fetch_assoc($k);
    $ttx = $ax[$var];

    return $ttx;
}


  if (isset($_POST['customer_id']) && isset($_POST['customer_type'])) {

    $customer_id = $_POST['customer_id'];
    $customer_type = $_POST['customer_type'];

    if ($customer_type == 'vendor') {
      // Get Bill Details
      $query = "Select * from zw_Bill where customer_id = $customer_id and status = 1";

      $con = dbCon();
      $res = mysqli_query($con, $query);

      if (mysqli_num_rows($res) >= 1) {
        $mainArray['data'] = [];
        $total = 0;
        while ($row = mysqli_fetch_assoc($res)) {
          $temArray = [];
          $temArray['bill_amount'] = $row['subTotal'];
          $total += $row['subTotal'];
          $temArray['bill_date'] = $row['bill_date'];
          $temArray['id'] = $row['id'];
          $temArray['subject'] = $row['subject'];
          $temArray['amount_due'] = $row['amount_due'];
          //$query = "Select customer_display_name from zw_customers where customer_id = $customer_id and status = 1";
          //$res = mysqli_query($con , $query);
          //$res = mysqli_fetch_assoc($res);
          $temArray['sales_person'] = $row['sales_person'];
          $mainArray['data'][] = $temArray;
        }
        $mainArray['total'] = $total;
      }
    } else if ($customer_type == 'customer') {

      $query = "Select * from zw_invoices where customer_id = $customer_id and status = 1";
      $con = dbCon();
      $res = mysqli_query($con, $query);

      if (mysqli_num_rows($res) >= 1) {
        $mainArray['data'] = [];
        $total = 0;
        while ($row = mysqli_fetch_assoc($res)) {
          $temArray = [];
          $total += $row['subTotal'];
          $temArray['bill_amount'] = $row['subTotal'];
          $temArray['bill_date'] = $row['invoice_date'];
          $temArray['id'] = $row['id'];
          $temArray['order_id'] = $row['p_o'];
          $temArray['discount'] = $row['inv_discount'];
          $temArray['sales_person'] = $row['sales_person'];
          $mainArray['data'][] = $temArray;
        }
        $mainArray['total'] = $total;
      }
      
      $query = "Select * from zw_epr_invoices where customer_id = $customer_id and status = 1";
      $res = mysqli_query($con, $query);

      if (mysqli_num_rows($res) >= 1) {
        $mainArrayy['data'] = [];
        $total = 0;
        while ($row = mysqli_fetch_assoc($res)) {
          $temArray = [];
          $total += $row['subTotal'];
          $temArray['bill_amount'] = $row['subTotal'];
          $temArray['bill_date'] = $row['invoice_date'];
          $temArray['id'] = "EPR-".$row['id'];
          $temArray['order_id'] = $row['po_id'];
          $temArray['discount'] = $row['inv_discount'];
          $temArray['sales_person'] = "";
          $mainArray['data'][] = $temArray;
        }
        $mainArrayy = $total;
      }
    }
    echo json_encode($mainArray);
    return;
  }


  if (isset($_POST['type'])) {

    if ($_POST['type'] == "bill") {

      $query = "SELECT YEAR(bill_date) AS year, MONTH(bill_date) AS month, SUM(bill_amount) AS total_amount FROM zw_Bill GROUP BY YEAR(bill_date), MONTH(bill_date) ORDER BY year, month LIMIT 12";
      $con = dbCon();
      $res = mysqli_query($con, $query);
      $array = [];
      while ($row = mysqli_fetch_assoc($res)) {
        $temp = [];
        $temp['year'] = $row['year'];
        $monthValue = $row['month'];

        // Convert the numeric value to a month name
        $monthName = date("F", mktime(0, 0, 0, $monthValue, 1));

        $temp['month'] = $monthName;
        $temp['total_amount'] = $row['total_amount'];
        $array[] = $temp;
      }
      echo json_encode($array);
      return;
    }
    
    // getting state data based on ulb
     else if ($_POST['type'] == "ulb") {
        $id = $_POST['value'];
      $query = "SELECT state FROM zw_ulb WHERE id = $id";
      $con = dbCon();
      $res = mysqli_query($con, $query);
      $array = [];
      while ($row = mysqli_fetch_assoc($res)) {
       $state = $row['state'];
      }
      echo $state;
      return;
    }
    
    // getting state data based on ulb
     else if ($_POST['type'] == "client") {
        $id = $_POST['value'];
      $query = "SELECT id FROM zw_epr_po WHERE customer_id = $id";
      $con = dbCon();
      $res = mysqli_query($con, $query);
      $array = [];
      $ret = '<option value="">Select a P/O #</option>';

      while ($row = mysqli_fetch_assoc($res)) {
        $ret .= '<option value="' . $row['id'] . '">' . "#ZW-000R-".$row['id'] . '</option>';
       }
      echo $ret;
      return;
    }
  }
  // aJAX for payment received and payment made details
  if (isset($_POST['payment_details'])) {
    $customer_id = $_POST['vendor_id'];

    // Ensure to use single quotes around 'received' if it's a string value in your database.
    if (isset($_POST['payment_type'])) {
      $type = $_POST['payment_type'];
      // You should use single quotes around 'received' since it's a string value.
      $query = "SELECT * FROM zw_payment_made WHERE vendor_id = $customer_id AND payment_type = '$type'";

      // Assuming you have a function dbCon() to establish a database connection.
      $con = dbCon();

      // Execute the SQL query.
      $res = mysqli_query($con, $query);

      if ($res) {
        // Initialize an empty array to store the results.
        $results = array();

        while ($row = mysqli_fetch_assoc($res)) {
          // Append each row to the results array.
          if($type!='made'){$row['customer'] = namebyAid($row['vendor_id'],"customer_display_name","zw_customers");}else{$row['customer'] = namebyAid($row['vendor_id'],"vendor_display_name","zw_company");}
          $results[] = $row;
        }

        // Encode the results array as JSON and send it back as a response.
        echo json_encode($results);
      } else {
        // Handle any database errors here.
        echo json_encode(array('error' => 'Database query failed.'));
      }
    } else {
      // Handle the case when payment_type is not 'received'.
      echo json_encode(array('error' => 'Invalid payment_type.'));
    }
  }
  // print_r($_POST);die;



  if (isset($_POST['key'])) {
   $con = dbCon();
    if ($_POST['flag'] == 0) { // First Time next button click


      unset($_POST['flag']); // Remove Flag Key
      unset($_POST['key']);
      unset($_POST['id']);
      $insertArray = $_POST;
      $keys = [];
      $values = [];
      foreach ($insertArray as $key => $val) {

      
        if (!empty($insertArray[$key]) && $insertArray[$key] != 'null') {
          $keys[] = $key;
          $values[] = $insertArray[$key];
        }
      }
      $columns = implode(', ', $keys);
      $values = implode("', '", $values);
     
      $query = "INSERT INTO zw_pickups ($columns) VALUES ('$values')";
    //   echo json_encode($query);die;
   
      $exec = mysqli_query($con , $query);
      
      $latestEntryQuery = "SELECT id FROM zw_pickups  ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($con, $latestEntryQuery); // Latest Data 

   if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    echo json_encode($id); // Return ID So that Next Time Update Query Can be execute
     } 
    } 
    else {
      // Update Other Time 
      unset($_POST['flag']); // Remove Flag Key
      unset($_POST['key']);
      $id = $_POST['id'];
      $id = $id;
      unset($_POST['id']);
      
      $insertArray = $_POST;
      
     
      $setClause = '';
      if(isset($_FILES['imageData'])){
          
          $imageName = $insertArray['imageName'];
          $imageFile = $_FILES['imageData']['error'];
        //   print_r($imageFile);die;
          unset($insertArray['imageData']);
          unset($insertArray['imageName']);
        
         $image_path =  uploadImage('imageData' , 'uploads/pickups');
        
         if(!empty($image_path)){
             
         }
        
      }
  
      foreach ($insertArray as $key => $val) {
        if (!empty($insertArray[$key])) {
          $setClause .= "$key = '$insertArray[$key]', ";
        }
      }
      $setClause = rtrim($setClause, ', '); // Remove the trailing comma and space

      $query = "UPDATE zw_pickups SET $setClause  WHERE id = $id";
      
      $exec = mysqli_query($con , $query);
      if(!empty($imageName)){
         $query = "UPDATE zw_pickups SET $imageName = '$image_path'  WHERE id = $id";
        
      $exec = mysqli_query($con , $query);
      }
      echo json_encode($id); // Return ID So that Next Time Update Query Can be execute
      
    }
  }

function uploadImage($inputName, $subFolder){
    global $uploadDir;
    if ($_FILES[$inputName]["error"] == 0) {
        $fileName = $_FILES[$inputName]["name"];
        $tempName = $_FILES[$inputName]["tmp_name"];
        
        $uniqueID = uniqid();
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = $uniqueID . "_" . $fileName;
        
        $uploadDirectory = FULL_PATH."/sub/epr/".$subFolder . "/" . $newFileName;
        if (move_uploaded_file($tempName, $uploadDirectory)) {
            return $uploadDir . $subFolder . "/" . $newFileName;
        } else {
            return "";
        }
    } else {
        return "";
    }
}


  ?>