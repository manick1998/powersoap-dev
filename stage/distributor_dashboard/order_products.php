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
    <title>Order Product List</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/order_products.css<?php echo $js_cache_string; ?>">
    <style>
        .product_val {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .value_list {
        width: 200px;
        }  
        .value_list h2{
        font-size: 18px;
        line-height: 28px;
        text-align: left;
        margin: 0;
        }  

        .table-filter {
            text-align: right;
            margin-bottom: 5px;
            padding: 0 20px;
        }
        .table-filter-box{
            display: inline-block;
            position: relative;
        }
        .search-input {
            padding: 10px 10px 10px 36px;
            outline: none;
            border: 1px solid #cfcfcf;
            width: 300px;
            border-radius: 4px;
        }
        .search-label {
            position: absolute;
            left: 12px;
            top: 11px;
        }
        .summary-table-container {
            max-height: 100%;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .summary-table-container::-webkit-scrollbar {
            display: block;
            width: 6px;
            /* height: 7px; */
            background-color: #cfcfcf;
        }
        .summary-table-container::-webkit-scrollbar-track {
            background-color: #cfcfcf;
        }
        .summary-table-container::-webkit-scrollbar-thumb {
            background-color: #232a77;
        }

        .summary-table-container table {
            width: 100%;
        }
        .summary-table-container table th {
            position:sticky;
            top: 0;
            background-color: #fff;
            white-space: nowrap;
            z-index: 1;
        }
        .summary-table-container table th,
        .summary-table-container table td {
            padding: 10px;
        }
        .cancelbtn {
            color:red;
        }
        .table-box .DTFC_ScrollWrapper {
            height: unset !important;
        }
        @media screen and (max-width: 550px){
/*
            #dataTables_filter_wrapper tr th:nth-child(1){
                width: 80px !important;
                padding-left: 5px;
                padding-right: 0px;
            }
*/
            
            
            #dataTables_filter_wrapper tr th:nth-child(1),
            #dataTables_filter_wrapper tr td:nth-child(1),
            #dataTables_filter_wrapper tr th:nth-child(2),
            #dataTables_filter_wrapper tr td:nth-child(2),
            #dataTables_filter_wrapper tr th:nth-child(4),
            #dataTables_filter_wrapper tr td:nth-child(4),
            #dataTables_filter_wrapper tr th:nth-child(6),
            #dataTables_filter_wrapper tr td:nth-child(6),
            #dataTables_filter_wrapper tr th:nth-child(7),
            #dataTables_filter_wrapper tr td:nth-child(7),
            #dataTables_filter_wrapper tr th:nth-child(5),
            #dataTables_filter_wrapper tr td:nth-child(5),
            #dataTables_filter_wrapper tr th:nth-child(9),
            #dataTables_filter_wrapper tr td:nth-child(9){
                display: none;
            }
            .mobile_devis_hide {
                display: none !important;
            }
            .mobile_devis_show {
                    display: block !important;
            }
            
            .search-input {
                width: 215px;

            }
            
            
            #dataTables_filter tr td:nth-child(1){
                /* width: 120px !important; */
                padding: 20px 2px;
            }
            #dataTables_filter tr td a:nth-child(1){
                font-size: 13px;
            }
            .view_link{
                margin: 0px 0px 0px 2px;
            }
/*
            #dataTables_filter_wrapper tr th:nth-child(2){
                padding-right: 5px;
                width: 116px !important;
            }
*/
            #dataTables_filter tr td:nth-child(2){
                padding-right: 5px;
                font-size: 13px;
            }
        }


        .modal-footer {
            flex-wrap: wrap;
        }
        #divisionlist{
            color:#69a7ff;
            padding: 8px 16px;
            border: 1px solid;
            border-color: #69a7ff;
            cursor: pointer; 
            border-radius: 5px;
            width: 300px;
            margin: 5px 0 5px;
        }

        @media only screen and (max-width: 550px) {
        .table-filter{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }
        #divisionlist{
            width: 215px;
        }
        
        }
        @media only screen and (max-width: 520px) {
        .table-filter{
            display: flex;
            flex-wrap: wrap;
        }
        }


        /* voice feature */


                /* Voice Search Button Styles */
        .voice-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .voice-btn:hover {
            background-color: #f0f0f0;
        }

        .voice-btn.listening {
            color: #ff0000;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: translateY(-50%) scale(1); }
            50% { transform: translateY(-50%) scale(1.2); }
            100% { transform: translateY(-50%) scale(1); }
        }

        /* Adjust search input padding for mic button */
        .search-input {
            padding-right: 45px !important; /* Make space for mic icon */
        }
    </style>
