$(document).ready(function(){ 

    var header1 = '<div class="head-logo">';
            header1 += '<a href="home.php"><img class="logo" src="assets/logo.png" alt="logo"></a>';
            header1 += '</div>'; 
            header1 += '<div class="back-drop hidden"></div>'
            header1 += '<div class="nav-menu">';
            header1 += '<ul class="nav-links">';
            header1 += '<li id="home-btn"><a href="home.php"><img src="assets/icons/home_icon.svg" alt=""></a></li>';        
            header1 += '<li id="bell-btn"><a href="notification_list"><img src="assets/icons/notification_icon_red_dot.svg" alt=""></a></li>';
            header1 += '<li id="bell-btn1" class="hidden"><a href="notification_list"><img src="assets/icons/notification_bell.svg" alt=""></a></li>';
            header1 += '<li id="profile">';
            header1 += '<div class="dropdown-logout">';
            header1 += '<a class="logout-toggle" href="#" role="button" id="logoutdropdownMenuLink" aria-expanded="false"><span id="profile-pic"><img src="assets/user.png" alt=""></span><span class="profile-name">'+gl_admin_name+'</span>';  
//    
            header1 += '</a>';
            header1 += '<div class="dropdown-menu">';
            // header1 += '<a class="dropdown-item" href="#">Action</a>';
//            header1 += '<a class="dropdown-item" href="#">Reset Password</a>';
            header1 += '<a class="dropdown-item" href="logout.php">Logout</a>';
            header1 += '</div>';
            header1 += '</div>';
            header1 += '</li>';
            header1 += '</ul>';
            header1 += '</div>';
    $("#main-dash-header").html(header1);
     


  // open logout

   const logoutToggle = document.querySelector('.logout-toggle');
   const backDrop = document.querySelector('.back-drop');
   let getAriaAtrr =  Boolean(logoutToggle.getAttribute('aria-expanded'));
   logoutToggle.addEventListener('click',()=>{
        if(getAriaAtrr){
           backDrop.classList.remove('hidden')
           document.querySelector('.dropdown-logout').classList.add('open');

           getAriaAtrr = false;
        }else{
           backDrop.classList.add('hidden')
           document.querySelector('.dropdown-logout').classList.remove('open');
           getAriaAtrr = true;
        }
   })
   backDrop.addEventListener('click',()=>{
        document.querySelector('.dropdown-logout').classList.remove('open');
        getAriaAtrr = true;
        backDrop.classList.add('hidden')
   })

   
     //page reload which clicking back button
    window.addEventListener("pageshow", function(event) {
        var historyTraversal = event.persisted ||
            (typeof window.performance != "undefined" &&
                window.performance.navigation.type === 2);
        if (historyTraversal) {
            // Handle page restore.
            window.location.reload();
        }
    });
    
});







