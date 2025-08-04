<script src="assets/js/jquery.js"></script>
<link rel="stylesheet" href="assets/css/melticon.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alata&amp;family=Ubuntu&amp;family=Poppins&amp;display=swap">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">

<style>
    * {
        font-family: Poppins;
    }

    h1,
    h2 {
        font-family: Alata;
    }

    small,
    p {
        font-family: ubuntu;
    }

    body {
        background: #fff;
        color: #222;
    }

    label,
    #userTable_wrapper * {
        color: #333;
    }
</style>
<style>
    button {
        background: #0000005c;
        color: #fff;
        padding: 6px 12px;
        border: 0;
        outline: none;
        border-radius: 4px;
    }

    #userTable {
        width: 100% !important;
    }
</style>

<style>
    .container.col-md,
    .container.col-md-10 {
        transform: scale(0.95);
        background: #fff !important;
    }

    table.dataTable tbody tr,
    tbody,
    tr,
    td {
        background: none !important;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        border: 0px !important;
    }

    .form-control,
    input[type=text],
    input[type=number],
    input[type=tel],
    input[type=email],
    input[type=url],
    textarea,
    select {
        border-radius: 11px !important;
        background-color: #dbdbdb !important;
        color: #000 !important;
        border: 1px solid #6666665c !important;
        border-radius: 11px;
        font-size: 80%;
        padding: 11px 16px;
        box-shadow: none !important
    }

    .form-control:hover,
    input:hover {
        border: 1px solid green !important;
        color: green !important;
    }

    .form-control:focus,
    input:focus {
        border: 1px solid #333 !important;
        color: green !important;
    }

    #deleteBtn i,
    .deleteBtn i {
        color: #ff0027 !important;
    }

    #editBtn i,
    .editBtn i {
        color: green !important;
    }

    #viewBtn i,
    .viewBtn i {
        color: orange !important;
    }

    #cnvtBtn i,
    .cnvtBtn i,
    .completeOrder i {
        color: #06f !important;
    }

    #awrdBtn i,
    .awrdBtn i {
        color: #a400ff !important;
    }

    .viewBtn,
    .editBtn,
    .awrdBtn,
    .deleteBtn,
    .cnvtBtn,
    .completeOrder {
        background: #fff !important;
    }

    .dataTables_info {
        color: #555 !important;
    }

    a.paginate_button {
        background: #dbdbdb8f !important;
        border-radius: 9px !important;
        border: 1px solid #6666663b !important;
        color: #3b3b3b !important;
        transform: scale(0.96);
    }

    table.dataTable thead th,
    table.dataTable thead td {
        border-color: gray !important;
    }

    table.dataTable tbody tr {
        border-color: #dbdbdb5c !important;
    }

    .odd * {
        color: green !important;
    }

    select {
        padding: 11px 14px !important;
        background: #dbdbdb;
        color: green;
        font-size: 90% !important;
    }

    .form-control,
    select {
        transform: scale(1) !important;
    }

    input[type=text],
    input[type=number],
    textarea {
        transform: scale(0.98);
    }

    .btn-danger {
        transform: scale(0.96);
    }

    label,
    small[for] {
        font-size: small;
        margin-left: 11px;
    }

    ::-webkit-input-placeholder {
        /* WebKit, Blink, Edge */
        color: #333 !important;
    }

    :-moz-placeholder {
        /* Mozilla Firefox 4 to 18 */
        color: #333 !important;
        opacity: 1;
    }

    ::-moz-placeholder {
        /* Mozilla Firefox 19+ */
        color: #333 !important;
        opacity: 1;
    }

    :-ms-input-placeholder {
        /* Internet Explorer 10-11 */
        color: #333 !important;
    }

    ::-ms-input-placeholder {
        /* Microsoft Edge */
        color: #333 !important;
    }

    ::placeholder {
        /* Most modern browsers support this now. */
        color: #333 !important;
    }



    .headlogo {
        width: 100px;
    }

    #leftmenu.mini {
        width: 121px;
        /* Adjust the width for the mini sidebar */
    }

    #leftmenu.mini .mainmenu {
        width: min-content !important;
    }

    .mini .submenubox {
        display: none !important;
    }

    #leftmenu.mini .mainmenu l {
        display: none;
    }

    #leftmenu.mini .mainmenu i {
        font-size: 121%;
    }

    #leftmenu.mini .headlogo {
        width: 51px;
    }
