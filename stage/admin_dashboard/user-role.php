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
        <title>Role and Access</title>
        <link rel="shortcut icon" href="assets/favi.png">

        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/user-roles.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">

        <style>
            span.error {
                color: red;
                display: inline-block;
                margin-top: 6px;
                margin-bottom: 6px;
            }
            .form__detail {
                position: relative;
                height: unset;
            }
        .update-btn{
        font: 16px var(--semibold-font);
        width: 130px;
        height: 40px;
        border: 1px solid #00B9F5;
        border-radius: 2px;
        background-color: #00B9F5;
        color: #fff;
        outline: none;
        text-transform: uppercase;
        -webkit-transition: .3s;
        transition: .3s;
        }
        .downloadcsv{
            display:none;
        }
        </style>
    </head>

    <body>
    <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>

        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar9"></div>

        <!-- main-contents -->
        <main class="main-contents">


            <section class="bg-white brad-4 full-height" id="employee">
                <div class="product_header_container">
                    <div class="header-details ">
                        <h1 class="header_main">User List <span class="total_emp">Total Users -<span>12</span></span></h1>
                    </div>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <button class="nav-link active adduser" id="pills-home-tab" data-toggle="modal" data-target="#role_popup"><span><img class="" src="assets/icons/add_employee.png" alt=""></span>Add Users</button>
                    </li>
                    <li class="nav-item downloadcsv">
                        <button class="nav-link" type="button">Download CSV</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="custom-table" id="dataTables_filter1">
                            <thead>
                                <tr>
                                    <th>SI.NO</th>
                                    <th>User Name</th>
                                    <th>Email Address</th>
                                    <th>Created on</th>
                                    <th>Module</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class = "table_body">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="" id="editModule" data-toggle="modal" data-target="#view_userrole">Edit</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </main>

        <div class="modal fade" id="role_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add User</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="dev-set">
                                <div class="info-set">
                                    <div class="form__detail">
                                        <input type="text" id="user_name" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">User Name</label>
                                    </div>
                                </div>
                                <div class="info-set">
                                    <div class="form__detail">
                                        <input type="text" id="user_email" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Email Address</label>
                                    </div>
                                </div>
                                <div class="info-set">
                                    <div class="form__detail">
                                        <!-- <input type="text" id="user_email" class="form__input" placeholder=" "> -->
                                        <select class="form__input role_option" id="role_option">
                                            <option value="">-Select Option-</option>
                                            <!-- <option value="1">1</option> -->
                                        </select>
                                        <label for="" class="form__label">State</label>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="underline-dev">
                            </div>
                            <div class="module-op-set">
                                <p>Modules</p>
                                <div class="module-op-filer-set" id="usermodule">
<!--
                                    <div class="module-option">
                                        <label for="user_mang">
                                            <input type="checkbox" id="user_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            User Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="cat_prod_mang">
                                            <input type="checkbox" id="cat_prod_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Category/Product Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="data_mang">
                                            <input type="checkbox" id="data_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Data Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="user_mang">
                                            <input type="checkbox" id="user_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Banner Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="cat_prod_mang">
                                            <input type="checkbox" id="cat_prod_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Afiliate Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="data_mang">
                                            <input type="checkbox" id="data_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            User role and access
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="user_mang">
                                            <input type="checkbox" id="user_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Legal settings
                                        </label>
                                    </div>
-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn">Create</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="view_userrole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit User</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="dev-set">
                                <div class="info-set">
                                    <div class="form__detail">
                                        <input type="text" id="user_name1" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Username</label>
                                    </div>
                                </div>
                                <div class="info-set">
                                    <div class="form__detail">
                                        <input type="text" id="user_email1" class="form__input" placeholder=" ">
                                        <label for="" class="form__label">Email Address</label>
                                    </div>
                                </div>
                                <div class="info-set">
                                    <div class="form__detail">
                                        <!-- <input type="text" id="user_email" class="form__input" placeholder=" "> -->
                                        <select class="form__input role_option" id="edit_role_option">
                                            <option value="">-Select Option-</option>
                                            <!-- <option value="1">1</option> -->
                                        </select>
                                        <label for="" class="form__label">State</label>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="underline-dev">
                            </div>
                            <div class="module-op-set">
                                <p>Modules</p>
                                <div class="module-op-filer-set" id="usermodule1">
