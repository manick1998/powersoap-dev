var global_exist_image = "assets/Add_employee/Add_employee_icon.svg";
function file_upload(file_id,view_id,exist_image){
    var fileUpload = document.getElementById(file_id+"_upload");
    var files = !!fileUpload.files ? fileUpload.files : [];
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
    if (regex.test(files[0].type)) {
        if (typeof (fileUpload.files) != "undefined") {
            var reader = new FileReader();
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
//                    if(this.width==200 && this.height==200){
                        $('#'+view_id).attr('src', e.target.result);
                        $('#'+file_id+'_valid').val("true");
//                    }else{
//                        $('#'+view_id).attr('src', exist_image);
//                        $('#'+file_id+'_valid').val("false");
//                        swal("", "Upload square photo or photo size 200*200.", "error");
//                    }
                };
            } 
        }
    }    
}

function file_upload_retailer(file_id,view_id,exist_image){
    var fileUpload = document.getElementById(file_id+"_upload");
    var files = !!fileUpload.files ? fileUpload.files : [];
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
    if (regex.test(files[0].type)) {
        if (typeof (fileUpload.files) != "undefined") {
            var reader = new FileReader();
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
//                    if(this.width==200 && this.height==200){
                        $('#'+view_id).attr('src', e.target.result);
                        $('#'+view_id).css('display', "block");
                        $('#'+file_id+'_valid').val("true");
//                    }else{
//                        $('#'+view_id).attr('src', exist_image);
//                        $('#'+view_id).css('display', "none");
//                        $('#'+file_id+'_valid').val("false");
//                        swal("", "Upload square photo or photo size 200*200.", "error");
//                    }
                };
            } 
        }
    }    
}
//upload support
function file_upload_support(file_id,view_id,exist_image){
    var fileUpload = document.getElementById(file_id+"_upload");
    var files = !!fileUpload.files ? fileUpload.files : [];
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
    if (regex.test(files[0].type)) {
        if (typeof (fileUpload.files) != "undefined") {
            var reader = new FileReader();
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
//                    if(this.width==200 && this.height==200){
                        $('#'+view_id).attr('src', e.target.result);
                        $('#'+view_id).css('display', "block");
                        $('#'+file_id+'_valid').val("true");
//                    }else{
//                        $('#'+view_id).attr('src', exist_image);
//                        $('#'+view_id).css('display', "none");
//                        $('#'+file_id+'_valid').val("false");
//                        swal("", "Upload square photo or photo size 200*200.", "error");
//                    }
                };
            } 
        }
    }    
}

function file_upload_sales(file_id,view_id,exist_image){
    var fileUpload = document.getElementById(file_id+"_upload");
    var files = !!fileUpload.files ? fileUpload.files : [];
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
    if (regex.test(files[0].type)) {
        if (typeof (fileUpload.files) != "undefined") {
            var reader = new FileReader();
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
//                    if(this.width==200 && this.height==200){
                        $('#'+view_id).attr('src', e.target.result);
                        $('#'+view_id).css('display', "block");
                        $('#'+file_id+'_valid').val("true");
//                    }else{
//                        $('#'+view_id).attr('src', exist_image);
//                        $('#'+view_id).css('display', "none");
//                        $('#'+file_id+'_valid').val("false");
//                        swal("", "Upload square photo or photo size 200*200.", "error");
//                    }
                };
            } 
        }
    }    
}

function file_upload_csv(file_id,view_id,replace_src){
    var fileUpload = document.getElementById(file_id+"_upload");
    var files = !!fileUpload.files ? fileUpload.files : [];
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.csv|.CSV)$");
    if (regex.test(files[0].type)) {
        if (typeof (fileUpload.files) != "undefined") {
            var reader = new FileReader();
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                $('#'+view_id).attr('src', replace_src);
                $('#'+file_id+'_valid').val("true");
                $("#"+file_id+'_name').html(files[0].name)
            } 
        }
    }    
}

//function s3_file_upload_employeeEdit(file,key){
//    var seconds  = parseInt(new Date().getTime()/1000);
//    var string   = makeid(8);
//    var filetype = (file.type).split("/");
//    var filename = "IMG_"+string+"_"+seconds+"."+filetype[1];
//    var objKey   =  'userImage/'+filename;
//    var params   = {
//        Key: objKey,
//        ContentType: file.type,
//        Body: file,
////        ACL: 'public-read'
//    };
//    bucket.putObject(params, function(err, data) {
//        if (err) {
//            alert('ERROR: ' + err);
//        } else {
//            var url = global_s3_cloud_front_url+filename;
//            $("#"+edit_image_id[key]+"_valid").val(url);
//            key++;
//            editEmployee_image_upload_loop(key);
//        }
//    });
//}

function s3_file_update(file,key){
    var seconds  = parseInt(new Date().getTime()/1000);
    var string   = makeid(8);
    var filetype = (file.type).split("/");
    var filename = "IMG_"+string+"_"+seconds+"."+filetype[1];
    var objKey   =  'userImage/'+filename;
    var params   = {
        Key: objKey,
        ContentType: file.type,
        Body: file,
//        ACL: 'public-read'
    };
    bucket.putObject(params, function(err, data) {
        if (err) {
            alert('ERROR: ' + err);
        } else {
            var url = global_s3_cloud_front_url+filename;
            $("#"+edit_image_id[key]+"_valid").val(url);
            key++;
            edit_image_upload_loop(key);
        }
    });
}


var global_s3_cloud_front_url = "https://d8yt9z8a0r4xc.cloudfront.net/userImage/";
// For S3 bucket
AWS.config.region = 'ap-south-1'; // 1. Enter your region
AWS.config.credentials = new AWS.CognitoIdentityCredentials({
    IdentityPoolId: 'ap-south-1:ebb1348b-859f-46dc-9f8a-8d6a91a79053' // 2. Enter your identity pool
});
AWS.config.credentials.get(function(err) {
    if (err) alert(err);
});
var bucket = new AWS.S3({
    params: { Bucket: 'powersoapapp' }
});
function s3_file_upload(file,key){
    var seconds  = parseInt(new Date().getTime()/1000);
    var string   = makeid(8);
    var filetype = (file.type).split("/");
    var filename = "IMG_"+string+"_"+seconds+"."+filetype[1];
    var objKey   =  'userImage/'+filename;
  
    var params   = {
        Key: objKey,
        ContentType: file.type,
        Body: file,
//        ACL: 'public-read'
    };
    bucket.putObject(params, function(err, data) {
        if (err) {
            alert('ERROR: ' + err);
        } else {
            var url = global_s3_cloud_front_url+filename;
            $("#"+image_id[key]+"_valid").val(url);
            key++;
            image_upload_loop(key);
        }
    });
}

function makeid(length) {
    var result           = '';
    var characters       = '0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}