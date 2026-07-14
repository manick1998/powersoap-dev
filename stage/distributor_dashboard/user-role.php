<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role and Access</title>
    <link rel="shortcut icon" href="assets/favi.png">
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/user-roles.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">


</head>

<body>
    <header id="main-dash-header" class="dash-header">      
    </header>

    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar9"></div>
    
    <!-- main-contents -->
    <main class="main-contents">
        

        <section class="bg-white brad-4 full-height" id="employee" >
            <div class="product_header_container">
                <div class="header-details ">
                    <h1 class="header_main">User List <span class="total_emp">Total Users -<span>12</span></span></h1>
                </div>
            </div>
           
            <!-- Nav tabs -->
            <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-toggle="modal" data-target="#role_popup"><span><img class="" src="assets/icons/add_employee.png" alt=""></span>Add Users</button>
                </li>
                <li class="nav-item">
                <button class="nav-link" type="button">Download CSV</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent" >
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="custom-table" id="dataTables_filter">
                        <thead>
                            <tr>
                                <th>SI.NO</th>
                                <th>User Name</th>
                                <th>Email Address</th>
                                <th>Created on</th>
                                <th>Access Type</th>
                                <th>Module</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Lorem ipsum dolor</td>
                                <td>test@gmail.com</td>
                                <td>12/14/2022</td>
                                <td>Manager</td>
                                <td>User Management <a href="">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </main>
    
    <div class="modal fade" id="role_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
                <div class="modal-header">
                    <h2>Add User</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-inner-body">
                        <div class="dev-set">
                            <div class="info-set">
                                <div class="form__detail">
                                    <input type="text" id="user_email" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Username</label>
                                </div>
                            </div>
                            <div class="info-set">
                                <div class="form__detail">
                                    <input type="text" id="user_email" class="form__input" placeholder=" ">
                                    <label for="" class="form__label">Email Address</label>
                                </div>
                            </div>
                            <div class="info-set">
                                <div class="form__detail">
                                    <!-- <input type="text" id="user_email" class="form__input" placeholder=" "> -->
                                    <select class="form__input">
                                        <option value="0">-Select Option-</option>
                                        <option value="1">1</option>
                                    </select>
                                    <label for="" class="form__label">Access Type</label>
                                </div>
                            </div>
                        </div>
                        <div class="underline-dev">
                        </div>
                        <div class="module-op-set">
                            <p>Modules</p>
                            <div class="module-op-filer-set">
                                <div class="module-option">
                                    <label for="user_mang">
                                        <input type="checkbox" id="user_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        User Management
                                    </label>
                                </div>
                                <div class="module-option">
                                    <label for="cat_prod_mang">
                                        <input type="checkbox" id="cat_prod_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        Category/Product Management
                                    </label>
                                </div>
                                <div class="module-option">
                                    <label for="data_mang">
                                        <input type="checkbox" id="data_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        Data Management
                                    </label>
                                </div>
                                <div class="module-option">
                                    <label for="user_mang">
                                        <input type="checkbox" id="user_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        Banner Management
                                    </label>
                                </div>
                                <div class="module-option">
                                    <label for="cat_prod_mang">
                                        <input type="checkbox" id="cat_prod_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        Afiliate Management
                                    </label>
                                </div>
                                <div class="module-option">
                                    <label for="data_mang">
                                        <input type="checkbox" id="data_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        User role and access
                                    </label>
                                </div>
                                <div class="module-option">
                                    <label for="user_mang">
                                        <input type="checkbox" id="user_mang" class="modal-input hidden">
                                        <span class="cust-checkbox"></span>
                                        Legal settings
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button class="create-btn">Create</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    datepicker-->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> 
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>

    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    <script>
            $("#dataTables_filter").DataTable({
                dom: 'Bfrtip',
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
    </script>

</body>
</html>