</head>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar2"></div>
    <div class="se-pre-con"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="toggle3">
            <div class="header_container">
                <div class="header-section">
                    <div>
                        <h1 class="header_main">Order Product List</h1>
                        
                    </div>
                    <p class='stack_total_amount'>Total Order Amount - ₹ <span id="stack_total_amount"></span></p>
                </div>
            </div>
            <div class="table-box">
                <div class="table-filter">
                <select name='devision' id='divisionlist'>
                </select>
                    <!-- <div class="table-filter-box">
                        <input type="search" class="search-input" id="table_search" placeholder="search product name">
                        <label  class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label>
                       
                        
                    </div> -->

                    <div class="table-filter-box">
                    <input type="search" class="search-input" id="table_search" placeholder="search product name">
                    <label class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label>
                    
                    <!-- NEW: Voice Search Button -->
                    <button type="button" id="voice_search_btn" class="voice-btn" title="Voice Search">
                        🎤
                    </button>
                </div>
                </div>
                <table class="custom-table" id="dataTables_filter">
                    <thead>
                        <tr>
                            <th>slno</th>
                            <th>Item Code</th>
                            <th>Item Image</th>
                            <th>Item Name</th>
                            <!-- <th>Scheme Name</th> -->
                            <th>Box Pieces</th>
                            <th>Division</th>
                            <th>Net Price(Per Piece Price)</th>
                            <th>Box Price</th>
                            <th><abbr title="Mninumum Floor Stock">MFS</abbr></th>
                            <th>Quantity In Box</th>
                        </tr>
                    </thead>
                    <tbody id="table_datawert">   
                    </tbody>
                </table>
            </div>
            <div class="product_val">
                <button class="btn_product" data-toggle="modal" data-target="#order-summary" onclick="orderSummary()" id="orderProductButton">Create Order Product</button>
                 <!-- <div class="value_list">
                     <h2>Total items : <span>20</span></h2>
                     <h2>Amount - <span id="total_amount"></span></h2>
                 </div> -->
            </div>
        </section>
        <section class="bg-white brad-4 full-height twoback" id="toggle4" style="display: none;">
            <img src="assets/back.png" onclick="hidemodal()" alt="" class="backword">
            <div class="side-position">
                
            </div>
        </section>
    </main>


    <!-- The Modal -->
    <div class="modal" id="order-summary">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Order Summary</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="summary-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Box Price</th>
                                </tr>
                            </thead>
                            <tbody id="orderDetails">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-between">
                    <h5 style="margin-left:10px;font-weight: 600;">Total Amount - <span class="total_emp"></span></h5>
                    <div>
                        <button type="button" class="savebtn mr-3" id="createorderProduct" onclick="createorderProduct()" data-dismiss="modal">Place order</button>
                        <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- js file -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
     <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
     <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    
     <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

    <!-- <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"> -->
    <script src="js/dataTables.fixedColumns.min.js<?php echo $js_cache_string; ?>"></script>
    
    <script>var notiCount = "<?php echo $notiCount; ?>";</script>
