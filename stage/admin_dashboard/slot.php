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
    <title>Power soap - Slot</title>
    <link rel="shortcut icon" href="assets/favi.png">
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/slot.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">


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
            <div class="slot_header_container">
                <div class="slot_header-section">
                        <h1 class="header_main">Slot List</h1>
                    <p class="table_count">Total Slots - <span id="project_count">4</span></p>
                </div>
            </div>
            
            <div class="gift_header">

                        <div class="gift_header_bottom col-12">
                                <button type="submit" data-toggle="modal" data-target="#exampleModal">Add Slot</button>
                            </div>
            </div>
                


            <div class="table-box">
                <table class="custom-table" id="dataTables_filter">
                    <thead>
                        <tr>
                            <th>SI.No</th>
                            <th>Slot Name</th>
                            <th>Gift Numbers</th>
                            <th>Gifts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="#">Slot 1</a></td>
                            <td>5</td>
                            <td>Silver Coin</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#">Slot 2</a></td>
                            <td>3</td>
                            <td>TV</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a href="#">Slot 1</a></td>
                            <td>3</td>
                            <td>Fridge</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>






             <!-- Modal 2-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title gift_title_center" id="exampleModalLongTitle">Add Slot</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
 
                            <div class="form-control">
                                <p>Slot Name</p>
                                <input class="input-field" value="">
                            </div> 
                          </div>
                          <div class="underline-div"></div>
                          <div class="form-group col-12  slot_modal_header">
                            <div class="form-control col-5">
                                <p>Gift Name</p>
                                <input class="input-field" value="">
                            </div> 
                            <div class="form-control col-3">
                                <p>Qty</p>
                                <input class="input-field" value="">
                            </div> 
                            <div class="form-control col-2">
                                <p>Cost</p>
                                <input class="input-field" value="">
                            </div> 
                            <div class="col-1">
                                 <img src="assets/icons/close-icon.png" class="close-icon" alt="close icon">
                            </div> 
                          </div>
                          <div class="form-group col-12  slot_modal_header">
                            <div class="form-control col-5">
                                <p>Gift Name</p>
                                <input class="input-field" value="">
                            </div> 
                            <div class="form-control col-3">
                                <p>Qty</p>
                                <input class="input-field" value="">
                            </div> 
                            <div class="form-control col-2">
                                <p>Cost</p>
                                <input class="input-field" value="">
                            </div> 
                            <div class="col-1">
                                 <img src="assets/icons/close-icon.png" class="close-icon" alt="close icon">
                            </div> 
                          </div>
                          <div class="col-12">
                            <a href="#" class="view_link">+ Add Gifts</a>
                          </div>
                      </form>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button class="create-btn">Create</button>
                </div>
              </div>
            </div>
          </div>
    </main>
    <script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> 
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script> 
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
<?php
}
mysqli_close($link);
?>