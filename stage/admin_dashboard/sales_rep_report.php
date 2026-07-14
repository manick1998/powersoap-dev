<?php
    include "config.php";
    include "$api_path/config/core.php";
    if ($cookie_admin_name == "") {
        header("Location:login.php");
    } else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Power Soap | sales rep report</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/offer.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/sales_rep_report.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/3.30.2/minified.js"></script>

        <style>
            .dataTables_filter .form-control {
                width: 100%;
            }
            .cred-btn-box {
                width: 100%;
                align-items: baseline;
            }
            .dt-buttons.btn-group {
                margin-left: 30px;
            }
            .dataTables_filter label {
                top: -40px;
            }
            .form-group {
                margin-bottom: 0 !important;
            }
        </style>
    </head>
    <body>
        <div class="se-pre-con" style="display: none;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar16"></div>
        <!-- main-contents -->
        <main class="main-contents">
        
            <section class="bg-white brad-4 full-height" id="salesrep">
                <div class="header_container">
                    <div>
                        <div style="display:flex;align-items: center;justify-content: flex-start;"> 
                            <h1 class="header_main">Sales Rep Report</h1>
                            <span class="table_count">Total Sales Rep - <span id="total_salesRep_count"></span></span>
                        </div>
                        <div class="cred-btn-box "> 
                            <div class="form-group">
                                <select id="selectState" class="form-control">
                                </select>
                            </div>
                            <div class="form-group" style="display:none;">
                                <select id="salesRep" class="form-control">
                                </select>
                            </div>
                            <div class="form-group" style="display:none;">
                                <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                            </div>
                            <div class="form-group" style="display:none;">
                                <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                            </div>
                            <div class="form-group" style="display:none;">
                                <button type="button"  class="primary-btn" >Go</button>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>order token</th>
                                <th>Sales Rep Name</th>
                                <th>Date</th>
                                <th>Distributor Name</th>
                                <th>Area</th>
                                <th>Order Taken shop</th>
                                <th>shop Visited</th>
                                <!--  ount</th> -->
                                <th class="sum">Order Value</th>
                                <th>Total expense</th>
                                <th>Total Shop</th>
                            </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <!-- <th></th> -->
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                        <tbody id="table_body">
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
            var from_date;
            var to_date;
        </script>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
        <script  src="https://cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script>
        // Set current date automatically
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var currentDate = yyyy + '-' + mm + '-' + dd;
        
        $('#fromDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });

        // Set current date as default for both fields
        $('#fromDate').val(currentDate);
        $('#toDate').val(currentDate);

        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table1;
        $(document).ready(function () {
            $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas){
                let data = datas;
                let html_text="";
                html_text = '<option value="">Select State</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                }
                $('#selectState').html(html_text);
                
                // Auto select admin state if available
                if(admin_state_id && admin_state_id != "") {
                    $('#selectState').val(admin_state_id).trigger('change');
                }
            });
        });
            
        //sales rep
        $('#selectState').on('change',function(){
            let region = {
                dashboard_code: verfication_code,
                type: "salesRep",
                state_id: $("#selectState").val()
            };
            var json_data = JSON.stringify(region);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/filterReportDropDown.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                let html_text = '<option value="all">All Sales Rep</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].token}">${data[key].sales_rep_name}</option>`;
                }
                $('#salesRep').html(html_text);
                $("#salesRep,#fromDate,#toDate,.primary-btn").parent("div").css("display","block");
                
                // Auto load data for current date after selecting state
                if($('#fromDate').val() && $('#toDate').val()) {
                    setTimeout(function(){
                        $(".primary-btn").trigger('click');
                    }, 500);
                }
            });
       });    
   
       $(".primary-btn").click(function(){
            $(".se-pre-con").fadeIn();
            from_date = $("#fromDate").val();
            to_date = $("#toDate").val();
            salesRep = $("#salesRep").val();
            selectState = $("#selectState").val();
            
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
                to_date = from_date;
            }
            
            if(from_date != "" && to_date != "" && from_date != undefined && to_date != undefined && selectState != ''){
                // Destroy existing table if exists
                if ($.fn.DataTable.isDataTable('#table_data1')) {
                    $('#table_data1').DataTable().destroy();
                }
                
                table = $('#table_data1').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0 ] }
                    ],
                    'ajax': {
                        'url':api_path+"/admin/salesRepReport.php",
                        'data': function (d) {
                            d.from_date = from_date; 
                            d.to_date = to_date;
                            d.v_id = verfication_code;
                            d.salesRep = salesRep;
                            d.selectState = selectState;
                        }, 
                        'dataSrc': function(data) {
                            $("#total_salesRep_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                        }
                    },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                    "order": [[2, "DESC"]],
                    'columns': [
                        { data: 'token' },
                        { data: 'sales_rep_name' },
                        { data: 'date_time' },
                        { data: 'distributor_name' },
                        { data: 'area_name' },
                        { data: 'oder_taken_shop' },
                        { data: 'count_visit' },
                        { data: 'order_value' },
                        { data: 'expense_amount' },
                        { data: 'total_Shop' }
                    ],
                    dom: 'Bfrltip',
                    destroy: true,
                    searching: true,
                    "initComplete": function (settings, json) {
                        if((this.api().data().length) > 0){
                            this.api().columns('.sum').every(function () {
                                var column = this;
                                var sum = column
                                .data()
                                .reduce(function (a, b) { 
                                    a = parseInt(a, 10);
                                    if(isNaN(a)){ a = 0; }
                                    
                                    b = parseInt(b, 10);
                                    if(isNaN(b)){ b = 0; }
                                    
                                    return a + b;
                                });
                                $(column.footer()).html('Sum: ' + sum);
                            });
                        }
                    },
                    buttons: [{
                                extend: 'pdfHtml5',
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6,7,8,9]
                                },
                                orientation: 'landscape',
                                footer: true,
                                pageSize: 'LEGAL'
                             },{
                                extend: 'csv',
                                className: 'btn-info buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6,7,8,9]
                                },
                                orientation: 'landscape',
                                footer: true,
                                pageSize: 'LEGAL'
                             },
                             {
                            extend: 'excelHtml5',
                            text: 'Excel',
                            className: 'btn-success buttonprint',
                            exportOptions: {
                                columns: [1,2,3,4,5,6,7,8,9]
                            },
                            footer: true
                        }
                                                
                            
                            ],
                });
                table.column(0).visible(false);
                $(".table_count").css("display","block");
            }else{
                swal('Please select State and Date');
                $(".table_count").css("display","none");
            }
            $(".se-pre-con").fadeOut();
        });

    </script>
    </body>
</html>
<?php
}
//mysqli_close($link);
?>