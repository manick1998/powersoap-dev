//using in dashboard ->family_tree.php
function value_check(id,value,type,label){
    var valid_value;
    if(type=="text"){
        if(value==""){
            $("#"+id).css("border","1px solid #ed3833");
            valid_value = false;
        }else{
            $("#"+id).css("border","1px solid #ced4da");
            valid_value = true;
        }
    }else if(type=="text_date"){
        if(value==""){
            $("#"+id).css("border","1px solid #ed3833 !important");
            valid_value = false;
        }else{
            $("#"+id).css("border","1px solid #ced4da !important");
            valid_value = true;
        }
    }else if(type=="text_box"){
        if(value==""){
            $("."+id+"_box").css("border","1px solid #ed3833");
            $("."+id).css("color","#ed3833");
            valid_value = false;
        }else{
            $("."+id+"_box").css("border","1px solid #ced4da");
            $("."+id).css("color","#798893");
            valid_value = true;
        }
    }else if(type=="select"){
        if(value==""){
            $("#"+id).css("border-bottom","1px solid rgb(237 56 51)");
            $("#"+id).css("color","#ed3833 !important");
            valid_value = false;
        }else{
            $("#"+id).css("border-bottom","1px solid #9e9c9c");
            $("#"+id).css("color","#9e9c9c !important");
            valid_value = true;
        }
    }else if(type=="text-noti"){
        if(value==""){
            $("#"+id).css("border","1px solid #ed3833");
            valid_value = false;
        }else{
            $("#"+id).css("border","1px solid #767676");
            valid_value = true;
        }
    }if(type=="select"){
        if(value==""){
            $("#"+id).css("border-bottom","1px solid rgb(237 56 51)");
            $("#"+id).css("color","#ed3833 !important");
            valid_value = false;
        }else{
            $("#"+id).css("border-bottom","1px solid #9e9c9c");
            $("#"+id).css("color","#9e9c9c !important");
            valid_value = true;
        }
    }else if(type=="email"){
        if(value==""){
            $("#"+id).css("border-bottom","1px solid #ed3833");
            $("."+id).css("color","#ed3833");
            $("."+id).html(label);
            valid_value = false;
        }else{
            valid_value = true;
            if(IsEmail(value)==false){
                $("#"+id).css("border-bottom","1px solid #ed3833");
                $("."+id).css("color","#ed3833");
                $("."+id).html("Please enter valid email");
                valid_value = false;
            }else{
                $("#"+id).css("border-bottom","1px solid #9e9c9c");
                $("."+id).css("color","#9e9c9c");
                $("."+id).html(label);
                valid_value = true;
            }
        }
    }else if(type=="text_box_email"){
        if(value==""){
            $("."+id+"_box").css("border","1px solid #ed3833");
            $("."+id).css("color","#ed3833");
            $("."+id).html(label);
            valid_value = false;
        }else{
            valid_value = true;
            if(IsEmail(value)==false){
                $("."+id+"_box").css("border","1px solid #ed3833");
                $("."+id).css("color","#ed3833");
                $("."+id).html("Please enter valid email");
                valid_value = false;
            }else{
                $("."+id+"_box").css("border","1px solid #9e9c9c");
                $("."+id).css("color","#9e9c9c");
                $("."+id).html(label);
                valid_value = true;
            }
        }
    }else if(type=="mobile_number"){
        if(value==""){
            $("#"+id).css("border-bottom","1px solid #ed3833");
            $("."+id).css("color","#ed3833");
            $("."+id).html(label);
            valid_value = false;
        }else{
            valid_value = true;
            if(IsMobile(value)==false){
                $("#"+id).css("border-bottom","1px solid #ed3833");
                $("."+id).css("color","#ed3833");
                $("."+id).html("Please enter 10 digit mobile number");
                valid_value = false;
            }else{
                $("#"+id).css("border-bottom","1px solid #9e9c9c");
                $("."+id).css("color","#9e9c9c");
                $("."+id).html(label);
                valid_value = true;
            }
        }
    }else if(type=="description"){
        if(value==""){
            $("#"+id).css("border","1px solid #ed3833");
            $("."+id).css("color","#ed3833");
            valid_value = false;
        }else{
            $("#"+id).css("border","1px solid #9e9c9c");
            $("."+id).css("color","#9e9c9c");
            valid_value = true;
        }
    }else if(type=="image"){
        if(value==""){
            valid_value = false;
        }else{
            valid_value = true;
        }
    }else if(type=="mobile"){ 
        if(value==""){
            $("."+id).css("color","#ed3833");
            $("."+id+"_box").css("border","1px solid #ed3833");
            $("."+id).html(label);
            valid_value = false;
        }else{
            if(value.length < 10){
                $("."+id).css("color","#ed3833");
                $("."+id+"_box").css("border","1px solid #ed3833");
                $("."+id).html("Please enter 10 digit mobile number");
                valid_value = false;
            }else{
                $("."+id).css("color","#9e9c9c");
                $("."+id+"_box").css("border","1px solid #ced4da");
                $("."+id).html(label);
                valid_value = true;
            }
        } 
    }else if(type=="pin_code"){ 
        if(value==""){
            $("."+id).css("color","#ed3833");
            $("."+id+"_box").css("border","1px solid #ed3833");
            valid_value = false;
        }else{
            if(value.length < 6){
                $("."+id).css("color","#ed3833");
                $("."+id+"_box").css("border","1px solid #ed3833");
                $("."+id).html("Please enter 6 digit for Pin code");
                valid_value = false;
            }else{
                $("."+id).css("color","#9e9c9c");
                $("."+id+"_box").css("border","1px solid #ced4da");
                valid_value = true;
            }
        } 
    }
    return valid_value;
}
//...............//
//using in dashboard ->family_tree.php
function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z@\\d]([a-z@\\d-]*[a-z@\\d])*)\\.)+[a-z@]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z@\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z@\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z@\\d_]*)?$','i'); // fragment locator
    return !!pattern.test(str);
}
//...............//
//unsing in dashboard -> gallery.php
var pdf_type_array = ['pdf'];
var image_type_array = ['png', 'jpg', 'jpeg', 'gif'];
var video_type_array = ['mp4', 'mov', 'wmv', 'avi', 'avchd', 'flv'];
var all_type_array   = ['png', 'jpg', 'jpeg', 'gif', 'mp4', 'mov', 'wmv', 'avi', 'avchd', 'flv'];
function get_url_type(file_url) {
    var url       = new URL(file_url);
    var length    = (url.pathname.split(".")).length;
    var count     = parseInt(length)-1;
    var extension = url.pathname.split(".")[count];
    extension     = extension.toLowerCase();
    return extension;
}
function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
}
function IsMobile(number) {
    return true;
}
$('.numberonly').keypress(function (e) {
    var charCode = (e.which) ? e.which : event.keyCode 
    if (String.fromCharCode(charCode).match(/[^0-9]/g))    
    return false;
}).on('paste', function (event) {  
    var $this = $(this);  
    setTimeout(function () {  
        $this.val($this.val().replace(/[^0-9]/g, ''));  
    }, 5);  
}); 
$(".floatonly").on("keypress keyup blur",function (event) {
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
}).on('paste', function (event) {  
    var $this = $(this);  
    setTimeout(function () {  
        $this.val($this.val().replace(/[^0-9]/g, ''));
    }, 5);  
});  
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
} 
function comma_separator(x){
   x=x.toString();
   var lastThree = x.substring(x.length-3);
   var otherNumbers = x.substring(0,x.length-3);
   if(otherNumbers != '')
      lastThree = ',' + lastThree;
   var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
   return res;
}
function numberFormatComma(number){
 return new Intl.NumberFormat('en-IN').format(number);
}

// Global default configuration for DataTables
if ($.fn.dataTable) {
    var dt_length = (typeof global_page_length !== 'undefined') ? global_page_length : 50;
    $.extend(true, $.fn.dataTable.defaults, {
        "pageLength": dt_length
    });
}