<script>
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    /* Radion button box */ 
    $('.ratio-btn-selecter').on('click',function(){
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
    
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
    $(document).ready(function () {
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
            success: success
        });
    });

    var table_main_data1;
    function success(data){
        table_main_data1 = data.data;
        //console.log(table_main_data1);
        var html_text2 = "";
        var html_text3 = `<option value=''>Select Division</option>`;
        var slno = 0;
        for(var key in table_main_data1){
               slno++;
               html_text2 += '<tr data-type="'+table_main_data1[key].product_category_name+'">';
               html_text2 += '<td>'+slno+'</td>';
               html_text2 += '<td><a class="view_link" data-product_token="'+table_main_data1[key].product_token+'" onclick="view_stock_in_hand('+table_main_data1[key].product_token+')">'+table_main_data1[key].item_code+'</a></td>';
               var img_data = '<img src="' + table_main_data1[key].product_image +'" height="50px" width="50px" >';
               html_text2 += '<td>' +img_data+ '</td>';
               html_text2 += '<td>'+table_main_data1[key].product_name+'</td>';
            //    if(table_main_data1[key].scheme_name != ''){
            //         html_text2 += '<td>'+table_main_data1[key].scheme_name+'</td>';
            //    }else{
            //         html_text2 += '<td>-</td>';
            //    }
               html_text2 += '<td>'+table_main_data1[key].piece_count+'</td>';
               html_text2 += '<td>'+table_main_data1[key].product_category_name+'</td>';
               html_text2 += '<td>'+table_main_data1[key].total_cost+'</td>';
               html_text2 += "<input type='hidden' class='iprice' value='"+table_main_data1[key].piece_count*table_main_data1[key].total_cost+"'>";
               html_text2 += '<td class="mobile_devis_show">'+numberFormatComma((table_main_data1[key].piece_count*table_main_data1[key].total_cost).toFixed(2))+'</td>';
               
               html_text2 += '<td class="mobile_devis_hide">'+table_main_data1[key].mfs+'</td>';
               html_text2 += '<td><div class="form_input waringScheme"><input data-user_value="'+table_main_data1[key].piece_count*table_main_data1[key].total_cost+'"  class="input_value" id="'+table_main_data1[key].product_token+'_prodoct_itemCode" value="" type="text" onkeypress="return isNumber(event)" onchange="warningSchemeName('+key+','+table_main_data1[key].product_token+','+table_main_data1[key].limit_box+')"><span id="schemeWarning'+key+'" style="display:none;">'+table_main_data1[key].scheme_name+'</span></div></td>';
               html_text2 += '</tr>';

               
               html_text3 += `<option value='${table_main_data1[key].product_category_name}'>${table_main_data1[key].product_category_name}</option>`;
            
        }
                
            
            //=== totel amount of product

            //     $(document).ready(function(){
            //     $(".input_value").on("change",function(){
            //             var user_amount = $(this).data("user_value");
            //          var count = $(this).val();
            //          //console.log(total);
            //         var total =0;
            //         total += user_amount*count;
            //            console.log(count[0]); 
            //             for(var i=0; i < count.length ;i++){
            //                 // console.log(arr[i].count);
            //                 // break;
            //                 total+=count* user_amount; 
            //             }
            //                 console.log(total);
            //      });
                    
               
            // });

        $(".se-pre-con").hide();
        $("#table_datawert").html(html_text2);
        $("#divisionlist").html(html_text3);
        var opt = [];
    $("#divisionlist > option").each(function () {
        if(opt[$(this).val()]) {
            $(this).remove();
        } else {
            opt[$(this).text()] = $(this).val();
        }
    });
       // console.log(screen.width);
        $("#dataTables_filter").DataTable({
            scrollX: true,
            scrollY: true,
            scrollCollapse: true,
            fixedColumns:   {
//               left: 2
            },
            // scrollY: screen.width > 768 ? '550' : '500',
           "bPaginate": false,
            dom: 'Brtip',
            buttons: [
            ],
            "order": [[ 0, "asc" ]],
           "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
            ],
            language: {
                search: '<img src="assets/svg/Search_icon.svg">', 
                searchPlaceholder: "Search Product Name" ,

                paginate: {
                    next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                    previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                },
                
                
            }
           
        });
        
    }

        $(document).ready(function(){
            //
            $(document).on('change','.input_value',function(){
                var total1 = 0;
                var grand_total = 0;
                var grand=$("#stack_total_amount").text();
                    console.log('haiuiu', grand);
                var arr=[];
                    $(this).each(function(){
                        var count = $(this).val();
                       console.log('hhhhhh',count);
                       var amount_value = $(this).closest('tr').find('td:eq(7)').text();
                       var item_price = amount_value.replace(",","");
                       
                            var total_amount = count * item_price;
                            
                           total1 += total_amount;
                        //    arr.push(total1)
                        //     for(var key in arr){
                        //        // console.log("array",arr[key]); 
                        //     }
                        //    console.log('arr',arr[key]+total1);
                        
                        grand_total = +grand+total1;

                    //    console.log('amount',total_amount + grand);
                    //    $('#stack_total_amount').append(total1);
                    });
                    $("#stack_total_amount").empty();
                    $('#stack_total_amount').append(grand_total);
                    
            });
            
        });


    function orderSummary(){
        var order_array = [];
        var billing_amount = 0;
        for (var key in table_main_data1) {
                //console.log(key);
                var quantity = $("#"+table_main_data1[key].product_token+"_prodoct_itemCode").val();
                //console.log(quantity[table_main_data1]);
                if(parseInt(quantity)>0){
                    var data = {
                        product_token:table_main_data1[key].product_token,
                        quantity:quantity
                    };
                    order_array.push(data);
                }
        }
       if(order_array.length != 0){
        var datas = {
            order_array: order_array,
            //distributor_token:distributor_token
        };
            var json_data = JSON.stringify(datas);
            console.log(json_data);
    $.ajax({
                type: "POST",
                dataType: "json",
                url :api_path+"/distributor/order_summary.php",
                data: json_data,
            }).done(function(data){
                //console.log(data);
                var table_main=data.data;
                var sum=data.final;
                console.log(sum);
                var html_text="";
                for(var key in table_main){
                html_text +='<tr>';
                html_text +='<td>' + table_main[key].product_name +'</td>';
                html_text +='<td>'+table_main[key].quantity+'</td>';
                html_text +='<td>'+table_main[key].box_price +'</td>';
                html_text +='</td>';
                }

                $(".total_emp").html(sum);
                $("#orderDetails").html(html_text);
    });
}
    }


     
   function createorderProduct(){ 
    //    $('#orderProductButton').prop('disabled', true);
    //    $(".se-pre-con").fadeIn();
        var order_array = [];
        var billing_amount = 0;
        for (var key in table_main_data1) {
                //console.log(key);
                var quantity = $("#"+table_main_data1[key].product_token+"_prodoct_itemCode").val();
                //console.log(quantity[table_main_data1]);
                if(parseInt(quantity)>0){
                    var data = {
                        product_token:table_main_data1[key].product_token,
                        quantity:quantity
                    };
                    order_array.push(data);
                }
        }
       if(order_array.length != 0){
        var datas = {
            order_array: order_array,
            distributor_token:distributor_token
        };
            var json_data = JSON.stringify(datas);
            console.log('this',json_data);
            $.ajax({
                async:false,
                type: "POST",
                dataType: "json",
                url : "../TCPDF-main/examples/invoice.php",
                data: json_data,
            }).done(function(data){
                if(data.status_code == "200"){
                    $(".se-pre-con").fadeOut();
                       swal("Order Created Successfully!", {icon: "success",}).then((value) => {
                            location.reload();
                        });
                    }else if(data.status_code == "400"){
                        $(".se-pre-con").fadeOut();
                         swal(data.message);
                    }
            });     
       }else{
           swal("Provide the Quantity!");
       }
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
    
    function view_stock_in_hand(product_token){
        $('#toggle3').hide();
        $(".se-pre-con").show();
        var datas = {
               product_token:product_token,
               dashboard_code: verfication_code,
               distributor_token: distributor_token
            };
        var json_data = JSON.stringify(datas);
            $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/stock_in_hand_detail_page.php",
            data: json_data,
        }).done(function(data) {
            console.log(data);
            if(data.status_code == 200){
                var stock = data.data
                var html_text = "";
                html_text += '<div class="header_container">';
                html_text += '<div class="header-section">';
                html_text += '<div class="inventory-top">';   
                html_text += '<h1 class="header_main">'+stock.product_name+'</h1>';
                html_text += '<span>Item Code: '+stock.item_code+'</span>';
                html_text += '<span id="indi_product_token" style="display:none;">'+stock.product_token+'</span>';
                html_text += '</div>';
                html_text += '</div>';
                html_text += '</div>';
                html_text += '<div class="inventory-body-section ">';
                html_text += '<div class="inventory-body-left">';
                html_text += '<img src="'+stock.image+'" alt="">';    
                html_text += '</div>';
                html_text += '<div class="inventory-body-right">';
                html_text += '<div class="container">';
                html_text += '<div class="row">';
                html_text += '<div class="part1">';
                html_text += '<h4>Product Details</h4>';
                html_text += '<p>Manufacture : <span>'+stock.manufacturer+'</span></p>';
                html_text += '<p>Item Code : <span>'+stock.item_code+'</span></p>';
                html_text += '<p>Location : <span>'+stock.location+'</span></p>';
                html_text += '<p>Origin : <span>India</span></p>';
                html_text += '<p>Piece Count For Box : <span>'+stock.piece_count+'</span></p>';
                html_text += '</div>';
                html_text += '<div class="part2">';
                html_text += '<p>Barcode : <span>'+stock.batch_number+'</span></p>';
                html_text += '<p>Net Weight : <span>'+stock.net_weight+'</span></p>';
                html_text += '<p>Division : <span>'+stock.product_category+'</span></p>';
                html_text += '<p>MRP : <span>'+stock.mrp+'</span></p>';
                html_text += '<p>Price Inclusive Tax : <span>'+stock.total_cost+'</span></p>';
                html_text += '</div>';
                html_text += '<div class="part3">';
                html_text += '<p>'+stock.description+'</p>';
                html_text += '</div>';
                html_text += '</div>';
                html_text += '</div>';
                html_text += '</div>';
                html_text += '</div>';
                $(".side-position").html(html_text);
                $(".se-pre-con").hide();
            }else{
                $(".se-pre-con").hide();                   
            }  
        });    
        $('#toggle4').show();
    } 
    function warningSchemeName(key,ordProdVal,limitBox){
        let order = $("#"+ordProdVal+"_prodoct_itemCode").val();
        let x = parseInt(order) % parseInt(limitBox);
            if(x != 0 && order != ''){
               $('#schemeWarning'+key).show();
            }else{
                $('#schemeWarning'+key).hide();
            }
    }

    $(document).ready(function(){
       $('#table_search').on('keyup',function(){
           var datas = $(this).val().toLowerCase();
           $("#table_datawert tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(datas) > -1)
          }); 
       });

       

       $(document).on('change','#divisionlist',function(){
            var data1 = $(this).val();
            var row = $('#table_datawert tr'); 
            row.hide();
            var bool = true;
            row.each(function(i, el) { 
                if($(el).attr('data-type') == data1) {
                     $(el).show();
                     bool = false;
                }  
         });
            if (bool != false) {
                row.show();
            }    
       });
    });
        // $(document).on("change",".input_value" ,function(){
        //                 var loop = $(".input_value");
        //                 var amount=$(this);
        //                 var count = $(this).val();
        //                 var amount_value =amount.closest('tr').find('td:eq(6)').text();
        //                 var item_price = amount_value.replace(",","");
        //                 // alert(item_price);
        //                 // alert(co
        //                 //console.log(loop.length);* count[i] total[i]+=

        //                 var total =0;
        //                 for(var i=0;i<loop.length;i++){
        //                        for (let j = 0; j < i; j+i) {
        //                                 console.log(j);
        //                                 break;
        //                        }
        //                       total+=item_price *count;
                               
        //                 }
        //                 console.log(total);
                            

            
        // });



        // ==========================================
