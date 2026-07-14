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
        <title>Power Soap | live track sales rep report</title>
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
            .buleline{
        border-left: 5px solid #2196F3 !important;
    }
        </style>
    </head>
    <body>
        <div class="se-pre-con" style="display: block;"></div>
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
                    <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span></h1>
                        <h1 class="header_main">Live Track Sales Rep Report</h1>
                <!--<span class="table_count">Total Sales Rep<span id="total_salesRep_count"></span></span>-->
                        <div class="cred-btn-box "> 
                            <!-- <div class="form-group">
                                <select id="selectState" class="form-control">
                                </select>
                            </div> -->
                            <div class="form-group">
                                <select id="salesRep" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="Select Date" readonly>
                            </div>
                            <!-- <div class="form-group" style="display:none;">
                                <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                            </div> -->
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
                                <th>Name</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Shop Name</th>
                                <th>Order Value</th>
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
            var from_date;
            var to_date;
            var table1;
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
        $(document).ready(function () {
            $(".se-pre-con").hide();
        //     $.ajax({
        //             type: "GET",
        //             dataType: "json",
        //             url: api_path + "/admin/state_list.php",
        //         }).done(function(datas){
        //         let data = datas;
        //         let html_text="";
        //         html_text = '<option value="">Select State</option>';
        //         for (let key in data) {
        //             html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
        //         }
        //         $('#selectState').html(html_text);
        //     });
        // });

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
            
            // //sales rep
            // let region = {
            //     dashboard_code: verfication_code,
            //     type: "salesRep",
            // };
            // var json_data = JSON.stringify(region);
            // //console.log(json_data);
            // $.ajax({
            //     type: "POST",
            //     dataType: "json",
            //     url: api_path + "/admin/filterReportDropDown.php",
            //     data:json_data,
            // }).done(function(datas){
            //     let data = datas.data;
            //     console.log(data);

            //     let html_text = '<option value="">Select Sales Rep</option>';
            //     for (let key in data) {
            //         html_text += `<option value="${data[key].token}">${data[key].sales_rep_name}</option>`;
            //     }
            //     $('#salesRep').html(html_text);
            // });
       });    
       

      $(".primary-btn").click(function(){
        $('#table_data1').DataTable().destroy();
        $(".se-pre-con").fadeIn();
            fromDate = $("#fromDate").val();
            salesRep = $("#salesRep").val();
            //stateId = $("#selectState").val();
            if (fromDate != "" && salesRep != '') {
                let region = {
                    dashboard_code: verfication_code,
                    fromDate: fromDate,
                    salesRep: salesRep
                    //stateId: stateId
                };
                var json_data = JSON.stringify(region);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesRepReport1.php",
                    data:json_data,
                }).done(function(data){
                   success(data);
                   console.log(data);
                });
            }else{
                swal('Please select all dropdown value');
            }                     
      });
  
   
        var table_main_data;
        function success(data) {
            table_main_data = data.data;
            console.log(data);
            var html_text = "";
            for (var key in table_main_data) {
                html_text += '<tr>';
                html_text += '<td>' + table_main_data[key].name + '</td>';
                html_text += '<td>' + table_main_data[key].date_time + '</td>';
                html_text += '<td>' + table_main_data[key].area_name + '</td>';
                html_text += '<td>' + table_main_data[key].shop_name + '</td>';
                html_text += '<td>' + table_main_data[key].total_amount + '</td>';
                html_text += '</tr>';
            }
            $(".se-pre-con").hide();
            $("#table_body").html(html_text);
            table1 = $("#table_data1").DataTable({
                dom: 'Bfrtip',
                buttons: ['csv', 'pdf'],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
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