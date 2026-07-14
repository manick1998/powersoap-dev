
$(document).ready(function () {
    var sidebar1 = '<div class="sidebar-header">';
    sidebar1 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar1 += '</div>';

    sidebar1 += '<h2 class="project-head">Order Management</h2>';
    sidebar1 += '<div class="sidebar-menu">';
    sidebar1 += '<ul>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="bluesline sidebar-link" href="sales_order" id="sales_order">';
    sidebar1 += '<img src="assets/sidebar/sales-order-icon.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Sales Order</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="van_order">';
    sidebar1 += '<img src="assets/sidebar/van_orders.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Van Order</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="Retailer_order" id="retailer_order">';
    sidebar1 += '<img src="assets/sidebar/RetailerShop.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Retailer Order</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '</ul>';


    sidebar1 += '</div>';

    var sidebar2 = '<div class="sidebar-header">';
    sidebar2 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar2 += '</div>';
    sidebar2 += '<h2 class="project-head">Inventory Management</h2>';
    sidebar2 += '<div class="sidebar-menu">';
    sidebar2 += '<ul>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="yellowline sidebar-link" href="order_products">';
    sidebar2 += '<img src="assets/order_product.png" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Order Product</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="redline sidebar-link" href="stock_orders">';
    sidebar2 += '<img src="assets/sidebar/van_orders.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Order History</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="greenline sidebar-link" href="stock_in_hand">';
    sidebar2 += '<img src="assets/sidebar/stock_in_hand.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Stock In Hand</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    //      sidebar2 += '<li class="project-menu">';
    //      sidebar2 += '<a class="violetline sidebar-link" href="addnew_product">';
    //      sidebar2 += '<img src="assets/sidebar/product_list.svg" class="side-icon" alt="side icon">'; 
    //      sidebar2 += '<span>My Products</span>';                      
    //      sidebar2 += '</a>';      
    //      sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="redline sidebar-link" href="Scheme">';
    sidebar2 += '<img src="assets/sidebar/Scheme.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Scheme</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '</ul>';
    sidebar2 += '</div>';



    var sidebar3 = '<div class="sidebar-header">';
    sidebar3 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar3 += '</div>';

    sidebar3 += '<h2 class="project-head">Employee Management</h2>';
    sidebar3 += '<div class="sidebar-menu">';
    sidebar3 += '<ul>';
    sidebar3 += '<li class="project-menu">';
    sidebar3 += '<a class="volietline sidebar-link" href="employees">';
    sidebar3 += '<img src="assets/sidebar/employee.svg" class="side-icon" alt="side icon">';
    sidebar3 += '<span>Employees</span>';
    sidebar3 += '</a>';
    sidebar3 += '</li>';
    sidebar3 += '</ul>';
    sidebar3 += '</div>';


    var sidebar33 = '<div class="sidebar-header">';
    sidebar33 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar33 += '</div>';

    sidebar33 += '<h2 class="project-head">Daily Summary Management</h2>';
    sidebar33 += '<div class="sidebar-menu">';
    sidebar33 += '<ul>';
    sidebar33 += '<li class="project-menu">';
    sidebar33 += '<a class="greenline sidebar-link" href="daily">';
    sidebar33 += '<img src="assets/sidebar/daily_summary.svg" class="side-icon" alt="side icon">';
    sidebar33 += '<span>Daily Summary</span>';
    sidebar33 += '</a>';
    sidebar33 += '</li>';
   
    sidebar33 += '</ul>';
    sidebar33 += '</div>';


    var sidebar4 = '<div class="sidebar-header">';
    sidebar4 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar4 += '</div>';

    sidebar4 += '<h2 class="project-head">Retailer Management</h2>';
    sidebar4 += '<div class="sidebar-menu">';
    sidebar4 += '<ul>';
    sidebar4 += '<li class="project-menu new_desing">';
    sidebar4 += '<a class="violetline sidebar-link" href="retailer">';
    sidebar4 += '<img src="assets/icons/retailer_icon.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Onboarded Retailer</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    sidebar4 += '<li class="project-menu new_desing">';
    sidebar4 += '<a class="orangeline sidebar-link" href="retailer-request">';
    sidebar4 += '<img src="assets/icons/Retailer@2x.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Retailer Request</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    sidebar4 += '<li class="project-menu old_desing">';
    sidebar4 += '<a class="violetline sidebar-link" href="retailer">';
    sidebar4 += '<img src="assets/icons/retailer_icon.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Details</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
   sidebar4 += '<li class="project-menu old_desing">';
    sidebar4 += '<a class="orangeline sidebar-link" href="take_order">';
    sidebar4 += '<img src="assets/icons/take_order.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Take Order</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    sidebar4 += '<li class="project-menu old_desing">';
    sidebar4 += '<a class="orangeline sidebar-link" href="order_history">';
    sidebar4 += '<img src="assets/icons/order_history_icon.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Order History</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    sidebar4 += '<li class="project-menu old_desing">';
    sidebar4 += '<a class="Redline sidebar-link" href="out_standing">';
    sidebar4 += '<img src="assets/icons/notification_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Outstanding</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    //            sidebar4 += '<li class="project-menu">';
    //            sidebar4 += '<a class="orangeline sidebar-link" href="shop_type">';
    //            sidebar4 += '<img src="assets/icons/order_history_icon.svg" class="side-icon" alt="side icon">'; 
    //            sidebar4 += '<span>Shop Type</span>';                      
    //            sidebar4 += '</a>';      
    //            sidebar4 += '</li>';
    sidebar4 += '</ul>';
    sidebar4 += '</div>';


    //        var sidebar5 = '<div class="sidebar-header">';
    ////            sidebar5 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/svg/menu-arrw.svg" alt=""></label>';
    //            sidebar5 += '</div>';
    //            
    //            sidebar5 += '<h2 class="project-head">Outstanding Management</h2>';
    //            sidebar5 += '<div class="sidebar-menu">';
    //            sidebar5 += '<ul>';
    //            sidebar5 += '<li class="project-menu">';
    //            sidebar5 += '<a class="sidebar-link" href="#">';
    //            sidebar5 += '<img src="assets/banner.png" class="side-icon" alt="side icon">'; 
    //            sidebar5 += '<span>Data Management</span>';                      
    //            sidebar5 += '</a>';      
    //            sidebar5 += '</li>';
    //            sidebar5 += '</ul>';
    //            sidebar5 += '</div>';




    var sidebar6 = '<div class="sidebar-header">';
    sidebar6 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar6 += '</div>';

    sidebar6 += '<h2 class="project-head">Schedule Management</h2>';
    sidebar6 += '<div class="sidebar-menu">';
    sidebar6 += '<ul>';
    sidebar6 += '<li class="project-menu">';
    sidebar6 += '<a class="roseline sidebar-link" href="daily-shedule">';
    sidebar6 += '<img src="assets/icons/daily_schedule_pink.svg" class="side-icon" alt="side icon">';
    sidebar6 += '<span>Daily Schedule</span>';
    sidebar6 += '</a>';
    sidebar6 += '</li>';
    sidebar6 += '<li class="project-menu">';
    sidebar6 += '<a class="blueline sidebar-link" href="unit-grouping">';
    sidebar6 += '<img src="assets/icons/unit_grouping_icon.svg" class="side-icon" alt="side icon">';
    sidebar6 += '<span>Unit Grouping</span>';
    sidebar6 += '</a>';
    sidebar6 += '</li>';
    sidebar6 += '</ul>';
    sidebar6 += '</div>';



    var sidebar12 = '<div class="sidebar-header">';
    sidebar12 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar12 += '</div>';

    sidebar12 += '<h2 class="project-head">Reports and Analytics</h2>';
    sidebar12 += '<div class="sidebar-menu">';
    sidebar12 += '<ul>';
    sidebar12 += '<li class="project-menu">';
    sidebar12 += '<a class="violetline sidebar-link" href="report_dashboard">';
    sidebar12 += '<img src="assets/icons/reports_icon.svg" class="side-icon" alt="side icon">';
    sidebar12 += '<span>My Dashboard</span>';
    sidebar12 += '</a>';
    sidebar12 += '</li>';
    sidebar12 += '</ul>';
    sidebar12 += '</div>';


    var sidebar7 = '<div class="sidebar-header">';
    sidebar7 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar7 += '</div>';

    sidebar7 += '<h2 class="project-head">Offer Management</h2>';
    sidebar7 += '<div class="sidebar-menu">';
    sidebar7 += '<ul>';
    sidebar7 += '<li class="project-menu">';
    sidebar7 += '<a class="blueline sidebar-link" href="offer">';
    sidebar7 += '<img src="assets/icons/offer_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar7 += '<span>Offer List</span>';
    sidebar7 += '</a>';
    sidebar7 += '</li>';
    sidebar7 += '</ul>';
    sidebar7 += '</div>';


    var sidebar8 = '<div class="sidebar-header">';
    sidebar8 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar8 += '</div>';
    sidebar8 += '<h2 class="project-head">Gift Management</h2>';
    sidebar8 += '<div class="sidebar-menu">';
    sidebar8 += '<ul>';
    sidebar8 += '<li class="project-menu">';
    sidebar8 += '<a class="blueline sidebar-link" href="shop-list">';
    sidebar8 += '<img src="assets/icons/offer_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar8 += '<span>Shop List</span>';
    sidebar8 += '</a>';
    sidebar8 += '</li>';
    sidebar8 += '<li class="project-menu">';
    sidebar8 += '<a class="greenline sidebar-link" href="slot">';
    sidebar8 += '<img src="assets/icons/slots_icon.svg" class="side-icon" alt="side icon">';
    sidebar8 += '<span>Slots</span>';
    sidebar8 += '</a>';
    sidebar8 += '</li>';
    sidebar8 += '</ul>';
    sidebar8 += '</div>';


    var sidebar10 = '<div class="sidebar-header">';
    sidebar10 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar10 += '</div>';
    sidebar10 += '<h2 class="project-head">Legal and settings</h2>';
    sidebar10 += '<div class="sidebar-menu">';
    sidebar10 += '<ul>';
    sidebar10 += '<li class="project-menu">';
    sidebar10 += '<a class="blueline sidebar-link" href="privacy-policy">';
    sidebar10 += '<img src="assets/icons/privacy_policy_icon.svg" class="side-icon" alt="side icon">';
    sidebar10 += '<span>Privacy Policy</span>';
    sidebar10 += '</a>';
    sidebar10 += '</li>';
    sidebar10 += '<li class="project-menu">';
    sidebar10 += '<a class="greenline sidebar-link" href="terms-condition">';
    sidebar10 += '<img src="assets/icons/terms_and_conditions_icon.svg" class="side-icon" alt="side icon">';
    sidebar10 += '<span>Terms and Conditions</span>';
    sidebar10 += '</a>';
    sidebar10 += '</li>';
    sidebar10 += '<li class="project-menu">';
    sidebar10 += '<a class="greenline sidebar-link" href="About_us">';
    sidebar10 += '<img src="assets/about.svg" class="side-icon" alt="side icon">';
    sidebar10 += '<span>About Us</span>';
    sidebar10 += '</a>';
    sidebar10 += '</li>';
    sidebar10 += '</ul>';
    sidebar10 += '</div>';


    var sidebar9 = '<div class="sidebar-header">';
    sidebar9 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar9 += '</div>';
    sidebar9 += '<h2 class="project-head">User roles and Access</h2>';
    sidebar9 += '<div class="sidebar-menu">';
    sidebar9 += '<ul>';
    sidebar9 += '<li class="project-menu">';
    sidebar9 += '<a class="violetline sidebar-link" href="user-role">';
    sidebar9 += '<img src="assets/icons/user_roles_icon.svg" class="side-icon" alt="side icon">';
    sidebar9 += '<span>User Roles</span>';
    sidebar9 += '</a>';
    sidebar9 += '</li>';
    sidebar9 += '</ul>';
    sidebar9 += '</div>';


    var sidebar11 = '<div class="sidebar-header">';
    sidebar11 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar11 += '</div>';
    sidebar11 += '<h2 class="project-head">Notification Managenment</h2>';
    sidebar11 += '<div class="sidebar-menu">';
    sidebar11 += '<ul>';
    sidebar11 += '<li class="project-menu">';
    sidebar11 += '<a class="Redline sidebar-link" href="notification">';
    sidebar11 += '<img src="assets/icons/notification_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar11 += '<span>Notification List</span>';
    sidebar11 += '</a>';
    sidebar11 += '</li>';
    sidebar11 += '</ul>';
    sidebar11 += '</div>';

    var sidebar13 = '<div class="sidebar-header">';
    sidebar13 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar13 += '</div>';
    sidebar13 += '<h2 class="project-head">Notification Managenment</h2>';
    sidebar13 += '<div class="sidebar-menu">';
    sidebar13 += '<ul>';
    sidebar13 += '<li class="project-menu">';
    sidebar13 += '<a class="Redline sidebar-link" href="notification_list">';
    sidebar13 += '<img src="assets/icons/notification_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar13 += '<span>Notification List</span>';
    sidebar13 += '</a>';
    sidebar13 += '</li>';
    sidebar13 += '</ul>';
    sidebar13 += '</div>';

    var sidebar14 = '<div class="sidebar-header">';
    sidebar14 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar14 += '</div>';
    sidebar14 += '<h2 class="project-head">Setting</h2>';
    sidebar14 += '<div class="sidebar-menu">';
    sidebar14 += '<ul>';
    sidebar14 += '<li class="project-menu">';
    sidebar14 += '<a class="Redline sidebar-link" href="setting">';
    sidebar14 += '<img src="assets/icons/notification_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar14 += '<span>Setup</span>';
    sidebar14 += '</a>';
    sidebar14 += '</li>';
    sidebar14 += '</ul>';
    sidebar14 += '</div>';


    var sidebar15 = '<div class="sidebar-header">';
    sidebar15 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar15 += '</div>';
    sidebar15 += '<h2 class="project-head">My Account</h2>';
    sidebar15 += '<div class="sidebar-menu">';
    sidebar15 += '<ul>';
    sidebar15 += '<li class="project-menu">';
    sidebar15 += '<a class="blueline sidebar-link" href="my_profile">';
    sidebar15 += '<img src="assets/icons/my-profile.svg" class="side-icon" alt="side icon">';
    sidebar15 += '<span>My Profile</span>';
    sidebar15 += '</a>';
    sidebar15 += '</li>';
    sidebar15 += '<li class="project-menu">';
    sidebar15 += '<a class="greenline sidebar-link" href="payment_method">';
    sidebar15 += '<img src="assets/icons/payment-method-details.svg" class="side-icon" alt="side icon">';
    sidebar15 += '<span>Payment Method Details here</span>';
    sidebar15 += '</a>';
    sidebar15 += '</li>';

    sidebar15 += '</ul>';
    sidebar15 += '</div>';













    $("#sidebar1").html(sidebar1);
    $("#sidebar2").html(sidebar2);
    $("#sidebar3").html(sidebar3);
    $("#sidebar33").html(sidebar33);
    $("#sidebar4").html(sidebar4);
    //$("#sidebar5").html(sidebar5);
    $("#sidebar6").html(sidebar6);
    $("#sidebar7").html(sidebar7);
    $("#sidebar8").html(sidebar8);
    $("#sidebar9").html(sidebar9);
    $("#sidebar10").html(sidebar10);
    $("#sidebar11").html(sidebar11);
    $("#sidebar12").html(sidebar12);
    //$("#sidebar13").html(sidebar13);
    $("#sidebar13").html(sidebar13);
    $("#sidebar14").html(sidebar14);
    $("#sidebar15").html(sidebar15);
    // $("#sidebar16").html(sidebar16);
    // sidebar active
    const currentLocation = location.href;
    const menuItems = document.querySelectorAll('.sidebar-link');
    const menuLength = menuItems.length;
    for (let i = 0; i < menuLength; i++) {
        if (menuItems[i].href === currentLocation) {
            menuItems[i].classList.add("active-sidemenu");
        }
    }
});