// VOICE SEARCH FEATURE - POWER SOAPS
// ==========================================
$(document).ready(function() {
    const voiceBtn = document.getElementById('voice_search_btn');
    const searchInput = document.getElementById('table_search');
    
    // Check browser support
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();
        
        // Settings
        recognition.lang = 'ta-IN'; // Tamil + English mixed (change to 'en-US' for English only)
        recognition.continuous = false;
        recognition.interimResults = true;
        recognition.maxAlternatives = 1;
        
        let isListening = false;
        
        // Click handler
        voiceBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (isListening) {
                recognition.stop();
                return;
            }
            
            try {
                recognition.start();
                isListening = true;
                voiceBtn.classList.add('listening');
                voiceBtn.title = "Listening... Click to stop";
                
                // Clear previous search
                searchInput.value = '';
                searchInput.focus();
                
            } catch(err) {
                console.error('Speech recognition error:', err);
                swal("Microphone Error!", "Please allow microphone access and try again.", "error");
                isListening = false;
                voiceBtn.classList.remove('listening');
            }
        });
        
        // Result handler
        recognition.onresult = function(event) {
            let finalTranscript = '';
            let interimTranscript = '';
            
            for (let i = event.resultIndex; i < event.results.length; i++) {
                const transcript = event.results[i][0].transcript;
                if (event.results[i].isFinal) {
                    finalTranscript += transcript;
                } else {
                    interimTranscript += transcript;
                }
            }
            
            // Show interim results while speaking
            if (interimTranscript) {
                searchInput.value = interimTranscript;
            }
            
            // When speech ends, set final result & trigger filter
            if (finalTranscript) {
                searchInput.value = finalTranscript.trim();
                
                // Trigger existing search filter
                $('#table_search').trigger('keyup');
                
                // Reset button state
                isListening = false;
                voiceBtn.classList.remove('listening');
                voiceBtn.title = "Voice Search";
            }
        };
        
        // Error handler
        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
            isListening = false;
            voiceBtn.classList.remove('listening');
            voiceBtn.title = "Voice Search";
            
            if (event.error === 'not-allowed') {
                swal("Microphone Blocked!", "Please allow microphone access in browser settings.", "warning");
            } else if (event.error === 'no-speech') {
                // Silent fail - user didn't speak
            } else {
                swal("Voice Error!", "Error: " + event.error, "error");
            }
        };
        
        // End handler
        recognition.onend = function() {
            isListening = false;
            voiceBtn.classList.remove('listening');
            voiceBtn.title = "Voice Search";
        };
        
    } else {
        // Browser doesn't support Web Speech API
        voiceBtn.style.display = 'none';
        console.warn('Web Speech API not supported in this browser. Use Chrome/Edge.');
    }
});

</script>
<script src="js/function.js<?php echo $js_cache_string; ?>"></script>
</body>
</html>
<?php
}
?>