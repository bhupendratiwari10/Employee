<?php

if (isset($_COOKIE['session_timeout'])) {
    $expirationTime = $_COOKIE['session_timeout'];
    if (time() > $expirationTime) {
	clearAllCookies();
	redirect("login.php");
	exit;
    }
}

function clearAllCookies() {
    $cookies = $_COOKIE;
    foreach ($cookies as $cookie_name => $cookie_value) {
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, '', time() - 3600, '/sub/epr');
    }
   
}
?>
<script src="assets/js/jquery.js"></script>
<link rel="stylesheet" href="assets/css/melticon.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alata&amp;family=Ubuntu&amp;family=Poppins&amp;display=swap">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<style>*{font-family:Poppins;} h1,h2{font-family:Alata;} small,p{font-family:ubuntu;}  body{background:#fff;color:#222;} label, #userTable_wrapper *{color:#333;}</style>
<style>button{background:#0000005c;color:#fff;padding:6px 12px;border:0;outline:none;border-radius:4px;} #userTable{width:100%!important;}</style>

<?php
$n = isset($_GET['t']) ? $_GET['t'] : '';
$n1 = isset($_GET['type']) ? $_GET['type'] : ''; 
?>

<style>

.container.col-md-10{transform:scale(0.9);border-radius:21px;border:1px solid #dbdbdb;background:#fff!important;}

table.dataTable tbody tr, tbody, tr, td{background: none!important;}
table.dataTable thead th, table.dataTable thead td {border: 0px !important;}

.form-control, input[type=text], input[type=number], input[type=tel], input[type=email], input[type=url], textarea, select{border-radius:11px!important;background-color:#dbdbdb!important;color:#000!important;border: 1px solid #6666665c!important;border-radius: 11px;font-size: 80%;padding: 11px 16px;box-shadow:none!important} 
.form-control:hover , input:hover{border: 1px solid green!important;color:green!important;} 
.form-control:focus , input:focus{border: 1px solid #333!important;color:green!important;}

#deleteBtn i , .deleteBtn i{color:#ff0027!important;}
#editBtn i , .editBtn i{color:green!important;}
#viewBtn i , .viewBtn i{color:orange!important;}
#cnvtBtn i , .cnvtBtn i, .completeOrder i{color:#06f!important;}
#awrdBtn i , .awrdBtn i {color: #a400ff!important;}

.viewBtn, .editBtn, .awrdBtn, .deleteBtn, .cnvtBtn, .completeOrder{background:#fff!important;} .dataTables_info{color:#555!important;}
a.paginate_button {background: #dbdbdb8f!important;border-radius: 9px!important;border: 1px solid #6666663b!important;color: #3b3b3b!important;transform: scale(0.96);}

table.dataTable thead th, table.dataTable thead td{border-color: gray!important;} 
table.dataTable tbody tr {border-color: #dbdbdb5c!important;}  .odd * {color: green!important;}

select{padding:11px 14px!important;background:#dbdbdb;color:green;font-size:90%!important;}

.form-control, select{transform:scale(1)!important;} input[type=text], input[type=number], textarea{transform:scale(0.98);} .btn-danger{transform:scale(0.96);}
label, small[for]{font-size:small;margin-left:11px;}

::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #333!important;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #333!important;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #333!important;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #333!important;
}
::-ms-input-placeholder { /* Microsoft Edge */
   color:    #333!important;
}

::placeholder { /* Most modern browsers support this now. */
   color:    #333!important;
}

</style>

<style>button[type=submit],button[type=reset] {margin-top: 21px;background: green!important;padding: 11px 21px;border-radius: 12px;}</style>


  <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
     <style>
     
.sidebar{
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 260px;
  background: #fefeff;
  z-index: 100;
  transition: all 0.5s ease;
}
.sidebar.closes{
  width: 100px;
}
.sidebar .logo-details{
  height: 60px;
  width: 100%;
  display: flex;
  align-items: center;
}
.sidebar .logo-details i{
  font-size: 30px;
  color: #fff;
  height: 50px;
  min-width: 78px;
  text-align: center;
  line-height: 50px;
}
.sidebar .logo-details .logo_name{
  font-size: 22px;
  color: #fff;
  font-weight: 600;
  transition: 0.3s ease;
  transition-delay: 0.1s;
}
.sidebar.closes .logo-details .logo_name{
  transition-delay: 0s;
  opacity: 0;
  pointer-events: none;
}
.sidebar .nav-links{
  height: 100%;
  padding: 30px 0 150px 0;
  overflow: auto;
}
.sidebar.closes .nav-links{
  overflow: visible;
}
.sidebar .nav-links::-webkit-scrollbar{
  display: none;
}
.sidebar .nav-links li{
  position: relative;
  list-style: none;
  transition: all 0.4s ease;
}
.sidebar .nav-links li:hover{
  background: green;
}
.sidebar .nav-links li .iocn-link{
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.sidebar.closes .nav-links li .iocn-link{
  display: block
}
.sidebar .nav-links li i{
  height: 50px;
  min-width: 78px;
  text-align: center;
  line-height: 50px;
  color: #000;
  font-size: 20px;
  cursor: pointer;
  transition: all 0.3s ease;
}
.sidebar .nav-links li.showMenu i.arrow{
  transform: rotate(-180deg);
}
.sidebar.closes .nav-links i.arrow{
  display: none;
}
.sidebar .nav-links li a{
  display: flex;
  align-items: center;
  text-decoration: none;
}
.sidebar .nav-links li a .link_name{
  font-size: 18px;
  font-weight: 400;
  color: #000;
  transition: all 0.4s ease;
}
.sidebar.closes .nav-links li a .link_name{
  opacity: 0;
  pointer-events: none;
}
.sidebar .nav-links li .sub-menu{
  padding: 6px 6px 14px 80px;
  margin-top: -10px;
  background: #bfbfbf;
  display: none;
}
.sidebar .nav-links li.showMenu .sub-menu{
  display: block;
}
.sidebar .nav-links li .sub-menu a{
  color: #000;
  font-size: 15px;
  padding: 5px 0;
  white-space: nowrap;
  opacity: 0.6;
  transition: all 0.3s ease;
}
.sidebar .nav-links li .sub-menu a:hover{
  opacity: 1;
  background: #bfbfbf;
}
.sidebar.closes .nav-links li .sub-menu{
  position: absolute;
  left: 100%;
  top: -10px;
  margin-top: 0;
  padding: 10px 20px;
  border-radius: 0 6px 6px 0;
  opacity: 0;
  display: block;
  pointer-events: none;
  transition: 0s;
}
.sidebar.closes .nav-links li:hover .sub-menu{
  top: 0;
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
}
.sidebar .nav-links li .sub-menu .link_name{
  display: none;
}
.sidebar.closes .nav-links li .sub-menu .link_name{
  font-size: 18px;
  opacity: 1;
  display: block;
}
.sidebar .nav-links li .sub-menu.blank{
  opacity: 1;
  pointer-events: auto;
  padding: 3px 20px 6px 16px;
  opacity: 0;
  pointer-events: none;
}
.sidebar .nav-links li:hover .sub-menu.blank{
  top: 50%;
  transform: translateY(-50%);
}

.one {
  width: 80%;
  margin-left: 10%;
  background-color: black;
  height: 400px;
}

.sidebar .profile-details{
  position: fixed;
  bottom: 0;
  width: 260px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #1d1b31;
  padding: 12px 0;
  transition: all 0.5s ease;
}
.sidebar.closes .profile-details{
  background: none;
}
.sidebar.closes .profile-details{
  width: 78px;
}
.sidebar .profile-details .profile-content{
  display: flex;
  align-items: center;
}
.sidebar .profile-details img{
  height: 52px;
  width: 52px;
  object-fit: cover;
  border-radius: 16px;
  margin: 0 14px 0 12px;
  background: #1d1b31;
  transition: all 0.5s ease;
}
.sidebar.closes .profile-details img{
  padding: 10px;
}
.sidebar .profile-details .profile_name,
.sidebar .profile-details .job{
  color: #fff;
  font-size: 18px;
  font-weight: 500;
  white-space: nowrap;
}
.sidebar.closes .profile-details i,
.sidebar.closes .profile-details .profile_name,
.sidebar.closes .profile-details .job{
  display: none;
}
.sidebar .profile-details .job{
  font-size: 12px;
}
.home-section{
  position: relative;
  background: #E4E9F7;
  height: 100vh;
  left: 260px;
  width: calc(100% - 260px);
  transition: all 0.5s ease;
}
.sidebar.closes ~ .home-section{
  left: 78px;
  width: calc(100% - 78px);
}
.home-section .home-content{
  height: 60px;
  display: flex;
  align-items: center;
}
.home-section .home-content .bx-menu,
.home-section .home-content .text{
  color: #11101d;
  font-size: 35px;
}
.home-section .home-content .bx-menu{
  margin: 0 15px;
  cursor: pointer;
}
.home-section .home-content .text{
  font-size: 26px;
  font-weight: 600;
}
@media (max-width: 420px) {
  .sidebar.closes .nav-links li .sub-menu{
    display: none;
  }
}

     </style>
<div class="sidebar closes">
    <div class="logo-details">
      <img src='http://employee.tidyrabbit.com/assets/zwnewlogo.png' class='' style='width:70px;'>
    </div>
    <ul class="nav-links">
      <li class="dashX">
        <a href="dashboard.php">
          <i class='mi-ic_fluent_gauge_20_filled' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="dashboard.php">Dashboard</a></li>
        </ul>
      </li>
      <li class="itemsX">
        <a href="manage.php?t=items" >
          <i class='mi-th-large' ></i>
          <span class="link_name">Items</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="manage.php?t=items">Items</a></li>
        </ul>
      </li>
      <li class="bankX">
        <a href="banking.php" >
          <i class='mi-currency-exchange' ></i>
          <span class="link_name">Banking</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="banking.php">Banking</a></li>
        </ul>
      </li>
      <li class="salesX">
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-collection' ></i>
            <span class="link_name">Sales</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Sales</a></li>
          <li><a href='manage.php?t=customer&g=sls' class='customerXbt'>Customers</a></li>
          <li><a href='manage.php?t=quote&g=sls' class='quoteXbt'>Quotes</a></li>
          <li><a href='manage.php?t=invoice&g=sls' class='invoiceXbt'>Invoices</a></li>
          <li><a href='manage.php?t=payments-received&g=sls' class='payments-receivedXbt'>Payments received</a></li>
        </ul>
      </li>
      <li class="purchX">
        <div class="iocn-link">
          <a href="#">
            <i class='mi-mi-list' ></i>
            <span class="link_name">Purchases</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Purchases</a></li>
          <li><a href='manage.php?t=companies&g=prc' class='companiesXbt'>Vendors</a></li>
          <li><a href='manage.php?t=bill&g=prc' class='billXbt'>Bills</a></li>
          <li><a href='manage.php?t=expense&g=prc' class='expenseXbt'>Expense</a></li>
          <li><a href='manage.php?t=payments-made&g=prc' class='payments-madeXbt'>Payments Made</a></li>

        </ul>
      </li>
      <li class="accX">
        <div class="iocn-link">
          <a href="#">
            <i class='mi-mi-book' ></i>
            <span class="link_name">Accountant</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Accountant</a></li>
          <li><a href='manage.php?t=accounts&g=ac' class='accountsXbt'>Chart of Accounts</a></li>
          <li><a href='manage.php?t=journal&g=ac' class='journalXbt'>Manual Journal</a></li>
          
        </ul>
      </li>
      <li><br/></li>
      <li class="eprX">
        <div class="iocn-link">
          <a href="#">
            <i class='mi-ic_fluent_channel_share_12_regular' ></i>
            <span class="link_name">EPR</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">EPR</a></li>
          <li><a href='manage.php?t=orders&g=epr' class='ordersXbt'>Orders</a></li>
          <li><a href='manage.php?t=pickups&g=epr' class='pickupsXbt'>Pickups</a></li>
          <li><a href='manage.php?t=eprinvoice&g=epr' class='eprinvoiceXbt'>Invoice</a></li>
          <li><a href='manage.php?t=ulbs&g=epr' class='ulbsXbt'>ULBs</a>  </li>
          <li><a href='manage.php?t=categories&g=epr' class='categoriesXbt'>Categories</a></li>
          
        </ul>
      </li>
      <li><br/></li>
      
      <li class="userX">
        <div class="iocn-link">
          <a href="#">
            <i class='mi-mi-settings' ></i>
            <span class="link_name">Setting</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Setting</a></li>
          <li><a href='manage.php?t=user&g=usr' class='userXbt'>Users</a></li>
          <li><a href='manage.php?t=roles&g=usr' class='rolesXbt'>User Roles</a></li>
        </ul>
      </li>
      <li class="repX">
        <a href="reports.php">
          <i class='mi-local_police' ></i>
          <span class="link_name">Reports</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="reports.php">Reports</a></li>
        </ul>
      </li>
      <li>
        <a href="logout.php">
          <i class='mi-power1'></i>
          <span class="link_name">Logout</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="logout.php">Logout</a></li>
        </ul>
      </li>
      <li class="bxmenu">
        <a href="#">
          <i class='mi-double_arrow'></i>
         
        </a>
       
      </li>
     
    </ul>
  </div>
  
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bxmenu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("closes");
  });
  </script>
