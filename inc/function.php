<?php
ob_start();
// Start output buffering to prevent header issues
if (ob_get_level() == 0) ob_start();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting configuration
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');

/**
 * Database connection
 */
function dbCon() {
    static $con = null;
    
    if ($con === null) {
        $con = mysqli_connect("localhost", "u984874713_zwindia_root", "UEws49t2iM@EhAa", "u984874713_zwindia_soft");
        
        if (!$con) {
            error_log("Database connection failed: " . mysqli_connect_error());
            die("Database connection error. Please try again later.");
        }
        
        // Set charset to avoid encoding issues
        mysqli_set_charset($con, "utf8mb4");
    }
    
    return $con;
}

/**
 * Check if already logged in (for login page)
 */
function checkLoggedin() {
    if (isset($_COOKIE["session"])) {
        redirect("dashboard.php");
        exit();
    }
}

/**
 * Check if user is logged in
 */
function checklogin() {
    if (!isset($_COOKIE["session"])) {
        redirect("login.php");
        exit();
    }
    if (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'logged_in') {
        // User is logged in
        // Reset the cookie expiration time using PHP instead of JavaScript
        setcookie('user_login', 'logged_in', time() + (45 * 60), '/');
    } else {
        // User is not logged in, perform logout or redirect
        $cookies = $_COOKIE;
        foreach ($cookies as $cookie_name => $cookie_value) {
            setcookie($cookie_name, '', time() - 3600, '/');
        }
        redirect("login.php");
    }
}

/**
 * Create login session
 */
function createLogin($uid, $unm, $session_id, $userRole) {
    // Set cookies using PHP
    setcookie("session", $session_id, 0, '/');
    setcookie("username", $unm, 0, '/');
    setcookie('user_login', 'logged_in', time() + (45 * 60), '/');
    setcookie('user_role', $userRole, 0, '/');
    
    // Store in session as backup
    $_SESSION['user_id'] = $uid;
    $_SESSION['username'] = $unm;
    $_SESSION['user_role'] = $userRole;
    
    redirect("dashboard.php");
}

/**
 * Safe redirect function
 */
function redirect($url) {
    // If headers already sent, use JavaScript
    if (headers_sent()) {
        echo "<script>window.location.replace('" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "');</script>";
    } else {
        header("Location: $url");
        exit();
    }
}

/**
 * GST Treatment Options
 */
function gstTreatmentOptions($title='') {
    $options = array(
        "Registered Business - Regular" => "Business that is registered under GST",
        "Registered Business - Composition" => "Business that is registered under the composition scheme in GST",
        "Unregistered Business" => "Business that has not been registered under GST",
        "Consumer" => "A customer who is a regular consumer",
        "Overseas" => "Person with whom you do import or export outside India",
        "Special Economic Zone" => "Business (Unit) that is located in Special Economic Zone (SEZ) of India or a SEZ Developer",
        "Deemed Export" => "Supply of goods to an Export Oriented Unit or against Advanced Authorization/Export Promotion Capital Goods",
        "Non-GST Supply" => "Transactions with supplies that do not attract GST",
        "Out of Scope" => "Transactions that do not come under the ambit of GST",
        "Tax Deductor" => "Departments of State/Central government, governmental agencies or local authorities",
        "SEZ Developer" => "A person/organisation who owns at least 26% of equity in creating business units in a Special Economic Zone (SEZ)"
    );

    $output = '';
    foreach ($options as $value => $description) {
        if($value==$title){$lol="selected";}else{$lol='';}
        
        $output .= "<option $lol value='" . htmlspecialchars($value) . "'>" . htmlspecialchars($value) . "</option>";
        $output .= "<option disabled>" . htmlspecialchars($description) . "</option>";  
        $output .= "<option disabled></option>";
    }   
    echo $output;
}

/**
 * Update all accounts or specific account
 */
