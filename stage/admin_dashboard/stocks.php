<?php
    include "config.php";
    include "$api_path/config/core.php";
    if($cookie_admin_name ==""){
        header("Location:login.php");
    }else{
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
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <!-- <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>"> -->
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
<style>
    .a_button{
        color: #00b9f5;
    }
    .edit_input{
        cursor: pointer;
    }
    .twoback {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    }
    .mrgzro {
    margin: 0 !important;
    }

    .header_container {
    width: 100%;
    margin: auto;
    padding: 20px;
    }
    .sep_word {
    display: flex !important;
    padding: 10px;
    width: 100%;
    align-items: center;
    justify-content: space-between;
    }
/*
    .header-section {
    display: block;
    width: 100%;
    position: relative;
    padding: 10px;
    }
*/
    .twoinspace {
    margin-left: 20px;
    color: #000 !important;
    }
    .header_main img {
    width: 30px;
    cursor: pointer;
    margin-right: 20px;
    }
    .bot_line {
    margin-bottom: 20px;
    border-bottom: 1px solid #DDECEF;
    padding-bottom: 20px;
    }

    .add_new_top {
    margin-top: 20px;
    display: flex;
    width: 100%;
    }
    .uploadimgs {
    width: 100%;
    object-fit: contain;
    } 
    .add_new_top h2 {
    font-size: 18px;
    line-height: 20px;
    }
    .nav-item button {
    width: auto;
    height: 50px;
    color: #fff;
    margin: 0 10px;
    }
    .nav-pills .nav-link.active, 
    .nav-pills .show>.nav-link {
    background-color: #00b9f5;
    border: 1px solid #04bcf4;
    }
    .pdf-btn {
    background: #bc87f0 !important;
    border: 1px solid #bc87f0;
    padding: 6px 15px;
    border-radius: 4px;
    }
    .name_box {
    color: #000;
    font-weight: 600;
    letter-spacing: 1px;
    }
    .codelevel p {
    font-size: 16px;
    line-height: 20px;
    }
    .codelevel p span {
    font-weight: 600;
    letter-spacing: 0.5px;
    }  
    .address_field {
    display: flex;
    margin: 30px 0;
    }
    .address_note h2 {
    font-size: 18px;
    line-height: 20px;
    font-weight: 600;
    }
    .address_note p {
    font-size: 16px;
    line-height: 26px;
    width: 100%;
    margin: 0;
    }
    .attach {
    display: block;
    width: 100%;
    }
    .attach h2 {
        font-size: 18px;
        line-height: 20px;
        font-weight: 600;
    }
    .attach_img {
        width: 100%;
        display: flex;
    }
    .btn_employee {
        width: 150px !important;
    }
    #totel{
        margin-left: 60px;
    }
    .attach_img img {
        border: 1px solid #ccc;
        margin: 5px;
        width: 100px;
        height: 100px;
        object-fit: contain;
    }  
    @media only screen and (max-width:1600px) {
	.custom-table.dataTable.no-footer {
		display: table;
/*		overflow-x: scroll;*/
	}
}
    
</style>
</head>
<body>
<div class="se-pre-con" style="display: block;"></div>    
<header id="main-dash-header" class="dash-header">      
</header>
<!-- sidebar -->
<input type="checkbox" id="sidebar-toggle">
<div class="sidebar" id="sidebar44"></div>
<!-- main-contents -->
<main class="main-contents">
    <section class="bg-white brad-4 full-height" id="retailer_table">
        <div class="header_container">
            <div class="header-section">
                <div>
                    <h1 class="header_main">Stocks List</h1>
                </div>
                <p class="table_count"><span id="total_retailer_count"></span></p> 
            </div>
        </div>
        <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
            <!-- <li class="nav-item " role="">
                <button onclick="show_RetailerCSV()" class="nav-link active" >CSV</button>
            </li>
            <li class="nav-item " role="">
                <button onclick="show_RetailerPDF()"  class="pdf-btn" >PDF</button>
            </li> -->
