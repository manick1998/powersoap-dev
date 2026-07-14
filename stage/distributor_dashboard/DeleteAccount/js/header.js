$(document).ready(function () {

  var header1 = '<div class="head-logo">';
  header1 += '<a href="home"><img class="logo" src="assets/logo.png" alt="logo"></a>';
  header1 += '</div>';
  header1 += '<div class="back-drop hidden"></div>'
  header1 += '<div class="nav-menu">';
  header1 += '<ul class="nav-links">';
  header1 += '<li id="support"><a href="#" data-toggle="modal" data-target="#support_pop" class="hide-suport"><img src="assets/icons/Support@2x.svg" alt=""></a></li>';
  header1 += '<li id="home-btn"><a href="home"><img src="assets/icons/home_icon.svg" alt=""></a></li>';

  header1 += '<li id="bell-btn"><a href="notification_list"><img src="assets/icons/notification_icon_red_dot.svg" alt=""></a></li>';
  header1 += '<li id="bell-btn1" class="hidden"><a href="notification_list"><img src="assets/icons/notification_bell.svg" alt=""></a></li>';

  header1 += '<li id="profile">';
  header1 += '<div class="dropdown-logout1" id="menu_dropdown">';
  header1 += '<a class="logout-toggle" href="#" role="button" id="logoutdropdownMenuLink" aria-expanded="false"><span id="profile-pic"><img src="assets/user.png" alt=""></span><span class="profile-name-set"><span class="profile-name">' + Distributor_name + '</span><span class="region-name">(' + region_name + ')</span></span>';
  header1 += '</a>';
  header1 += '';
  header1 += '<div class="dropdown-menu">';
  header1 += '<a class="dropdown-item logout-link" href="my_profile">My Profile</a>';
  header1 += '<a class="dropdown-item logout-link" href="logout">Logout</a>';
  header1 += '</div>';
  header1 += '</div>';
  header1 += '</li>';
  header1 += '</ul>';
  header1 += '</div>';
  $("#main-dash-header").html(header1);

  if (notiCount > 0) {
    $('#bell-btn1').addClass('hidden');
    $('#bell-btn').removeClass('hidden');
  } else {
    $('#bell-btn').addClass('hidden');
    $('#bell-btn1').removeClass('hidden');
  }




  // open logout

  //   const logoutToggle = document.querySelector('.logout-toggle');
  // const backDrop = document.querySelector('.back-drop');
  // let getAriaAtrr =  Boolean(logoutToggle.getAttribute('aria-expanded'));
  // logoutToggle.addEventListener('click',()=>{
  //      if(getAriaAtrr){
  //         backDrop.classList.remove('hidden')
  //         document.querySelector('.dropdown-logout').classList.add('open');

  //         getAriaAtrr = false;
  //      }else{
  //         backDrop.classList.add('hidden')
  //         document.querySelector('.dropdown-logout').classList.remove('open');
  //         getAriaAtrr = true;
  //         alert('vp-out')
  //      }
  // })
  // backDrop.addEventListener('click',()=>{
  //      localStorage.clear();
  //      document.querySelector('.dropdown-logout').classList.remove('open');
  //      getAriaAtrr = true;
  //      backDrop.classList.add('hidden');
  // });
});