function updateAccounts($id='') { 
    $con = dbCon();
    if (empty($id)) {
        $query = "SELECT id FROM zw_accounts";
        $res = mysqli_query($con, $query);

        while ($account = mysqli_fetch_assoc($res)) {
            $currentId = $account['id'];
            updateAccountBalance($currentId); 
        }
    } else {
        updateAccountBalance($id); 
    }
}

/**
 * Update individual account balance
 */
function updateAccountBalance($id) {
    $tt = 0; //initial total value
    $con = dbCon();
    
    // Validate ID
    if (!is_numeric($id) || $id <= 0) {
        error_log("Invalid account ID provided: " . $id);
        return false;
    }
    
    // Escape the ID to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);
    
    // Calculate from payment_made table (paid_through)
    $query1 = "SELECT * FROM `zw_payment_made` WHERE paid_through='$id'";
    $kl = mysqli_query($con, $query1);
    
    if ($kl === false) {
        error_log("Query failed: " . mysqli_error($con) . " - Query: " . $query1);
        return false;
    }
    
    while($nala = mysqli_fetch_assoc($kl)){ 
        $inrval = $nala['payment_made'];
        $tt = $tt - $inrval;
    } 
    
    // Calculate from payment_made table (deposit_to)
    $query2 = "SELECT * FROM `zw_payment_made` WHERE deposit_to='$id'";
    $kl = mysqli_query($con, $query2);
    
    if ($kl === false) {
        error_log("Query failed: " . mysqli_error($con) . " - Query: " . $query2);
        return false;
    }
    
    while($nala = mysqli_fetch_assoc($kl)){ 
        $inrval = $nala['payment_made'];
        $tt = $tt + $inrval;
    } 

    // Calculate from expense table (paid_throw)
    $query3 = "SELECT * FROM `zw_expense` WHERE paid_throw='$id'";
    $kil = mysqli_query($con, $query3);
    
    if ($kil === false) {
        error_log("Query failed: " . mysqli_error($con) . " - Query: " . $query3);
        return false;
    }
    
    while($naila = mysqli_fetch_assoc($kil)){ 
        $inrvall = $naila['amount'];
        $tt = $tt - $inrvall;
    } 
    
    // Calculate from expense table (acc)
    $query4 = "SELECT * FROM `zw_expense` WHERE acc='$id'";
    $kil = mysqli_query($con, $query4);
    
    if ($kil === false) {
        error_log("Query failed: " . mysqli_error($con) . " - Query: " . $query4);
        return false;
    }
    
    while($naila = mysqli_fetch_assoc($kil)){ 
        $inrvall = $naila['amount'];
        $tt = $tt + $inrvall;
    }
    
    // Calculate from journal items
    $query5 = "SELECT * FROM `zw_journal_items` WHERE account_id='$id'";
    $kils = mysqli_query($con, $query5);
    
    if ($kils === false) {
        error_log("Query failed: " . mysqli_error($con) . " - Query: " . $query5);
        return false;
    }
    
    while($nala = mysqli_fetch_assoc($kils)){ 
        $debit = $nala['debit']; 
        $credit = $nala['credit'];
        $tt = $tt + $debit; 
        $tt = $tt - $credit;
    }
    
    // Update the balance
    $updateQuery = "UPDATE zw_accounts SET closing_balance='$tt' WHERE id = '$id'";
    $updateResult = mysqli_query($con, $updateQuery);
    
    if ($updateResult === false) {
        error_log("Update failed: " . mysqli_error($con) . " - Query: " . $updateQuery);
        return false;
    }
    
    // Output jQuery update only if jQuery is loaded
    echo "<script>if(typeof $ !== 'undefined'){ $('#ttl').text('$tt'); }</script>";
    
    return true;
}

/**
 * Check user permissions
 */
