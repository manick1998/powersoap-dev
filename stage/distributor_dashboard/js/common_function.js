function success(data){
    var table_data = data;
    var new_data    = table_data.data;
    var html_text1="";
    var slno = 0;
    for (var key in new_data) {
         slno++;
         html_text1 += '<tr>';
         html_text1 += '<td>'+slno+'</td>';
         html_text1 += '<td><a href="javascript:void(0)" onclick="showmodal('+new_data[key].order_token+')">'+new_data[key].order_token+'</a></td>';
         html_text1 += '<td>'+new_data[key].date_time+'</td>';
         html_text1 += '<td>'+new_data[key].shop_name+'</td>';
         html_text1 += '<td>'+new_data[key].employee_name+'</td>';
         html_text1 += '<td>'+new_data[key].items+'</td>';
         html_text1 += '<td>'+new_data[key].billing_amount+'</td>';
            if(new_data[key].delivery == "Pending"){
                 html_text1 += '<td><button class="tb-btn voliet">Pending</button></td>';                       
            }else if(new_data[key].delivery == "Cancelled"){                        
                html_text1 += '<td><button class="tb-btn red">Cancelled</button></td>';                    
            }else{   
                html_text1 += '<td><button class="tb-btn greenbtn">Delivered</button></td>';                       
            }              
            if(new_data[key].delivered_on == ""){                       
                 html_text1 += '<td>-</td>';                    
            }else{                         
               html_text1 += '<td>'+new_data[key].delivered_on+'</td>';                       
            }
         html_text1 += '<td><span style="color: tomato;">'+new_data[key].total_outstanding+'</span></td>';
         html_text1 += '</tr>';   
    }
    $("#table_data").html(html_text1);
     key++;
     if(isNaN(key)){
         $("#project_count").text('0'); 
     }else{
         $("#project_count").html(key); 
     }
    tableinit();
    $(".se-pre-con").hide();
}

function tableinit(){

  table = $("#dataTables_filter").DataTable({
                dom: 'Bfrtip', 
                "order": [[ 0, "desc" ]],
               "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                buttons: [
                ],

                language: {
                    search: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                    paginate: {
                        next: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Right_arrow_icon.svg">', // or '→'
                        previous: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Left_arrow_icon.svg">' // or '←'  <img src="path/to/arrow.png">'
                    }
                }
            });
}
    
function individual_shop_order_detail(data){
    var mat_data = data;
    var material_data = mat_data.data;
    var order_detail="";
    var srno = 0;
    for(var key in material_data){
            srno++;
            order_detail += '<tr>';
            order_detail += '<td>'+srno+'</td>';
            order_detail += '<td>'+material_data[key].product_name+'</td>';
            order_detail += '<td>'+material_data[key].item_code+'</td>';
            order_detail += '<td>'+material_data[key].quantity+'</td>';
            order_detail += '<td>'+material_data[key].price_per_unit+'</td>';
            order_detail += '<td>'+material_data[key].amount+'</td>';
            order_detail += '<td>'+material_data[key].units+'</td>';
            order_detail += '</tr>';

    $("#purchase_items").html(order_detail);
    }
    $(".se-pre-con").hide();
}

function individual_shop_detail(data){ 
    var indShop_data = data;
    var shop_data    = indShop_data.data;
    var order_text1="";
        order_text1 += '<div class="title_box">';
        order_text1 += '<div class="header_box">';
        order_text1 += '<h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span>'+shop_data.shop_name+'</h1>';
        if(shop_data.delivery == "Pending"){
        order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn voliet">Pending</button>';        
        }else if(shop_data.delivery == "Cancelled"){
        order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn red">Cancelled</button>';    
        }else{
        order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn greenbtn">Delivered</button>';    
        }
        order_text1 += '</div>';
        if(shop_data.delivery == "Pending"){
        order_text1 += '<a href="javascript:void(0)" onclick=cancel_order('+shop_data.order_token+')>Cancel Order</a>';
        }
        order_text1 += '</div>';
        order_text1 += '<p class="table_count">'+shop_data.order_token+'</p>';
        order_text1 += '<div class="details-top-section">';

        order_text1 += '<div class="details-top-div">';
        order_text1 += '<p>Date & Time: '+shop_data.date_time+'</p>';
        order_text1 += '<p>Amount: '+shop_data.mrp_amount+'</p>';
        order_text1 += '</div>';
        order_text1 += '<div class="details-top-div">';
        order_text1 += '<p>Salesman: '+shop_data.employee_name+'</p>';
        order_text1 += '<p>Paid: '+shop_data.paid_amount+'</p>';
        order_text1 += '</div>';
        order_text1 += '<div class="details-top-div">';
        order_text1 += '<p>Items: '+shop_data.items+'</p>';
        order_text1 += '<p>Outstanding: <span style="color: tomato;">'+shop_data.total_outstanding+'</span></p>';
        order_text1 += '</div>';
        order_text1 += '<div class="details-top-div">';
        order_text1 += '<p>GST(18%): Rs.'+shop_data.gst_amount+'</p>';
        if(shop_data.delivered_on == ""){
          order_text1 += '<p>Delivered on: -</p>';  
        }else{
          order_text1 += '<p>Delivered on: '+shop_data.delivered_on+'</p>';  
        }
        order_text1 += '</div>';
        order_text1 += '</div>';

        $(".header-details").html(order_text1); 
        $(".order-right-content").text('Total Amount: Rs.'+shop_data.billing_amount);
}


function  individual_shop_paid_detail(data){
    var Shop_data = data;
    var shopPayment_data = Shop_data.data;
    var srno = 0; 
    var payment_text1="";
    for(var key in shopPayment_data){
        srno++;
        payment_text1 += '<tr>';
        payment_text1 += '<td>'+srno+'</td>';
        payment_text1 += '<td>'+shopPayment_data[key].paid_on+'</td>';
        payment_text1 += '<td>'+shopPayment_data[key].payment_mode+'</td>';
        payment_text1 += '<td>'+shopPayment_data[key].paid_amount+'</td>';
        payment_text1 += '</tr>';
    }
    $("#individual_shop_paid_detail").html(payment_text1);
} 



