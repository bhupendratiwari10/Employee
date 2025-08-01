 <?php 

//if (session_status() === PHP_SESSION_NONE) {
    session_start();
};
 
error_reporting(E_ALL);
ini_set('display_errors', 1);
 function dbCon(){
    $con = mysqli_connect("localhost","root","","tidy_rabbit");
    //mysqli_set_charset($con,"utf-8");
    return $con;
}


function checkLoggedin(){ 
    if (isset($_COOKIE["session"])) { redirect("dashboard.php");  exit(); }
}

function checkPermission($url){
    $con = dbCon();

    $user_role_id = $_COOKIE['user_role'];

// Constructing the SQL query
$query = "SELECT IF(FIND_IN_SET('$url', page_permissions) > 0, 1, 0) AS found FROM zw_user_roles WHERE id = $user_role_id";
    $result = mysqli_query($con, $query);
    if ($result) {
    $row = mysqli_fetch_assoc($result);
    $found = $row['found'];
    if($found > 0){
        return true;
    }
    return 0;
} else {
    // Handle query error
    return 0;
}

}

function checklogin(){
    if (!isset($_COOKIE["session"])) { redirect("login.php");  exit(); }
    if (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'logged_in') {
	    // User is logged in
	    // Reset the cookie expiration time
	    setcookie('user_login', 'logged_in', time() + (45*60));
	} else {
	    // User is not logged in, perform logout or redirect
	    //session_destroy();
	    $cookies = $_COOKIE;
	    foreach ($cookies as $cookie_name => $cookie_value) {
		setcookie($cookie_name, '', time() - 3600, '/');
		setcookie($cookie_name, '', time() - 3600, '/sub/epr');
	    }
	    redirect("login.php");
	}
}


function createLogin($uid,$unm,$session_id , $userRole){
    setcookie("session",$session_id); 
    setcookie("username",$unm);
    setcookie('user_login', 'logged_in', time() + 45);
    setcookie('user_role' , $userRole);
    //setcookies("session",$session_id);
    //setcookies("username",$unm);
}

function dataGet($q){
    $con = dbCon();  $q = $_REQUEST[$q];
    $q = htmlentities($q);
    return $q;
}

function checkPrint($type, $var, $dbtable) {
    $type = $conn->real_escape_string($type);
    $query = "SELECT 1 FROM $dbtable WHERE $var = '$type' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    return mysqli_num_rows($result) > 0;
}


function acOptions($atype=''){
    $con = dbCon();
    if($atype == 'received'){
        $bankQuery = 'SELECT * FROM zw_account_types WHERE title = "Cash" OR title = "Bank" OR title = "Other Current Liability" ORDER BY title ASC';
    }
    else if($atype == 'made'){
        $bankQuery = 'SELECT * FROM zw_account_types WHERE title = "Cash" OR title = "Bank" OR title = "Other Current Liability" or title = "Equity" or title = "Other Current Asset" ORDER BY title ASC';
    }else if($atype == 'paid_throw'){
        $bankQuery = 'SELECT * FROM zw_account_types WHERE (title = "Cash" OR title = "Bank" OR title = "Other Current Liability" or title = "Other Current Asset" or title="Fixed Asset" or title="Equity" or title="Long Term Liability") AND collection != "Expense" ORDER BY title ASC';
    }else if($atype == 'expense'){
        $bankQuery = 'SELECT * FROM zw_account_types WHERE collection = "Expense" ORDER BY collection ASC';
    }
    else {
        $bankQuery = 'SELECT * FROM zw_account_types  ORDER BY title ASC';
    }
     $nn = mysqli_query($con, $bankQuery);
 while($vnx=mysqli_fetch_assoc($nn)){ $aid=$vnx['id'];
        $bb = mysqli_query($con,"SELECT * FROM zw_accounts WHERE account_type=$aid"); $bnk = mysqli_num_rows($bb);
            if($bnk>0){
                echo"<option disabled>".$vnx['title']."</option>";
                optionPrintAdv("zw_accounts WHERE account_type=$aid","id","account_name", "$atype");
                echo"<option disabled></option>";
                }
            }
}


