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
    <title>Product list</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/select2.min.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
</head>
<style> 
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #ccc !important;
    outline: 0;
}
.select2-container--default .select2-selection--multiple{
    border: 1px solid #ccc !important;
    min-height: 52px;
}

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 25px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }

</style>

<body>
    <!-- <div class="se-pre-con"></div> -->
    <header id="main-dash-header" class="dash-header">
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar12"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="toggle5">
            <div class="product_header_container">
                <div class="header-details ">
                    <h1 class="header_main">State Sales Reports </h1>
                </div>
            </div>
            <!-- Nav tabs -->
            <div class="dataTables_filter">
                <form class="formdield">
                    <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate"  type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate"  type="text" placeholder="To Date" readonly>
                        </div>
                        <div class="form-group">
                            <button id="stateGoBtn" type="button" onclick="filterStateWise();" class="primary-btn" >Go</button>
                        </div>
                    </form>
                </div>
            <div id="my-div">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane active fade show" id="pills-home">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Item / State</th>
                                <th>Tamil Nadu</th>
                                <th>Kerala</th>
                                <th>Andhra</th>
                                <th>Karnataka</th>
                                <th>karaikal</th>
                                <!-- <th>SubTotal</th> -->
                                
                            </tr>
                            <!-- <tr>
                                <th rowspan='2' colspan="1">Item\State</th>
                                <th rowspan='1' colspan="2">Tamil Nadu</th>
                                <th rowspan='1' colspan="2">Kerala</th>
                                <th rowspan='1' colspan="2">Andhra</th>
                                <th rowspan='1' colspan="2">Karnataka</th>
                                <th rowspan='1' colspan="2">karaikal</th>
                            </tr>
                            <tr>
                                <th rowspan='1' colspan="1">QTY</th>
                                <th rowspan='1' colspan="1">AMT</th>
                                <th rowspan='1' colspan="1">QTY</th>
                                <th rowspan='1' colspan="1">AMT</th>
                                <th rowspan='1' colspan="1">QTY</th>
                                <th rowspan='1' colspan="1">AMT</th>
                                <th rowspan='1' colspan="1">QTY</th>
                                <th rowspan='1' colspan="1">AMT</th>
                                <th rowspan='1' colspan="1">QTY</th>
                                <th rowspan='1' colspan="1">AMT</th>
                            </tr> -->
                        </thead>
                        <tbody id="table_body"></tbody>
                        <!-- <tfoot>
                    <tr>
                        <th colspan="7" style="text-align:right"></th>
                        <th></th>
                    </tr>
                </tfoot> -->
                    </table>
                </div>
            </div>
                </div>
        </section>
    </main>


    <!-- jquery CDN -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    datepicker-->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
    <!---- For S3 bucket upload ---->
    <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script>

    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var from_date;
    var to_date;
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
            dateFormat: 'yy-mm-dd'
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd'
        });
    </script>
    <script>
    $(document).ready(function() {

//allstate
            let state = {
                type: "allstate",
                
            };
            var json_data = JSON.stringify(state);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                let html_text = '<option></option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                }
                $('#selectState').html(html_text);
                $('#selectState').select2({
                            closeOnSelect: false,
                            placeholder: "State"
                        });
            });
        });
           
  function filterStateWise(){
    var from_date = $("#fromDate").val();
    var to_date = $("#toDate").val();
    var state = [];
     $('#selectState :selected').each(function() {
            state.push($(this).val());
    });
    let data = {
                from_date :from_date,
                to_date : to_date,
                type: "stateSales"
            };
    var json_data = JSON.stringify(data);
    console.log('json_data',json_data);
    $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/stateReport.php",
                data:json_data,
                success: function(data){
                    var value = data.data;
                    var  checkdata = value[0].name;
                    // console.log('hhhhh',arradata);
                // var table = $('<table>').addClass('my-table');
                //     var headerRow = $('<tr>');
                //     var headerCol1 = $('<th>').text('Item / State');
                //     var headerCol2 = $('<th>').text('Tamil Nadu');
                //     var headerCol3 = $('<th>').text('Kerala');
                //     var headerCol4 = $('<th>').text('Andhra');
                //     var headerCol5 = $('<th>').text('Karnataka');
                //     var headerCol6 = $('<th>').text('Karaikal');
                //     var headerCol6 = $('<th>').text('SubTotal');
                //     headerRow.append(headerCol1).append(headerCol2).append(headerCol3).append(headerCol4).append(headerCol5).append(headerCol6);
                //     table.append(headerRow);
                    let name='';
                    var division_name = '' ;
                    var arr = [];
                    var html_text = '';
                    value.forEach(function(item,index){
                        arr.push(item.name)
                    });
                    uniq = [...new Set(arr)];
                    console.log('arr',uniq);

                    const groupedData = {};
                    value.forEach(entry => {
                    const key = entry.name;
                    if (!groupedData[key]) {
                        groupedData[key] = [];
                    }
                    groupedData[key].push({ state: entry.state_name, quantity: entry.total_quantity, amount: entry.total_amount });
                    });
                   

                    //Display the grouped information
                    // const resultArray = [];
                    //     for (const key in groupedData) {
                    //     const entries = groupedData[key];
                    //     // entries.forEach(function(item){
                    //     //     console.log(item.state);
                    //     // });
                    //     console.log('entries',entries[0]); 
                    //     resultArray.push({ product: key, details: entries });
                    //     }

                    //     // Display the array of objects
                    //     console.log(resultArray);

                    var arrays = [];
                        for (const key in groupedData) {
                        const entries = groupedData[key];
                        // console.log(`${key}:`);
                        arrays.push({key});
                        entries.forEach(e => {
                            arrays.push({state: e.state, quantity: e.quantity,amount: e.amount});
                            // console.log(e.state,e.quantity,e.amount);
                        });
                        }
                        // console.log(arrays);



                        const resultArray = [];
                    let currentProduct = {};
                            var newarray = [];
                    arrays.forEach(entry1 => {
                    if (entry1.key) {
                        // If it's a product key entry1, create a new product object
                        currentProduct = { division: entry1.key, details: [] };
                        resultArray.push(currentProduct);
                    } else {
                        // If it's a state entry1, add details to the current product
                        currentProduct.details.push({
                        state: entry1.state,
                        quantity: entry1.quantity,
                        amount: entry1.amount
                        });
                    }
                    });
                        console.log("newarray",newarray);
                    // Display the array of objects
                    console.log("resultArray",resultArray);
                    var col1 = '';
                    var col2 = '';
                    var col3 = '';
                    var col4 = '';
                    var col5 = '';
                    var col6 = '';
                    var col7 = '';
                    for(var key in resultArray) {
                       
                        html_text += '<tr>';
                        //  col1 = $('<td>').text(resultArray[key].division);
                        html_text += `<td> ${resultArray[key].division} </td>`;
                        var details1 = resultArray[key].details;
                        console.log("details1",details1);
                        val = true;
                        details1.forEach(function(item,index){
                            //  col2 = $('<td>').text(item.state == 'Tamilnadu' ? item.quantity + ' | ' + item.amount : '');
                            //  col3 = $('<td>').text(item.state == 'Kerala' ? item.quantity + ' | ' + item.amount : '');
                            //  col4 = $('<td>').text(item.state == 'Andhra' ? item.quantity + ' | ' + item.amount : '');
                            //  col5 = $('<td>').text(item.state == 'Karnataka' ? item.quantity + ' | ' + item.amount : '');
                            //  col6 = $('<td>').text(item.state == 'Karaikal' ? item.quantity + ' | ' + item.amount : '');
                            //  col7 = $('<td>').text(item.quantity + ' | ' + item.amount);
                                
                                    
                                // html_text += `<td> ${item.state == 'Tamilnadu' ? item.quantity : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Tamilnadu' ?  item.amount : ''} </td>`;

                                // html_text += `<td> ${item.state == 'Kerala' ? item.quantity : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Kerala' ?  item.amount : ''} </td>`;

                                // html_text += `<td> ${item.state == 'Andhra' ? item.quantity : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Andhra' ?  item.amount : ''} </td>`;

                                // html_text += `<td> ${item.state == 'Karnataka' ? item.quantity : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Karnataka' ?  item.amount : ''} </td>`;

                                // html_text += `<td> ${item.state == 'Karaikal' ? item.quantity : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Karaikal' ?  item.amount : ''} </td>`;
                                   
                                // html_text += `<td> ${item.state == 'Tamilnadu' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Andhra' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                // html_text += `<td> ${item.state == 'Karnataka' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                               // html_text += `<td> ${item.state == 'Karaikal' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                // html_text += `<td> ${item.quantity + ' | ' + item.amount} </td>`
                                // val = false;
                            
                                
                               
                                    html_text += `<td> ${item.state == 'Tamilnadu' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                html_text += `<td> ${item.state == 'Kerala' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                html_text += `<td> ${item.state == 'Andhra' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                html_text += `<td> ${item.state == 'Karnataka' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                                html_text += `<td> ${item.state == 'Karaikal' ? item.quantity + ' | ' + item.amount : ''} </td>`;
                               
                                
                        });
                        html_text += '</tr>';
                        // row.append(col1).append(col2).append(col3).append(col4).append(col5).append(col6).append(col7);
                        //     table.append(row);
                    }

                    $('#table_body').html(html_text);


                    // for(var key in value) {
                    //     division_name = value[key].name
                    // //   console.log('hello',division_name);  
                        
                    //      var row = $('<tr>');
                    //     // if(name!=value[key].name){
                    //     //     var col1 = $('<td>').text(value[key].name);
                    //     //     name=value[key].name;
                    //     // }

                    //     // for (let index = 0; index < uniq.length; index++) {
                    //     //     const element = uniq[index];
                    //     //     console.log('mylog',element);
                    //     //     var col1 = $('<td>').text(element);
                            
                    //     // }
                    //         var col1 = $('<td>').text(value[key].name);
                    //         var col2 = $('<td>').text(value[key].state_name == 'Tamilnadu' ? value[key].total_quantity + ' | ' + value[key].total_amount : '');
                    //         var col3 = $('<td>').text(value[key].state_name == 'Kerala' ? value[key].total_quantity + ' | ' + value[key].total_amount : '');
                    //         var col4 = $('<td>').text(value[key].state_name == 'Andhra' ? value[key].total_quantity + ' | ' + value[key].total_amount : '');
                    //         var col5 = $('<td>').text(value[key].state_name == 'Karnataka' ? value[key].total_quantity + ' | ' + value[key].total_amount : '');
                    //         var col6 = $('<td>').text(value[key].state_name == 'Karaikal' ? value[key].total_quantity + ' | ' + value[key].total_amount : '');
                    //         var col7 = $('<td>').text(value[key].total_quantity + ' | ' + value[key].total_amount);
                    //         row.append(col1).append(col2).append(col3).append(col4).append(col5).append(col6).append(col7);
                    //         table.append(row);

                    //         // html_text += `<tr>` 
                    //         //     html_text += `<td> ${value[key].state_name == 'Tamilnadu' ? value[key].total_quantity + ' | ' + value[key].total_amount : ''} </td>`
                    //         //     html_text += `<td> ${value[key].state_name == 'Kerala' ? value[key].total_quantity + ' | ' + value[key].total_amount : ''} </td>`
                    //         //     html_text += `<td> ${value[key].state_name == 'Andhra' ? value[key].total_quantity + ' | ' + value[key].total_amount : ''} </td>`
                    //         //     html_text += `<td> ${value[key].state_name == 'Karnataka' ? value[key].total_quantity + ' | ' + value[key].total_amount : ''} </td>`
                    //         //     html_text += `<td> ${value[key].state_name == 'Karaikal' ? value[key].total_quantity + ' | ' + value[key].total_amount : ''} </td>`
                    //         //     html_text += `<td> ${value[key].total_quantity + ' | ' + value[key].total_amount} </td>`
                                
                    //         //      '</tr>';
                        
                   
                        
                    //     //$('.my-table').html(html_text);
                        
                    // }
                    // $('#my-div').html(table);
        }
    });
              
    }


    </script>

</body>

</html>
<?php
}
mysqli_close($link);
?>