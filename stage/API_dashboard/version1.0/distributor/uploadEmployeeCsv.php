<?php
session_start();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee_distributor.php';
$distributor_token = $_SESSION['distributor_token'];
$employee = new Employee($db);
$array = [];
$arrayExistsEmailid = [];
$row = 1;
$obj=new stdClass();
if(is_array($_FILES)) {
    if(is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
        $sourcePath = $_FILES['file_upload']['tmp_name'];
        if (($handle = fopen($sourcePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",",'"')) !== FALSE) {
                $num = count($data);
                for ($c=0; $c < $num; $c++) {
                    if($c==0){
                        if($row>1){
                              $employee->distributor_token = $distributor_token;
                              $employee->mobileNumber = addslashes($data[1]);
                              $employee->emaiId = addslashes($data[4]);
                              $stmt=$employee->employeeEmaiIdCheck();
                              $checkEmailId = $stmt->rowCount();
                              if($checkEmailId == 0){
                                    $token = token_generate("employees","token");
                                    $employee->token = $token;
                                    $employee->name = addslashes($data[0]);
                                    $employee->gender = addslashes($data[2]);
                                    $employee->department_name = addslashes($data[3]);
                                    $employee->department = $employee->employeeDepartmentToken();
                                      if($employee->department == "93402780"){
                                           $employees_code = token_generate("employees","employees_code");
                                           $employee->code = 'DEL'.$employees_code;
                                      }else if($employee->department == "45916684"){
                                           $employees_code = token_generate("employees","employees_code");
                                           $employee->code = 'SAL'.$employees_code;
                                      }
                                    $joinDate = addslashes($data[5]);
                                    $employee->joinDate = date("Y-m-d", strtotime($joinDate));
                                    $dob = addslashes($data[6]);
                                    $employee->dob = date("Y-m-d", strtotime($dob));
                                    $employee->bloodGroup = addslashes($data[7]);
                                    $employee->address = addslashes($data[8]);
                                    $employee->street = addslashes($data[9]);
                                    $employee->city = addslashes($data[10]);
                                    $employee->pincode = addslashes($data[11]);
                                    $employee->image = addslashes($data[12]);
                                    $employee->proof1= addslashes($data[13]);
//                                    $employee->proof2= addslashes($data[14]);
//                                    $employee->proof3= addslashes($data[15]);
//                                    $employee->proof4= addslashes($data[16]);
//                                    $employee->proof5= addslashes($data[17]);
                                    $insert = $employee->addEmployee($indiaDateTime);
                            }else{
                
                                  if($checkEmailId != 0){
                                     array_push($arrayExistsEmailid, $employee->emaiId);
                                  }
                            }  
                                   array_push($array,$employee->mobileNumber);
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
            //If upload all row Email Id Already Exists, this condition gets true
            if(count($array)==count($arrayExistsEmailid)){
                $obj->code    = 503;
                if(count($arrayExistsEmailid)==1){
                    $obj->message2 = implode(", ",$arrayExistsEmailid)." this Email Id already exists. We can't upload this Employee detail.";
                }else{
                    $obj->message2 = implode(", ",$arrayExistsEmailid)." these Email Ids already exists. We can't upload these Employee details.";
                }
            }else{
                if(count($arrayExistsEmailid)==0){
                    $obj->code     = 201;
                    $obj->message = "CSV Data Upload Successfully";
                }else{
                    //Employee Code
                    $obj->code    = 503;
                    if(count($array)!=count($arrayExistsEmailid)){
                        if(count($arrayExistsEmailid)==1){
                            $obj->message2 = implode(", ",$arrayExistsEmailid)." this Email Id already exists. We can't upload this Employee details.";
                        }else if(count($arrayExistsEmailid) > 1){
                            $obj->message2 = implode(", ",$arrayExistsEmailid)." these Email Ids already exists. We can't upload these Employee details.";
                        }
                    }
                    
                }
            }
        }
    }else{
        $obj->code    = 503;
        $obj->message = "Error2";
    }
}else{
    $obj->code    = 503;
    $obj->message = "Error";
}
echo json_encode($obj);
?>