function checkPermission($url) {
    $con = dbCon();

    if (!isset($_COOKIE['user_role'])) {
        return false;
    }

    $user_role_id = $_COOKIE['user_role'];
   
    // Constructing the SQL query with proper escaping
    $user_role_id = mysqli_real_escape_string($con, $user_role_id);
    $url = mysqli_real_escape_string($con, $url);
    
    $query = "SELECT IF(FIND_IN_SET('$url', page_permissions) > 0, 1, 0) AS found FROM zw_user_roles WHERE id = '$user_role_id'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $found = $row['found'];
        if ($found > 0) {
            return true;
        }
        return false;
    } else {
        // Handle query error
        return false;
    }
}

/**
 * Get data from request
 */
function dataGet($q) {
    if (isset($_REQUEST[$q])) {
        return htmlentities($_REQUEST[$q]);
    }
    return '';
}

/**
 * Check if value exists in database
 */
function checkPrint($type, $var, $dbtable) {
    $con = dbCon();
    $type = mysqli_real_escape_string($con, $type);
    $var = mysqli_real_escape_string($con, $var);
    $dbtable = mysqli_real_escape_string($con, $dbtable);
    
    $query = "SELECT 1 FROM $dbtable WHERE $var = '$type' LIMIT 1";
    $result = mysqli_query($con, $query);

    return mysqli_num_rows($result) > 0;
}

/**
 * Account options with advanced filtering
 */
function acOptionsAdv($atype = '', $id='') {
    $con = dbCon();
    $cond = '';
    
    if ($atype == 'received') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE title = "Cash" OR title = "Bank" OR title = "Other Current Liability" ORDER BY title ASC';
    } else if ($atype == 'made') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE title = "Cash" OR title = "Bank" OR title = "Other Current Liability" or title = "Equity" or title = "Other Current Asset" ORDER BY title ASC';
    } else if ($atype == 'paid_throw') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE (title = "Cash" OR title = "Bank" OR title = "Other Current Liability" or title = "Other Current Asset" or title="Fixed Asset" or title="Equity" or title="Long Term Liability") AND collection != "Expense" ORDER BY title ASC';
    } else if ($atype == 'expense') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE collection = "Expense" ORDER BY collection ASC';  
        $cond = "AND id!='83' AND id!='84'";
    } else if ($atype == 'bills') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE (title = "Other Current Liability" or title = "Other Current Asset" or title="Fixed Asset" or title="Equity" or title="stock" or title="Long Term Liability" or title="Income" or title="Expense" or title="Cost of goods sold") ORDER BY collection ASC'; 
        $cond = "AND id!='83' AND id!='84'";
    } else {
        $bankQuery = 'SELECT * FROM zw_account_types  ORDER BY title ASC';
    }
    
    $nn = mysqli_query($con, $bankQuery);
    while ($vnx = mysqli_fetch_assoc($nn)) {
        $aid = $vnx['id'];
        $bb = mysqli_query($con, "SELECT * FROM zw_accounts WHERE account_type=$aid $cond");
        $bnk = mysqli_num_rows($bb);
        if ($bnk > 0) {
            echo "<option disabled>" . $vnx['title'] . "</option>";
            optionPrintAdv("zw_accounts WHERE account_type=$aid $cond", "id", "account_name", "$id");
            echo "<option disabled></option>";
        }
    }
}

/**
 * Account options
 */