function redirect($url){
    header("Location: $url");
    echo"<script>window.location.replace('$url');</script>";
}


function verfD($con, $tb, $at, $val){
    $query = "SELECT `id` FROM `$tb` WHERE `$at`='$val'"; 
    $kl = mysqli_query($con,$query); $nl = mysqli_num_rows($kl);
    if($nl==0){return 0;}else{return 1;}
}


function currentURL(){
    $url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $url;
}


function optionPrint($var , $selectedID = ''){
    $con = dbCon();
    $query = "SELECT id,title FROM $var"; $k = mysqli_query($con,$query); while($ax = mysqli_fetch_assoc($k)){ $idx = $ax['id']; $ttx = $ax['title'];
   
    if(!empty($selectedID) && $selectedID == $idx)  {
      echo"<option value='$idx' selected>$ttx</option>";  
    } 
   else{ 
   echo"<option value='$idx'>$ttx</option>";  
   }

}}


function optionPrintAdv($tb,$var1,$var2, $selectedID=''){
    $con = dbCon();
  
    $query = "SELECT $var1,$var2 FROM $tb"; $k = mysqli_query($con,$query); while($ax = mysqli_fetch_assoc($k)){ $idx = $ax[$var1]; $ttx = $ax[$var2];
    if(!empty($selectedID) && $selectedID == $idx)  {
      echo"<option value='$idx' selected>$ttx</option>";  
    } 
   else{ 
   echo"<option value='$idx'>$ttx</option>";  
   }
}}


function optionPrintAdvx($tb,$var1,$var2,$var3 , $selectedID=''){
    $con = dbCon();
    $query = "SELECT $var1,$var2 FROM $tb"; $k = mysqli_query($con,$query); while($ax = mysqli_fetch_assoc($k)){ $idx = $ax[$var1]; $ttx = $ax[$var2];
    if(!empty($selectedID) && $selectedID == $idx)  {
        
      echo"<option value='$idx' selected>$var3$ttx</option>";  
    }else{
    echo"<option value='$idx'>$var3$ttx</option>";
    }
}}


function uploadImage($inputName, $subFolder){
    global $uploadDir;
    if ($_FILES[$inputName]["error"] == 0) {
        $fileName = $_FILES[$inputName]["name"];
        $tempName = $_FILES[$inputName]["tmp_name"];
        
        $uniqueID = uniqid();
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = $uniqueID . "_" . $fileName;
        
        if (move_uploaded_file($tempName, $uploadDir . $subFolder . "/" . $newFileName)) {
            return $uploadDir . $subFolder . "/" . $newFileName;
        } else {
            return "";
        }
    } else {
        return "";
    }
}




function titlebyId($id,$var){
    $con = dbCon();
    $query = "SELECT title FROM $var WHERE `id`='$id'"; 
    $k = mysqli_query($con,$query);
    $ax = mysqli_fetch_assoc($k); 
    $ttx = $ax['title'];
    return $ttx; 
}
function namebyAid($id,$var,$tb){
    $con = dbCon();
     $query = "SELECT $var FROM $tb WHERE `id`='$id'"; 
    $k = mysqli_query($con,$query); 
    $ax = mysqli_fetch_assoc($k); 
    $ttx = $ax[$var];
   
    return $ttx; 
}

function valByVal($tbv,$val2,$var,$tb){
    $con = dbCon();
    $query = "SELECT $var FROM $tb WHERE `$tbv`='$val2'"; 
    $k = mysqli_query($con,$query); 
    $ax = mysqli_fetch_assoc($k); 
    $ttx = $ax[$var];
    return $ttx; 
}

