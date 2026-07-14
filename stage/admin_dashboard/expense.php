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
        <title>Power Soap | Offer</title>
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
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/3.30.2/minified.js"></script>
        <!-- playground-hide -->
        <script>
          const process = { env: {} };
          process.env.GOOGLE_MAPS_API_KEY =
            "AIzaSyBnA5GAtJFECfmRwsSWmQ_svQ4sBGFtw00";
        </script>
        <style>
            #View_expance_detail {
                display: none;
            }
            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border: none !important;
                outline: 0;
            }
            .select2-container--default .select2-selection--multiple{
                border: none !important;
            }
            .form-control {
                margin: 0 0 20px;
            }
            .marginzero{
                margin: 0;
            }
            .form-control p {
                margin: 0;
                color: #798893;
                font-size: 14px;
                font-weight: 600;
                line-height: 20px;
                text-align: left;
            }

            .input-field {
                border: none;
                color: #333;
                width: 100%;
                font-size: 16px;
                line-height: 20px;
                outline: none;
            }
            h1.header_main img {
                width: 30px;
                height: 40px;
                object-fit: contain;
                margin-right: 1rem;
           }


            .delete-cls {
                cursor: pointer;
            }
            #map {
              height: 500px;
            }
            .gm-style-iw.gm-style-iw-c {
                padding-right: 12px !important;
                padding-bottom: 10px !important;
            }
            .cred-btn-box .nav-link.active {
            color: #fff;
            background-color: #04bcf4 !important;
            border: 1px solid #04bcf4;
            border-radius: 4px;
            }
            .product_list button {
            margin-left: 30px;
            border: 1px solid #03bcf4;
            background: #fff;
            color: #03bcf4;
            }
            .cred-btn-box {
                display: flex;
                gap: 10px;
            }
            .pdf-btn {
                height: 38px;
                background: #bc87f0 !important;
                padding: 8px 15px;
                border-radius: 4px;
                color: #fff !important;
                border: 1px solid #bc87f1 !important;
            }

            @media only screen and (max-width:1100px){
                #table_data1{
                    display: block;
                    overflow: hidden;
                    overflow-x: scroll;
                }
            }
            #regionrep{
                display:none;
            }
            #areaRep{
                display:none;
            }
            #area_dis{
                display:none;
                
            }

            .custom-nav{
                border-bottom: 1px solid #D9D9D9;
                display:flex;
                align-items: center;
            }
            .custom-nav{
            border-bottom: 1px solid #D9D9D9;
            display:flex;
            align-items: center;
            flex-wrap: nowrap;
            white-space: nowrap;
            /* overflow: auto; */
        }

                .scrollbar
        {	
            overflow-x: scroll;
        }
        
        #style-1::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 0;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar
        {
            height: 10px;
            background-color: #F5F5F5;
            display: block !important;
        }

        #style-1::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #c9c9c9;
        }
            .custom-nav__item{
                padding: 8px 24px;
                border-bottom:1px solid transparent;
                cursor: pointer;
                color: var(--light-gray);
                font: 15px var(--medium-font);
            }
            .custom-nav__item:hover {
                background-color: #f3f7fa;
            }
            .custom-nav__item.active {
                background-color: #f3f7fa;
                border-bottom: 2px solid #04bcf4;
                color: #000;
            }
            .custom-nav.statewise {
                flex-wrap: nowrap;
                padding-bottom: 12px;
                /* overflow-x: auto; */
            }
            .custom-nav.statewise a {
                white-space: nowrap;
            }
            .title_box {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .header_main {
                display: inline-block;
                text-transform: capitalize;
                font: 24px var(--medium-font);
                margin: 0;
                color: #000;
                letter-spacing: -0.75px;
                padding-bottom: 8px;
            }
            .twoinspace img {
                width: 30px;
                margin-right: 10px;
                object-fit: contain;
                cursor: pointer;
            }
            .page_contain{
                padding: 20px;
            }
            .profiledetails{

            }
            .flexarea{    
                display: flex;
                justify-content: flex-start;
                align-items: flex-start;
                padding: 20px 0;
            }
            .profileimage{
                width: 320px;
                height: 320px;
            }
            .profileupload{

            }
            .Uploading{
                width: 300px;
                height: auto;
                object-fit: contain;
            }
            .Employeedetail{

            }
            .flexsameview{
                display: flex;
                justify-content: flex-start;
                align-items: center;    
                margin-bottom: 20px;
            }
            .flexsameview p{
                text-transform: capitalize;
                font: 18px var(--medium-font);
                width: fit-content;
            }
            .flexsameview p span{    
                color: #333;
                font: 18px var(--regular-font);
                text-align: center;
                float: right;
                width: fit-content;
            }
            .flexsameview h3{
                text-transform: capitalize;
                font: 18px var(--regular-font);
            }
            .ticketfield{
                background-color: #dedede;
                padding: 20px;
                background-origin: padding-box;
                border-radius: 8px;
            }
            .ticketfield h2{
                text-transform: capitalize;
                font: 24px/30px var(--medium-font);
            }
            .insertphoto{
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
                align-items: center;
                gap: 20px;
            }
            .insertfield{
                text-align: center;
            }
            .insertfield h3{
                text-transform: capitalize;
                font: 18px var(--regular-font);
            }
            .insertimg{
                width: 200px;
                height: auto;
                object-fit: contain;
                margin-bottom: 10px;
            }
            .custom-nav{
                border-bottom: 1px solid #D9D9D9;
                display:flex;
                align-items: center;
            }
            .custom-nav__item{
                padding: 8px 24px;
                border-bottom:1px solid transparent;
                cursor: pointer;
                color: var(--light-gray);
                font: 15px var(--medium-font);
            }
            .custom-nav__item:hover {
                background-color: #f3f7fa;
            }
            .custom-nav__item a {
                padding: 7px 15px;
                color: #000;
            }
            .custom-nav__item a.active {
                background-color: #f3f7fa;
                border-bottom: 2px solid #04bcf4;
            }

            
            .custom-nav.statewise a {
                white-space: nowrap;
            }
            ol{
                list-style: none;
            }
             /* new Feature */
             .dataTables_info, .dataTables_wrapper .dataTables_length {
                padding-top:0;
            }

            .form-group {
                margin-bottom: 0;
            }
            .header_container {
                padding: 20px 20px 0;
            }

            .dataTables_filter label {
                top: 10px;
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
            <!-- <section class="bg-white brad-4" style="padding: 24px 16px;margin-bottom:16px;">
            <div class="scrollbar" id="style-1">
                <ul class="custom-nav nav nav-pills statewise force-overflow" id="stateList">
                </ul>

            </div>
            </section> -->
            <section class="bg-white brad-4 full-height" id="salesrep">
                <div class="header_container">
                    <div>
                    <!-- <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span></h1> -->
                        <h1 class="header_main">Expense List</h1>
                <!--                        <span class="table_count">Total Sales Rep<span id="total_salesRep_count"></span></span>-->
                        <div class="cred-btn-box">
                        <div class="form-group">
                                <select id="selectState" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="salesRep" class="form-control">
                                </select>
                            </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()"   type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate"   onchange="date_filter()"  type="text" placeholder="To Date" readonly>
                        </div>
                        <button onclick="show_ProductPDF()" class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                        </div>
                        
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>slno</th>
                                <th>Sales Rep Name</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_data">
                        </tbody>
                        
                    </table>
                </div>
            </section>
            
<section  class="bg-white brad-4 full-height" id="View_expance_detail">
    <div class="page_contain">      
        <div class="title_box">
            <div class="header_box">
             <!-- <p>Total Expense Today:<span id="expense_total"></span></p> -->
                <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="backtoexpense()" alt=""></span><span id="single_shop_name">Expense Detail</span></h1>
            </div>
        </div>
        <div class="profiledetails">
            <div class="flexarea">
                <div class="Employeedetail">
                    <div class="flexsameview">
                        <p>Employe Name : <span id="employee_name"></span></p>
                    </div>
                    <div class="flexsameview">
                        <p>Department : <span>Sales Rep</span></p>
                    </div>
                </div>
            </div>
            <div class="ticketfield">
                <h2>Ticket Details</h2>
                <!-- <div class="insertphoto">
                    <ol id="category">
                  </ol>

                  
               </div> -->
               <div class="table-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>category</th>
                                <th>amount</th>
                                <th>image</th>
                              
                            </tr>
                        </thead>
                        <tbody id="expenseDetails">
                        </tbody>
                        
                    </table>
                </div>
        </div>
</div>
</section>
</main>

        
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var state_id = "<?php echo $cookie_admin_state; ?>";
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
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    
        <script src="js/polyfill.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnA5GAtJFECfmRwsSWmQ_svQ4sBGFtw00"></script>
        <script src="https://unpkg.com/@googlemaps/js-api-loader@1.0.0/dist/index.min.js"></script>
        
        
        
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
            dateFormat: 'yy-mm-dd',
            maxDate: 0 
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd',
            maxDate: 0 
        });

        function viewDetail() {
            $("#View_expance_detail").show();
            $("#salesrep").hide();
        }
        function backtoexpense() {
            $("#salesrep").show();
            $("#View_expance_detail").hide();
        }
        function back_view_order(){
            location.reload();
        }

