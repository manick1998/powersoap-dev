<?php
    include "config.php";
    include "$api_path/config/core_distributor.php";
//    if($cookie_admin_name ==""){
//        header("Location:shop_type.php");
//    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Soaps</title>
    <link rel="shortcut icon" href="assets/favi.png">
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <!-- <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>"> -->
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
<style>
    .a_button {
    color: #00b9f5;
    }
    .a_button:hover{
        color: #fff;
    }
    a{
        cursor: pointer;
    }
    .btn_employees:hover .a_button{
        color: #fff;
    }
</style>
</head>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar4"></div>
    <div class="se-pre-con" style="display: none;"></div>
       <!-- main-contents -->
       <main class="main-contents">
        <section class="bg-white brad-4 full-height" >
            <div class="header_container">
                <div class="header-section">
                    <div>
                        <h1 class="header_main">Shop Type</h1>
                    </div>
                    <p class="table_count">Total Shop Type - <span id="total_shopType_count"></span></p>
                </div>
            </div>
            <div class="dataTables_filter">
                <form class="formdield">
                    <div class="form-group">  
                        <button class="btn_employee "class="btn btn-danger" data-toggle="modal" data-target="#form" type="button">Add Shop Type</button>
                        <input type="hidden" id="hiden" value="">
                  </div>
<!--
                  <div class="form-group">
                      <button class="btn_employees active"  type="button" data-toggle="modal" data-target="#myModal">Upload CSV</button>
                  </div>
                  <div class="form-group">
                      <button class="btn_employees active" type="button"><a class="a_button" href="assets/csv/sampleShoptype.csv" download>Sample CSV File</a></button>
                  </div>
-->
              </form>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data1" style="display:table;">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Shop Type</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_Shop">
                    </tbody>
                </table>
            </div>
        </section>
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Add Shop Type</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form  class="forms">
                        <div class="form-control shop_type_box">
                            <p class="shop_type">Shop type</p>
                            <input class="input-field" id="shop_type" placeholder="Enter Shop Type" value="">
                        </div>   
                    </form>
                </div>
                <div class="modal-footer">
                  <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                  <button type="button" class="btn model-btn" onclick="add_shoptype()">Add Shop Type</button>
                </div>
              </div>
            </div>
          </div>              
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload CSV File</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <label class="upload_filed" for="csv_file_upload">
                <input id="csv_file_valid" type="hidden">    
                            <input id="csv_file_upload" onchange="file_upload_csv('csv_file','csv_view_url','assets/upload_csv_done.png')" type="file"  accept=".csv" style="display:none;">
                    <img alt="" src="assets/csvfile.png" class="csvfile" id="csv_view_url"/>
                    <h2 id="csv_file_name">Upload Files</h2>
                </label>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
          <button type="button" class="savebtn" id="csv_upload_button" onclick="upload_csv_file()">Upload</button>
        </div>
      </div>
    </div>
  </div>      
     <div class="modal fade" id="formUpdate" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Shop Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  class="forms">
                        <input id="edit_shop_type_token" type="hidden">
                        <div class="form-control edit_shop_type_name_box">
                            <p class="edit_shop_type_name">Shop Type</p>
                            <input class="input-field" id="edit_shop_type_name" placeholder="Enter Shop Name" value="">
                        </div>   
                    </form>
                </div>
                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                    <button type="button" class="btn model-btn" id="update_retailer_button" onclick="update_shoptype()">Update Shop Type</button>
                </div>
            </div>
        </div>
    </div>       
    </main>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->
    
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script><!---- For S3 bucket upload ---->
    <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>   