function hitQuery($query , $var1 , $var2){
    $con = dbCon();
    $k = mysqli_query($con,$query); while($ax = mysqli_fetch_assoc($k)){ $idx = $ax[$var1]; $ttx = $ax[$var2];
    if(!empty($selectedID) && $selectedID == $idx)  {
      echo"<option value='$idx' selected>$ttx</option>";  
    } 
   else{ 
   echo"<option value='$idx'>$ttx</option>";  
   }
    
}
}

function getdbVal($id,$var,$tb){
    $con = dbCon();
    $query = "SELECT $var FROM $tb WHERE id=$id"; 
    $k = mysqli_query($con,$query); 
    $ax = mysqli_fetch_assoc($k); 
    $ttx = $ax[$var];
    echo $ttx; 
}


function filterILink($link){
    $vv = str_replace("http"," ",$link);
    $base = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    if($vv==$link){$link = $base."/".$link;}
    return $link;
}


function maxId($key1){
    $con = dbCon();
    $query = mysqli_query($con,"SELECT id FROM `$key1` ORDER BY id DESC");
    $num = mysqli_fetch_assoc($query); $jj = $num['id'];
    return $jj;
}



function countRows($key1){
    $con = dbCon();
    $query = mysqli_query($con,"SELECT id FROM $key1");
    $num = mysqli_num_rows($query);
    return $num;
}



function userIP(){
    $myip = $_SERVER['REMOTE_ADDR'];
    return $myip;
}


function uniQue($num){
    $rand = rand(000000,999999);$r2 = base64_encode($rand);
    $rand2 = rand(000000,999999);$r3 = base64_encode($rand);
    $r4 = $rand/$rand2; $r4 = $r4.$r2.$r3; $r4 = substr($r4,0,$num);
    return $r4;
}

function alert($q){
    echo"<script>alert('$q')</script>";
}


function setcookies($name,$val){
    echo"<script>document.cookie='$name=$val'; path=/;</script>";
}



function unsetcookies($name) {
    echo "<script>document.cookie = '$name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';</script>";
}



function getOS() { 
    global $user_agent;
    $os_platform  = "Unknown OS Platform";
    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );
    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;
            return $os_platform;
}


function getBrowser() {
    global $user_agent;
    $browser        = "Unknown Browser";
    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/torch/i'     => 'Torch',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/rockmelt/i' => 'RockMelt',
                            '/mobile/i'    => 'Handheld Browser'
                     );
    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
        $browser = $value;
        return $browser;
}


function getUserDetails($userID){
    if($userID){
        
$con = dbCon(); $query = "SELECT first_name, last_name FROM zw_user where id = $userID"; 
$result = mysqli_query($con, $query);   $result = mysqli_fetch_assoc($result);
$customerName = $result['first_name']." ".$result['last_name'];
return $customerName;
    }
    return "No Record";
}
function billDetails(){
if(isset($_GET['customer_id'])){
$customer_id = $_GET['customer_id'];
 // Get Bill Details
  $query = "Select * from zw_Bill where customer_id = $customer_id and status = 1";
  $con = dbCon;
  $res = mysqli_query($con , $query);
  if(mysqli_num_rows($res) > 1){
    $mainArray = [];
  while($row = mysqli_fetch_assoc($res)){
    $temArray = [];
    $temArray['bill_amount'] = $row['bill_amount'];
     $temArray['bill_date'] = $row['bill_date'];
     $temArray['id'] = $row['id'];
     $temArray['order_id'] = $row['order_id'];
     $temArray['sales_person'] = $row['sales_person'];
    $mainArray[] = $temArray;
  }
    echo json_encode($mainArray);
    return;
  }
}
  else{
  echo json_encode(0);
    return;
  }
}

// Function For General Query
function generalQuery($query){
    $con = dbCon();
  $res = mysqli_query($con , $query);
  return $res;
  if(mysqli_num_rows($res) >= 1){
      return $res;
  }
  else{
      return '';
  }
    
}




?>