<!--
            <li class="nav-item " role="">
            <div class="form-group"> 
                    <button class="btn_employee "class="btn btn-danger" data-toggle="modal" data-target="#form" type="button"><span><img src="assets/retailer.png" class="icon_add"></span> Add Retail</button>
                </div>
            </li>
-->
        </ul>
        <div class="dataTables_filter">
            <form class="formdield">
<!--
                <div class="form-group"> 
                    <button class="btn_employee "class="btn btn-danger" data-toggle="modal" data-target="#form" type="button"><span><img src="assets/retailer.png" class="icon_add"></span> Add Retail</button>
                </div>
                <div class="form-group">
                    <button class="btn_employees active"  type="button" data-toggle="modal" data-target="#myModal">Upload CSV</button>
                </div>
                <div class="form-group">
                    <button class="btn_employees active" type="button"><a  class="a_button" href="assets/csv/sampleRetailerCsv.csv" download>Sample CSV File</a></button>
                </div>
-->

            </form>
        </div>
        <div class="table-box">
            <table class="custom-table" id="table_data">
                <thead>
                    <tr>
                        <th>Si_no</th>
                        <th>Item_Name</th>
                        <th>Division</th>
                        <th>Box Count</th>
                        <th>MFS</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table_body_id">
                </tbody>
            </table>
        </div>
    </section>
               
   <section class="bg-white brad-4 full-height twoback" id="retailer_view" style="display: none;">
            <div class="header_container mrgzro" >
                <div class="header-section sep_word">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_retailer()" alt=""></span></h1>
                        <div class="de_activate">
                        </div>
                </div>
                <div class="add_new_top bot_line">
                    <div class="col-md-12">
                    <h2 class="name_box" id="single_shop_name"></h2>
                    <div class="row">
                    <div class="col-md-4 padz">
                        <div class="codelevel">
                        <p>Shop Name : <span id="single_shop_name1"></span></p>
                        <p>Shop Type : <span id="single_shop_type"></span></p>
                        </div>
                    </div>
                    <div class="col-md-4 padz">
                        <div class="codelevel">
                        <p>Contact Person : <span id="single_shop_person">34 Years</span></p>
<!--                        <p>Slot : <span id="single_shop_slot"></span></p>-->
                        </div>
                    </div>
                    <div class="col-md-4 padz">
                        <div class="codelevel">
                        <p>Contact Number : <span id="single_shop_contact"></span></p>
                        <p>GST Number : <span id="single_shop_license"></span></p>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="address_field">
                    <div class="col-md-12">
                        <div class="address_note">
                            <h2>Address :</h2>
                            <p id="single_shop_address"></p>
                        </div>
                        <div class="address_note">
                            <h2>City :</h2>
                            <p id="single_shop_city"></p>
                        </div>
                        <div class="address_note">
                            <h2>Pincode :</h2>
                            <p id="single_shop_pincode"></p>
                        </div>
                        <div class="address_note">
                            <h2>Coordinates :</h2>
                            <p id="single_shop_coordinates"></p>
                        </div>
                    </div>
                </div>
                 <div class="attach">
                    <div class="col-md-12">
                        <h2>Other Attachments :</h2>
                        <div class="attach_img">
                        <img class="uploadimgs" id="single_shop_view_image" alt="" src="">
                        </div>
                    </div>
                </div>
            </div>
        </section> 
    
     
    
</main>
<div class="modal fade" id="forminput" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span>Update Stocks & MFS</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control region">
                                <input id="token" type="hidden">
                                    <p class="region_name">Update Stocks</p>
                                    <input class="input-field" id="stocks"   placeholder="Enter Stocks" value="" onkeypress="return isNumber(event);">
                                </div>
                                <div class="form-control state_name_box">
                                    <p class="state_name">MFS Update</p>
                                    <input class="input-field" id="mfshold"  placeholder="Enter MFS" value="" onkeypress="return isNumber(event);">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" onclick="updateData()">Update</button>
                        </div>
                    </div>
                </div>
            </div>