</script>


<script>
        
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table1;
        $(document).ready(function () {
            datavalue(state_id);
           
            $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas){
                let data = datas;
               let html_text = '<option value="">Select State</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                }
                $('#selectState').html(html_text);
    });
        });
            //sales rep
            $('#selectState').on('change',function(){
                state_id=$("#selectState").val();
            let region = {
                dashboard_code: verfication_code,
                type: "salesRep",
                state_id: state_id
            };
            var json_data = JSON.stringify(region);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/filterReportDropDown.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                console.log(data);

                let html_text = '<option value="">Select Sales Rep</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].token}">${data[key].sales_rep_name}</option>`;
                }
               $('#salesRep').html(html_text);
            });
       });    

       
      function date_filter() {
                 from_date = $("#fromDate").val();
                 to_date = $("#toDate").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDate").val(from_date);
                }
                 to_date = $("#toDate").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    table1.clear();
                    table1.destroy();
                    datavalue(state_id,from_date,to_date);
                }
            }
   
        function datavalue(state_id,from_date,to_date){
            salesRep =$("#salesRep").val();
            var datas = {
                from_date:from_date,
                to_date:to_date,
                state_id:state_id,
                salesRep:salesRep,
                type: "Allexpense"
            };
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/expenseDetail.php",
                data: json_data,
                success: success,
            });
        }
        var table_main_data;
        function success(data) {
            table_main_data = data.data;
            //console.log(table_main_data);
            var html_text = "";
            var slno = 0;
            for (var key in table_main_data) {
                slno++;
                html_text += '<tr>';
                html_text += '<td>' + slno + '</td>';
                html_text += '<td>' + table_main_data[key].name + '</td>';
                html_text += '<td>' + table_main_data[key].date_time + '</td>';
                html_text += '<td>' + table_main_data[key].total + '</td>';
                html_text += '<td>' + table_main_data[key].module + '</td>';
                html_text += '<td>' + table_main_data[key].amount + '</td>';
                html_text += ` <td><a href="JavaScript:void(0)" id="editModule" onclick="viewDetail()" data-token=${table_main_data[key].token} data-token1=${table_main_data[key].date_time} data-toggle="modal">View</a></td>`;
                html_text += '</tr>';
            }
            $(".se-pre-con").hide();
            $("#table_data").html(html_text);
            table1 = $("#table_data1").DataTable({
                dom: 'Bfrtip',
                buttons: [],
                "columnDefs": [
                    {
                        "visible": false,
                        "searchable": false
                    }
                ],
                lengthChange:true,
                dom: 'Bfrltip',
                lengthMenu: [10,25,100,500,1000,5000,10000,100000],
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
        $('body').on('click','#editModule',function(){
            let token = $(this).attr('data-token');
            let date = $(this).attr('data-token1');
        var datas = {
            token:token,
            date:date
        };
        var json_data = JSON.stringify(datas);
        //console.log(json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/expenseViewDetails.php",
            data: json_data,
        }).done(function(data) {
            var emp_data = data.data;
            console.log(emp_data);
            $("#employee_name").html(emp_data.name);
           let li_html='';
           let ex_html='';
           li_html += '<tr>';
           li_html += '<td>' + emp_data.category_module + '</td>';
           li_html += '<td>' + emp_data.amount  + '</td>';
           var images=emp_data.image;
           console.log(images);
            for(var key1 in images){
                 ex_html += '<a href="'+ images[key1] +'" download><img src="' + images[key1] + '" alt="" width="100" height="100"></a>';
              }
                 li_html += `<td>${ex_html} </div></td>`;
                 li_html += '</tr>';
            $("#expenseDetails").html(li_html);
            $('#View_expance_detail').show();
         });
    });
    function show_ProductPDF(){
        var from_date=$("#fromDate").val();
        var to_date=$("#toDate").val();
        var salesRep =$("#salesRep").val();
    var data={
        'invoice_name': "",
    }
    $.ajax({
                type: "POST",
                dataType: "json",
                url : "../TCPDF-main/examples/ExpenseListPdf.php?from_date="+from_date+"&&to_date="+to_date+"&&state_id="+state_id+"&&salesRep="+salesRep,
                data: data,
                }).done(function(data) {
                    if(data.status_code==200){
                    $(".se-pre-con").hide();
                    window.open('../invoice_pdf/'+data.data, '_blank');
                    }else{
                        swal("Something Happened!", {icon: "failed"});
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