function acOptions($atype = '') {
    $con = dbCon();
    $cond = '';
    
    if ($atype == 'received') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE title = "Cash" OR title = "Bank" OR title = "Other Current Liability" ORDER BY title ASC';
    } else if ($atype == 'made') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE title = "Cash" OR title = "Bank" OR title = "Other Current Liability" or title = "Equity" or title = "Other Current Asset" ORDER BY title ASC';
    } else if ($atype == 'paid_throw') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE (title = "Cash" OR title = "Bank" OR title = "Other Current Liability" or title = "Other Current Asset" or title="Fixed Asset" or title="Equity" or title="Long Term Liability") AND collection != "Expense" ORDER BY title ASC';
    } else if ($atype == 'expense') {
        $bankQuery = 'SELECT * FROM zw_account_types WHERE collection = "Expense" ORDER BY collection ASC';  
        $cond = "AND id!='83' AND id!='84'";
    } else {
        $bankQuery = 'SELECT * FROM zw_account_types  ORDER BY title ASC';
    }
    
    $nn = mysqli_query($con, $bankQuery);
    while ($vnx = mysqli_fetch_assoc($nn)) {
        $aid = $vnx['id'];
        $bb = mysqli_query($con, "SELECT * FROM zw_accounts WHERE account_type=$aid $cond");
        $bnk = mysqli_num_rows($bb);
        if ($bnk > 0) {
            echo "<option disabled>" . $vnx['title'] . "</option>";
            optionPrintAdv("zw_accounts WHERE account_type=$aid $cond", "id", "account_name", "$atype");
            echo "<option disabled></option>";
        }
    }
}

/**
 * Account types
 */
function acTypes($atype = ''){
    $con = dbCon(); 
    $bankQuery = 'SELECT * FROM zw_account_types GROUP BY collection ORDER BY id;';
    $nn = mysqli_query($con, $bankQuery);
    while ($vnx = mysqli_fetch_assoc($nn)) {
        $aid = $vnx['id']; 
        $acol = $vnx['collection'];
        echo "<option disabled>" . $acol . "</option>";
            
        $bb = mysqli_query($con, "SELECT * FROM zw_account_types WHERE collection='$acol'");
        $bnk = mysqli_num_rows($bb);
        if ($bnk > 0) {
            while($kkk = mysqli_fetch_assoc($bb)){ 
                if($atype==$kkk['id']){$nxx="selected";}else{$nxx="";}
                echo "<option value=".$kkk['id']." $nxx>".$kkk['title']."</option>";
            }
            echo "<option disabled></option>";
        }
    }
}

/**
 * Verify data exists
 */
function verfD($con, $tb, $at, $val) {
    $query = "SELECT `id` FROM `$tb` WHERE `$at`='$val'";
    $kl = mysqli_query($con, $query);
    $nl = mysqli_num_rows($kl);
    if ($nl == 0) {
        return 0;
    } else {
        return 1;
    }
}

/**
 * Get current URL
 */
function currentURL() {
    $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

/**
 * Print options from table
 */
function optionPrint($var, $selectedID = '') {
    $con = dbCon();
    $query = "SELECT id,title FROM $var";
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax['id'];
        $ttx = $ax['title'];

        if (!empty($selectedID) && $selectedID == $idx) {
            echo "<option value='$idx' selected>$ttx</option>";
        } else {
            echo "<option value='$idx'>$ttx</option>";
        }
    }
}

/**
 * Advanced option print
 */
function optionPrintAdv($tb, $var1, $var2, $selectedID = '') {
    $con = dbCon();

    $query = "SELECT $var1,$var2 FROM $tb";
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax[$var1];
        $ttx = $ax[$var2];
        if (!empty($selectedID) && $selectedID == $idx) {
            echo "<option value='$idx' selected>$ttx</option>";
        } else {
            echo "<option value='$idx'>$ttx</option>";
        }
    }
}

/**
 * Advanced option print with prefix
 */
function optionPrintAdvx($tb, $var1, $var2, $var3, $selectedID = '') {
    $con = dbCon();
    $query = "SELECT $var1,$var2 FROM $tb";
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax[$var1];
        $ttx = $ax[$var2];
        if (!empty($selectedID) && $selectedID == $idx) {
            echo "<option value='$idx' selected>$var3$ttx</option>";
        } else {
            echo "<option value='$idx'>$var3$ttx</option>";
        }
    }
}

/**
 * Upload image
 */