<script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var admin_state_id = "<?php echo $cookie_admin_state; ?>";
</script>    
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
<!-- datepicker-->

<!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
<script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

<!-- jquery CDN -->
<script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
<!-- datatable -->
<script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
<script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script><!---- For S3 bucket upload ---->
<script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
<script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
<!-- js file -->
<script src="js/header.js<?php echo $js_cache_string; ?>"></script>
<script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
<script src="js/function.js<?php echo $js_cache_string; ?>"></script>   
<script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
<script>

       
     function back_view_retailer(){
         $("#retailer_table").show();
        $("#retailer_view").hide();
    }

    function isNumber(e){
    e = e || window.event;
    var charCode = e.which ? e.which : e.keyCode;
    return /\d/.test(String.fromCharCode(charCode));
}
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    let distributor_token = localStorage.getItem("distributor_token");

      
    
    $(document).ready(function(){
            var emp_token = {
                distributor_token: distributor_token
        };
        var jdata_1 = JSON.stringify(emp_token);

       // console.log(jdata);

        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/admin_view_stock.php",
            data: jdata_1,
            success:function(response){
                console.log(response);
                $("#total_retailer_count").html(`Total Stocks -${response.length}`);
                var datas="";
                response.forEach(function(item,index){
                    datas +=`<tr>
                                    <td>${index}</td>
                                    <td>${item.item_name}</td>
                                    <td>${item.division}</td>
                                    <td>${item.total_stock}</td>
                                    <td>${item.mfs}</td>
                                    <td><a data-toggle="modal" data-target="#forminput"><img src="assets/edit.png" class="edit" data-target ="${item.total_stock}" data-target1 ="${item.mfs}" data-target2="${item.token}" onclick="updatestocks()" alt=""></a></td>
                            </tr>`
                });
                $("#table_body_id").append(datas);
                dataTableIn();
                $(".se-pre-con").hide();
            }
        });
    });
    function dataTableIn() {
        $(".se-pre-con").hide();
                $("#table_data").DataTable({
                    scrollX: true,
                    dom: 'Bfrtip',
                    buttons: [{
                                extend: 'pdfHtml5',
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [0,1,2,3,4]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             },{
                                extend: 'csv',
                                className: 'btn-info buttonprint',
                                exportOptions: {
                                   columns: [0,1,2,3,4]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             }],
                    
                    "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }],
                    // "fnRowCallback": function(nRow, item, iDisplayIndex, iDisplayIndexFull) {
                    //     if (item.total_stock == item.mfs) {
                    //         $('td', nRow).css('background-color', '#ff9d87');
                    //     }
                    // },
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
    
            $(document).on("click",'.edit',function() {
                   var stocks=$(this).attr('data-target');
                   var mfscount = $(this).attr('data-target1');
                   var token = $(this).attr('data-target2');
                   updatestocks(stocks,mfscount,token);
                });


            function updatestocks(stocks,mfscount,token){
                $("#stocks").val(stocks);
               $("#mfshold").val(mfscount);
               $("#token").val(token);
                $("#forminput").modal('show');
                }

    function updateData(){
              var stocks= $("#stocks").val();
              var mfscount =$("#mfshold").val();
              var token = $("#token").val();
              if(stocks!='' && mfscount!=''){
                    var datas={
                     'stocks':stocks,
                     'mfscount':mfscount,
                     'token':token,
                     'distributor_token':distributor_token,
                     'dashboard_code': verfication_code,
                     'type':"updateStocks"
                };
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/stockInHand.php",
                        data: json_data,
                    }).done(function(data) {
                       
                        if (data.code == "201") {
                            swal("Updated stock Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            swal(data.message);
                            console.log(data.message);
                        }
                    });
                }else{
                    swal("Please Enter All Details");
                }
            }

</script>
</body>
</html>
<?php
}
mysqli_close($link);
?>