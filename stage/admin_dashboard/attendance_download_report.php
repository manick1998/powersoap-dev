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
        <title>Power Soap | attendance download report</title>
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
                        <h1 class="header_main">Download Report</h1>
                        <span class="table_count">Monthly Attendance Report for Sales Rep</span>
                        <div class="cred-btn-box">
                            <div class="form-group">
                                <select id="stateSel" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                            </div>
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                            </div>
                            <div class="form-group">
                                <button type="button" class="primary-btn">Go</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead id="tbl_thead">
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Designation</th>
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
            var api_path = "<?php echo $api_path; ?>";
            var verfication_code = "<?php echo $verification_code; ?>";
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
            // ===== date picker + default dates (full current month) =====
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
            (function () {
                var t = new Date();
                var y = t.getFullYear();
                var m = t.getMonth() + 1;
                var ms = String(m).length < 2 ? '0' + m : String(m);
                var lastDay = new Date(y, m, 0).getDate();
                var ld = String(lastDay).length < 2 ? '0' + lastDay : String(lastDay);
                $('#fromDate').val(y + '-' + ms + '-01');
                $('#toDate').val(y + '-' + ms + '-' + ld);
            })();

            // ===== load states =====
            $(document).ready(function () {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data: JSON.stringify({ type: "allstate" })
                }).done(function (datas) {
                    var html = '<option value="">Select State</option>';
                    for (var key in datas.data) {
                        html += '<option value="' + datas.data[key].state_token + '">' + datas.data[key].state_name + '</option>';
                    }
                    $('#stateSel').html(html);
                });
            });

            // ===== GO =====
            $(".primary-btn").click(function () {
                var state_id = $('#stateSel').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                if (!state_id) { swal('Please select State'); return; }
                if (!fromDate || !toDate) { swal('Please select From and To date'); return; }
                if (fromDate > toDate) { swal('From date must be before To date'); return; }

                $('.se-pre-con').fadeIn();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/attendance_monthly_report.php",
                    data: JSON.stringify({ state_id: state_id, fromDate: fromDate, toDate: toDate })
                }).done(function (res) {
                    $('.se-pre-con').fadeOut();
                    if (res.status_code != 200 || !res.data || res.data.length == 0) {
                        swal(res.message ? res.message : 'No records found');
                        return;
                    }
                    buildAttendanceTable(res.data);
                }).fail(function () {
                    $('.se-pre-con').fadeOut();
                    swal('Request failed!');
                });
            });

            // ===== build matrix table =====
            function buildAttendanceTable(data) {
                if ($.fn.DataTable.isDataTable('#table_data1')) {
                    $('#table_data1').DataTable().destroy();
                }
                var daysArr = data[0].days; // same day list for every rep
                var colors = { P: '#15803d', H: '#2563eb', S: '#dc2626', L: '#ea580c' };

                var thead = '<tr><th>S.No</th><th>Name</th><th>Designation</th>';
                for (var i = 0; i < daysArr.length; i++) {
                    thead += '<th>' + daysArr[i].day + '</th>';
                }
                thead += '<th>No. Of Absent</th><th>Total Working Days</th></tr>';
                $('#tbl_thead').html(thead);

                var body = '';
                for (var r = 0; r < data.length; r++) {
                    body += '<tr><td>' + data[r].sl + '</td><td>' + data[r].name + '</td><td>' + data[r].designation + '</td>';
                    for (var d = 0; d < daysArr.length; d++) {
                        if (data[r].days[d]) {
                            body += '<td style="color:' + colors[data[r].days[d].mark] + ';font-weight:bold;">' + data[r].days[d].mark + '</td>';
                        } else {
                            body += '<td>-</td>';
                        }
                    }
                    var abs = String(data[r].absent);
                    if (abs.length < 2) abs = '0' + abs;
                    body += '<td>' + abs + '</td><td>' + data[r].working + '</td></tr>';
                }
                $('#table_body').html(body);

                $('#table_data1').DataTable({
                    scrollX: true,
                    dom: 'Bfrtip',
                    buttons: ['csv','excel'],
                    order: [[0, 'asc']],
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
