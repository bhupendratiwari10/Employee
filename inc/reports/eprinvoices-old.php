<div class="row col-12" style='background:#fff;transform:none!important;'>
        <div class="col-md-12">
            <div class="col-md-3">
              <div class="form-group">
                
                <select name="period" id="period">
                    <option value="">Select Period</option>
                    <option value="for_invoice">For Invoice</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="half_yearly">Half-Yearly</option>
                    <option value="yearly">Yearly</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
               <select name="pickup_categories" id="pickup_categories" required>
                    <option value="">Select Categories</option>
                    <?php optionPrintAdv("zw_pickup_categories", "id", "title"); ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
               <select name="customer" id="customer" required>
                    <option value="">Select Customer</option>
                    <?php optionPrintAdv("zw_customers WHERE customer_type!='ulb' and status=1", "id", "customer_display_name"); ?>
                </select>
              </div>
            </div>
            <div class="col-md-2">
                <button id="applyFilterBtn" class='btn' style='border-radius: 12px;color: #fff;font-weight: 600;background: #0f6b2b;'>Apply Filter </button>
            </div>
        </div>
        
    </div>
    <hr/>
<div class='row col-12' style='color:#000!important;'>
    <input type="hidden" id="urlInput" name="url" value="">

                <table id="eprinvoiceRTable" class="table dataTable no-footer">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Invoice#</th>
                            <th>PO#</th>
                            <th>Customer Name</th>
                            <th>Terms</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User data will be loaded here using jQuery -->
                    </tbody>
                </table>
            </div>

            <script >
                
                $(document).ready(function() {
                    $('#applyFilterBtn').on('click', function() {
                        $('#eprinvoiceRTable').DataTable().destroy();
                        var customer_id = $('#customer').val();
                        var period = $('#period').val();
                        var pickup_categories = $('#pickup_categories').val();
                        // Make jQuery request
                        if(period=='for_invoice'){
                        	$('#eprinvoiceRTable').DataTable({
		                    "ajax": "api.php?fun=getEPRInvoiceforReport&customer_id="+customer_id+"&period="+period+"&pickup_categories="+pickup_categories, // Endpoint to fetch user data
		                    "columns": [
		                        { "data" : "invoice_date"},
		                        { "data": null,
		                            "render": function(data, type, row) {
		                                return `<a href="print.php?type=eprinvoice&id=${data.id}" >${data.invoice_id}</a>`;
		                            } 
		                        },
		                        { "data": "po_id" },
		                        { "data": "customer_name" },
		                        { "data": "terms" },
		                        { "data": "due_date" }
		                    ]
		                });
                        }else{
                        	$('#eprinvoiceRTable').DataTable({
		                    "ajax": "api.php?fun=getEPRInvoiceforReport&customer_id="+customer_id+"&period="+period+"&pickup_categories="+pickup_categories, 
		                    "columns": [
		                        { "data" : "invoice_date"},
		                        { "data": null,
		                            "render": function(data, type, row) {
		                            	return `<a onclick="openPopup('inc/reports/eprpickups/index.php?type=eprinvoice&poid=${data.po_id}', 'popup', 930, 800); return false;" >${data.invoice_id}</a>`;
		                            	
		                            } 
		                        },
		                        { "data": "po_id" },
		                        { "data": "customer_name" },
		                        { "data": "terms" },
		                        { "data": "due_date" }
		                    ]
		                });
                        }
                        
                    });

                });
            </script>
            <script>
    $(document).ready(function() {
      // Remove the "table-dark" class from all tables with the specified class
      $('table.table-dark').removeClass('table-dark');
    });
  </script>

<script>
function openPopup(url, name, width, height) {
    var left = (screen.width - width) / 2;
    var top = 2;
    var options = 'width=' + width + ', height=' + height + ', top=' + top + ', left=' + left + ', fullscreen=no, resizable=no, scrollbars=yes, location=no';
    window.open(url, name, options);
}
</script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
