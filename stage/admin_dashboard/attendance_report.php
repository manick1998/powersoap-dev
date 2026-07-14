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
                        <h1 class="header_main">Attendance Report</h1>
                        <span class="table_count">Total Attendance Report - <span id="total_salesRep_count"></span></span>
                        <div class="cred-btn-box "> 
                            <div class="form-group">
                                <select id="salesRep" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                            </div>
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                            </div>
                            <div class="form-group">
                                <button type="button"  class="primary-btn" >Go</button>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <!-- <th>Leave_Date</th> -->
                                <th>Sales Rep Name</th>
                                <th>Region</th>
                                <th>Distributor Name</th>
                                <th>Area</th>
                                <th>Total Expense</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                        </tbody>
                        
                    </table>
                </div>
            </section>
        </main>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
            var fromDate;
            var toDate;
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
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script>
        //date picker
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#datePicker').attr('min',today);
        $('#fromDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd'
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd'
        });

        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table1;

        $(document).ready(function() {
            let value = {
                type: "salesRep"
            };
            var json_data = JSON.stringify(value);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data:json_data,
            }).done(function(datas) {
                let data = datas.data;
                let html_text = '<option value="">Select SalesRep</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].employee_token}">${data[key].employee_name}</option>`;
                    }
                $('#salesRep').html(html_text);
            });
       });    
            
        $(".primary-btn").click(function(){
        $('#table_data1').DataTable().destroy();
        // $(".se-pre-con").fadeIn();
            fromDate = $("#fromDate").val();
            salesRep = $("#salesRep").val();
            toDate = $("#toDate").val();
            if (fromDate != "" && salesRep != '' && toDate != '') {
                let region = {
                    dashboard_code: verfication_code,
                    fromDate: fromDate,
                    salesRep: salesRep,
                    toDate: toDate
                };
                var json_data = JSON.stringify(region);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/attendanceReport.php",
                    data:json_data,
                }).done(function(data){
                   success(data,fromDate,toDate);
                });
            }else{
                swal('Please select all dropdown value');
            }                     
      });
  
   



                        
        //  var table_main_data;
        //  var table_main_data1;
        // function success(data,fromDate,toDate) {
        //     table_main_data = data.data || [];
        //     table_main_data1 = data.data1 || [];
            
        //     $('#total_salesRep_count').html(table_main_data.length);
        //     console.log('leave',table_main_data1);
        //     console.log('table_main_data',table_main_data);
        //     var html_text = "";
        //     var start = new Date(fromDate);
        //     var end = new Date(toDate);
        //     var Arraydata = [];
            
        //     while (start <= end) {
        //         var k = new Date(start);
        //         var year = k.getFullYear();
        //         var month = String(k.getMonth() + 1).padStart(2, '0');
        //         var day = String(k.getDate()).padStart(2, '0');
        //         var formattedDate = year + '-' + month + '-' + day;
                
                
        //         var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        //         var dayName = days[k.getDay()];
        //         var isSunday = (k.getDay() === 0);
                
        //         var objdata = {
        //             "formattedDate": formattedDate,
        //             "dayName": dayName,
        //             "isSunday": isSunday
        //         };
        //         Arraydata.push(objdata);
        //         start.setDate(start.getDate() + 1);
        //     }
            
        //     Arraydata.forEach(function(item, index){
        //         var val = true;
        //         var check_date = item.formattedDate;
                
        //         html_text += '<tr>';
                
        //         // Date column
        //         if(item.isSunday) {
        //             html_text += '<td style="color: red; font-weight: bold;">' + item.formattedDate + ' (' + item.dayName + ')</td>';
        //         } else {
        //             html_text += '<td>' + item.formattedDate + ' (' + item.dayName + ')</td>';
        //         }
                
        //         // Check for attendance data
        //         for (var key in table_main_data) {
        //             if (check_date == table_main_data[key].date) {
        //                 html_text += '<td>' + table_main_data[key].sales_rep_name + '</td>';
        //                 html_text += '<td>' + table_main_data[key].region_name + '</td>';
        //                 html_text += '<td>' + table_main_data[key].distributor_name + '</td>';
        //                 html_text += '<td>' + table_main_data[key].area_name + '</td>';
        //                 html_text += '<td>' + table_main_data[key].expense_amount + '</td>';
        //                 val = false;
        //                 break;
        //             }
        //         }

        //         // If no attendance data found
        //         if(val == true) {
        //             if(item.isSunday) {
        //                 // Sunday - show in RED
        //                 html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
        //                 html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
        //                 html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
        //                 html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
        //                 html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
        //             } else {
        //                 // Weekday but empty - show as LEAVE in ORANGE
        //                 html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
        //                 html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
        //                 html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
        //                 html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
        //                 html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
        //             }
        //         }
                
        //         html_text += '</tr>';
        //     });  
            
        //     $("#table_body").html(html_text);
            
        //     table1 = $("#table_data1").DataTable({
        //         scrollX: true,
        //         dom: 'Bfrtip',
        //         buttons: ['csv','pdf'],
        //         language: {
        //             search: '<img src="assets/svg/Search_icon.svg">', 
        //             searchPlaceholder: "Search",
        //             paginate: {
        //                 next: '<img src="assets/svg/Right_arrow_icon.svg">', 
        //                 previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
        //             }
        //         }
        //     });
        // }
        

        var table_main_data;
        var table_main_data1;
        
        function success(data,fromDate,toDate) {
            table_main_data = data.data || [];
            table_main_data1 = data.data1 || [];
            
            $('#total_salesRep_count').html(table_main_data.length);
            console.log('leave',table_main_data1);
            console.log('table_main_data',table_main_data);
            var html_text = "";
            var start = new Date(fromDate);
            var end = new Date(toDate);
            var Arraydata = [];
            
            while (start <= end) {
                var k = new Date(start);
                var year = k.getFullYear();
                var month = String(k.getMonth() + 1).padStart(2, '0');
                var day = String(k.getDate()).padStart(2, '0');
                
                // Format for database comparison (YYYY-MM-DD)
                var compareDate = year + '-' + month + '-' + day;
                
                // Format for display (DD-MM-YYYY)
                var displayDate = day + '-' + month + '-' + year;
                
                var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                var dayName = days[k.getDay()];
                var isSunday = (k.getDay() === 0);
                
                var objdata = {
                    "compareDate": compareDate,
                    "displayDate": displayDate,
                    "dayName": dayName,
                    "isSunday": isSunday
                };
                Arraydata.push(objdata);
                start.setDate(start.getDate() + 1);
            }
            
            Arraydata.forEach(function(item, index){
                var val = true;
                var check_date = item.compareDate; // Use YYYY-MM-DD for checking data
                
                // This creates your exact requested format: 01-06-2026- (Tuesday)
                var formattedDateString = item.displayDate + '- (' + item.dayName + ')';
                
                html_text += '<tr>';
                
                // Date column rendering with the new format
                if(item.isSunday) {
                    html_text += '<td style="color: red; font-weight: bold;">' + formattedDateString + '</td>';
                } else {
                    html_text += '<td>' + formattedDateString + '</td>';
                }
                
                // Check for attendance data
                for (var key in table_main_data) {
                    if (check_date == table_main_data[key].date) {
                        html_text += '<td>' + table_main_data[key].sales_rep_name + '</td>';
                        html_text += '<td>' + table_main_data[key].region_name + '</td>';
                        html_text += '<td>' + table_main_data[key].distributor_name + '</td>';
                        html_text += '<td>' + table_main_data[key].area_name + '</td>';
                        html_text += '<td>' + table_main_data[key].expense_amount + '</td>';
                        val = false;
                        break;
                    }
                }

                // If no attendance data found
                if(val == true) {
                    if(item.isSunday) {
                        // Sunday - show in RED
                        html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
                        html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
                        html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
                        html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
                        html_text += '<td style="color: red; font-weight: bold;">Sunday</td>';
                    } else {
                        // Weekday but empty - show as LEAVE in ORANGE
                        html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
                        html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
                        html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
                        html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
                        html_text += '<td style="color: orange; font-weight: bold;">Leave</td>';
                    }
                }
                
                html_text += '</tr>';
            });  
            
            $("#table_body").html(html_text);
            
            table1 = $("#table_data1").DataTable({
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ['csv','pdf'],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">', 
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                    }
                }
            });
        }



        
     </script>
    </body>
</html>
<?php
}
//mysqli_close($link);
?>