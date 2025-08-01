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
.dropup, .dropend, .dropdown, .dropstart, .dropup-center, .dropdown-center {
    position: relative;
}
.text-dashed-underline {
    padding-bottom: 2px;
    border-bottom: 1px dashed #969696 !important;
}
.text-medium, .banking-filter .dropdown-toggle, .bank-accounts-filter .ac-box .ac-selected, .new-approvals .standard-approval-th, .card-details:hover .text-hightlight {
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
.dropdown-menu .dropdown-item:hover, .dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item.item-focus {
    background-color: var(--zf-dd-link-hover-bg-color);
}
.dropdown-menu .dropdown-item.item-focus{
        color: var(--zf-dd-link-hover-color);
}
.dropdown-menu .dropdown-item:first-child{
        margin-top: 0;
}
.dropdown-menu .dropdown-item:last-child {
    margin-bottom: 0;
}
.dropdown-menu.show {
    display: block;
}
.dropdown-menu .dropdown-item:hover, .dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item.item-focus {
    background-color: var(--zf-dd-link-hover-bg-color);
}
.dropdown-toggle::after{
    content:'';
}
.fill-container .zi-table tr th:last-of-type, .fill-container .zi-table tr td:last-of-type {
    padding-right: 30px;
}
.financial-comparison td {
    font-size: 14px;
}
.text-end {
    text-align: right !important;
}
.column {
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.ps-2 {
    padding-left: 5px !important;
}
.pt-1 {
    padding-top: 2.5px !important;
}
</style>

<div class="rep-container">
    <div id="ember1819" class="ember-view"> </div>
    <div id="ember1820" class="ember-view">
        <div class="page-header notranslate text-center">
            <h4>zw</h4>
            <h3 class="reports-headerspacing">Cash Flow Statement</h3> 
            <h5><span>From</span> <?php echo date('01/m/Y')?> <span>To</span> <?php echo date('t/m/Y')?></h5>
            <div class="tags"></div> 
        </div>
       
    </div> 
    <div class="reports-table-wrapper cf-table-container table-container fill-container">
        <table class="table tb-comparison-table financial-comparison zi-table table-no-border">
            <thead>
                <tr>
                    <th class="text-start sortable   align-middle whitespace-nowrap  asc" style="" rowspan="1" colspan="1">
                        <div class="position-relative d-flex ">
                            <div title="Account">Account </div> <span class="column d-print-none sort pt-1 ps-2"><svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 374.98 227.51" class="icon icon-xxxs sort-up-caret rotate-180">
                                    <path d="M187.46 227.51c-10.23 0-20.46-3.9-28.27-11.71L11.73 68.45C-3.9 52.83-3.91 27.51 11.71 11.88c15.62-15.63 40.94-15.64 56.57-.02l119.18 119.09L306.69 11.72c15.62-15.62 40.95-15.62 56.57 0 15.62 15.62 15.62 40.95 0 56.57L215.75 215.8c-7.81 7.81-18.05 11.72-28.28 11.72z" id="Layer_1-2"></path>
                                </svg> <svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 374.98 227.51" class="icon icon-xxxs sort-down-caret">
                                    <path d="M187.46 227.51c-10.23 0-20.46-3.9-28.27-11.71L11.73 68.45C-3.9 52.83-3.91 27.51 11.71 11.88c15.62-15.63 40.94-15.64 56.57-.02l119.18 119.09L306.69 11.72c15.62-15.62 40.95-15.62 56.57 0 15.62 15.62 15.62 40.95 0 56.57L215.75 215.8c-7.81 7.81-18.05 11.72-28.28 11.72z" id="Layer_1-2"></path>
                                </svg></span>
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
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Beginning Cash Balance</strong></td>
                    <td class="text-end">1,66,099.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td> Cash Flow from Operating Activities</td>
                    <td colspan="1"></td>
                </tr>
                <tr class=" ">
                    <td> <a id="ember1828" class="ember-view" href="#/reports/profitandloss?can_show_detailed_reports_list=&amp;cash_based=false&amp;corporation_tax_return_id=&amp;custom_report_id=&amp;filter_by=CustomDate&amp;from_date=2024-03-01&amp;is_recent_period_first=&amp;per_page=500&amp;report_action=&amp;select_columns=&amp;show_rows=&amp;to_date=2024-03-31&amp;usestate=false">Net Income</a></td>
                    <td class="text-end"><a id="ember1830" class="ember-view" href="#/reports/profitandloss?can_show_detailed_reports_list=&amp;cash_based=false&amp;corporation_tax_return_id=&amp;custom_report_id=&amp;filter_by=CustomDate&amp;from_date=2024-03-01&amp;is_recent_period_first=&amp;per_page=500&amp;report_action=&amp;select_columns=&amp;show_rows=&amp;to_date=2024-03-31&amp;usestate=false">0.00</a></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Net cash provided by Operating Activities</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td> Cash Flow from Investing Activities</td>
                    <td colspan="1"></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Net cash provided by Investing Activities</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class=" fw-bold">
                    <td> Cash Flow from Financing Activities</td>
                    <td colspan="1"></td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td> <strong>Net cash provided by Financing Activities</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td class="text-end"> <strong>Net Change in cash</strong></td>
                    <td class="text-end">0.00</td>
                </tr>
                <tr class="highlight-subaccount-section ">
                    <td class="text-end"> <strong>Ending Cash Balance</strong></td>
                    <td class="text-end">1,66,099.00</td>
                </tr>
            </tbody>
        </table> 
        <div class="reconciliation-summary-table p-4"><small>**Amount is displayed in your base currency</small><span class="badge text-semibold badge-success d-inline">INR</span></div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Add Button
    $('a[href="add.php?type=cashflow"]').hide();
})
</script>