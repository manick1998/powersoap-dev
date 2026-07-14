<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power soap - Gift Management</title>
    <link rel="shortcut icon" href="assets/favi.png">
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/order.css?v=123">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/shop-list.css<?php echo $js_cache_string; ?>">


    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    datepicker-->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>

</head>

<body>
    <header id="main-dash-header" class="dash-header">      
    </header>

    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar8"></div>
    
      <!-- main-contents -->
      <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="toggle">
            <div class="gift_header_container">
                <div class="gift_header-section">
                        <h1 class="header_main">Shop List</h1>
                    <p class="table_count">Total Shops - <span id="project_count">3,745</span></p>
                </div>
            </div>
            
            <div class="gift_header">
                        <div class="gift_header_content">
                            <div class="header-part col-3">
                                <p>Total Gifts</p>
                                <span>124</span>
                            </div>
                            <div class="header-part col-9">
                                <p>Total Amount on Gifts</p>
                                <span>1,00,000</span>
                            </div>
                            
                        </div>
                        <div class="gift_header_bottom col-12">
                                <button type="submit" data-toggle="modal" data-target="#exampleModalCenter">Add Gift to Shop</button>
                            </div>
            </div>
                


            <div class="table-box">
                <table class="custom-table" id="dataTables_filter">
                    <thead>
                        <tr>
                            <th>SI.No</th>
                            <th>Retailer Code</th>
                            <th>Retailer Name</th>
                            <th>Type</th>
                            <th>Order Value</th>
                            <th>Gifts Given</th>
                            <th>Current Slot</th>
                            <th>Last Gift</th>
                            <th>Given On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="#">876834</a></td>
                            <td>Murugan Stores</td>
                            <td>DMart</td>
                            <td>Rs.3,78,000</td>
                            <td>34</td>
                            <td>Slot 1</td>
                            <td>Silver Coin</td>
                            <td>12/02/2022</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#">876832</a></td>
                            <td>Nanayam</td>
                            <td>Super Market</td>
                            <td>Rs.3,78,000</td>
                            <td>27</td>
                            <td>Slot 1</td>
                            <td>Silver Coin</td>
                            <td>12/02/2022</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a href="#">564643</a></td>
                            <td>Nilgiris</td>
                            <td>Hyper Market</td>
                            <td>Rs.3,78,000</td>
                            <td>13</td>
                            <td>Slot 2</td>
                            <td>Silver Coin</td>
                            <td>12/02/2022</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>


        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Add Gift to Shop</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form  class="forms">
                        <div class="form-control">
                            <p>Shop Type</p>
                             <select class="input-field" >
                             <option>Sales</option>
                             <option>Delivery</option>
                             <option>Sales</option>
                             <option>Sales</option>
                             </select>
                        </div>
                        <div class="form-control">
                            <p>Shop Type</p>
                             <select class="input-field" >
                             <option>Sales</option>
                             <option>Delivery</option>
                             <option>Sales</option>
                             <option>Sales</option>
                             </select>
                        </div>
                        <div class="form-control">
                            <p>Shop Type</p>
                             <select class="input-field" >
                             <option>Sales</option>
                             <option>Delivery</option>
                             <option>Sales</option>
                             <option>Sales</option>
                             </select>
                        </div>

                        <div class="rates">
                            <input class="form-control box_form" name="date" id="datepicker" type="text"  placeholder="Gift on" readonly> 
                       </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                  <button type="button" class="btn model-btn">Create</button>
                </div>
        
              </div>
            </div>
          </div>


    </main>
    <script>
    $(document).ready(function() {
    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
        
    $('#datepicker1').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    }); 
        
        
        
        
            $("#dataTables_filter").DataTable({
                dom: 'Bfrtip', 
                order: [[ 3, 'desc' ], [ 0, 'asc' ]],
                buttons: [
                    // {
                    //     extend: 'csvHtml5',
                    //     title: 'Project Management'
                    // },
                    // {
                    //     extend: 'pdfHtml5',
                    //     orientation: 'landscape',
                    //     pageSize: 'LEGAL',
                    //     title: 'Project Management'
                    // }
                ],
                language: {
                    search: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                    paginate: {
                        next: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Right_arrow_icon.svg">', // or '→'
                        previous: '<img src="https://www.aloro.io/stage/dashboard/assets/svg/Left_arrow_icon.svg">' // or '←'  <img src="path/to/arrow.png">'
                    }
                }
            });
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
    </script>

    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>