
$(document).ready(function () {
    var sidebar1 = '<div class="sidebar-header">';
    sidebar1 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar1 += '</div>';
    sidebar1 += '<h2 class="project-head">Order Management</h2>';
    sidebar1 += '<div class="sidebar-menu">';
    sidebar1 += '<ul class="toggle_sidebar">';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="greenline sidebar-link" href="distributor_order">';
    sidebar1 += '<img src="assets/sidebar/sales_orders.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Distributor Orders</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="buleline sidebar-link" href="sales_order">';
    sidebar1 += '<img src="assets/sidebar/sales-order-icon.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Sales Order</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="retailer_order">';
    sidebar1 += '<img src="assets/sidebar/Retailer Shop.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Retailer Order</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="van_order">';
    sidebar1 += '<img src="assets/sidebar/van_orders.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Van Order</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="sales_order_report">';
    sidebar1 += '<img src="assets/sidebar/sales-report@2x.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Sales Order Report</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';

    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="sales_order_count">';
    sidebar1 += '<img src="assets/sidebar/Sales_order_count.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Sales Order Count</span>';
    sidebar1 += '</a>';
    sidebar1 += '</li>';
    sidebar1 += '<li class="project-menu">';
    sidebar1 += '<a class="redline sidebar-link" href="distributor_stock_sales">';
    sidebar1 += '<img src="assets/sidebar/Sales Stock.svg" class="side-icon" alt="side icon">';
    sidebar1 += '<span>Distributor sales stock</span>';
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
    sidebar2 += '<a class="brownline sidebar-link" href="division">';
    sidebar2 += '<img src="assets/sidebar/division.png" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Divisions</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="violetline sidebar-link" href="product_list">';
    sidebar2 += '<img src="assets/sidebar/product_list.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Product List</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="greenline sidebar-link" href="stock_in_hand">';
    sidebar2 += '<img src="assets/sidebar/stock_in_hand.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Stock In Hand</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="redline sidebar-link" href="Scheme">';
    sidebar2 += '<img src="assets/sidebar/Scheme.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Scheme</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';
    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="redline sidebar-link" href="stockReports.php">';
    sidebar2 += '<img src="assets/sidebar/Stock report.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Stock Reports</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';

    sidebar2 += '<li class="project-menu">';
    sidebar2 += '<a class="redline sidebar-link" href="schem_product_report.php">';
    sidebar2 += '<img src="assets/sidebar/Free product report.svg" class="side-icon" alt="side icon">';
    sidebar2 += '<span>Scheme Products Reports</span>';
    sidebar2 += '</a>';
    sidebar2 += '</li>';


    sidebar2 += '</ul>';
    sidebar2 += '</div>';



    var sidebar3 = '<div class="sidebar-header">';
    sidebar3 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar3 += '</div>';

    sidebar3 += '<h2 class="project-head">Distributor Management</h2>';
    sidebar3 += '<div class="sidebar-menu">';
    sidebar3 += '<ul>';
    sidebar3 += '<li class="project-menu">';
    sidebar3 += '<a class="volietline sidebar-link" href="employees">';
    sidebar3 += '<img src="assets/sidebar/employee.svg" class="side-icon" alt="side icon">';
    sidebar3 += '<span>Distributor</span>';
    sidebar3 += '</a>';
    sidebar3 += '</li>';
    sidebar3 += '<li class="project-menu">';
    sidebar3 += '<a class="volietline sidebar-link" href="distrequest">';
    sidebar3 += '<img src="assets/sidebar/DistributorRequest@2x.svg" class="side-icon" alt="side icon">';
    sidebar3 += '<span>Distributor Request</span>';
    sidebar3 += '</a>';
    sidebar3 += '</li>';

    sidebar3 += '<li class="project-menu">';
    sidebar3 += '<a class="volietline sidebar-link" href="distributor_withorder">';
    sidebar3 += '<img src="assets/sidebar/Order.svg" class="side-icon" alt="side icon">';
    sidebar3 += '<span>Distributor Orders</span>';
    sidebar3 += '</a>';
    sidebar3 += '</li>';

    sidebar3 += '<li class="project-menu">';
    sidebar3 += '<a class="volietline sidebar-link" href="distributorOrderReport">';
    sidebar3 += '<img src="assets/sidebar/DistributorOrderReport.svg" class="side-icon" alt="side icon">';
    sidebar3 += '<span>Orders Reports</span>';
    sidebar3 += '</a>';
    sidebar3 += '</li>';

    sidebar3 += '<li class="project-menu">';
    sidebar3 += '<a class="volietline sidebar-link" href="distributorPurchaseReport">';
    sidebar3 += '<img src="assets/sidebar/Purchased Product sale.svg" class="side-icon" alt="side icon">';
    sidebar3 += '<span>Purchase Reports</span>';
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
    sidebar4 += '<li class="project-menu">';
    sidebar4 += '<a class="violetline sidebar-link" href="retailer">';
    sidebar4 += '<img src="assets/icons/retailer_icon.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Retailer</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    sidebar4 += '<li class="project-menu">';
    sidebar4 += '<a class="orangeline sidebar-link" href="order_history">';
    sidebar4 += '<img src="assets/icons/order_history_icon.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Order History</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';

    sidebar4 += '<li class="project-menu">';
    sidebar4 += '<a class="orangeline sidebar-link" href="shop_type">';
    sidebar4 += '<img src="assets/sidebar/shop_list.png" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Shop Type</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';

    sidebar4 += '<li class="project-menu">';
    sidebar4 += '<a class="orangeline sidebar-link" href="retailer_onboard.php">';
    sidebar4 += '<img src="assets/sidebar/Onboard User Signup.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Retailer Onboard</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';
    sidebar4 += '<li class="project-menu">';
    sidebar4 += '<a class="orangeline sidebar-link" href="discount.php">';
    sidebar4 += '<img src="assets/sidebar/discount.svg" class="side-icon" alt="side icon">';
    sidebar4 += '<span>Discount</span>';
    sidebar4 += '</a>';
    sidebar4 += '</li>';

    sidebar4 += '</ul>';
    sidebar4 += '</div>';

    var sidebar44 = '<div class="sidebar-header">';
    sidebar44 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar44 += '</div>';
    sidebar44 += '<h2 class="project-head">DISTRIBUTOR MANAGEMENT</h2>';
    sidebar44 += '<div class="sidebar-menu">';
    sidebar44 += '<ul>';
    sidebar44 += '<li class="project-menu">';
    sidebar44 += '<a class="volietline sidebar-link" href="employees">';
    sidebar44 += '<img src="assets/sidebar/employee.svg" class="side-icon" alt="side icon">';
    sidebar44 += '<span>Distributor</span>';
    sidebar44 += '</a>';
    sidebar44 += '</li>';
    sidebar44 += '<li class="project-menu">';
    sidebar44 += '<a class="violetline sidebar-link" href="retailer_view">';
    sidebar44 += '<img src="assets/icons/retailer_icon.svg" class="side-icon" alt="side icon">';
    sidebar44 += '<span>Retailer View</span>';
    sidebar44 += '</a>';
    sidebar44 += '</li>';
    sidebar44 += '<li class="project-menu">';
    sidebar44 += '<a class="orangeline sidebar-link" href="stocks">';
    sidebar44 += '<img src="assets/sidebar/stock_in_hand.svg" class="side-icon" alt="side icon">';
    sidebar44 += '<span>Stocks</span>';
    sidebar44 += '</a>';
    sidebar44 += '</li>';
    sidebar44 += '<li class="project-menu">';
    sidebar44 += '<a class="orangeline sidebar-link" href="retailer-request">';
    sidebar44 += '<img src="assets/sidebar/retailRequest.svg" class="side-icon" alt="side icon">';
    sidebar44 += '<span>Retailer Request</span>';
    sidebar44 += '</a>';
    sidebar44 += '</li>';
    sidebar44 += '</ul>';
    sidebar44 += '</div>';



    var sidebar5 = '<div class="sidebar-header">';
    sidebar5 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar5 += '</div>';
    sidebar5 += '<h2 class="project-head">Outstanding Management</h2>';
    sidebar5 += '<div class="sidebar-menu">';
    sidebar5 += '<ul>';
    sidebar5 += '<li class="project-menu">';
    sidebar5 += '<a class="sidebar-link" href="#">';
    sidebar5 += '<img src="assets/banner.png" class="side-icon" alt="side icon">';
    sidebar5 += '<span>Data Management</span>';
    sidebar5 += '</a>';
    sidebar5 += '</li>';
    sidebar5 += '</ul>';
    sidebar5 += '</div>';




    var sidebar6 = '<div class="sidebar-header">';
    sidebar6 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar6 += '</div>';
    sidebar6 += '<h2 class="project-head">Schedule Management</h2>';
    sidebar6 += '<div class="sidebar-menu">';
    sidebar6 += '<ul>';
    sidebar6 += '<li class="project-menu">';
    sidebar6 += '<a class="roseline sidebar-link" href="daily-schedule">';
    sidebar6 += '<img src="assets/icons/daily_schedule_pink.svg" class="side-icon" alt="side icon">';
    sidebar6 += '<span>Daily Schedule</span>';
    sidebar6 += '</a>';
    sidebar6 += '</li>';
    //                sidebar6 += '<li class="project-menu">';
    //                    sidebar6 += '<a class="blueline sidebar-link" href="unit-grouping">';
    //                        sidebar6 += '<img src="assets/icons/unit_grouping_icon.svg" class="side-icon" alt="side icon">'; 
    //                        sidebar6 += '<span>Unit Grouping</span>';                      
    //                    sidebar6 += '</a>';      
    //                sidebar6 += '</li>';
    sidebar6 += '</ul>';
    sidebar6 += '</div>';

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
    sidebar8 += '<img src="assets/icons/order_history_icon.svg" class="side-icon" alt="side icon">';
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
    sidebar10 += '<span>About us</span>';
    sidebar10 += '</a>';
    sidebar10 += '</li>';
    sidebar10 += '</ul>';
    sidebar10 += '</div>';





    var sidebar11 = '<div class="sidebar-header">';
    sidebar11 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar11 += '</div>';
    sidebar11 += '<h2 class="project-head">Notification Managenment</h2>';
    sidebar11 += '<div class="sidebar-menu">';
    sidebar11 += '<ul>';
    sidebar11 += '<li class="project-menu">';
    sidebar11 += '<a class="redline sidebar-link" href="notification_list">';
    sidebar11 += '<img src="assets/icons/notification_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar11 += '<span>Notification List</span>';
    sidebar11 += '</a>';
    sidebar11 += '</li>';
    sidebar11 += '</ul>';
    sidebar11 += '</div>';


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
    sidebar12 += '<li class="project-menu">';
    sidebar12 += '<a class="redline sidebar-link" href="overallitemproduct.php">';
    sidebar12 += '<img src="assets/sidebar/Items report.svg" class="side-icon" alt="side icon">';
    sidebar12 += '<span>Item wise sales report</span>';
    sidebar12 += '</a>';
    sidebar12 += '</li>';
    sidebar12 += '<li class="project-menu">';
    sidebar12 += '<a class="redline sidebar-link" href="overall_productoff_report.php">';
    sidebar12 += '<img src="assets/sidebar/Overall items sales report.svg" class="side-icon" alt="side icon">';
    sidebar12 += '<span>Overall item sales report</span>';
    sidebar12 += '</a>';
    sidebar12 += '</li>';

    sidebar12 += '<li class="project-menu">';
    sidebar12 += '<a class="redline sidebar-link" href="stateWise_report.php">';
    sidebar12 += '<img src="assets/sidebar/State-wise sales report.svg" class="side-icon" alt="side icon">';
    sidebar12 += '<span>StateWise Reports</span>';
    sidebar12 += '</a>';
    sidebar12 += '</li>';

    sidebar12 += '<li class="project-menu">';
    sidebar12 += '<a class="redline sidebar-link" href="state_report.php">';
    sidebar12 += '<img src="assets/sidebar/state_sales.svg" class="side-icon" alt="side icon">';
    sidebar12 += '<span>State Reports</span>';
    sidebar12 += '</a>';
    sidebar12 += '</li>';

    sidebar12 += '</ul>';
    sidebar12 += '</div>';


    var sidebar14 = '<div class="sidebar-header">';
    sidebar14 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar14 += '</div>';
    sidebar14 += '<h2 class="project-head">Setting</h2>';
    sidebar14 += '<div class="sidebar-menu">';
    sidebar14 += '<ul>';
    sidebar14 += '<li class="project-menu">';
    sidebar14 += '<a class="redline sidebar-link" href="setting">';
    sidebar14 += '<img src="assets/icons/notification_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar14 += '<span>Setup</span>';
    sidebar14 += '</a>';
    sidebar14 += '</li>';
    sidebar14 += '</ul>';
    sidebar14 += '</div>';


    var sidebar15 = '<div class="sidebar-header">';
    sidebar15 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar15 += '</div>';
    sidebar15 += '<h2 class="project-head">Region Management</h2>';
    sidebar15 += '<div class="sidebar-menu">';
    sidebar15 += '<ul>';
    sidebar15 += '<li class="project-menu">';
    sidebar15 += '<a class="greenline sidebar-link" href="region">';
    sidebar15 += '<img src="assets/region@1X.svg" class="side-icon" alt="side icon">';
    sidebar15 += '<span>Region</span>';
    sidebar15 += '</a>';
    sidebar15 += '</li>';
    sidebar15 += '</ul>';
    sidebar15 += '</div>';



    var sidebar16 = '<div class="sidebar-header">';
    sidebar16 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar16 += '</div>';
    sidebar16 += '<h2 class="project-head">Sales Rep Management</h2>';
    sidebar16 += '<div class="sidebar-menu">';
    sidebar16 += '<ul>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="brownline sidebar-link" href="sales-rep">';
    sidebar16 += '<img src="assets/sales rep side menu@1X.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Sales Rep</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="violetline sidebar-link" href="schedule_create">';
    sidebar16 += '<img src="assets/sidebar/schedule.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Schedule</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="brownline sidebar-link" href="leave_management">';
    sidebar16 += '<img src="assets/sidebar/leave.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Leave Management</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="greenline sidebar-link" href="expense">';
    sidebar16 += '<img src="assets/sidebar/expense.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Expense</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="violetline sidebar-link" href="sales_rep_report">';
    sidebar16 += '<img src="assets/sidebar/sales-rep-report@2x.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Sales Rep Report</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="buleline sidebar-link" href="livetrack_sales_rep">';
    sidebar16 += '<img src="assets/sidebar/live-tracking-report.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Livetrack Sales Rep</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="buleline sidebar-link" href="sales_rep_role">';
    sidebar16 += '<img src="assets/sidebar/Sales_rep_role.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Sales Rep Roles</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '<li class="project-menu">';
    sidebar16 += '<a class="buleline sidebar-link" href="attendance_report">';
    sidebar16 += '<img src="assets/sidebar/Attendance.svg" class="side-icon" alt="side icon">';
    sidebar16 += '<span>Attendance Report</span>';
    sidebar16 += '</a>';
    sidebar16 += '</li>';
    sidebar16 += '</ul>';
    sidebar16 += '</div>';



    var sidebar17 = '<div class="sidebar-header">';
    sidebar17 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar17 += '</div>';

    sidebar17 += '<h2 class="project-head">Support Management</h2>';
    sidebar17 += '<div class="sidebar-menu">';
    sidebar17 += '<ul>';
    sidebar17 += '<li class="project-menu">';
    sidebar17 += '<a class="volietline sidebar-link" href="Support">';
    sidebar17 += '<img src="assets/sidebar/Support@2x.svg" class="side-icon" alt="side icon">';
    sidebar17 += '<span>Support</span>';
    sidebar17 += '</a>';
    sidebar17 += '</li>';
    sidebar17 += '</ul>';
    sidebar17 += '</div>';

    var sidebar18 = '<div class="sidebar-header">';
    sidebar18 += '<label for="sidebar-toggle" class="side-togglebar"><img src="assets/next.svg" alt=""></label>';
    sidebar18 += '</div>';
    sidebar18 += '<h2 class="project-head">Support Log</h2>';
    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="log">';
    sidebar18 += '<img src="assets/sidebar/Support@2x.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Support Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';


    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="shop_type_log">';
    sidebar18 += '<img src="assets/sidebar/shop_list.png" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Shop Type Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="shop_create_log">';
    sidebar18 += '<img src="assets/icons/retailer_icon.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Shop Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="admin_stock_log">';
    sidebar18 += '<img src="assets/sidebar/stock_in_hand.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Admin Stock Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="distributor_log">';
    sidebar18 += '<img src="assets/sidebar/employee.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Distributor Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="offer_log">';
    sidebar18 += '<img src="assets/icons/offer_list_icon.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Offer Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="salesRep_log">';
    sidebar18 += '<img src="assets/sales rep side menu@1X.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>SalesRep Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="schedule_log">';
    sidebar18 += '<img src="assets/sidebar/schedule.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Schedule Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="product_log">';
    sidebar18 += '<img src="assets/sidebar/product_list.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Product Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="leave_log">';
    sidebar18 += '<img src="assets/sidebar/leave.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Leave Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="division_log">';
    sidebar18 += '<img src="assets/sidebar/division.png" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Division Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    sidebar18 += '<div class="sidebar-menu">';
    sidebar18 += '<ul>';
    sidebar18 += '<li class="project-menu">';
    sidebar18 += '<a class="volietline sidebar-link" href="order_log">';
    sidebar18 += '<img src="assets/sidebar/sales_orders.svg" class="side-icon" alt="side icon">';
    sidebar18 += '<span>Order Log</span>';
    sidebar18 += '</a>';
    sidebar18 += '</li>';
    sidebar18 += '</ul>';
    sidebar18 += '</div>';

    $("#sidebar1").html(sidebar1);
    $("#sidebar2").html(sidebar2);
    $("#sidebar3").html(sidebar3);
    $("#sidebar33").html(sidebar33);
    $("#sidebar4").html(sidebar4);
    $("#sidebar44").html(sidebar44);
    $("#sidebar5").html(sidebar5);
    $("#sidebar6").html(sidebar6);
    $("#sidebar7").html(sidebar7);
    $("#sidebar8").html(sidebar8);
    $("#sidebar9").html(sidebar9);
    $("#sidebar10").html(sidebar10);
    $("#sidebar11").html(sidebar11);
    $("#sidebar12").html(sidebar12);
    //    $("#sidebar13").html(sidebar13);
    $("#sidebar14").html(sidebar14);
    $("#sidebar15").html(sidebar15);
    $("#sidebar16").html(sidebar16);
    $("#sidebar18").html(sidebar18);

    $("#sidebarsupport").html(sidebar17);




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