<!--
                                    <div class="module-option">
                                        <label for="user_mang">
                                            <input type="checkbox" id="user_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            User Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="cat_prod_mang">
                                            <input type="checkbox" id="cat_prod_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Category/Product Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="data_mang">
                                            <input type="checkbox" id="data_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Data Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="user_mang">
                                            <input type="checkbox" id="user_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Banner Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="cat_prod_mang">
                                            <input type="checkbox" id="cat_prod_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Afiliate Management
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="data_mang">
                                            <input type="checkbox" id="data_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            User role and access
                                        </label>
                                    </div>
                                    <div class="module-option">
                                        <label for="user_mang">
                                            <input type="checkbox" id="user_mang" class="modal-input hidden">
                                            <span class="cust-checkbox"></span>
                                            Legal settings
                                        </label>
                                    </div>
-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" id="cancel-update" data-dismiss="modal">Cancel</button>
                        <button class="update-btn" id = "updatebtn">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        </script>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
<!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>-->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";

            $(document).ready(function(){
                $(".se-pre-con").hide();
                //get option
                $.ajax({
                    type: "POST",
                    url: api_path + "/admin/state_list.php",
                    dataType: "json",
                    success: function(response) {
                        let options = "";
                                options += `<option value="" >Select State</option>`;
                            response.forEach(function(item, index) {
                                options += `<option value="${item.state_token}" >${item.state_name}</option>`;
                            });
                        $("#role_option").html(options);
                        $("#edit_role_option").html(options);  
                    }
                });

                //get  module list
                $.ajax({
                    type: "POST",
                    url: api_path + "/admin/list_user_module.php",
                    dataType : "json",
                    success: function(response){
                        let module_list = "";
                        response.forEach(function(item, index) {
                            module_list += `
                                <div class="module-option">
                                <label for="user_mang${index}">
                                <input type="checkbox" id="user_mang${index}" data-token = "${item.id}" name = "modules" value="${item.module_name}" class="modal-input hidden">
                                <span class="cust-checkbox"></span>
                                ${item.module_name}
                                </label>
                                </div>`
                        });
                        $("#usermodule").html(module_list);
                        $("#usermodule1").html(module_list);
                    }
                });
                
                   //list access roles
                var datas1 = {
                    'type': 'all_admin_details'
                }
                var json_data = JSON.stringify(datas1);
                $.ajax({
                    type: "POST",
                    url: api_path + "/admin/moduleList.php",
                    dataType: "json",
                    data: json_data,
                    success : function(response){
                        $(".total_emp").html(`Total Users -${response.data.length}`);
                        let accessList = "";
                            response.data.forEach(function(item,index){
                                let status = "";
                                let color = "";
                                let modules = "";
                                if(item.status == 1){
                                    status = `<a href="javascript:void(0)"  class = "statusbtn" id="statusbtn1" style="color:orange" data-token="${item.token}">Block</a>`;
                                    // color = "orange";
                                }
                                else if(item.status == 2){
                                    status = `<a href="javascript:void(0)"  class = "statusbtn1" id="statusbtn2" style="color:green" data-token="${item.token}">Unblock</a>`;
                                    // color = "green";
                                }
                                accessList += `<tr role="row" class="odd">
                                                <td class="sorting_1">${index+1}</td>
                                                <td>${item.name}</td>
                                                <td>${item.email}</td>
                                                <td>${item.date_time}</td>
                                                <td>${item.module_name}</td>
                                                <td>${status}</td>
                                                <td><a href="" id="editModule" data-token=${item.token} data-toggle="modal" data-target="#view_userrole">Edit</a></td>
                                                </tr>`
                            });
                            $('#dataTables_filter1').DataTable().destroy();
                            $("#dataTables_filter1").find(".table_body").html(accessList);
                            $('#dataTables_filter1').DataTable({
                                language: {
                                    search: '<img src="assets/svg/Search_icon.svg">',
                                    searchPlaceholder: "Search",
                                    // paginate: {
                                    //   next: '<img src="img/icons/down-arrow.svg">', // or '→'
                                    //   previous: '<img src="img/icons/down-arrow.svg">', // or '←'
                                    // },
                                },
                                dom: "Bfrtip",
                                buttons: [
                                    // {
                                    // extend: "pdf",
                                    // footer: true,
                                    // title: "UserAccessRole",
                                    // exportOptions: {
                                    //     columns: [0, 1, 2,3],
                                    // },
                                    // },
                                    // {
                                    // extend: "csv",
                                    // footer: true,
                                    // title: "UserAccessRole",
                                    // exportOptions: {
                                    //     columns: [0, 1, 2,3],
                                    // },
                                    // },
                                ],
                                order: [],
                                }).draw();
                    }
                });
                
            });

            $("body").on("click","#statusbtn1",function(){
                let admin_token = $(this).attr("data-token");
                let type = "status";
                let datas = {
                            admin_token : admin_token,
                            type : type
                            }
                let data = JSON.stringify(datas);
                
                swal({
                    title: `Are you sure want to Block this User?`,
							icon: "warning",
							buttons: [
								'No, cancel it!',
								'Yes, I am sure!'
							],
							dangerMode: true,
                    }).then(function(isConfirm){
                        if(isConfirm){
                            $.ajax({
                                type: "POST",
                                url: api_path + "/admin/moduleList.php",
                                dataType: "json",
                                data: data,
                                success:function(response){
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success",
                                        button: "Ok",
                                    }).then((value) => {
                                        location.reload();
                                        
                                    });
                                }
                            })
                        }else {
								swal("Cancelled", "", "error");
							}

                    })

            })

            //unblock status update
            $("body").on("click","#statusbtn2",function(){
                $(".se-pre-con").show();
                let admin_token = $(this).attr("data-token");
                let datas = {
                            admin_token : admin_token,
                            type : "statusUpdate"
                            }
                            let data = JSON.stringify(datas);
                            swal({
                                title: `Are you sure want to UnBlock this User?`,
                                        icon: "warning",
                                        buttons: [
                                            'No, cancel it!',
                                            'Yes, I am sure!'
                                        ],
                                        dangerMode: true,
                                }).then(function(isConfirm){
                                if(isConfirm){
                                            $.ajax({
                                            type: "POST",
                                            url: api_path + "/admin/moduleList.php",
                                            dataType: "json",
                                            data: data,
                                            success:function(response){
                                                swal({
                                                    title: "Success!",
                                                    text: response.message,
                                                    icon: "success",
                                                    button: "Ok",
                                                }).then((value) => {
                                                    location.reload();
                                                });
                                            }
                                    })
                                }else {
                                        swal("Cancelled", "", "error");
                                    }

                    })

                            
            })

                //adduser
                $("body").on("click",".create-btn",function(){
                    $(".se-pre-con").show();
                    let user_name = $("#user_name").val();
                    let user_email = $("#user_email").val();
                    let mailFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    let user_state = $('#role_option :selected').val();
                    let checked_module = []; 
                    $('input[name="modules"]:checked').each(function() {
                    checked_module.push($(this).val());
                    });
                    let module_id = [];
                    $('input[name="modules"]:checked').each(function() {
                    module_id.push($(this).attr("data-token"));
                    });
                    let datas = {
                        user_name : user_name,
                        user_email : user_email,
                        user_state : user_state,
                        checked_module : checked_module,
                        module_id : module_id
                    }
                    let data = JSON.stringify(datas);
                    
                    if(user_email != "" && mailFormat.test(user_email) && user_name !="" && user_state != "" && checked_module !="" ){
                        $.ajax({
                            type: "POST",
                            url: api_path + "/admin/create_module.php",
                            dataType: "json",
                            data : data,
                            success:function(response){
                                if(response.code == 201){
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success",
                                        button: "Ok",
                                    }).then((value) => {
                                        location.reload();
                                    });
                                }else{
                                    swal({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error",
                                        button: "Ok",
                                    });
                                }
                            }

                        });

                    }else{
                        $(".error").remove();
                        if(user_name == ""){
                            $("#user_name").parent().append("<span class='error'>* User Name is Required</span>");
                        }
                        
                        if(user_email == ""){
                            $("#user_email").parent().append("<span class='error'>* Email is Required</span>");
                        }
                        else if(!mailFormat.test(user_email)){
                            $("#user_email").parent().append("<span class='error'>* Please provide a valid Email</span>");
                        }
                        if(user_state == ""){
                            $("#role_option").parent().append("<span class='error'>* State is Required</span>");
                        }
                        if(checked_module == ""){
                            swal({
                                title: "Error!",
                                text: "Please select Roles",
                                icon: "error",
                                button: "Ok",
                                });
                        }
                    }
                });

             

                //edituseraccessmodule
                $("body").on("click","#editModule",function(){
                    let token = $(this).attr("data-token");
                    $("#updatebtn").attr("data-token",token);
                    var datas = {
                        admin_token : token,
                        type : 'edit_admin_module'
                    }
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                    type: "POST",
                    url: api_path + "/admin/moduleList.php",
                    dataType: "json",
                    data: json_data,     
                    success : function(response){
                            item = response.data;
                           // console.log(response);
                            var module_details = item.modules_data;
                            var module_name = [];
                            module_details.forEach(function(module_value, index){
                                module_name.push(module_value.module_name);
                            });
                            $("#user_name1").val(item.name);
                            $("#user_email1").val(item.email);
                            $("#edit_role_option").val(item.state_token);
                            $("#usermodule1 .module-option  input[type = 'checkbox']").each( function(){
                                if(module_name.includes($(this).val())){
                                    $(this).prop("checked", true);     
                                }
                                else{
                                    $(this).prop("checked", false); 
                                }
                            }); 

                            $(".module-option label").click( function(){
                                if( $(this).find("input").prop("checked")) {
                                    $(this).find("input").prop("checked",false)
                                } else if($(this).find("input").prop("checked",false)) {
                                    $(this).find("input").prop("checked",true)
                                }
                            });

                            $("#view_userrole").modal("show");

                        }
                    });
                });

                //update modules
                $('#updatebtn').click(function(){
                    $(".se-pre-con").show();
                let moduleToken = $(this).attr("data-token");
                let moduleName= $("#user_name1").val();
                let moduleEmail=$("#user_email1").val();
                let mailFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                let module_array = []; 
                $('input[name="modules"]:checked').each(function() {
                    module_array.push($(this).attr("data-token"));
                });
                    let datas = {
                        token : moduleToken,
                        name :moduleName,
                        email:moduleEmail,
                        module_id : module_array
                    }
                    let data = JSON.stringify(datas);
                    //console.log(data);
                    if(moduleEmail != "" && mailFormat.test(moduleEmail) && moduleName !=""){
                        //update
                        $.ajax({
                            type: "POST",
                            url: api_path + "/admin/update_user_roles.php",
                            dataType : "json",
                            data : data,
                                success:function(response){
                                    if(response.status_code == 200){
                                        swal({
                                            title: "Success!",
                                            text: response.message,
                                            icon: "success",
                                            button: "Ok",
                                        }).then((value) => {
                                            location.reload();
                                        });
                                    }else{
                                        swal({
                                            title: "Please Select Module!",
                                            text: response.message,
                                            icon: "error",
                                            button: "Ok",
                                        });
                                    }
                                }
                        })
                     }else{
                        $(".error").remove();
                        if(moduleName == ""){
                            $("#user_name1").parent().append("<span class='error'>* User Name is Required</span>");
                        }
                        
                        if(moduleEmail == ""){
                            $("#user_email1").parent().append("<span class='error'>* Email is Required</span>");
                        }
                        else if(!mailFormat.test(user_email)){
                            $("#user_email1").parent().append("<span class='error'>* Please provide a valid Email</span>");
                        }
                        if(module_array == ""){
                            swal({
                                title: "Error!",
                                text: "Please select Roles",
                                icon: "error",
                                button: "Ok",
                                });
                        }
                    }
                });
            
        </script>
    </body>
    </html>
<?php
}
mysqli_close($link);
?>