<?php
include "config.php";
include "$api_path/config/core_distributor.php";
session_start();
if (!$_SESSION['distributor_token'] || $_SESSION["verification_code"] != $verification_code) {   
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
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
</head>
    <style>
        .button_blue{
             background-color:#11b8f4; 
        }
    </style>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <div class="se-pre-con" style="display: none;"></div>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar2"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="product_list" >
            <div class="product_header_container">
                <div class="header-details ">
                        <h1 class="header_main">My Products</h1>
                </div>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">  
            </ul>
            <div class="tab-content" id="pills-tabContent" >
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="custom-table" id="dataTables_filter">
                        <thead>
                            <tr>
                                <th data-i18n="item_code">Item Code</th>
                                <th data-i18n="item_name">Item Name</th>
                                <th data-i18n="type">Type</th>
                                <th data-i18n="mrp">MRP</th>
                                <th data-i18n="gst">GST</th>
                                <th data-i18n="net_price">Net Price</th>
                                <th data-i18n="status">Status</th>
                            </tr>
                        </thead>
                        <tbody id="table_datas">
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="bg-white brad-4 full-height twoback" id="active_power" style="display: none;">
            <img src="assets/back.png" onclick="back_active()" alt="" class="backword">
            <div class="side-position">
            </div>
        </section>    
    </main>
     <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    <script>var notiCount = "<?php echo $notiCount; ?>";</script>
    <script>
        var Distributor_name = "<?php echo $_SESSION["name"]; ?>";  
        
        function back_active(){
            $('#product_list').show();
            $('#active_power').hide();
        }
        function dataTableIn(){
            $("#dataTables_filter").DataTable({
                dom: 'Bfrtip',
                buttons: [
                ],
                language: {
                    search: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Search_icon.svg">', searchPlaceholder: getGlobalTranslation("search") ,
                    paginate: {
                        next: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Right_arrow_icon.svg">', // or '→'
                        previous: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Left_arrow_icon.svg">' // or '←'  <img src="path/to/arrow.png">'
                    }
                }
            });
        }
        /* Radion button box */ 
        $('.ratio-btn-selecter').on('click',function(){
            debugger
            var quickcheck = $(this).attr('data-value');
           if(quickcheck == "image"){
               $('input[name=radio_btn_option][value="image"]').attr('checked', 'checked');
               $('.popup-image-box').removeClass('hidden');
               $('.popup-video-box').addClass('hidden');
           }
           else{
              $('input[name=radio_btn_option][value="video"]').attr('checked', 'checked');
              $('.popup-image-box ').addClass('hidden');
               $('.popup-video-box').removeClass('hidden');
           }
        })
  
        var product_detail;
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
        $(document).ready(function () {
            $(".se-pre-con").show();
            var datas = {
                dashboard_code: verfication_code,
                distributor_token: distributor_token  
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/distributor/product_list.php",
                data: json_data,
                success: success,
            });
        });
        var table_main_data;
        function success(data){
            table_main_data = data.data;
            var html_text1="";
            for (var key in table_main_data) {
                 html_text1 += '<tr>';
                 html_text1 += '<td><a href="#" onclick="view_product_details('+key+')">'+table_main_data[key].item_code+'</a></td>';
                 html_text1 += '<td>'+table_main_data[key].product_name+'</td>';
                 html_text1 += '<td>'+table_main_data[key].product_category_name+'</td>';
                 html_text1 += '<td>'+table_main_data[key].mrp+'</td>';
                 html_text1 += '<td>'+table_main_data[key].gst+'</td>';
                 html_text1 += '<td>'+table_main_data[key].total_cost+'</td>';
                    if(table_main_data[key].status == "Added"){ 
                        html_text1 += '<td><button class="tb-btn greenbtn">' + getGlobalTranslation("added") + '</button></td>';
                    }else{ 
                        html_text1 += '<td><button class="tb-btn button_blue" id="'+table_main_data[key].product_token+'AddedBtn" onclick="addNewProduct('+key+')">' + getGlobalTranslation("add_product") + '</button></td>'; 
                    } 
                 html_text1 += '</tr>'; 
            }
        
            $("#table_datas").html(html_text1);
            dataTableIn();
           $(".se-pre-con").hide();
        }
        
        function view_product_details(key){
            $(".se-pre-con").show();
            $('#product_list').hide();
            var product_token1 = table_main_data[key].product_token;
            var datas = {"product_token":product_token1,dashboard_code: verfication_code};
            var json = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path+"/distributor/product_detail.php",
                data: json,
                }).done(function(data) {
                if(data.status_code == 200){

                     product_detail = data.data

            var html_text = "";
            html_text += '<div class="header_container">';
            html_text += '<div class="header-section">';
            html_text += '<div class="inventory-top">';   
            html_text += '<h1 class="header_main">'+product_detail.product_name+'</h1>';
            html_text += '<span>Item Code: '+product_detail.item_code+'</span>';
            html_text += '</div>';
            html_text += '</div>';
            html_text += '<div class="form_sec">';          
            html_text += '</div>';
            html_text += '</div>';
            html_text += '<div class="inventory-body-section">';
            html_text += '<div class="inventory-body-left">';
            html_text += '<img src="'+product_detail.image+'" alt="">';    
            html_text += '</div>';
            html_text += '<div class="inventory-body-right">';
            html_text += '<div class="container">';
            html_text += '<div class="row">';
            html_text += '<div class="part1">';
            html_text += '<h4>Product Details</h4>';
            html_text += '<p>Manufacture : <span>'+product_detail.manufacturer+'</span></p>';
            html_text += '<p>Item Code : <span>'+product_detail.item_code+'</span></p>';
            html_text += '<p>Location : <span>'+product_detail.location+'</span></p>';
            html_text += '<p>Transporter : <span>'+product_detail.transporter+'</span></p>';
            html_text += '<p>Origin : <span>India</span></p>';
            html_text += '</div>';
            html_text += '<div class="part2">';
            html_text += '<p>Batch Number : <span>'+product_detail.batch_number+'</span></p>';
            html_text += '<p>Net Weight : <span>'+product_detail.net_weight+'</span></p>';
            html_text += '<p>Type : <span>'+product_detail.product_category_name+'</span></p>';
            html_text += '<p>MRP : <span>'+product_detail.mrp+'</span></p>';
            html_text += '<p>GST : <span>'+product_detail.gst+'</span></p>';
            html_text += '<p>Total Cost : <span>'+product_detail.total_cost+'</span></p>';
            html_text += '</div>';
            html_text += '<div class="part3">';
            html_text += '<p>'+product_detail.description+'</p>';
            html_text += '</div>';
            html_text += '</div>';
            html_text += '</div>';
            html_text += '</div>';
            html_text += '</div>';
            $(".se-pre-con").hide();
            $(".side-position").html(html_text);  
        }else{
            $(".se-pre-con").hide();                   
        }  
    });  
     $('#active_power').show();
    }
        
    function addNewProduct(key){
        $("#"+table_main_data[key].product_token+"AddedBtn").prop('disabled', true);
        var product_toke =  table_main_data[key].product_token;
        var product_categ = table_main_data[key].product_category_token;
        var datas1 = {distributor_token:distributor_token,
            product_token:product_toke,
            pro_category_token:product_categ,
            dashboard_code:verfication_code,
            type:"AddNewProduct"};
        var json1 = JSON.stringify(datas1);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path+"/distributor/order_product.php",
            data: json1,
            }).done(function(data) {
        if(data.status_code == "200"){
             $(".se-pre-con").hide();
           swal("Product Added Successfully!", {icon: "success",}).then((value) => {
            $("#"+table_main_data[key].product_token+"AddedBtn").html("Added");
            $("#"+table_main_data[key].product_token+"AddedBtn").removeClass("button_blue");
            $("#"+table_main_data[key].product_token+"AddedBtn").addClass(" greenbtn");   
            });
        }else if(data.status_code == "400"){
            $(".se-pre-con").hide();
              swal(data.title, data.message,{icon: "error",}).then((value) => {
                location.reload();
            $("#"+table_main_data[key].product_token+"AddedBtn").prop('disabled', false);
            });
        }
    });     
    }     
        
/* ============== Only Allow Numeric value in Phone Field code ============== */
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}       
</script>
</body>
</html>
<?php
}
?>