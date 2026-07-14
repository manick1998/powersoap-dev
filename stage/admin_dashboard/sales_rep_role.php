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

        <style>
            .dataTables_filter .form-control {
                width: 100%;
            }
            .cred-btn-box {
                width: 100%;
                    align-items: baseline;
            }
            .roleAdd{    
                padding: 0;
                text-align: left;
            }
            .dt-buttons.btn-group {
                margin-left: 30px;
            }
            .insideBtn {
                position: relative;
            }
            .inputRemove{
                color: red;
                position: absolute;
                right: 10px;
                top: 15px;
            }
            .inputRemove:hover {
                color: red;
            }
            .closeBtn {
                width: 25px;
                height: 25px;
                object-fit: contain;
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
                        <h1 class="header_main">Sales Rep Roles</h1>
                        <!-- <span class="table_count">Total Sales Rep<span id=""></span></span> -->
                        <div class="cred-btn-box ">
                            <div class="form-group">
                                <button type="button"  class="primary-btn" data-toggle="modal" data-target="#exampleModal" >Create Roles</button>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>SI.No</th>
                                <th>State</th>
                                <th>Role</th>
                                <th>Allowance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                        </tbody>
                        
                    </table>
                </div>
            </section>
        </main>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add Sales Rep Roles</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                <div class="form-control ">
                                        <p for="offer_division" class="input-field state_id">Choose State</p>
                                        <select class="input-field" id="state_id">
                                            <!-- <option value="">Choose State</option>
                                            <option value="Tamilnadu">Tamilnadu</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option> -->
                                        </select>
                                    </div>
                                    <div class="form-control ">
                                        <p for="offer_name" class="input-field rols_token">Role Name</p>
                                        <select class="input-field" id="rols_token">
                                        </select>
                                        <!-- <input type="text" class="input-field" id="rols_token" required placeholder="Please Enter Name"> -->
                                    </div>
                                    <div id="req_input" class="datainputs">
                                        <div class="form-control ">
                                            <p for="offer_percentage" class="input-field alamount1">Amount</p>
                                            <input type="text" id="alamount1" class="input-field countbox" placeholder="Please Enter Amount" >
                                        </div>
                                    </div>
                                    <div class="roleAdd ">
                                        <a href="#" id="addmore" class="add_input">Add more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="add_sales_button">Create</button>
                        <!-- onclick="add_sales_rep()" -->
                    </div>
                </div>
            </div>
        </div>

         <!-- edit modele -->

        <div class="modal fade" id="edit_exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit Sales Rep Roles</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                <div class="form-control ">
                                        <p for="offer_division" class="input-field edit_state_id">Choose State</p>
                                        <select class="input-field" id="edit_state_id">
                                            <!-- <option value="">Choose State</option>
                                            <option value="Tamilnadu">Tamilnadu</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option> -->
                                        </select>
                                    </div>
                                    <div class="form-control ">
                                        <p for="offer_name" class="input-field edit_rols_token">Role Name</p>
                                        <select class="input-field" id="edit_rols_token">
                                        </select>
                                        <!-- <input type="text" class="input-field" id="rols_token" required placeholder="Please Enter Name"> -->
                                    </div>
                                    <div id="edit_req_input" class="datainputs">
                                        <div class="form-control">
                                            <p for="offer_percentage" class="input-field edit_alamount1">Amount</p>
                                            <input type="text" id="edit_alamount1" class="input-field edit_countbox" placeholder="Please Enter Amount" >
                                            <input type="hidden" id="rep_al_token">
                                        </div>
                                    </div>
                                    <div class="roleAdd ">
                                        <a href="#" id="edit_addmore" class="add_input">Add more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="edit_sales_button">Update</button>
                        <!-- onclick="add_sales_rep()" -->
                    </div>
                </div>
            </div>
        </div>
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
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script>
             var verfication_code = "<?php echo $verification_code; ?>";
             var api_path = "<?php echo $api_path; ?>";
             var table;
        $(document).ready(function() {
            
            //========== Add Amount fild

            $("#addmore").click(function() {
                $(this).hide();
                $("#req_input").append(`
                <div class="form-control insideBtn ">
                    <p for="offer_percentage" class="input-field ">Amount</p>
                    <input type="text" id="alamount2" class="input-field countbox" placeholder="Please Amount" >
                    <a href="#" id="removemore" class="inputRemove"><img src="./assets/svg/close.svg" alt="close" class="closeBtn" /></a>
                </div>`);
            });
            $('body').on('click','.inputRemove',function() {
                $(this).parent('div.insideBtn').remove();
                $('#addmore').show();
            });
            //========== edit Amount fild
             $("#edit_addmore").click(function() {
                $('#edit_addmore').hide();
                $("#edit_req_input").append(`
                <div class="form-control insideBtn ">
                    <p for="offer_percentage" class="input-field ">Amount</p>
                    <input type="text" id="edit_alamount2" class="input-field edit_countbox" placeholder="Please Amount" >
                    <a href="#" id="edit_removemore" class="inputRemove"><img src="./assets/svg/close.svg" alt="close" class="closeBtn" /></a>
                </div>`);
             });
             $('#edit_addmore').hide();
            $("#edit_req_input").append(`
                <div class="form-control insideBtn ">
                    <p for="offer_percentage" class="input-field ">Amount</p>
                    <input type="text" id="edit_alamount2" class="input-field edit_countbox" placeholder="Please Amount" >
                    <a href="#" id="edit_removemore" class="inputRemove"><img src="./assets/svg/close.svg" alt="close" class="closeBtn" /></a>
                </div>`);
            
            $('body').on('click','.inputRemove',function() {
                $(this).parent('div.insideBtn').remove();
                $('#edit_addmore').show();
            });

            
            //=========show table data
            var data = {
                verfication_code:verfication_code,
                type : 'table_datas'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesrep_role_amt.php",
                    data: json_data,
            }).done(function(result4){
                console.log('result4',result4);
                var html1 = '';
                var i = 1;
                result4.roll_amt_data.forEach(function(item,index){
                    html1 += `<tr>`
                    html1 += `<td>${i++}</td>`
                    html1 += `<td>${item.state_name}</td>`
                    html1 += `<td>${item.dep_name}</td>`
                    html1 += `<td>${item.al_amount}</td>`
                    html1 += `<td><a data-toggle="modal" id='edit_btn' data-al_amount ='${item.al_amount}' data-sales_allowance_token = '${item.sales_allowance_token}' data-state_token = '${item.state_token}' data-dep_token = '${item.dep_token}' data-target="#edit_exampleModal"><img src="assets/edit.png" class="add_input employee_code_edit" alt="" /></a></td>`
                    //onclick="showeditehadler()"
                    html1 += `</tr>`
                });
               $('#table_body').html(html1);
                 table = $("#table_data1").DataTable({
                        "scrollX": true,
                        dom: 'Bfrtip',
                        "ordering": false,
                        buttons: [],
                        language: {
                            searching: false,
                            search: '<img src="assets/svg/Search_icon.svg">',
                            searchPlaceholder: "Search",
                            paginate: {
                                next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                            }
                        }
                    }); 
                    $(".se-pre-con").hide();
            });

            //=========All State
            var data = {
                verfication_code:verfication_code,
                type : 'all_state'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesrep_role_amt.php",
                    data: json_data,
            }).done(function(result){
                var html = `<option value="">Select State</option>`
                result.data.forEach(function(item,index){
                    html += `<option value="${item.state_token}">${item.state_name}</option>`;
                });
                $('#state_id').append(html);
            });
            //========== REP designation
        var data = {
                verfication_code:verfication_code,
                type : 'designation'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesrep_role_amt.php",
                    data: json_data,
            }).done(function(result1){
                // console.log('result1',result1);
                var html = `<option value="">Select State</option>`
                result1.rollsdata.forEach(function(item,index){
                    html += `<option value="${item.rolls_token}">${item.rolls_name}</option>`;
                });
                $('#rols_token').append(html);
            });
        });

        //==========Add rols Amount

        $(document).on('click','#add_sales_button',function(){
            $(".se-pre-con").show();
            // $('#add_sales_button').prop('disabled', true);
            var numItems = $('.countbox').length;
           console.log('countclass',numItems);
            var datas = '';
            var state_token = $('#state_id').val();
            var val1 = value_check('state_id', state_token,'text_box');
            console.log('val1',val1);
            var roles_token = $('#rols_token').val();
            var val2 = value_check('rols_token', roles_token,'text_box');
            var alamount1 = $('#alamount1').val();
            var val3 = value_check('alamount1', alamount1,'text_box');
            var alamount2 = $('#alamount2').val();
            if (val1 == true && val2 == true && val3 == true) {
                    if (numItems == 1) {
                    datas = {
                        state_token:state_token,
                        roles_token:roles_token,
                        alamount1:alamount1,
                        type : 'addamount1'
                    };
                }else{
                    datas = {
                        state_token:state_token,
                        roles_token:roles_token,
                        alamount1:alamount1,
                        alamount2:alamount2,
                        type : 'addamount2'
                    };
                }
                var json_data = JSON.stringify(datas);
                console.log('json_data',json_data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/salesrep_role_amt.php",
                        data: json_data,
                }).done(function(result3){
                        console.log(result3);
                    if (result3.status_code == 200) {
                        swal("Roles Amount added successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal(data.message);
                    }
                });
            }else{
                    $('.form-control').css({'border':'1px solid #ed3833'});
                swal("Please enter all details!");
            }
            

        });
        //=========Edit All State
        $(document).on('click','#edit_btn',function(e){
            // $(".se-pre-con").show();
            var edit_state_token = $(this).attr('data-state_token');
            var edit_dep_token = $(this).attr('data-dep_token');
            var al_amount = $(this).attr('data-al_amount');
            var split_amt = al_amount.split(',');
            $('#edit_alamount1').val(split_amt[0]);     
            $('#edit_alamount2').val(split_amt[1]);
            var rep_al_token = $(this).attr('data-sales_allowance_token');
            $('#rep_al_token').val(rep_al_token);
            var data = {
                verfication_code:verfication_code,
                type : 'all_state'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesrep_role_amt.php",
                    data: json_data,
            }).done(function(result){
                var html = `<option value="">Select State</option>`
                result.data.forEach(function(item,index){
                    html += `<option value="${item.state_token}"${item.state_token === edit_state_token ? 'selected' : ''}>${item.state_name}</option>`;
                });
                $('#edit_state_id').html(html);
            });
            //========== Edit REP designation
            var data = {
                verfication_code:verfication_code,
                type : 'designation'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesrep_role_amt.php",
                    data: json_data,
            }).done(function(result1){
                // console.log('result1',result1);
                var html = `<option value="">Select State</option>`
                result1.rollsdata.forEach(function(item,index){
                    html += `<option value="${item.rolls_token}" ${item.rolls_token===edit_dep_token ? 'selected':''} >${item.rolls_name}</option>`;
                });
                $('#edit_rols_token').html(html);
            });
        
        });
            // ===== Update rols amount
         $(document).on('click','#edit_sales_button',function(){
            var numItems = $('.edit_countbox').length;
           console.log('countclass',numItems);
            var datas = '';
            var state_token = $('#edit_state_id').val();
            var val1 = value_check('edit_state_id', state_token,'text_box');
            var roles_token = $('#edit_rols_token').val();
            var val2 = value_check('edit_rols_token', roles_token,'text_box');
            var alamount1 = $('#edit_alamount1').val();
            var val3 = value_check('edit_alamount1', alamount1,'text_box');
            var alamount2 = $('#edit_alamount2').val();
            var rep_al_token = $('#rep_al_token').val();
            if (val1 == true && val2 == true && val3 == true) {
                    if (numItems == 1) {
                        datas = {
                            state_token:state_token,
                            roles_token:roles_token,
                            alamount1:alamount1,
                            rep_al_token:rep_al_token,
                            type : 'update_addamount1'
                        };
                    }else{
                        datas = {
                            state_token:state_token,
                            roles_token:roles_token,
                            alamount1:alamount1,
                            alamount2:alamount2,
                            rep_al_token:rep_al_token,
                            type : 'update_addamount2'
                        };
                    }
                    var json_data = JSON.stringify(datas);
                    console.log('json_data',json_data);
                    $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/salesrep_role_amt.php",
                            data: json_data,
                    }).done(function(res){
                            console.log(res);
                        if (res.status_code == 200) {
                            swal("Updated successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            swal(res.message);
                        }
                    });
                }else{
                    $('.form-control').css({'border':'1px solid #ed3833'});
                    swal("Please enter all details!");
                }
        })   
    </script>
    </body>
</html>
<?php
}
//mysqli_close($link);
?>