<?php 

$totalOperatingIncomeQuery = "SELECT sum(closing_balance) as total FROM `zw_accounts` where account_type = 14";
$balance = generalQuery($totalOperatingIncomeQuery);
$balance = mysqli_fetch_assoc($balance);
$totalOperatingIncome = $balance['total'];

?>
<style>
.page-header.notranslate.text-center {}

.rep-container .page-header {
    border: 0;
}
.page-header {
    padding-bottom: 9px;
    margin: 40px 0 20px;
    border-bottom: 1px solid #eee;
}
.text-regular, h3, h4 {
    font-weight: 400;
}
.h4, h4 {
    font-size: 1.5rem;
}
.reports-headerspacing {
    margin-top: -5px;
}
@media (min-width: 1200px)
.h3, h3 {
    font-size: 1.75rem;
}
.h5, h5 {
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
.rep-container .fill-container .zi-table tr th:first-of-type, .rep-container .fill-container .zi-table tr td:first-of-type {
    padding-left: 35px;
}
.financial-comparison thead tr th:first-child {
    background-color: #fff;
}
.rep-container .table thead>tr>th, .rep-container .table tbody>tr>th, .rep-container .table tfoot>tr>th, .rep-container .table thead>tr>td, .rep-container .table tbody>tr>td, .rep-container .table tfoot>tr>td {
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
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
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
.fill-container .zi-table tr th:last-of-type, .fill-container .zi-table tr td:last-of-type {
    /* padding-right: 30px; */
}
.justify-content-end {
    justify-content: flex-end !important;
}
.fw-bold {
    font-weight: 700 !important;
}
table.dataTable tbody tr, tbody, tr, td {
    background: none !important;
}
tbody, td, tfoot, th, thead, tr {
    border:none;
}
.highlight-subaccount-section {
    border-bottom: 1px solid #eee;
}
table.dataTable tbody tr, tbody, tr, td {
    background: none !important;
}
.reconciliation-summary-table {
    max-width: 60%;
    margin: auto;
}
.p-4 {
    padding: 15px !important;
}
.text-semibold, .badge-lhs-webinar, b, strong, th {
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

</style>






<div class="rep-container">
    <div id="ember1011" class="ember-view"><!---->
        <!----><!---->
    </div>
    <div id="ember1012" class="ember-view">
        <div class="page-header notranslate text-center">
            <h4>zw</h4>
            <h3 class="reports-headerspacing">Profit and Loss</h3>
            <!----><span>Basis: Accrual</span><!----><!----><!---->
            <h5><span>From</span> <?php echo date('01-m-Y');?>
                <span>To</span>&nbsp;<?php echo date('t-m-Y');?>
            </h5><!----><!---->
            <div class="tags"><!----></div>
        </div>
        
    </div> <!---->
    <div class="reports-table-wrapper fill-container table-container"><!---->
        <table class="table tb-comparison-table zi-table financial-comparison table-no-border">
            <thead>
                <tr>
                    <th class="text-start sortable   align-middle whitespace-nowrap " style rowspan="1" colspan="1">
                        <div class="position-relative d-flex "><!---->
                            <div title="Account">Account<!----> <!----></div>
                            <!---->
                        </div> <!---->
                    </th>
                    <th class="text-end sortable   align-middle whitespace-nowrap " style rowspan="1" colspan="1">
                        <div class="position-relative d-flex justify-content-end"><!---->
                            <div title="Total">Total<!----> <!----></div>
                            <!---->
                        </div> <!---->
                    </th>
                </tr>
                <!----><!---->
            </thead>
            <tbody><!---->
                <tr class=" fw-bold">
                    <td>
                        Operating Income</td>
                    <td colspan="1">&nbsp;</td>
                </tr><!---->
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for
                            Operating Income</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td>
                        Cost of Goods Sold</td>
                    <td colspan="1">&nbsp;</td>
                </tr><!---->
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for
                            Cost of Goods Sold</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td class="text-end">
                        <strong>Gross Profit</strong>
                    </td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td>
                        Operating Expense</td>
                    <td colspan="1">&nbsp;</td>
                </tr><!---->
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for
                            Operating Expense</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td class="text-end">
                        <strong>Operating Profit</strong>
                    </td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td>
                        Non Operating Income</td>
                    <td colspan="1">&nbsp;</td>
                </tr><!---->
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for
                            Non Operating Income</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td>
                        Non Operating Expense</td>
                    <td colspan="1">&nbsp;</td>
                </tr><!---->
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Total for
                            Non Operating Expense</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td class="text-end">
                        <strong>Net Profit/Loss</strong>
                    </td>
                    <td class="text-end">0.00</td>
                </tr><!---->
            </tbody>
        </table>
        <!---->
        <div class="reconciliation-summary-table p-4"><!----><small>**Amount is
                displayed in your base currency</small>&nbsp;<span class="badge text-semibold badge-success d-inline">INR</span><!----><!----></div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Add Button
    $('a[href="add.php?type=profit-loss"]').hide();
})
</script>