</style>




<style>
    button[type=submit],
    button[type=reset] {
        margin-top: 21px;
        background: green !important;
        padding: 11px 21px;
        border-radius: 12px;
    }
</style>


<script>
    $(document).ready(function() {

        $('.submenu').click(function() {
            $(this).toggleClass('issact');
            var target = $(this).data('target');
            $(target).toggleClass('d-none');

            var sidebar = document.getElementById('leftmenu');
            var sidebarX = $('#nosta2');
            var sidebarClass = sidebarX.attr('class');

            if (sidebarClass.includes('col-md-1')) {
                sidebar.classList.toggle('mini');
                sidebarX.removeClass('col-md-1').addClass('col-md-2');
            } else {
                $('.issact.submenubox').toggleClass('d-none');
            }
        });



        $('.jslink').click(function() {
            var url = $(this).data('href');
            window.location.href = url;
        });

        $('.rtbtn').click(function() {
            //$("#leftmenu").toggleClass('d-none');
            //$("#nosta2").toggleClass('d-none');
            $("#voivon").toggleClass('mi-chevron-double-left mi-chevron-double-right');
            var sidebar = document.getElementById('leftmenu');
            var sidebarX = document.getElementById('nosta2');
            sidebar.classList.toggle('mini');
            sidebarX.classList.toggle('col-md-2');
            sidebarX.classList.toggle('col-md-1');
        });

        /*$('.table').toggleClass('table-dark');*/

    });
</script>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

<button class='rtbtn' style='position:fixed;bottom: 2%;left: 1px;width:min-content;z-index:999;background:none;color: #004d2a;border: 0;padding: 2px 21px;font-size: 151%;transform: scale(0.69);'> <i id='voivon' class='mi-chevron-double-left'></i> </button>

