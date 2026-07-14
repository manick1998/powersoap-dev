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
    <title>Powersoaps</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/unit-grouping.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head>
<style>
    .remove{
        cursor: pointer;
    }
.selected-shop-right::-webkit-scrollbar {
    width: 16px;
    display: block;
}
 
.selected-shop-right::-webkit-scrollbar-track {
    background-color: #e4e4e4;
    border-radius: 100px;
}
 
.selected-shop-right::-webkit-scrollbar-thumb {
    background-color: #00b9f5;
    border-radius: 100px;
}
.choose-shop-left::-webkit-scrollbar {
    width: 16px;
    display: block;
}
 
.choose-shop-left::-webkit-scrollbar-track {
    background-color: #e4e4e4;
    border-radius: 100px;
}
 
.choose-shop-left::-webkit-scrollbar-thumb {
    background-color: #00b9f5;
    border-radius: 100px;
}
    @media only screen (max-width:1440px) {
        #table_data {
        overflow-x: hidden;
        white-space: break-spaces !important;
        display: table !important;
        } 
    }
    
</style>
<body>
    <div class="se-pre-con" style="display: block;"></div>
    <header id="main-dash-header" class="dash-header"></header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar6"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <div class="total-unit">
                    <h1 class="header_main">Unit Grouping</h1>
                    <p class="table_count mrg_count">Total unit - <span id="total_count"></span></p>
                    <div class="cred-btn-box"></div>
                    <button class="primary-btn" onclick="open_modal()"><span><img class="icon_add" src="assets/unit_group.png" alt=""></span>Create New Unit</button>
                </div>
            </div>
            <div class="table-box">
                    <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Unit Name</th>
                            <th>Shop Numbers</th>
                            <th>Shop Names</th>
                            <th>Distributor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_id"></tbody>
                </table>
            </div>
        </section>
    </main>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Create New Unit</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-inner-body">
                        <div class="form__detail">
                            <input type="text" id="unit_name" class="form__input" placeholder=" ">
                            <label for="" class="form__label unit_name">Unit Name</label>
                        </div>
                        <div class="border-underline"></div>
                    </div>
                    <div class="shop-common-box">
                        <div class="choose-shop">
                            <p>Choose Shops :</p>
                            <div class="choose-shop-inner">
                                <div class="choose-shop-left">
                                    <div class="search-filter-common">
                                        <div class="search-box">
                                            <img src="assets/icons/search_icon.svg" class="search_icon">
                                            <input type="text" id="add_search_text" onkeyup="add_search()" name="search" class="search-input" placeholder="Search">
                                        </div>
                                        <div class="filter-box">
                                            <img src="assets/icons/filter_icon.svg">
                                        </div>
                                    </div>
                                    <ul class="choose-shop-list" id="add_shop_html">
                                    </ul>
                                </div>
                            </div>    
                        </div>
                        <div class="selected-shop">
                            <p>Selected Shops :</p>
                            <div class="shop-table-box">
                                <div class="selected-shop-right">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th >Shop Name</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="added_shop_html">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button class="create-btn" id="add_unit_button" onclick="add_unit()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="update_view_name"></h2>
                    <input id="update_token" type="hidden">
                </div>
                <div class="modal-body">
                    <div class="shop-common-box">
                        <div class="choose-shop">
                            <p>Choose Shops :</p>
                            <div class="choose-shop-inner">
                                <div class="choose-shop-left">
                                    <div class="search-filter-common">
                                        <div class="search-box">
                                            <img src="assets/icons/search_icon.svg" class="search_icon">
                                            <input type="text" id="edit_search_text" onkeyup="edit_add_search()"   name="search" class="search-input" placeholder="Search">
                                        </div>
                                        <div class="filter-box">
                                            <img src="assets/icons/filter_icon.svg">
                                        </div>
                                    </div>
                                    <ul class="choose-shop-list" id="edit_shop_html">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="selected-shop">
                            <p>Selected Shops :</p>
                            <div class="shop-table-box">
                                <div class="selected-shop-right">
                                    <table class="custom-table" id="dataTables_filter">
                                        <thead>
                                            <tr>
                                                <th>Shops</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="edit_added_shop_html"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button class="create-btn" id="update_unit_button" onclick="update_unit()">Update</button>
                </div>
            </div>
        </div>
    </div>
<script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
<!--    datepicker-->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> 
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
    
