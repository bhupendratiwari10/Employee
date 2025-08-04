<?php

function dbCon($type = 'mysqli'){
    $dbConfig = [
        'host' => DATABASE_HOST,
        'username' => DATABASE_USER,
        'password' => DATABASE_PASSWORD,
        'database' => DATABASE_NAME,
    ];

    if ($type === 'mysqli') {
        $con = @mysqli_connect($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);
        if (!$con) {
            die('Database connection failed: ' . mysqli_connect_error());
        }
        // Set the character set
        mysqli_set_charset($con, 'utf8');
    } elseif ($type === 'pdo') {
        try {
            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']}";
            $con = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    } else {
        die('Unsupported database connection type');
    }

    return $con;
}



function checkLoggedin() {
    if (isset($_COOKIE['session'])) {
        redirect('dashboard.php');
        exit();
    }
}

function checkLogin() {
    if (!isset($_COOKIE['session'])) {
        redirect('login.php');
        exit();
    }
}

function createLogin($uid, $unm, $session_id) {
    setCookie("session", $session_id);
    setCookie("username", $unm);
}




/* ----- Data Handling and Validation ----- */


function dataGet($q) {
    $con = dbCon();
    $q = $_REQUEST[$q];
    $q = htmlentities($q);
    return $q;
}

function checkPrint($type, $var, $dbtable) {
    global $conn;
    $type = $conn->real_escape_string($type);
    $query = "SELECT 1 FROM $dbtable WHERE $var = '$type' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}


/* ----- Navigation and Redirection ----- */

function redirect($url) {
    header("Location: $url");
    echo "<script>window.location.replace('$url');</script>";
}

/* ----- Data Verification and Retrieval ----- */

function verfD($con, $tb, $at, $val) {
    $query = "SELECT `id` FROM `$tb` WHERE `$at`='$val'";
    $kl = mysqli_query($con, $query);
    $nl = mysqli_num_rows($kl);
    return ($nl == 0) ? 0 : 1;
}

/* ----- URL and UI Elements ----- */

function currentURL() {
    $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

function optionPrint($var, $selectedID = '') {
    $con = dbCon();
    $query = "SELECT id, title FROM $var";
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax['id'];
        $ttx = $ax['title'];
        $selected = (!empty($selectedID) && $selectedID == $idx) ? 'selected' : '';
        echo "<option value='$idx' $selected>$ttx</option>";
    }
}

function optionPrintAdv($tb, $var1, $var2, $selectedID = '') {
    $con = dbCon();
    $query = "SELECT $var1, $var2 FROM $tb";
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax[$var1];
        $ttx = $ax[$var2];
        $selected = (!empty($selectedID) && $selectedID == $idx) ? 'selected' : '';
        echo "<option value='$idx' $selected>$ttx</option>";
    }
}

function optionPrintAdvx($tb, $var1, $var2, $var3) {
    $con = dbCon();
    $query = "SELECT $var1, $var2 FROM $tb";
    $k = mysqli_query($con, $query);
    while ($ax = mysqli_fetch_assoc($k)) {
        $idx = $ax[$var1];
        $ttx = $ax[$var2];
        echo "<option value='$idx'>$var3$ttx</option>";
    }
}

/* ----- File Handling ----- */

function uploadImage($inputName, $subFolder) {
    global $uploadDir;
    if ($_FILES[$inputName]["error"] == 0) {
        $fileName = $_FILES[$inputName]["name"];
        $tempName = $_FILES[$inputName]["tmp_name"];
        $uniqueID = uniqid();
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = $uniqueID . "_" . $fileName;
        $destination = $uploadDir . $subFolder . "/" . $newFileName;
        
        if (move_uploaded_file($tempName, $destination)) {
            return $destination;
        }
    }
    return "";
}

/* ----- Database Query Helpers ----- */

function titlebyId($id, $var) {
    $con = dbCon();
    $query = "SELECT title FROM $var WHERE `id`='$id'";
    $k = mysqli_query($con, $query);
    $ax = mysqli_fetch_assoc($k);
    $ttx = $ax['title'];
    return $ttx;
}

function namebyAid($id, $var, $tb) {
    $con = dbCon();
    $query = "SELECT $var FROM $tb WHERE `id`='$id'";
    $k = mysqli_query($con, $query);
    $ax = mysqli_fetch_assoc($k);
    $ttx = $ax[$var];
    return $ttx;
}

function valByVal($tbv, $val2, $var, $tb) {
    $con = dbCon();
    $query = "SELECT $var FROM $tb WHERE `$tbv`='$val2'";
    $k = mysqli_query($con, $query);
    $ax = mysqli_fetch_assoc($k);
    $ttx = $ax[$var];
    return $ttx;
}

function getdbVal($id, $var, $tb) {
    $con = dbCon();
    $query = "SELECT $var FROM $tb WHERE id=$id";
    $k = mysqli_query($con, $query);
    $ax = mysqli_fetch_assoc($k);
    $ttx = $ax[$var];
    echo $ttx;
}

/* ----- Other Helper Functions ----- */

function filterILink($link) {
    $vv = str_replace("http", " ", $link);
    $base = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    if ($vv == $link) {
        $link = $base . "/" . $link;
    }
    return $link;
}

function maxId($key1) {
    $con = dbCon();
    $query = mysqli_query($con, "SELECT id FROM `$key1` ORDER BY id DESC");
    $num = mysqli_fetch_assoc($query);
    $jj = $num['id'];
    return $jj;
}

function countRows($key1) {
    $con = dbCon();
    $query = mysqli_query($con, "SELECT id FROM $key1");
    $num = mysqli_num_rows($query);
    return $num;
}

function userIP() {
    $myip = $_SERVER['REMOTE_ADDR'];
    return $myip;
}

function unique($num) {
    $rand = rand(000000, 999999);
    $r2 = base64_encode($rand);
    $rand2 = rand(000000, 999999);
    $r3 = base64_encode($rand);
    $r4 = $rand / $rand2;
    $r4 = $r4 . $r2 . $r3;
    $r4 = substr($r4, 0, $num);
    return $r4;
}

function alert($q) {
    echo "<script>alert('$q')</script>";
}

function setCookies($name, $val) {
    echo "<script>document.cookie = '$name=$val'; path=/;</script>";
}

function unsetCookies($name) {
    echo "<script>document.cookie = '$name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';</script>";
}


/* ----- User-Agent Information ----- */

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


?>