<script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var gl_admin_token = "<?php echo $token; ?>";
    console.log("token",gl_admin_token);
   var Admin_token =  localStorage.getItem("Admin_token");
   
    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    $('#datepicker1').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    $(document).ready(function(){
        $(".se-pre-con").show();
        var datas = {
            dashboard_code: verfication_code,
            type:"All"
        };
        var json_data = JSON.stringify(datas);
        console.log(json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/shop_type.php",
            data: json_data,
            success: success,
        });
    });
    var table_main_data;
    function success(data){
        table_main_data = data.data;
        var html_text = "";
        var slno = 0;
        for (var key in table_main_data) {
            slno++;
            html_text += '<tr>';
                html_text += '<td>'+slno+'</td>';
                html_text += '<td>'+table_main_data[key].shop_type+'</td>';
                html_text += '<td>'+table_main_data[key].value+'</td>';
                html_text += '<td><a><img src="assets/edit.png" class="edit_input" id="edit" onclick="edit('+key+')" alt=""></a></td>';
            html_text += '</tr>';
        }
        $(".se-pre-con").hide();
        $("#table_body_Shop").html(html_text);
        key++;
        $("#total_shopType_count").html(key);
        table = $("#table_data1").DataTable({
            dom: 'Bfrtip',
            scrollX: true,
            buttons: [
            ],
//            "columnDefs": [
//                {
//                    "targets": [ 0 ],
//                    "visible": false,
//                    "searchable": false
//                }
//            ],
           language: {
                search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                paginate: {
                    next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                    previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                }
            }
        });
    }
    $("#shop_type,#edit_shop_type_name").keydown(function (event) {
        if (event.keyCode == 32 && this.value.length == 0) {
            event.preventDefault();
        }
    });
    function add_shoptype(){
        var shop_type     = $("#shop_type").val();
        var val1          = value_check('shop_type',shop_type,'text_box');
        gl_admin_token = Admin_token;
        // console.log('Admin_token',Admin_token);
        if(val1==true){
             var datas ={
                'dashboard_code': verfication_code,
                 'shop_type': shop_type,
                 'admin_token':gl_admin_token,
                 'type': "AddShopType"
             }
             var json_data = JSON.stringify(datas);
             console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/distributor/shop_type.php",
                data: json_data,
            }).done(function(data) {
                if(data.status_code=="200"){
                     swal("Shop Type Added Successfully!", {icon: "success",}).then((value) => {
                    location.reload();
                 });
                }else{
                    swal(data.message);
                }
            });
             
        }else{
            swal("Please Enter Shop Type");
        }  
    }
    
    function edit(key){
         $("#edit_shop_type_token").val(table_main_data[key].shop_token); 
         $("#edit_shop_type_name").val(table_main_data[key].shop_type); 
        var old_name = $("#edit_shop_type_name").val();
            $("#hiden").val(old_name);
          $("#formUpdate").modal('show');
    }

    function update_shoptype(){
       var shop_token     = $("#edit_shop_type_token").val();
       var shop_type  = $("#edit_shop_type_name").val();
       var old_name  = $("#hiden").val();
       var val1         = value_check('edit_shop_type_name',shop_type,'text_box');
       gl_admin_token = Admin_token;
       if(val1==true){
             var datas ={
                'dashboard_code': verfication_code,
                'admin_token':gl_admin_token,
                'shop_token': shop_token,
                'old_name' : old_name,
                'shop_type': shop_type,
                'type': "UpdateShopType"
             }
             var json_data = JSON.stringify(datas);
             console.log('json_data',json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/distributor/shop_type.php",
                data: json_data,
            }).done(function(data) {
                if(data.status_code=="200"){
                     swal("Shop Type Updated Successfully!", {icon: "success",}).then((value) => {
                    location.reload();
                 });
                }else{
                    swal(data.message);
                }
            });             
        }else{
            swal("Please Enter Shop Type");
        }     
    }
    
function upload_csv_file(){
    var valid = $('#csv_file_valid').val();
    if(valid=="true"){
        $('#csv_upload_button').prop('disabled', true);
        var myFormData = new FormData();
        myFormData.append('file_upload', csv_file_upload.files[0]);
        $.ajax({
            dataType: "json",
            url: api_path+"/distributor/uploadShopTypeCsv.php",
            type: 'POST',
            async: false,
            processData: false, 
            contentType: false,
            data: myFormData,
            success: function(data){
                console.log(data);
                if(data.code==503){
                    $('#csv_upload_button').prop('disabled', false);
                    swal(data.message);
                }else if(data.code==201){
                    swal("Csv data uploaded successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                    });
                }
            }
        });
    }else{
        swal("Please select a csv file!");
    }
}  
</script> 
</body>
</html>
<?php
//}
mysqli_close($link);
?>