function uploadImage($inputName, $subFolder) {
    global $uploadDir;
    
    if (!isset($uploadDir)) {
        $uploadDir = 'uploads/';
    }
    
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

/**
 * Get name by ID
 */
function namebyAid($id, $var, $tb) {
    $con = dbCon();
    
    // Validate inputs
    if (empty($id) || !is_numeric($id)) {
        return '';
    }
    
    // Escape inputs to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);
    $var = mysqli_real_escape_string($con, $var);
    $tb = mysqli_real_escape_string($con, $tb);
    
    $query = "SELECT $var FROM $tb WHERE `id`='$id'";
    $k = mysqli_query($con, $query);
    
    // Check if query was successful
    if ($k === false) {
        error_log("Query failed in namebyAid: " . mysqli_error($con));
        return '';
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($k) == 0) {
        return '';
    }
    
    $ax = mysqli_fetch_assoc($k);
    
    // Check if the field exists in the result
    if (isset($ax[$var])) {
        return $ax[$var];
    }
    
    return '';
}

/**
 * Get value by value
 */
function valByVal($tbv, $val2, $var, $tb) {
    $con = dbCon();
    
    // Validate inputs
    if (empty($val2)) {
        return '';
    }
    
    // Escape inputs to prevent SQL injection
    $tbv = mysqli_real_escape_string($con, $tbv);
    $val2 = mysqli_real_escape_string($con, $val2);
    $var = mysqli_real_escape_string($con, $var);
    $tb = mysqli_real_escape_string($con, $tb);
    
    $query = "SELECT $var FROM $tb WHERE `$tbv`='$val2'";
    $k = mysqli_query($con, $query);
    
    // Check if query was successful
    if ($k === false) {
        error_log("Query failed in valByVal: " . mysqli_error($con));
        return '';
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($k) == 0) {
        return '';
    }
    
    $ax = mysqli_fetch_assoc($k);
    
    // Check if the field exists in the result
    if (isset($ax[$var])) {
        return $ax[$var];
    }
    
    return '';
}

/**
 * Get title by ID
 */
function titlebyId($id, $var) {
    $con = dbCon();
    
    // Validate inputs
    if (empty($id) || !is_numeric($id)) {
        return '';
    }
    
    // Escape inputs to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);
    $var = mysqli_real_escape_string($con, $var);
    
    $query = "SELECT title FROM $var WHERE `id`='$id'";
    $k = mysqli_query($con, $query);
    
    // Check if query was successful
    if ($k === false) {
        error_log("Query failed in titlebyId: " . mysqli_error($con));
        return '';
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($k) == 0) {
        return '';
    }
    
    $ax = mysqli_fetch_assoc($k);
    
    // Check if the field exists in the result
    if (isset($ax['title'])) {
        return $ax['title'];
    }
    
    return '';
}

/**
 * Get database value
 */
function getdbVal($id, $var, $tb) {
    $con = dbCon();
    
    // Validate inputs
    if (empty($id) || !is_numeric($id)) {
        echo '';
        return;
    }
    
    // Escape inputs to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);
    $var = mysqli_real_escape_string($con, $var);
    $tb = mysqli_real_escape_string($con, $tb);
    
    $query = "SELECT $var FROM $tb WHERE id=$id";
    $k = mysqli_query($con, $query);
    
    // Check if query was successful
    if ($k === false) {
        error_log("Query failed in getdbVal: " . mysqli_error($con));
        echo '';
        return;
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($k) == 0) {
        echo '';
        return;
    }
    
    $ax = mysqli_fetch_assoc($k);
    
    // Check if the field exists in the result
    if (isset($ax[$var])) {
        echo $ax[$var];
    } else {
        echo '';
    }
}

/**
 * Get user details
 */
function getUserDetails($userID) {
    if (empty($userID) || !is_numeric($userID)) {
        return "No Record";
    }

    $con = dbCon();
    
    // Escape input to prevent SQL injection
    $userID = mysqli_real_escape_string($con, $userID);
    
    $query = "SELECT first_name, last_name FROM zw_user WHERE id = $userID";
    $result = mysqli_query($con, $query);
    
    // Check if query was successful
    if ($result === false) {
        error_log("Query failed in getUserDetails: " . mysqli_error($con));
        return "No Record";
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($result) == 0) {
        return "No Record";
    }
    
    $row = mysqli_fetch_assoc($result);
    
    // Check if the fields exist in the result
    if (isset($row['first_name']) && isset($row['last_name'])) {
        return $row['first_name'] . " " . $row['last_name'];
    }
    
    return "No Record";
}

/**
 * Execute query and return options
 */
function hitQuery($query, $var1, $var2) {
    $con = dbCon();
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax[$var1];
        $ttx = $ax[$var2];
        // Note: $selectedID is not defined in this function
        if (isset($selectedID) && !empty($selectedID) && $selectedID == $idx) {
            echo "<option value='$idx' selected>$ttx</option>";
        } else {
            echo "<option value='$idx'>$ttx</option>";
        }
    }
}

