
<?php
// To Enable error Reporting 
// error_reporting(E_ALL);ini_set('display_errors', 1);

$cashTypeQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 3";
$cashTypes = generalQuery($cashTypeQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$cashTypes = mysqli_fetch_all($cashTypes, MYSQLI_ASSOC);

//Bank
$BankTypeQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 4";
$BankTypes = generalQuery($BankTypeQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$BankTypes = mysqli_fetch_all($BankTypes, MYSQLI_ASSOC);


//Account Receivable
$AccountReQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 22";
$AccountReTypes = generalQuery($AccountReQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$AccountReTypes = mysqli_fetch_all($AccountReTypes, MYSQLI_ASSOC);


//Other Current Assets
$otherCurrentAssetQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 2";
$otherCurrentTypes = generalQuery($otherCurrentAssetQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$otherCurrentTypes = mysqli_fetch_all($otherCurrentTypes, MYSQLI_ASSOC);


//Fixed Assets
$FixedAssetQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 5";
$FixedTypes = generalQuery($FixedAssetQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$FixedTypes = mysqli_fetch_all($FixedTypes, MYSQLI_ASSOC);

// Liabilty
$LiabilityQuery  = "SELECT account_name, closing_balance AS total 
FROM zw_accounts 
WHERE account_type IN (9, 23, 11, 19) 
ORDER BY 
    CASE 
        WHEN account_type = 9 THEN 1 
        WHEN account_type = 23 THEN 2 
        WHEN account_type = 11 THEN 3 
        WHEN account_type = 19 THEN 4 
    END;
";
$LiabiltyTypes = generalQuery($LiabilityQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$LiabiltyTypes = mysqli_fetch_all($LiabiltyTypes, MYSQLI_ASSOC);



//Long Tern Liabilty
$longTermLiabiltyQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 8";
$longTermLiabiltyTypes = generalQuery($longTermLiabiltyQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$longTermLiabiltyTypes = mysqli_fetch_all($longTermLiabiltyTypes, MYSQLI_ASSOC);


//Equity
$equityQuery  = "SELECT account_name, closing_balance AS total FROM zw_accounts WHERE account_type = 13";
$equityTypes = generalQuery($equityQuery);
// $cashTypes = mysqli_fetch_assoc($cashTypes);
$equityTypes = mysqli_fetch_all($equityTypes, MYSQLI_ASSOC);
?>
<style>
    .rep-container .page-header {
        border: 0;
    }

    .page-header {
        padding-bottom: 9px;
        margin: 40px 0 20px;
        border-bottom: 1px solid #eee;
    }

    .text-regular,
    h3,
    h4 {
        font-weight: 400;
    }

    .h4,
    h4 {
        font-size: 1.5rem;
    }

    .reports-headerspacing {
        margin-top: -5px;
    }

    @media (min-width: 1200px) .h3,
    h3 {
        font-size: 1.75rem;
    }

    .h5,
    h5 {
        font-size: 1.25rem;
    }

    .rep-container .tags {
        margin-top: 25px;
    }

    .fill-container .zi-table {
        border-left: none;
        border-right: none;
    }

    .table-container .financial-comparison {
        margin: 0 auto 30px;
    }

    .financial-comparison {
        min-width: 60%;
        max-width: 100%;
        width: auto;
    }

    .table-no-border {
        border-bottom: 0;
    }

    .zi-table {
        border-bottom: 1px solid var(--zf-border-color);
        table-layout: fixed;
    }

    .zi-table.table thead:first-child tr:first-child th {
        border-top: var(--zf-table-header-border-top);
    }

    .rep-container .fill-container .zi-table tr th:first-of-type,
    .rep-container .fill-container .zi-table tr td:first-of-type {
        padding-left: 35px;
    }

    .financial-comparison thead tr th:first-child {
        background-color: #fff;
    }

    .rep-container .table thead>tr>th,
    .rep-container .table tbody>tr>th,
    .rep-container .table tfoot>tr>th,
    .rep-container .table thead>tr>td,
    .rep-container .table tbody>tr>td,
    .rep-container .table tfoot>tr>td {
        padding: 6px;
        word-wrap: break-word;
        white-space: normal;
    }

    .zi-table.table thead>tr>th {
        color: #757383;
        font-size: var(--zf-table-header-font-size);
        text-transform: uppercase;
        -webkit-font-smoothing: antialiased;
        position: sticky;
        top: -1px;
        z-index: 1;
        background-color: #fff;
        background-clip: padding-box;
        border-top: 1px solid #fff;
        border-bottom: 1px solid #fff;
    }

    .tb-comparison-table thead th:first-child {
        background-color: #fff;
    }

    .table thead>tr>th {
        color: var(--zf-grey-12);
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        vertical-align: middle !important;
    }

    .tb-comparison-table thead th {
        border-top: 1px solid #ddd;
        min-width: 120px;
        text-transform: uppercase;
    }

    .table>:not(caption)>*>* {
        padding: .5rem .5rem;
        /* color: var(--bs-table-color-state, var(--bs-table-color-type, var(--bs-table-color))); */
        background-color: var(--bs-table-bg);
        border-bottom-width: var(--bs-border-width);
        box-shadow: inset 0 0 0 9999px var(--bs-table-bg-state, var(--bs-table-bg-type, var(--bs-table-accent-bg)));
    }

    .whitespace-nowrap {
        white-space: nowrap !important;
    }

    .sortable {
        cursor: pointer;
    }

    .position-relative {
        position: relative !important;
    }

    .d-flex {
        display: flex !important;
    }



    .justify-content-end {
        justify-content: flex-end !important;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    table.dataTable tbody tr,
    tbody,
    tr,
    td {
        background: none !important;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border: none;
    }

    .highlight-subaccount-section {
        border-bottom: 1px solid #eee;
    }

    table.dataTable tbody tr,
    tbody,
    tr,
    td {
        background: none !important;
    }

    .reconciliation-summary-table {
        max-width: 60%;
        margin: auto;
    }

    .p-4 {
        padding: 15px !important;
    }

    .text-semibold,
    .badge-lhs-webinar,
    b,
    strong,
    th {
        font-weight: 600;
    }

    .badge-success {
        background-color: #388a10;
    }

    .d-inline {
        display: inline !important;
    }

    .badge {
        color: #fff;
        border-radius: var(--zf-bdg-border-radius);
        --zf-badge-padding-y: .25rem;
        --zf-badge-padding-x: .4rem;
    }

    .dropup,
    .dropend,
    .dropdown,
    .dropstart,
    .dropup-center,
    .dropdown-center {
        position: relative;
    }

    .text-dashed-underline {
        padding-bottom: 2px;
        border-bottom: 1px dashed #969696 !important;
    }

    .text-medium,
    .banking-filter .dropdown-toggle,
    .bank-accounts-filter .ac-box .ac-selected,
    .new-approvals .standard-approval-th,
    .card-details:hover .text-hightlight {
        font-weight: 500;
    }

    .pb-0 {
        padding-bottom: 0 !important;
    }

    .dropdown-toggle {
        white-space: nowrap;
    }

    .text-blue {
        color: #408dfb !important;
    }

    span.cell-dropdown .dropdown-menu {
        top: 24px;
        z-index: unset;
    }

    .dropdown-menu:not(.ac-dropdown-results) {
        box-shadow: 0 7px 12px 0 var(--zf-grey-18);
    }

    .dropdown-menu {
        left: 0;
        top: 100%;
        margin: .125rem 0 0;
        padding: var(--zf-dd-padding);
    }

    .dropdown-menu {
        min-width: 100%;
    }

    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus,
    .dropdown-menu .dropdown-item.item-focus {
        background-color: var(--zf-dd-link-hover-bg-color);
    }

    .dropdown-menu .dropdown-item.item-focus {
        color: var(--zf-dd-link-hover-color);
    }

    .dropdown-menu .dropdown-item:first-child {
        margin-top: 0;
    }

    .dropdown-menu .dropdown-item:last-child {
        margin-bottom: 0;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus,
    .dropdown-menu .dropdown-item.item-focus {
        background-color: var(--zf-dd-link-hover-bg-color);
    }

    .dropdown-toggle::after {
        content: '';
    }

    .fill-container .zi-table tr th:last-of-type,
    .fill-container .zi-table tr td:last-of-type {
        padding-right: 30px;
    }

    .financial-comparison td {
        font-size: 14px;
    }

    .text-end {
        text-align: right !important;
    }
</style>

<div class="form-check form-switch" style="position: absolute;
    right: 50px;
    top: 91px;">
  <input class="form-check-input changeviewerwef" type="checkbox" id="changeView">
  <label class="form-check-label" for="changeView">Horizontal View</label>
</div>
<div class="rep-container">
    
    <div id="ember1391" class="ember-view">
        <div class="page-header notranslate text-center">
            <h4>zw</h4>
            <h3 class="reports-headerspacing">Balance Sheet</h3> <span>Basis: Accrual</span>
            <h5>As of <?php echo date('d/m/Y'); ?></h5>
            <div class="tags"> </div>
        </div>

    </div>
    <div class="reports-table-wrapper fill-container table-container" id = "vertical-view">
        <table class="table zi-table tb-comparison-table financial-comparison table-no-border">
            <thead>
                <tr>
                    <th class="text-start sortable   align-middle whitespace-nowrap " style="" rowspan="1" colspan="1">
                        <div class="position-relative d-flex ">
                            <div title="Account">Account </div>
                        </div>
                    </th>
                    <th class="text-end sortable   align-middle whitespace-nowrap " style="" rowspan="1" colspan="1">
                        <div class="position-relative d-flex justify-content-end">
                            <div title="Total">Total </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class=" fw-bold">
                    <td> Assets</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; Current Assets</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cash</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <?php

                $cashTotal = 0;
                foreach ($cashTypes as $type) {
                    $cashTotal += $type['total']; ?>
                    <tr class=" ">

                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1397" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                        <td class="text-end"><a id="ember1399" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>

                    </tr>
                <?php } ?>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Cash</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $cashTotal); ?></td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bank</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <?php

                $bankTotal = 0;
                foreach ($BankTypes as $type) {
                    $bankTotal += $type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1403" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                        <td class="text-end"><a id="ember1405" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                    </tr>
                <?php } ?>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Bank</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $bankTotal); ?></td>
                </tr>
                <?php

                $accountReceivableTotal = 0;
                foreach ($AccountReTypes as $type) {
                    $accountReceivableTotal += $type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1403" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                        <td class="text-end"><a id="ember1405" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                    </tr>
                <?php } ?>

                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Other current assets</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <?php

                $otherCurrentAssetTotal = 0;
                foreach ($otherCurrentTypes as $type) {
                    $otherCurrentAssetTotal += $type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1423" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                        <td class="text-end"><a id="ember1425" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                    </tr>
                <?php } ?>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Other current assets</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $otherCurrentAssetTotal); ?></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Current Assets</strong></td>
                    <?php
                    $totalForCurrentAssest = $cashTotal + $bankTotal +  $accountReceivableTotal  + $otherCurrentAssetTotal;
                    ?>
                    <td class="text-end"><?php echo sprintf("%.2f", $totalForCurrentAssest); ?></td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; Fixed Assets</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <?php

                $fixedTotal = 0;
                foreach ($FixedTypes as $type) {
                    $fixedTotal += $type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1435" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                        <td class="text-end"><a id="ember1437" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                    </tr>
                <?php } ?>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Fixed Assets</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $fixedTotal); ?></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for Assets</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", ($totalForCurrentAssest + $fixedTotal)); ?></td>
                </tr>
                <tr class=" fw-bold">
                    <td> Liabilities &amp; Equities</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; Liabilities</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Current Liabilities</td>
                    <td colspan="1">&nbsp;</td>
                </tr>

                <?php

                $LiabiltyTotal = 0;
                foreach ($LiabiltyTypes as $type) {
                    $LiabiltyTotal += $type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="cell-dropdown"><span id="ember1443" class="dropdown ember-view"><span id="ember1444" class="dropdown-toggle ember-view cursor-pointer dropdown-value text-blue text-dashed-underline pb-0 text-medium no-caret"><?php echo $type['account_name'] ?></span>

                                </span></span></td>
                        <td class="text-end"><span class="cell-dropdown"><span id="ember1448" class="dropdown ember-view"><span id="ember1449" class="dropdown-toggle ember-view cursor-pointer dropdown-value text-blue text-dashed-underline pb-0 text-medium no-caret"><?php echo sprintf("%.2f", $type['total']) ?></span>

                                </span></span></td>
                    </tr>
                <?php } ?>

                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Current Liabilities</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $LiabiltyTotal) ?></td>
                </tr>

                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Long Term Liabilities</td>
                    <td colspan="1">&nbsp;</td>
                </tr>


                <?php

                $otherLiabiltyTotal = 0;
                foreach ($longTermLiabiltyTypes as $type) {
                    $otherLiabiltyTotal += $type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="cell-dropdown"><span id="ember1443" class="dropdown ember-view"><span id="ember1444" class="dropdown-toggle ember-view cursor-pointer dropdown-value text-blue text-dashed-underline pb-0 text-medium no-caret"><?php echo $type['account_name'] ?></span>

                                </span></span></td>
                        <td class="text-end"><span class="cell-dropdown"><span id="ember1448" class="dropdown ember-view"><span id="ember1449" class="dropdown-toggle ember-view cursor-pointer dropdown-value text-blue text-dashed-underline pb-0 text-medium no-caret"><?php echo sprintf("%.2f", $type['total']); ?></span>

                                </span></span></td>
                    </tr>
                <?php } ?>


                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Long Term Liabilities</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $otherLiabiltyTotal) ?></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Liabilities</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", ($totalLibility = $LiabiltyTotal + $otherLiabiltyTotal)); ?></td>
                </tr>
                <tr class=" fw-bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; Equities</td>
                    <td colspan="1">&nbsp;</td>
                </tr>
                <?php

                $equityTotal = 0;
                foreach ($equityTypes as $type) {
                    $equityTotal += (int)$type['total']; ?>
                    <tr class=" ">
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1461" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                        <td class="text-end"><a id="ember1463" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']); ?></a></td>
                    </tr>
                <?php } ?>
                <tr class="highlight-subaccount-section ">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Equities</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", $equityTotal); ?></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for Liabilities &amp; Equities</strong></td>
                    <td class="text-end"><?php echo sprintf("%.2f", ($totalLibility + $equityTotal)); ?></td>
                </tr>
            </tbody>
        </table>
        <div class="reconciliation-summary-table p-4"> <small>**Amount is displayed in your base currency</small>&nbsp;<span class="badge text-semibold badge-success d-inline">INR</span> </div>
    </div>
<div class="rep-container" style ="display:none" id = "horizontal-display">
    <div class="row horizontal-display">
        <!-- First Section -->
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="reports-table-wrapper fill-container table-container">
                    <table class="table zi-table tb-comparison-table financial-comparison table-no-border">

                        <tbody>
                            <tr class=" fw-bold">
                                <td> Assets</td>
                                <td colspan="1">&nbsp;</td>
                            </tr>
                            <tr class=" fw-bold">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp; Current Assets</td>
                                <td colspan="1">&nbsp;</td>
                            </tr>
                            <tr class=" fw-bold">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cash</td>
                                <td colspan="1">&nbsp;</td>
                            </tr>
                            <?php

                            $cashTotal = 0;
                            foreach ($cashTypes as $type) {
                                $cashTotal += $type['total']; ?>
                                <tr class=" ">

                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1397" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                                    <td class="text-end"><a id="ember1399" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>

                                </tr>
                            <?php } ?>
                            <tr class="highlight-subaccount-section ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Cash</strong></td>
                                <td class="text-end"><?php echo sprintf("%.2f", $cashTotal); ?></td>
                            </tr>
                            <tr class=" fw-bold">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Bank</td>
                                <td colspan="1">&nbsp;</td>
                            </tr>
                            <?php

                            $bankTotal = 0;
                            foreach ($BankTypes as $type) {
                                $bankTotal += $type['total']; ?>
                                <tr class=" ">
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1403" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                                    <td class="text-end"><a id="ember1405" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                                </tr>
                            <?php } ?>
                            <tr class="highlight-subaccount-section ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Bank</strong></td>
                                <td class="text-end"><?php echo sprintf("%.2f", $bankTotal); ?></td>
                            </tr>
                            <?php

                            $accountReceivableTotal = 0;
                            foreach ($AccountReTypes as $type) {
                                $accountReceivableTotal += $type['total']; ?>
                                <tr class=" ">
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1403" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                                    <td class="text-end"><a id="ember1405" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                                </tr>
                            <?php } ?>

                            <tr class=" fw-bold">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Other current assets</td>
                                <td colspan="1">&nbsp;</td>
                            </tr>
                            <?php

                            $otherCurrentAssetTotal = 0;
                            foreach ($otherCurrentTypes as $type) {
                                $otherCurrentAssetTotal += $type['total']; ?>
                                <tr class=" ">
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1423" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                                    <td class="text-end"><a id="ember1425" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                                </tr>
                            <?php } ?>
                            <tr class="highlight-subaccount-section ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Other current assets</strong></td>
                                <td class="text-end"><?php echo sprintf("%.2f", $otherCurrentAssetTotal); ?></td>
                            </tr>
                            <tr class="highlight-subaccount-section ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Current Assets</strong></td>
                                <?php
                                $totalForCurrentAssest = $cashTotal + $bankTotal +  $accountReceivableTotal  + $otherCurrentAssetTotal;
                                ?>
                                <td class="text-end"><?php echo sprintf("%.2f", $totalForCurrentAssest); ?></td>
                            </tr>
                            <tr class=" fw-bold">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp; Fixed Assets</td>
                                <td colspan="1">&nbsp;</td>
                            </tr>
                            <?php

                            $fixedTotal = 0;
                            foreach ($FixedTypes as $type) {
                                $fixedTotal += $type['total']; ?>
                                <tr class=" ">
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1435" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                                    <td class="text-end"><a id="ember1437" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']) ?></a></td>
                                </tr>
                            <?php } ?>
                            <tr class="highlight-subaccount-section ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Fixed Assets</strong></td>
                                <td class="text-end"><?php echo sprintf("%.2f", $fixedTotal); ?></td>
                            </tr>
                            <tr class="highlight-subaccount-section ">
                                <td> <strong>Total for Assets</strong></td>
                                <td class="text-end"><?php echo sprintf("%.2f", ($totalForCurrentAssest + $fixedTotal)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <!-- Second Section -->
            <div class="col-md-6">
                <div class="col-md-12">
                <div class="reports-table-wrapper fill-container table-container">
                    <table class="table zi-table tb-comparison-table financial-comparison table-no-border">
                        <tbody>
                        <tr class=" fw-bold">
                            <td> Liabilities &amp; Equities</td>
                            <td colspan="1">&nbsp;</td>
                        </tr>
                        <tr class=" fw-bold">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp; Liabilities</td>
                            <td colspan="1">&nbsp;</td>
                        </tr>
                        <tr class=" fw-bold">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Current Liabilities</td>
                            <td colspan="1">&nbsp;</td>
                        </tr>

                        <?php

                        $LiabiltyTotal = 0;
                        foreach ($LiabiltyTypes as $type) {
                            $LiabiltyTotal += $type['total']; ?>
                            <tr class=" ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="cell-dropdown"><span id="ember1443" class="dropdown ember-view"><span id="ember1444" class="dropdown-toggle                                           "><?php echo $type['account_name'] ?></span>

                                        </span></span></td>
                                <td class="text-end"><span class="cell-dropdown"><span id="ember1448" class="dropdown ember-view"><span id="ember1449" class="dropdown-toggle "><?php echo sprintf("%.2f", $type['total']) ?></span>

                                        </span></span></td>
                            </tr>
                        <?php } ?>

                        <tr class="highlight-subaccount-section ">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Current Liabilities</strong></td>
                            <td class="text-end"><?php echo sprintf("%.2f", $LiabiltyTotal) ?></td>
                        </tr>

                        <tr class=" fw-bold">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Long Term Liabilities</td>
                            <td colspan="1">&nbsp;</td>
                        </tr>


                        <?php

                        $otherLiabiltyTotal = 0;
                        foreach ($longTermLiabiltyTypes as $type) {
                            $otherLiabiltyTotal += $type['total']; ?>
                            <tr class=" ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="cell-dropdown"><span id="ember1443" class="dropdown ember-view"><span id="ember1444" class="dropdown-toggle ember-view cursor-pointer dropdown-value text-blue text-dashed-underline pb-0 text-medium no-caret"><?php echo $type['account_name'] ?></span>

                                        </span></span></td>
                                <td class="text-end"><span class="cell-dropdown"><span id="ember1448" class="dropdown ember-view"><span id="ember1449" class="dropdown-toggle ember-view cursor-pointer dropdown-value text-blue text-dashed-underline pb-0 text-medium no-caret"><?php echo sprintf("%.2f", $type['total']); ?></span>

                                        </span></span></td>
                            </tr>
                        <?php } ?>


                        <tr class="highlight-subaccount-section ">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Long Term Liabilities</strong></td>
                            <td class="text-end"><?php echo sprintf("%.2f", $otherLiabiltyTotal) ?></td>
                        </tr>
                        <tr class="highlight-subaccount-section ">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Liabilities</strong></td>
                            <td class="text-end"><?php echo sprintf("%.2f", ($totalLibility = $LiabiltyTotal + $otherLiabiltyTotal)); ?></td>
                        </tr>
                        <tr class=" fw-bold">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp; Equities</td>
                            <td colspan="1">&nbsp;</td>
                        </tr>
                        <?php

                        $equityTotal = 0;
                        foreach ($equityTypes as $type) {
                            $equityTotal += (int)$type['total']; ?>
                            <tr class=" ">
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="ember1461" class="ember-view" href=""><?php echo $type['account_name'] ?></a></td>
                                <td class="text-end"><a id="ember1463" class="ember-view" href=""><?php echo sprintf("%.2f", $type['total']); ?></a></td>
                            </tr>
                        <?php } ?>
                        <tr class="highlight-subaccount-section ">
                            <td>&nbsp;&nbsp;&nbsp;&nbsp; <strong>Total for Equities</strong></td>
                            <td class="text-end"><?php echo sprintf("%.2f", $equityTotal); ?></td>
                        </tr>
                        <tr class="highlight-subaccount-section ">
                            <td> <strong>Total for Liabilities &amp; Equities</strong></td>
                            <td class="text-end"><?php echo sprintf("%.2f", ($totalLibility + $equityTotal)); ?></td>
                        </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
       <div class="reconciliation-summary-table p-4"> <small>**Amount is displayed in your base currency</small>&nbsp;<span class="badge text-semibold badge-success d-inline">INR</span> </div>        
</div>
</div>

<script>
        $(document).ready(function() {
            // Add Button
            $('a[href="add.php?type=balance-sheet"]').hide();

            $(document).on('click' ,'#changeView' , function(){

                if($(this).is(':checked')){
                    
                    $('#vertical-view').hide();
                    $('#horizontal-display').show();
                } 
                else {
               $('#horizontal-display').hide();
                    $('#vertical-view').show();
                }
            });
        })
    </script>
