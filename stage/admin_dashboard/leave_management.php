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
        <link rel="shortcut icon" href="assets/favicon.ico">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/offer.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">

        <style>
       
            label {
            font:
                1rem 'Fira Sans',
                sans-serif;
            }

            input {
            margin: 0.4rem;
            }
            .form-control {
                margin: 20px 0;
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
            .custom-nav__item a {
                padding: 7px 15px;
                color: #000;
            }
            .custom-nav__item a.active {
                background-color: #f3f7fa;
                border-bottom: 2px solid #04bcf4;
            }
            .custom-nav.statewise {
                flex-wrap: nowrap;
                padding-bottom: 12px;
                /* overflow-x: auto; */
            }
            .custom-nav.statewise a {
                white-space: nowrap;
            }
            /* .custom-nav.statewise::-webkit-scrollbar {
                display: block;
                background-color: #000;
                height: 4px;
                border-radius: 16px;
            }
            .custom-nav.statewise::-webkit-scrollbar-thumb {
                background-color: #232a77;
            }
            .custom-nav.statewise::-webkit-scrollbar-track {
                background-color: #cacaca;
            } */
            
            .btn_alingen .create-btn_wrong {
                    font: 14px var(--semibold-font);
                    width: 130px;
                    height: 40px;
                    border: 1px solid #a7b2b6;
                    border-radius: 2px;
                    outline: none;
                    text-transform: uppercase;
                    -webkit-transition: .3s;
                    transition: .3s;
                    
                   background-color: transparent;
                }
                
            .btn_alingen .create-btn_sucss {
                    font: 14px var(--semibold-font);
                    width: 130px;
                    height: 40px;
                    border: 1px solid #a7b2b6;
                    border-radius: 2px;
                    outline: none;
                    text-transform: uppercase;
                    -webkit-transition: .3s;
                    transition: .3s;
            
                   background-color: transparent;
                }

                /* .btn_alingen .create-btn:active,
                .btn_alingen .create-btn:focus,
                .btn_alingen .create-btn:visited
                 {
                    background-color: #00B9F5;
                    color: #fff;
                } */
                .btn_alingen {
                display: flex;
                justify-content: center;
                gap: 3rem;
            }
            .hide {
                display: none;
            }
            .after_suss {
                color: #43a048;
            }
            .after_wrong {
                color: #be1e2e;
            }
            .defult {
                color: #a7b2b6;
            }
            .btn_alingen .create-btn_sucss:hover {
                border: 1px solid #43a048;
            }
            .btn_alingen .create-btn_wrong:hover {
                border: 1px solid #be1e2e;
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
            <section class="bg-white brad-4" style="padding: 24px 16px;margin-bottom:16px;">
            <div class="scrollbar" id="style-1">
                <ul class="custom-nav nav nav-pills statewise force-overflow" id="stateList">
                </ul>

            </div>
            </section>
            <section class="bg-white brad-4 full-height" id="salesrep">
                <div class="header_container">
                    <div>
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span></h1>
                        <h1 class="header_main">Leave Management</h1>
<!--                        <span class="table_count">Total Sales Rep<span id="total_salesRep_count"></span></span>-->
                        <div class="cred-btn-box">
                            <button class="primary-btn" data-toggle="modal" data-target="#apply_leave" >Apply Leave</button>
                        </div>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>slno</th>
                                <th>Sales_Rep_Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Leave Shift</th>
                                <th>Reason</th>
                                <th>Action</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_Sales">
                        </tbody>
                    </table>
                </div>
            </section>
            
        </main>

        <div class="modal fade" id="apply_leave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Apply Leave</h2>
                    </div>
                    <input type="hidden" name="name1" id='hide_input' value="">

                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                    <div class="form-control region_token_box">
                                        <p for="offer_division">Sales rep</p>
                                        <select name="" id="sales_rep_names" class="input-field">

                                        </select>
                                    </div> 
                                    <div class="form-control sales_rep_name_box date_Picker">
                                        <p for="offer_name">From Date</p>
                                        <input type="date" class="input-field" id="datePicker_from" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="form-control sales_rep_name_box date_Picker">
                                        <p for="offer_name">To Date</p>
                                        <input type="date" class="input-field" id="datePicker_to" placeholder="DD-MM-YYYY">
                                    </div>
                                    <div class="form-control sales_rep_name_box date_Picker">
                                        <p for="offer_division">Shift</p>
                                        <select name="" id="shift" class="input-field">
                                            <option value="">Select Shift</option>
                                            <option value="fullday">Full Day</option>
                                            <option value="halfday">Half Day</option>
                                        </select>
                                    </div>
                                    <div class="form-control region_token_box">
                                        <p for="offer_division">Reason</p>
                                        <input type="text" class="input-field" id="reason" placeholder="Enter your reason">
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="apply_button" onclick="applyLeave()">Apply</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade " id="status-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Leave Status</h2>
                    </div>
               

                    <div class="modal-body">
                        <div class="modal-inner-body">
                           <fieldset>
                           <input type="radio" id="approved" name="radio" value="Approved">
                           <label for="approved">Approved</label>
                           &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                           <input type="radio" id="rejected" name="radio" value="Rejected">
                           <label for="rejected">Rejected</label>
                     </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="apply_button" onclick="applyConfirm()">Apply</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var gl_admin_token = "<?php echo $token; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        </script>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    
        <script>
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            // $('#datePicker_from').attr('min',today);
            // $('#datePicker_to').attr('min',today);

            function back_view_order(){
                location.reload();
            }
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var table;
            $(document).ready(function(){
                data_fetch();

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas){
                let data = datas;
                let html_text="";
                    for (let key in data) {
                        html_text += `<li class="custom-nav__item" data-id="${data[key].state_token}"><a href="#" data-toggle="tab">${data[key].state_name}</a></li>`;
                    }
                    $('#stateList').html(html_text);
                    $(".statewise li").on("click", function(){
                    admin_state_id = 0?0:$(this).data("id");
                    table.clear();
                    table.destroy();
                    data_fetch();
                });
                });
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
                    $('#sales_rep_names').html(html_text);
            });
     });
     function data_fetch(){
     $(".se-pre-con").hide();
        table = $('#table_data').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 2 ] }, 
            ],
            'ajax': {'url':api_path+"/admin/salesRepLeave.php?v_id="+verfication_code+"&&state_id="+admin_state_id},
            "order": [[0, "DESC" ]],
            'columns': [
                { data: 'sales_rep_token' },
                { data: 'salesname' },
                { data: 'start_date' },
                { data: 'end_date' },
                { data: 'leave_shift'},
                { data: 'reason' },
                { data: 'action' }, // Added missing comma here
                {data :'delete'}                             
            ],
            lengthChange:true,
                dom: 'lrtip',
                lengthMenu: [10,25,100,500,1000,5000,10000,100000],
            language: {
                search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
            }
        });
        table.column(0).visible(false);
        //$('.dataTables_length').css("display","none");
    }
    $(document).on('click', '.delete_leave', function(){
    
    const data_token = $(this).data('token1');
    
    var obj_data = {
        'data_token': data_token
    };
    
    let json_data = JSON.stringify(obj_data);

    swal({
        title: "Are you sure?",
        text: "You want to delete this leave request?", // Fixed text from "deliver this order"
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(function(willDelete){
        if (willDelete) {
             $.ajax({
                type: 'POST',
                dataType: "json",
                url: api_path + "/admin/salesRepLeave.php",
                data: json_data,
            }).done(function(response) { 
                
                console.log("Status Code:", response.code);
                
                if(response.code === 200) {
                    // Cleaner: Replace browser alert with a success SweetAlert
                    swal("Deleted!", response.message, "success");
                    
                    // Reloads your DataTable automatically on success
                    table.ajax.reload(null, false); 
                } else {
                    swal("Error", "Error: " + response.message, "error");
                }
                
            }).fail(function(xhr, status, error) {
                console.error("AJAX Error:", error);
                swal("Oops!", "Something went wrong on the server.", "error");
            });
        }
    });
});
    function applyLeave(){
        let sales_rep_token = $("#sales_rep_names ").find(':selected').val();
        let start_date=$("#datePicker_from").val();
        let end_date=$("#datePicker_to").val();
        let reason = $("#reason").val();
        let leave_shift = $("#shift ").find(':selected').text();
        if(sales_rep_token!="" && start_date!="" && end_date!="" && reason!="" && leave_shift !=""){
        let datas={
            "sales_rep_token":sales_rep_token,
            "start_date":start_date,
            "end_date":end_date,
            "admin_token":gl_admin_token,
            "reason":reason,
            "leave_shift":leave_shift
        }
        let json_data =JSON.stringify(datas);
        
       // console.log(json_data);
        $.ajax({
              type:'POST',
              dataType: "json",
              url: api_path + "/admin/addLeave.php",
             data: json_data,
            success:function(response){
            if(response.code ==201){
                swal("Leave Submited!", {
                icon: "success",
            }).then((value) => {
                 location.reload();
            });
        }else if(response.code==400){
            swal(response.message);
        }else{
            swal(response.message);
        }
    }
});
                 
  }else{
     swal("Enter all Details");
}
    }

//leave approve or reject
let sales_rep_token;
$("body").on("click","#statusbtn",function(){
 sales_rep_token = $(this).attr("data-token");

});
let token;
$("body").on("click","#statusbtn",function(){
 token = $(this).attr("data-token1");

});
    function applyConfirm(){
        var leave_status=$('input[type=radio]:checked').val();
        let datas={
            "token":token,
            "sales_rep_token":sales_rep_token,
            "admin_token":gl_admin_token,
            "leave_status":leave_status
        }
        let json_data =JSON.stringify(datas);
        console.log(json_data);
     if($("input[type=radio]").is(':checked')){
        $.ajax({
              type:'POST',
              dataType: "json",
              url: api_path + "/admin/updateLeave.php",
             data: json_data,
            success:function(response){
            if(response.code ==201){
                swal("Updated Leave!", {
                icon: "success",
            }).then((value) => {
                     location.reload();
            });
        }else if(response.code==400){
            swal(response.message);
        }else{
            swal(response.message);
        }
    }
});
                 
     }else{
        swal("Select AnyOne Option");
     }
    }

    </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>