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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/home.css<?php echo $js_cache_string; ?>">
        

        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    </head>

    <body>

        <header id="main-dash-header" class="dash-header">
        </header>
        <main class="home-main">
            <section>
                <div class="flex-grid moduleselect">
        
                </div>
            </section>
        </main>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
        <!-- 3. Load your custom application script LAST -->
        <!-- <script src="js/your-custom-ajax-script.js"></script> -->
        <script>
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";

        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        let token = "<?php echo $token; ?>";

        let value = {
            token : token
        }
        let data = JSON.stringify(value);
        if(token != ""){
         $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/home_module_list.php",
                data: data,
                success:function(response){
                    if(response.length > 0){
                    let moduleList = "";
                    response.forEach(function(item,index){
                        moduleList +=`<div class="flex-box" data-value="${item.file_name}">
                                            <div class="home-widget-box">
                                                <img src="${item.image}" class="home-widget" alt="">
                                            </div>
                                            <div class="module-box">
                                                <span>${item.module_name}</span>
                                            </div>
                                        </div>`
                    })
                    $(".moduleselect").html(moduleList);
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
        }

        $(document).ready(function(){
            setTimeout(() => {
                $('body').on('click','.flex-box',function(){
               // $('.flex-box').on('click',function(){
            var url_link = $(this).attr('data-value');
            //window.open(url_link,'_self');
             if(url_link == "working"){
                
                swal("Work in progress!", "");
                
            }else{
                localStorage.setItem('style_data', 'show');
                window.open(url_link,'_self');
                
            }
        });
            }, 500);
            
        });

        // $(document).ready(function(){
        // let value = {
        //     type : 'stock_in_hand_alert'
        // }
        // let data = JSON.stringify(value);
        
        //  $.ajax({
        //         type: "POST",
        //         dataType: "json",
        //         url : api_path+"/admin/stock_in_hand_alert.php",
        //         data: data,// Converts JS object to JSON string for php://input
        //         success: function(response) {
        //         // 1. Check if the server returned a success status code
        //             if (response.status_code === 200 && response.data1.length > 0) {
                        
        //                 let flaggedProducts = [];

        //                 // 2. Scan items to check if any item triggers the condition
        //                 response.data1.forEach(function(item, index) {
        //                     if (item.stock_in_hand < 1000) {
        //                         // Save as an object so you can access .name and .stock inside the table loop
        //                         flaggedProducts.push({
        //                             name: item.stock_name || "Unknown Product",
        //                             stock: item.stock_in_hand
        //                         });
        //                     }
        //                 });

        //                 // 3. Show exactly ONE alert if any products were flagged
        //                 if (flaggedProducts.length > 0) {
                            
        //                     // Build the table layout inside the check block
        //                     let tableHtml = `
        //                         <div style="max-height: 250px; overflow-y: auto; margin-top: 15px;">
        //                             <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
        //                                 <thead>
        //                                     <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
        //                                         <th style="padding: 10px; font-weight: 600;">Product Name</th>
        //                                         <th style="padding: 10px; font-weight: 600; text-align: right;">Stock in Hand</th>
        //                                     </tr>
        //                                 </thead>
        //                                 <tbody>
        //                     `;

        //                     // Loop and safely append each object property
        //                     flaggedProducts.forEach(function(product) {
        //                         tableHtml += `
        //                             <tr style="border-bottom: 1px solid #dee2e6;">
        //                                 <td style="padding: 10px; color: #495057;">${product.name}</td>
        //                                 <td style="padding: 10px; color: #dc3545; font-weight: bold; text-align: right;">${product.stock}</td>
        //                             </tr>
        //                         `;
        //                     });

        //                     tableHtml += `
        //                                 </tbody>
        //                             </table>
        //                         </div>
        //                     `;

        //                     // Changed from swal() to Swal.fire() to support HTML
        //                     Swal.fire({
        //                         title: "Stock Alert!",
        //                         html: tableHtml, 
        //                         icon: "warning",
        //                         confirmButtonText: "Ok",
        //                         confirmButtonColor: "#3085d6",
        //                         width: "500px"
        //                     });
        //                 }
                        
        //             } else {
        //                 // Handles 400/404 statuses returned from your PHP structure
        //                 Swal.fire({
        //                     title: "Error!",
        //                     text: response.message || "An unexpected error occurred.",
        //                     icon: "error",
        //                     confirmButtonText: "Ok",
        //                     confirmButtonColor: "#dc3545"
        //                 });
        //             }
        //         }, // <--- ✅ ADDED THIS MISSING COMMA TO SEPARATE THE AJAX PROPERTIES

        //         error: function(xhr, status, error) {
        //             // Handles hard network failures or crash bugs
        //             Swal.fire({ // ✅ UPDATED TO SWAL.FIRE FOR CONSISTENCY
        //                 title: "Connection Error!",
        //                 text: "Could not reach the server.",
        //                 icon: "error",
        //                 confirmButtonText: "Ok",
        //                 confirmButtonColor: "#dc3545"
        //             });
        //         }
        //     });
        
        // });
            
        </script>

        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        </script>
    </body>

    </html>

<?php
}
mysqli_close($link);
?>