<div class='col-md-2' id='leftmenu' style='border-right: 1px solid #cecece;padding:3% 0%;display:block;overflow-y:scroll;overflow-x:hidden;z-index:99;backgroundi:#111;color:#000;position:fixed;left:0;top:0;bottom:0;'>
    <menulist style='overflow-x:hidden;'>
        <center><img src='http://employee.tidyrabbit.com/assets/logo.svg' class='headlogo' style=''></center>
        <br>
        <style>
            menu {
                display: flex !important;
                flex-direction: column;
                align-items: center;
                width: 100%;
                padding: 0px 5px;
            }

            body {
                overflow-x: hidden;
            }

            .issacti {
                color: #fff !important;
            }

            .mainmenu {
                color: #333;
                transform: scale(0.9);
                font-size: 14px !important;
                padding: 9px 18px;
                border-radius: 8px;
                cl: #9584a9;
            }

            .mainmenu i {
                margin-right: 4px;
            }

            .submenubox a {
                padding: 6px 5px;
            }

            menu a {
                display: block;
                text-align: left;
                width: 100%;
                text-decoration: none;
                color: #333 !important;
                padding: 11px 5px;
            }

            ::-webkit-scrollbar-thumb {
                background: #6666668c;
                border-radius: 6px;
                border: 3px solid rgba(0, 0, 0, 0);
                background-clip: padding-box;
            }

            ::-webkit-scrollbar {
                width: 21px !important;
                height: 21px !important
            }

            ::-webkit-scrollbar-track {
                background: none;
                position: absolute;
            }
        </style>

        <menu>
            <a class='mainmenu dashX' href='dashboard.php'><i class='mi-ic_fluent_gauge_20_filled'></i>
                <l>Dashboard</l>
            </a>
            <a class='mainmenu itemsX' href='manage.php?t=items'><i class='mi-th-large'></i>
                <l>Items</l>
            </a>
            <a class='mainmenu bankX' href='banking.php'><i class='mi-currency-exchange'></i>
                <l>Banking</l>
            </a><br>



            <a class='mainmenu salesX submenu' data-target='#managesale'><i class='mi-shopping-cart'></i>
                <l>Sales</l>
            </a>
            <div class='d-none submenubox' id='managesale'>
                <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                    <a href='manage.php?t=customer&g=sls' class='customerXbt'>Customers</a>
                    <a href='manage.php?t=quote&g=sls' class='quoteXbt'>Quotes</a>
                    <a href='manage.php?t=invoice&g=sls' class='invoiceXbt'>Invoices</a>
                    <a href='manage.php?t=payments-received&g=sls' class='payments-receivedXbt'>Payments received</a>
                </div>
            </div>

            <a class='mainmenu purchX submenu' data-target='#managepurch'><i class='mi-mi-list'></i>
                <l>Purchases</l>
            </a>
            <div class='d-none submenubox' id='managepurch'>
                <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                    <a href='manage.php?t=companies&g=prc' class='companiesXbt'>Vendors</a>
                    <a href='manage.php?t=bill&g=prc' class='billXbt'>Bills</a>
                    <a href='manage.php?t=expense&g=prc' class='expenseXbt'>Expense</a>
                    <a href='manage.php?t=payments-made&g=prc' class='payments-madeXbt'>Payments Made</a>
                </div>
            </div>

            <a class='mainmenu accX submenu' data-target='#manageac'><i class='mi-mi-book'></i>
                <l>Accountant</l>
            </a>
            <div class='d-none submenubox' id='manageac'>
                <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                    <a href='manage.php?t=accounts&g=ac' class='accountsXbt'>Chart of Accounts</a>
                    <a href='manage.php?t=journal&g=ac' class='journalXbt'>Manual Journal</a>
                </div>
            </div><br>






            <a class='mainmenu eprX submenu' data-target='#manageepr'><i class='mi-ic_fluent_channel_share_12_regular'></i>
                <l>EPR</l>
            </a>
            <div class='d-none submenubox' id='manageepr'>
                <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                    <a href='manage.php?t=orders&g=epr' class='ordersXbt'>Orders</a>
                    <a href='manage.php?t=pickups&g=epr' class='pickupsXbt'>Pickups</a>
                    <a href='manage.php?t=eprinvoice&g=epr' class='eprinvoiceXbt'>Invoice</a>
                    <a href='manage.php?t=ulbs&g=epr' class='ulbsXbt'>ULBs</a>

                    <a href='manage.php?t=categories&g=epr' class='categoriesXbt'>Categories</a>
                    <a href='reports.php?t=eprinvoice&g=epr'>Reports</a>
                </div>
            </div>

            <!--                <a class='mainmenu certX submenu' data-target='#certsub'><i class='mi-patch-check-fill'></i> Certificates </a>
                <div class='d-none submenubox' id='certsub'>
                    <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                        <a href='certificate.php?t=epr'>EPR</a>
                        <a href='certificate.php?t=ulb'>ULB</a>
                    </div>
                </div>
                
-->



            <br>
            <a class='mainmenu  repX submenu' data-target='#managesreports'><i class='mi-local_police'></i>
                <l>Reports</l>
            </a>
            <div class='d-none submenubox' id='managesreports'>
                <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                    <a href='manage.php?t=profit-loss' class='profitlossXbt'>Profit & Loss</a>
                    <a href='manage.php?t=balance-sheet' class='balancesheetXbt'>Balance Sheet</a>
                    <a href='manage.php?t=cashflow' class='cashflowXbt'>Cash flow statement</a>
                </div>
            </div>
            <br>





            <a class='mainmenu userX submenu' data-target='#managesub'><i class='mi-mi-settings'></i>
                <l>Setting</l>
            </a>
            <div class='d-none submenubox' id='managesub'>
                <div style='display:block;width:100%;margin-left:15%;font-size:80%;'>
                    <a href='manage.php?t=user&g=usr' class='userXbt'>Users</a>
                    <a href='manage.php?t=roles&g=usr' class='rolesXbt'>User Roles</a>
                </div>
            </div>





            <a class='mainmenu' href='logout.php'><i class='mi-power1'></i>
                <l>Logout</l>
            </a>
        </menu>
    </menulist>
