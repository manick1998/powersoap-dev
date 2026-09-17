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
        <title>Product list</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <!-- <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>"> -->
        <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select2.min.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
    </head>
    <style>
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #deecef !important;
            outline: 0;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #deecef !important;
            min-height: 52px;
        }

        table,
        th,
        td {
            border: 1px solid #deecef;
            border-collapse: collapse;
            padding: 25px;
            text-align: center;
            white-space: nowrap;
        }

        th {
            background-color: #f2f2f2;
        }

        #table_data thead th:first-child,
        #table_data tbody td:first-child {
            min-width: 300px;
            width: 300px;
            max-width: 300px;
            white-space: nowrap;
            text-align: left;
            padding-left: 16px;
        }

        .dt-buttons {
            margin: 10px 25px;
        }

        .tableAlignment {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 20px;
        }
        #table_data {
            overflow-x: scroll;
            display: block;
        }
    </style>

    <body>
        <!-- <div class="se-pre-con"></div> -->
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar12"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle5">
                <div class="product_header_container">
                    <div class="header-details ">
                        <h1 class="header_main">State Sales Reports </h1>
                    </div>
                </div>
                <!-- Nav tabs -->
                <div class="dataTables_filter" style="display: flex;justify-content: space-between;">
                    <form class="formdield">
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                        </div>
                        <div class="form-group">
                            <button id="stateGoBtn" type="button" onclick="filterStateWise();" class="primary-btn">Go</button>
                        </div>
                    </form>
                    <div class="tableAlignment">
                        <p class="table_count"> Total Quantity : <span id="totalquantity"></span></p>
                        <p class="table_count"> Total Amount: <span id="totalamount"></span></p>
                    </div>
                </div>

                <div id="my-div">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane active fade show" id="pills-home">
                            <table class="custom-table" id="table_data">
                                <thead  id="state_details">
                                <tr>
                                    <th rowspan='2' colspan="1">Item\State</th>
                                    <th rowspan='1' colspan="2">All State</th>
                                    <th rowspan='1' colspan="2">Andhra</th>
                                    <th rowspan='1' colspan="2">Andhra Pradesh</th>
                                    <th rowspan='1' colspan="2">Chhattisgarh</th>
                                    <th rowspan='1' colspan="2">KARAIKAL</th>
                                    <th rowspan='1' colspan="2">Karnataka</th>
                                    <th rowspan='1' colspan="2">Kerala</th>
                                    <th rowspan='1' colspan="2">Tamilnadu</th>
                                    <th rowspan='1' colspan="2">Telangana</th>
                                </tr>
                                <tr>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                    <th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>
                                </tr>
                                </thead>
                                <tbody id="table_body"></tbody>
                                <tfoot>
                                    <tr>
                                        <th style="display:none" id="footer">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                        </div>
                    </div>
                </div>
            </section>
        </main>


        <!-- jquery CDN -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <!---- For S3 bucket upload ---->
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var from_date;
            var to_date;
            var table1;
            //date picker
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            $('#datePicker').attr('min', today);
            $('#fromDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                maxDate: 0,
                dateFormat: 'yy-mm-dd'
            });
            $('#toDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                maxDate: 0,
                dateFormat: 'yy-mm-dd'
            });
        </script>
        <script>

            function filterStateWise() {
                var from_date = $("#fromDate").val();
                var to_date =$("#toDate").val();
                let data = {
                    from_date: from_date,
                    to_date: to_date,
                    type: "stateSales"
                };
                var json_data = JSON.stringify(data);
                if (from_date != '' && to_date != '') {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/stateReport.php",
                        data: json_data,
                        success: function(data) {
                            if ($.fn.DataTable.isDataTable('#table_data')) {
                                $('#table_data').DataTable().destroy();
                            }
                            var value = data.data;
                            console.log(value);
                            var StateList=value[0].state;

                            var html_text = '';
                            html_text +=`<tr><th rowspan='2' colspan="1">Item\State</th>`;
                            for (var key in StateList) {
                                html_text += `
                                    <th rowspan='1' colspan="2">${StateList[key].state}</th>`;
                            }
                            html_text +=`</tr>`;
                            html_text +=`<tr>`;
                            for (var key in StateList) {
                                html_text +=`<th rowspan='1' colspan="1" class="sum">QTY</th>
                                    <th rowspan='1' colspan="1" class="sum">AMT</th>`;
                            }

                            // html_text +=`</tr>`;
                            // html_text +=`<tfoot>`;
                            // html_text +=`<tr>`;
                            // html_text +=`<th style="display:none" id="footer">Total</th>`;
                            // for (var key in StateList) {
                            //     html_text +=`<th></th>`;
                            // }

                            // html_text +=`</tr>`;
                            // html_text +=`</tfoot>`;
                            $('#state_details').html(html_text);
                            var html_text2 = '';
                            for (var key in value) {
                                    html_text2 += '<tr>';
                                    html_text2 += `<td rowspan="1" colspan="1"> ${value[key].name} </td>`;
                                    var stateDetails=value[key].state;
                            for(var key2 in stateDetails){
                                html_text2 += `<td>${stateDetails[key2].total_quantity}</td>`;
                                html_text2 += `<td>${stateDetails[key2].total_price}</td>`;
                            }
                                    html_text2 += '</tr>';
                            }
                            $('#table_body').html(html_text2);
                            $("#totalquantity").html(data.overall.overallquantity);
                            $("#totalamount").html(data.overall.overallsales);
                            table1 = $('#table_data').DataTable({
                                "paging": false,
                                "searching": false,
                                "ordering": false,
                                "initComplete": function(settings, json) {
                                    if ((this.api().data().length) > 0) {
                                        this.api().columns('.sum').every(function() {
                                            var column = this;

                                            var sum = column
                                                .data()
                                                .reduce(function(a, b) {
                                                    a = parseInt(a, 10);
                                                    if (isNaN(a)) {
                                                        a = 0;
                                                    }

                                                    b = parseInt(b, 10);
                                                    if (isNaN(b)) {
                                                        b = 0;
                                                    }

                                                    return a + b;
                                                });
                                            document.getElementById("footer").style.display =
                                                'block';
                                            $(column.footer()).html(sum);

                                        });
                                    } else {
                                        // this.api().clear('.sum');
                                        this.api().columns('.sum').visible(false);
                                    }
                                },
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'pdf',
                                    text: 'PDF',
                                    title: 'State_report:' + $('#fromDate').val() + 'to' + $('#toDate').val(),
                                    footer: true,
                                    download: 'download',
                                    orientation:'landscape',
                                    pageSize: 'A2',
                                    customize: function(pdfDocument) {
                                        pdfDocument.content[1].table.headerRows = 2;
                                        var firstHeaderRow = [];
                                        $('#table_data').find("thead>tr:first-child>th").each(
                                            function(index, element) {
                                                var colSpan = element.getAttribute(
                                                    "colSpan");
                                                firstHeaderRow.push({
                                                    text: element.innerHTML,
                                                    style: "tableHeader",
                                                    colSpan: colSpan
                                                });
                                                for (var i = 0; i < colSpan - 1; i++) {
                                                    firstHeaderRow.push({});
                                                }
                                            });
                                        pdfDocument.content[1].table.body.unshift(
                                            firstHeaderRow);

                                    }
                                },
                                // {
                                //     extend: 'csv',
                                //     title: 'State_report:' + $('#fromDate').val() + 'to' + $('#toDate').val(),
                                //     text: 'CSV',
                                //     customize: function(csvData, btn, tbl) {
                                //         let firstHeader =
                                //             '"","Andhra Pradesh","","KARAIKAL","","Karnataka","","Kerala","","Tamilnadu","","Telangana",""\r\n'
                                //         return firstHeader + csvData;
                                //     },
                                //     footer: true,
                                //     pageSize: 'LEGAL'
                                // }
                            ],

                            });
                        }
                    });
                } else {
                    swal("Please Select All the Fields");
                }

            }
        </script>

    </body>

    </html>
<?php
}
mysqli_close($link);
?>