/**
 * Filter internal link
 */
function filterILink($link) {
    $vv = str_replace("http", " ", $link);
    $base = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    if ($vv == $link) {
        $link = $base . "/" . $link;
    }
    return $link;
}

/**
 * Get maximum ID
 */
function maxId($key1) {
    $con = dbCon();
    $query = mysqli_query($con, "SELECT id FROM `$key1` ORDER BY id DESC");
    $num = mysqli_fetch_assoc($query);
    $jj = $num['id'];
    return $jj;
}

/**
 * Count rows
 */
function countRows($key1) {
    $con = dbCon();
    $query = mysqli_query($con, "SELECT id FROM $key1");
    $num = mysqli_num_rows($query);
    return $num;
}

/**
 * Get user IP
 */
function userIP() {
    $myip = $_SERVER['REMOTE_ADDR'];
    return $myip;
}

/**
 * Generate unique ID
 */
function uniQue($num) {
    $rand = rand(000000, 999999);
    $r2 = base64_encode($rand);
    $rand2 = rand(000000, 999999);
    $r3 = base64_encode($rand2);
    $r4 = $rand . $rand2;
    $r4 = $r4 . $r2 . $r3;
    $r4 = substr($r4, 0, $num);
    return $r4;
}

/**
 * Show alert
 */
function alert($q) {
    echo "<script>alert('$q')</script>";
}

/**
 * Set cookies using JavaScript
 */
function setcookies($name, $val) {
    echo "<script>document.cookie='$name=$val; path=/;';</script>";
}

/**
 * Unset cookies using JavaScript
 */
function unsetcookies($name) {
    echo "<script>document.cookie = '$name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';</script>";
}

/**
 * Get OS from user agent
 */
function getOS() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
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

/**
 * Get browser from user agent
 */
function getBrowser() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
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

/**
 * Get bill details
 */
function billDetails() {
    if (isset($_GET['customer_id'])) {
        $customer_id = $_GET['customer_id'];
        // Validate and escape
        if (!is_numeric($customer_id)) {
            echo json_encode(['error' => 'Invalid customer ID']);
            return;
        }
        
        $con = dbCon();
        $customer_id = mysqli_real_escape_string($con, $customer_id);
        
        // Get Bill Details
        $query = "SELECT * FROM zw_Bill WHERE customer_id = '$customer_id' AND status = 1";
        $res = mysqli_query($con, $query);
        
        if (mysqli_num_rows($res) > 0) {
            $mainArray = [];
            while ($row = mysqli_fetch_assoc($res)) {
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
    echo json_encode(0);
    return;
}

/**
 * General query function
 */
function generalQuery($query) {
    $con = dbCon();
    $res = mysqli_query($con, $query);
    return $res;
}

// Clean up output buffer at the end
if (ob_get_level() > 0) {
    ob_end_flush();
}

?>