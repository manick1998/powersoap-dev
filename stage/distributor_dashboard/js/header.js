$(document).ready(function () {
  // Sync variables with sessionStorage for cross-page persistence
  if (typeof distributor_token !== 'undefined' && distributor_token) sessionStorage.setItem('distributor_token', distributor_token);
  else if (typeof Distributor_token !== 'undefined' && Distributor_token) sessionStorage.setItem('distributor_token', Distributor_token);
  
  if (typeof verfication_code !== 'undefined' && verfication_code) sessionStorage.setItem('verfication_code', verfication_code);
  else if (typeof verification_code !== 'undefined' && verification_code) sessionStorage.setItem('verfication_code', verification_code);
  
  if (typeof api_path !== 'undefined' && api_path) sessionStorage.setItem('api_path', api_path);

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
  


  header1 += '  <li id="profile">';
  header1 += '   <div class="dropdown-logout1" id="menu_dropdown">';
  header1 += '      <a class="logout-toggle" href="#" role="button" id="logoutdropdownMenuLink" aria-expanded="false"><span id="profile-pic"><img src="assets/user.png" alt=""></span><span class="profile-name-set"><span class="profile-name">' + Distributor_name + '</span><span class="region-name">(' + region_name + ')</span></span>';
  header1 += '      </a>';
  header1 += '      <div class="dropdown-menu">';
  header1 += '         <a class="dropdown-item logout-link" href="my_profile" data-i18n="my_profile">My Profile</a>';
  header1 += '         <div class="dropdown-divider"></div>';
  header1 += '         <div class="dropdown-language language-switch">';
  header1 += '            <a class="dropdown-item logout-link lang-btn-gl" id="gl_lang_en" href="#" onclick="changeGlobalLanguage(\'en\')"><span data-i18n="english">English</span></a>';
  header1 += '            <a class="dropdown-item logout-link lang-btn-gl" id="gl_lang_ta" href="#" onclick="changeGlobalLanguage(\'ta\')"><span data-i18n="tamil">Tamil</span></a>';
  header1 += '         </div>';
  header1 += '         <div class="dropdown-divider"></div>';
  header1 += '         <a class="dropdown-item logout-link" href="logout" data-i18n="logout">Logout</a>';
  header1 += '      </div>';
  header1 += '   </div>';
  header1 += '</li>';

  // header1 += '<li id="profile">';
  // header1 += '<div class="dropdown-logout1" id="menu_dropdown">';
  // header1 += '<a class="logout-toggle" href="#" role="button" id="logoutdropdownMenuLink" aria-expanded="false"><span id="profile-pic"><img src="assets/user.png" alt=""></span><span class="profile-name-set"><span class="profile-name">' + Distributor_name + '</span><span class="region-name">(' + region_name + ')</span></span>';
  // header1 += '</a>';
  // header1 += '';
  // header1 += '<div class="dropdown-menu">';
  // header1 += '<a class="dropdown-item logout-link" href="my_profile" data-i18n="my_profile">My Profile</a>';
  // header1 += '<div class="dropdown-divider"></div>';
  // header1 += '<div class="dropdown-language language-switch">';
  // header1 += '<a class="dropdown-item logout-link" href="#" onclick="changeGlobalLanguage(\'en\')"><img src="assets/icons/en_flag.png" style="width:18px;margin-right:8px;" alt=""> <span data-i18n="english">English</span></a>';
  // header1 += '<a class="dropdown-item logout-link" href="#" onclick="changeGlobalLanguage(\'ta\')"><img src="assets/icons/ta_flag.png" style="width:18px;margin-right:8px;" alt=""> <span data-i18n="tamil">Tamil</span></a>';
  // header1 += '<div class="dropdown-divider"></div>';
  // header1 += '<a class="dropdown-item logout-link" href="logout" data-i18n="logout">Logout</a>';
  // header1 += '</div>';
  // header1 += '</div>';
  // header1 += '</div>';
  // header1 += '</li>';
  
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

  // Popup for unseen notifications
  if (window.location.pathname.endsWith('home.php') || window.location.pathname.endsWith('home') || window.location.pathname.endsWith('distributor_dashboard/')) {
      var dToken = (typeof distributor_token !== 'undefined' && distributor_token) ? distributor_token : 
                  ((typeof Distributor_token !== 'undefined' && Distributor_token) ? Distributor_token : 
                  sessionStorage.getItem('distributor_token'));
      var vCode = (typeof verfication_code !== 'undefined' && verfication_code) ? verfication_code : 
                 ((typeof verification_code !== 'undefined' && verification_code) ? verification_code : 
                 sessionStorage.getItem('verfication_code'));
      var aPath = (typeof api_path !== 'undefined' && api_path) ? api_path : 
                 sessionStorage.getItem('api_path');

      if (dToken && vCode && aPath) {
          $.ajax({
              type: "POST",
              dataType: "json",
              url: aPath + "/distributor/notification.php",
              data: JSON.stringify({
                  dashboard_code: vCode,
                  distributor_token: dToken,
                  type: 'count_unseen'
              }),
          }).done(function(data) {
              if (data.code == 200 && data.count > 0) {
                  swal({
                      title: getGlobalTranslation("notification"),
                      text: getGlobalTranslation("you_have_notifications"),
                      icon: "info",
                      buttons: {
                          cancel: getGlobalTranslation("later"),
                          confirm: {
                              text: getGlobalTranslation("view_now"),
                              value: true,
                          }
                      },
                  }).then((willView) => {
                      if (willView) {
                          window.location.href = "notification_list";
                      }
                  });
              }
          });
      }
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

// Global i18n Logic
var currentGlobalLang = localStorage.getItem('selectedLang') || 'en';
var globalTranslations = {};

function initGlobalI18n() {
  $.getJSON('js/translations.json', function (data) {
    globalTranslations = data;
    applyGlobalTranslations(currentGlobalLang);
  });
}

function changeGlobalLanguage(lang) {
  currentGlobalLang = lang;
  localStorage.setItem('selectedLang', lang);
  applyGlobalTranslations(lang);

  // Persistence logic: Update language in database
  // Check global variables first, then fallback to sessionStorage
  var dToken = (typeof distributor_token !== 'undefined' && distributor_token) ? distributor_token : 
              ((typeof Distributor_token !== 'undefined' && Distributor_token) ? Distributor_token : 
              sessionStorage.getItem('distributor_token'));
              
  var vCode = (typeof verfication_code !== 'undefined' && verfication_code) ? verfication_code : 
             ((typeof verification_code !== 'undefined' && verification_code) ? verification_code : 
             sessionStorage.getItem('verfication_code'));
             
  var aPath = (typeof api_path !== 'undefined' && api_path) ? api_path : 
             sessionStorage.getItem('api_path');

  if (dToken && vCode && aPath) {
    var datas = {
        dashboard_code: vCode,
        distributor_token: dToken,
        language: lang
    };
    var json_data = JSON.stringify(datas);
    $.ajax({
        type: "POST",
        dataType: "json",
        url : aPath + "/distributor/updateLanguage.php",
        data: json_data,
    }).done(function(data) {
        if(data.code == 200) {
            if (typeof swal !== 'undefined') {
                swal(getGlobalTranslation('lang_success'), "", "success");
            }
        } else {
            console.error("Language update failed:", data.message);
        }
    });
  }
  
  // If we are on My Profile, update the select box too if it exists
  if ($('#language_select').length) {
    $('#language_select').val(lang);
  }
}

function applyGlobalTranslations(lang) {
  $('.lang-btn-gl').removeClass('active');
  $('#gl_lang_' + lang).addClass('active');

  $('[data-i18n]').each(function () {
    var key = $(this).data('i18n');
    if (globalTranslations[lang] && globalTranslations[lang][key]) {
      $(this).text(globalTranslations[lang][key]);
    }
  });

  $('[data-i18n-placeholder]').each(function () {
    var key = $(this).data('i18n-placeholder');
    if (globalTranslations[lang] && globalTranslations[lang][key]) {
      $(this).attr('placeholder', globalTranslations[lang][key]);
    }
  });
}

function getGlobalTranslation(key) {
  return (globalTranslations[currentGlobalLang] && globalTranslations[currentGlobalLang][key]) ? globalTranslations[currentGlobalLang][key] : key;
}

$(document).ready(function() {
  initGlobalI18n();
});