<script>
    $('table').on('scroll', function() {
  $("table > *").width($("table").width() + $("table").scrollLeft());
});
    
    
    
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table;    
    var table_main_data;  
    var gl_shop_data;
    function success(data) {
        table_main_data = data.data;
        var html_text = "";
        var slno = 0;
        for (var key in table_main_data) {
            slno++;
            html_text += '<tr>';
                html_text += '<td>'+slno+'</td>';
                html_text += '<td>'+table_main_data[key].name+'</td>';
                html_text += '<td>'+table_main_data[key].shop_count+'</td>';
                html_text += '<td>'+table_main_data[key].shop_name+'</td>';
                html_text += '<td>'+table_main_data[key].distributor+'</td>';
                html_text += '<td><div><a onclick="get_unit_data('+key+')" class="view_link">View Details</a></div></td>';
            html_text += '</tr>';
        }
        $("#total_count").html(slno);
        $("#table_body_id").html(html_text);
        table = $("#table_data").DataTable({
            dom: 'Bfrtip',
            buttons: [],
            language: {
                search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                paginate: {
                    next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                    previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                }
            }
        });
        $(".se-pre-con").hide();

         // customize unit list
                $(document).ready(function(){
                // var distributor_token_1 = distributor_token;
                // console.log(distributor_token_1);
                var datas = {
                    distributor_token: distributor_token,
                };
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                // $.ajax({
                //     type : "POST",
                //     dataType : "json",
                //     url : api_path + "/distributor/customize_unit_list.php",
                //     data : json_data,
                
                // }).done(function(data){
                //     var show_data='';
                //     var myarray=[];
                //     for (var key in data) {
                //         // console.log('fdau',data[key]); 
                    
                //         myarray.push(data[key]);
                //         console.log("myarr",myarray);
                //     //   data.forEach(function(item,index) {
                //         // show_data +='<li id="unit_cuz'+ data[key].beat_token+"'>'"+data[key].beat_name+ "'<a onclick="add_units('+data[key]+')" class="view_link" id='"add_unit"'>Add</a></li>'
                    
                //         show_data += '<li  id="unit_cuz' + data[key].beat_token + '">';
                //         show_data += '<p>' + data[key].beat_name + '</p>';
                //         show_data += '<a  id="units" class="view_link">Add</a>';
                //         show_data += '</li>';
                //        }
                //        $("#add_units_list").append(show_data);
                // });

                // $("#units").click(function(){
                //     console.log("hai");
                // });
                
            });
            // $(document).on('click','#units',function(){
            //      var newdata = $("#units").attr(data-mydata);
            //     console.log("newdata".newdata);
            // });

    }
    $(document).ready(function () {
        var datas = {
            dashboard_code: verfication_code,
            type: "all"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/unitList.php",
            data: json_data,
            success: success,
        });
        shop_data();
    });
    function shop_data(){
        var datas = {
            dashboard_code: verfication_code
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/unitShopList.php",
            data: json_data,
        }).done(function(data) {
            gl_shop_data = data.data;
            var html_text = "";
            for(var key in gl_shop_data){
                html_text += '<li class="shop_list_class" id="add_'+gl_shop_data[key].token+'">';
                    html_text += '<p>'+gl_shop_data[key].name+'</p>';
                    html_text += '<a onclick="add_shop('+key+')" class="view_link">Add</a>';
                html_text += '</li>';
            }
            $("#add_shop_html").html(html_text);  
            
            var html_text = "";
            for(var key in gl_shop_data){
                html_text += '<li class="edit_shop_list_class" id="edit_'+gl_shop_data[key].token+'">';
                    html_text += '<p>'+gl_shop_data[key].name+'</p>';
                    html_text += '<a onclick="edit_add_shop('+key+')" class="view_link">Add</a>';
                html_text += '</li>';
            }
            $("#edit_shop_html").html(html_text);
        });
    }
    function add_shop(key){
        var token = gl_shop_data[key].token;
        $("#add_"+gl_shop_data[key].token).remove();
        var html_text = "";
        html_text += '<tr class="added_shops_class" id="'+gl_shop_data[key].token+'">';
            html_text += '<input value="'+gl_shop_data[key].token+'" hidden>';
            html_text += '<td>'+gl_shop_data[key].name+'</td>';
            html_text += '<td><span onclick="remove_shop('+key+')" class="remove">Remove</span></td>';
        html_text += '</tr>';
        $("#added_shop_html").append(html_text);
    }
    function remove_shop(key){
        var token = gl_shop_data[key].token;
        $("#"+gl_shop_data[key].token).remove();
        var html_text = "";
        html_text += '<li class="shop_list_class" id="add_'+gl_shop_data[key].token+'">';
            html_text += '<p>'+gl_shop_data[key].name+'</p>';
            html_text += '<a onclick="add_shop('+key+')" class="view_link">Add</a>';
        html_text += '</li>';
        $("#add_shop_html").append(html_text);
    }
    function add_search(){
        var text = $("#add_search_text").val();
        text     = text.toLowerCase();
        $('.shop_list_class').each(function(i, obj) {
            var id   = this.id;
            var name = $("#"+id+" > p").html();
            name     = name.toLowerCase();
            if(name.startsWith(text)){
                $("#"+id).css("display","flex");
            }else{
                $("#"+id).css("display","none");
            }
        });
    }
    function add_unit(){
        var unit_name   = $("#unit_name").val();
        var val1        = value_check('unit_name',unit_name,'text');
        var shop_tokens = [];
        $('.added_shops_class').each(function(i, obj) {
            var token    = this.id;
            shop_tokens.push(token);
        });
        if(val1==true && shop_tokens.length>0){
            var datas ={
                'unit_name':unit_name,
                'shop_tokens':shop_tokens,
                'dashboard_code':verfication_code
            }
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/addUnit.php",
                data: json_data,
            }).done(function(data) {
                if(data.code=="201"){
                    swal("New Unit Created Successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                    });
                }else{
                    $('#add_unit_button').prop('disabled', false);
                    swal(data.message);
                }
            });
        }else{
            if(shop_tokens.length==0){
                swal("Please Select Shop");
            }else{
                swal("Please enter all details!");
            }
        }
    }
    function open_modal(){
        shop_data();
        $("#edit_added_shop_html").html('');
        $("#exampleModal").modal("show");
    }
    var exist_shop_data;
    function get_unit_data(key){
        $("#update_view_name").html(table_main_data[key].name);
        $("#update_token").val(table_main_data[key].token);
        var token = table_main_data[key].token;
        shop_data();
        $("#added_shop_html").html('');
        var datas = {
            dashboard_code: verfication_code,
            token: token,
            type: "single"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/unitList.php",
            data: json_data,
        }).done(function(data) {
            exist_shop_data = data.data;
            var html_text = "";
            for(var key in exist_shop_data){
                html_text += '<tr class="edit_added_shops_class" id="'+exist_shop_data[key].token+'">';
                    html_text += '<input value="'+exist_shop_data[key].token+'" hidden>';
                    html_text += '<td>'+exist_shop_data[key].name+'</td>';
                    html_text += '<td><span onclick="edit_remove_shop_exist('+key+')" class="remove">Remove</span></td>';
                html_text += '</tr>';
            }
            $("#edit_added_shop_html").html(html_text);
        });
        $("#viewmodal").modal('show');
    }
    //exist shop add and remove while update
    function edit_remove_shop_exist(key){
        var token = exist_shop_data[key].token;
        $("#"+exist_shop_data[key].token).remove();
        var html_text = "";
        html_text += '<li class="edit_shop_list_class" id="edit_'+exist_shop_data[key].token+'">';
            html_text += '<p>'+exist_shop_data[key].name+'</p>';
            html_text += '<a onclick="edit_add_shop_exist('+key+')" class="view_link">Add</a>';
        html_text += '</li>';
        $("#edit_shop_html").append(html_text);
    }
    function edit_add_shop_exist(key){
        var token = exist_shop_data[key].token;
        $("#edit_"+exist_shop_data[key].token).remove();
        var html_text = "";
        html_text += '<tr class="edit_added_shops_class" id="'+exist_shop_data[key].token+'">';
            html_text += '<input value="'+exist_shop_data[key].token+'" hidden>';
            html_text += '<td>'+exist_shop_data[key].name+'</td>';
            html_text += '<td><span onclick="edit_remove_shop_exist('+key+')" class="remove">Remove</span></td>';
        html_text += '</tr>';
        $("#edit_added_shop_html").append(html_text);
    }
    //
    //new add and remove while update
    function edit_add_shop(key){
        var token = gl_shop_data[key].token;
        $("#edit_"+gl_shop_data[key].token).remove();
        var html_text = "";
        html_text += '<tr class="edit_added_shops_class" id="'+gl_shop_data[key].token+'">';
            html_text += '<input value="'+gl_shop_data[key].token+'" hidden>';
            html_text += '<td>'+gl_shop_data[key].name+'</td>';
            html_text += '<td><span onclick="edit_remove_shop('+key+')" class="remove">Remove</span></td>';
        html_text += '</tr>';
        $("#edit_added_shop_html").append(html_text);
    }
    function edit_remove_shop(key){
        var token = gl_shop_data[key].token;
        $("#"+gl_shop_data[key].token).remove();
        var html_text = "";
        html_text += '<li class="edit_shop_list_class" id="edit_'+gl_shop_data[key].token+'">';
            html_text += '<p>'+gl_shop_data[key].name+'</p>';
            html_text += '<a onclick="edit_add_shop('+key+')" class="view_link">Add</a>';
        html_text += '</li>';
        $("#edit_shop_html").append(html_text);
    }
    function edit_add_search(){
        var text = $("#edit_search_text").val();
        text     = text.toLowerCase();
        $('.edit_shop_list_class').each(function(i, obj) {
            var id   = this.id;
            var name = $("#"+id+" > p").html();
            name     = name.toLowerCase();
            if(name.startsWith(text)){
                $("#"+id).css("display","flex");
            }else{
                $("#"+id).css("display","none");
            }
        });
    }
    function update_unit(){
        var unit_token  = $("#update_token").val();
        var shop_tokens = [];
        $('.edit_added_shops_class').each(function(i, obj) {
            var token    = this.id;
            shop_tokens.push(token);
        });
        if(shop_tokens.length>0){
            var datas ={
                'unit_token':unit_token,
                'shop_tokens':shop_tokens,
                'dashboard_code':verfication_code
            }
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/updateUnit.php",
                data: json_data,
            }).done(function(data) {
                if(data.code=="201"){
                    swal("Shop Updated Successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                    });
                }else{
                    $('#update_unit_button').prop('disabled', false);
                    swal(data.message);
                }
            });
        }else{
            if(shop_tokens.length==0){
                swal("Please Select Shop");
            }else{
                swal("Please enter all details!");
            }
        }
    }
</script>
</body>
</html>
<?php
}
mysqli_close($link);
?>