</div>

<div class='d-none col-12' style='margin-top:36px;'></div>

<div class='col-md-2' id='nosta2'></div>

<script>
    // $(document).ready(function() {
    //     $anchorTags = $('a'); // Select All Anchor Tags
    //     $hrefArray = [];
    //     let accessArray = "<?php //echo $permissions; 
                                ?>";

    //     $anchorTags.each(function() {
    //         $attributes = $(this).attr('href');
    //         if ($attributes !== undefined &&  ($attributes.includes('?'))) {
    //             $matchValue = storeUrlString($attributes);
    //             searchString = $matchValue + '_view';
    //             if(!(accessArray.includes(searchString))){
    //                 // $(this).hide();
    //                 console.log($matchValue);
    //             } // Match To view in menu dropdown

    //         }
    //     });
    //     // console.log($hrefArray);
    //     console.log(accessArray);

    //     function storeUrlString(hrefArray) {

    //         // Assuming the URL is stored in a variable

    //         // console.log(hrefArray);
    //         if (hrefArray.includes('?')){
    //         // Split the URL by '?' to separate the base URL from the parameters
    //         var parts = hrefArray.split('?');

    //         if (parts.length > 1) {
    //             // Split the parameters by '&' to get individual key-value pairs
    //             var params = parts[1].split('&');

    //             // Initialize a variable to store the value of the 't' parameter
    //             var tValue = null;

    //             // Iterate through each parameter to find the 't' parameter
    //             params.forEach(function(param) {
    //                 var keyValue = param.split('=');
    //                 if (keyValue[0] === 't') {
    //                     tValue = keyValue[1];
    //                 }
    //             });

    //             return tValue;
    //         }

    //     }
    //     }
    // });





    accessArray = '';
    editPermission = true;
    deletePermission = true;
    $(document).ready(function() {
        var $anchorTags = $('menu a'); // Select All Anchor Tags
        accessArray = <?php echo json_encode($permissions); ?>;

        $anchorTags.each(function() {
            var href = $(this).attr('href');
            if (href !== undefined && href.includes('?')) {
                var matchValue = storeUrlString(href);
                var searchString = matchValue + '_view';
                // We suppose if view Permission is Not there it means edit will also be not there
                if (!accessArray.includes(searchString)) {
                    $(this).fadeOut(); // Hide anchor tags for which user does not have permission to view
                    $(this).addClass('noAccess');
                }
            }
        });
        let currentPageUrl = window.location.href;
        let matchValueEdit = storeUrlString(currentPageUrl)
        // console.log(matchValueEdit);
        if (!(accessArray.includes(matchValueEdit + '_edit'))) {
            editPermission = false;
        }

        let matchValueDelete = storeUrlString(currentPageUrl)
        if (!(accessArray.includes(matchValueDelete + '_delete'))) {
            deletePermission = false;
        }




        // Hide main Menu Too if there is no submenu availabe to access

        hideMainMenus();

        function storeUrlString(href) {
            if (href.includes('?')) {
                var parts = href.split('?');
                if (parts.length > 1) {
                    var params = parts[1].split('&');
                    var tValue = null;
                    params.forEach(function(param) {
                        var keyValue = param.split('=');
                        if (keyValue[0] === 't') {
                            tValue = keyValue[1];
                        }
                    });
                    return tValue;
                }
            }
        }

        function hideMainMenus() {
            let mainMenus = $('a.mainmenu.submenu');

            mainMenus.each(function() {
                let dataTarget = $(this).data('target');
                let subMenuDiv = $(dataTarget);
                let childAnchors = subMenuDiv.find('a');
                childAnchorsLength = childAnchors.length;
                // Count the number of hidden anchor tags
                let hiddenAnchorCount = childAnchors.filter('.noAccess').length;
                if (hiddenAnchorCount == childAnchorsLength) {
                    // If no visible anchor tags, hide the main menu
                    $(this).hide();
                }
            });
        }



        // Hide Edit Button


    });
</script>