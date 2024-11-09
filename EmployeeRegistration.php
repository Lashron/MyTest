<?php  
$dbConn = mysqli_connect('localhost','root','','test_06092024');

// print_r($_POST);
if (isset($_POST["btn_save"])){
    $WorkPlace  = $_POST["radio_workplace"];
    $EmpNo      = $_POST["txt_empno"];
    $Salutation = $_POST["cmb_empsalutation"];
    $EmpName    = $_POST["txt_empname"];
    $Gender     = $_POST["radio_gender"];
    $FatherName = $_POST["txt_fathername"];
    $Address    = $_POST["txtarea_address"];
    $MobileNo   = $_POST["txt_mobileno"];
    $Email      = $_POST["txt_email"];
    $Education = implode(", ", $_POST['chk_education']);
    $SaveEmpDtlsQuery = "INSERT INTO employee (work_place,emp_no,salutation,emp_name,gender,father_name,address,mobile_no,email_id,education) VALUES ('$WorkPlace',$EmpNo,'$Salutation','$EmpName','$Gender','$FatherName','$Address','$MobileNo','$Email','$Education')";
    $SaveEmpDtlsSql = mysqli_query($dbConn,$SaveEmpDtlsQuery);
    if ($SaveEmpDtlsSql == true){
        $SelectMaxQry = "SELECT Max(emp_id) as max FROM employee";
        $SelectMaxSql = mysqli_query($dbConn,$SelectMaxQry);
        $RowMax = mysqli_fetch_assoc($SelectMaxSql);
        $LatestEmpId = $RowMax["max"];

        $CourseNameArr  = $_POST["hid_course"];
        $InstitutionArr = $_POST["hid_institution"];
        $YrsOfPassArr   = $_POST["hid_yrofpassing"];
        $GradeArr       = $_POST["hid_grade"];
        $CompNameArr    = $_POST["hid_compname"];
        $RolePlayedArr  = $_POST["hid_roleplayed"];
        $YrsOfExpArr    = $_POST["hid_yrofexp"];
        $SkillSetArr    = $_POST["hid_skillset"];
        
        if(count($CourseNameArr)>0){
            foreach($CourseNameArr as $Key => $Value){
                $CourseName  = $CourseNameArr[$Key];
                $Institution = $InstitutionArr[$Key];
                $YrsOfPass   = $YrsOfPassArr[$Key];
                $Grade       = $GradeArr[$Key];
                $SaveEmpEducationDtlsQuery = "INSERT INTO education_qual (emp_id,course_name,institute_name,year_passed,grade) VALUES ($LatestEmpId,'$CourseName','$Institution','$YrsOfPass','$Grade')";
                $SaveEmpEducationDtlsSql = mysqli_query($dbConn,$SaveEmpEducationDtlsQuery);
            }
        }
        if(count($CompNameArr)>0){
            foreach($CompNameArr as $Key => $Value){
                $CompName     	= $CompNameArr[$Key];
                $RolePlayed     = $RolePlayedArr[$Key];
                $YrsOfExp    	= $YrsOfExpArr[$Key];
                $SkillSet       = $SkillSetArr[$Key];
                $SaveEmpCarrierDtlsQuery = "INSERT INTO carrier_exp (emp_id,company_name,role_played,year_exp,skill_set) VALUES ($LatestEmpId,'$CompName','$RolePlayed','$YrsOfExp','$SkillSet')";
                $SaveEmpCarrierDtlsSql = mysqli_query($dbConn,$SaveEmpCarrierDtlsQuery);
            }
        }
        if (($SaveEmpDtlsSql == true) && ($SaveEmpEducationDtlsSql == true) && ($SaveEmpCarrierDtlsSql == true)){
            $msg = "Employee Details Saved Successfully..!!";
        }else{
            $msg = "Error : Employee Details Not Saved";
        }
    } else {
        $msg = "Error : Employee Details Not Saved";
    }
}
if (isset($_POST["btn_update"])){
    // GetPostedValues();
    $EmpId = $_POST["hid_empid"];
    $WorkPlace  = $_POST["radio_workplace"];
    $EmpNo      = $_POST["txt_empno"];
    $Salutation = $_POST["cmb_empsalutation"];
    $EmpName    = $_POST["txt_empname"];
    $Gender     = $_POST["radio_gender"];
    $FatherName = $_POST["txt_fathername"];
    $Address    = $_POST["txtarea_address"];
    $MobileNo   = $_POST["txt_mobileno"];
    $Email      = $_POST["txt_email"];
    $Education = implode(", ", $_POST['chk_education']);
    $UpdateEmpDtlsQuery = "UPDATE employee SET work_place='$WorkPlace',emp_no=$EmpNo,salutation='$Salutation',emp_name='$EmpName',gender='$Gender',father_name='$FatherName',address='$Address',mobile_no='$MobileNo',email_id='$Email',education='$Education' WHERE emp_id='$EmpId'";
    $UpdateEmpDtlsSql = mysqli_query($dbConn,$UpdateEmpDtlsQuery);

    if ($UpdateEmpDtlsSql == true){
        // DELETE FROM Customers WHERE Country='Germany';
        $DeleteEmpQlyQuery = "DELETE FROM education_qual SET active=0 WHERE emp_id=$EmpId";
        $DeleteEmpQlyQuery = "UPDATE education_qual SET active=0 WHERE emp_id=$EmpId";
        $DeleteEmpQlySql = mysqli_query($dbConn,$DeleteEmpQlyQuery);
        $DeleteEmpCarrQuery = "UPDATE carrier_exp SET active=0 WHERE emp_id=$EmpId";
        $DeleteEmpCarrQuery = "UPDATE carrier_exp SET active=0 WHERE emp_id=$EmpId";
        $DeleteEmpCarrSql = mysqli_query($dbConn,$DeleteEmpCarrQuery);
        
        $CourseNameArr  = $_POST["hid_course"];
        $InstitutionArr = $_POST["hid_institution"];
        $YrsOfPassArr   = $_POST["hid_yrofpassing"];
        $GradeArr       = $_POST["hid_grade"];
        $CompNameArr    = $_POST["hid_compname"];
        $RolePlayedArr  = $_POST["hid_roleplayed"];
        $YrsOfExpArr    = $_POST["hid_yrofexp"];
        $SkillSetArr    = $_POST["hid_skillset"];
        
        if(count($CourseNameArr)>0){
            foreach($CourseNameArr as $Key => $Value){
                $CourseName  = $CourseNameArr[$Key];
                $Institution = $InstitutionArr[$Key];
                $YrsOfPass   = $YrsOfPassArr[$Key];
                $Grade       = $GradeArr[$Key];
                $SaveEmpEducationDtlsQuery = "INSERT INTO education_qual (emp_id,course_name,institute_name,year_passed,grade) VALUES ($EmpId,'$CourseName','$Institution','$YrsOfPass','$Grade')";
                $SaveEmpEducationDtlsSql = mysqli_query($dbConn,$SaveEmpEducationDtlsQuery);
            }
        }
        if(count($CompNameArr)>0){
            foreach($CompNameArr as $Key => $Value){
                $CompName     	= $CompNameArr[$Key];
                $RolePlayed     = $RolePlayedArr[$Key];
                $YrsOfExp    	= $YrsOfExpArr[$Key];
                $SkillSet       = $SkillSetArr[$Key];
                $SaveEmpCarrierDtlsQuery = "INSERT INTO carrier_exp (emp_id,company_name,role_played,year_exp,skill_set) VALUES ($EmpId,'$CompName','$RolePlayed','$YrsOfExp','$SkillSet')";
                $SaveEmpCarrierDtlsSql = mysqli_query($dbConn,$SaveEmpCarrierDtlsQuery);
            }
        }
        if (($UpdateEmpDtlsSql == true) && ($SaveEmpEducationDtlsSql == true) && ($SaveEmpCarrierDtlsSql == true)){
            $msg = "Employee Details Updated Successfully..!!";
        }else{
            $msg = "Error : Employee Details Not Updated";
        }
    }
}
if(isset($_GET["delete"])){   
    $EmpId = $_GET["empid"];
    $DeleteEmpQuery = "UPDATE employee SET active=0 WHERE emp_id=$EmpId";
    $DeleteEmpSql = mysqli_query($dbConn,$DeleteEmpQuery);
    if ($DeleteEmpSql == true){
        $msg = "Employee Details Deleted Successfully";   
    }
}
if(isset($_GET['empid'])){   
    $EmpId = $_GET['empid'];
	$SelectEmpDtlsQuery = "SELECT * FROM employee WHERE emp_id = '$EmpId'";
    $SelectEmpDtlsSql   = mysqli_query($dbConn,$SelectEmpDtlsQuery);
	if(($SelectEmpDtlsSql == true) && (mysqli_num_rows($SelectEmpDtlsSql)>0)){
        $Row = mysqli_fetch_assoc($SelectEmpDtlsSql);
        $WorkPlace = $Row["work_place"];
        $EmpNo   = $Row["emp_no"];
        $Salutation   = $Row["salutation"];
        $EmpName  = $Row["emp_name"];
        $Gender  = $Row["gender"];
        $FatherName = $Row["father_name"];
        $Address  = $Row["address"];
        $MobileNo = $Row["mobile_no"];
        $Email   = $Row["email_id"];
        $Education   = $Row["education"];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form method="POST" action="">
    <table border="1" align="center">
        <tr><td colspan=2>Employee Registration</td></tr>
        <tr>
            <td>Work Place</td>
            <td>
                <input type="hidden" id="hid_empid" name="hid_empid" value="<?php if (isset($_GET['empid'])){ echo $Row["emp_id"];}?>">
                <input type="radio" name="radio_workplace" value="ONS" <?php if (isset($_GET['empid'])){ if ($WorkPlace == 'ONS') {echo ("checked");} }?>> OnShore
                <input type="radio" name="radio_workplace" value="OFFS" <?php if (isset($_GET['empid'])){ if ($WorkPlace == 'OFFS') {echo ("checked");} }?>> OffShore
            </td> 
        </tr>
        <tr><td>Employee No</td><td><input type="text" id="txt_empno" name="txt_empno" value="<?php if (isset($_GET['empid'])){ echo $EmpNo;}?>"></td></tr>
        <tr><td>Salutation</td><td> <select name="cmb_empsalutation" id="cmb_empsalutation">
            <option value="MR"<?php if (isset($_GET['empid'])){ if ($Salutation =='MR') {echo ("selected");} }?>>Mr</option>
            <option value="MISS"<?php if (isset($_GET['empid'])){ if ($Salutation =='MISS') {echo ("selected");} }?>>Miss</option>
            <option value="MRS"<?php if (isset($_GET['empid'])){ if ($Salutation =='MRS') {echo ("selected");} }?>>Mrs</option>
            <option value="DR"<?php if (isset($_GET['empid'])){ if ($Salutation =='DR') {echo ("selected");} }?>>Dr</option>
        </select></td></tr>
        <tr><td>Employee Name</td><td><input type="text" id="txt_empname" name="txt_empname" value="<?php if (isset($_GET['empid'])){ echo $EmpName;}?>"></td></tr>

        <tr><td>Father's Name</td><td><input type="text" id="txt_fathername" name="txt_fathername" value="<?php if (isset($_GET['empid'])){ echo $FatherName;}?>"></td></tr>
        <tr>
            <td>Gender</td>
            <td>
                <input type="radio" name="radio_gender" value="M" <?php if (isset($_GET['empid'])){ if ($Gender == 'M') {echo ("checked");} }?>> Male
                <input type="radio" name="radio_gender" value="F" <?php if (isset($_GET['empid'])){ if ($Gender == 'F') {echo ("checked");} }?>> Female
                <input type="radio" name="radio_gender" value="O" <?php if (isset($_GET['empid'])){ if ($Gender == 'O') {echo ("checked");} }?>> Others
            </td>
        </tr>

        <tr><td>Address</td><td><textarea name="txtarea_address" id="txtarea_address" value=""><?php if (isset($_GET['empid'])){ echo $Address;}?></textarea></td></tr>
        <tr><td>Mobile No</td><td>
            <input type="text" id="txt_mobileno" name="txt_mobileno" value="<?php if (isset($_GET['empid'])){ echo $MobileNo;}?>">
        </td></tr>
        <tr><td>E-Mail</td><td><input type="text" id="txt_email" name="txt_email" value="<?php if (isset($_GET['empid'])){ echo $Email;}?>"></td></tr>
        <tr>
                <td>Education</td>
                <td><input type="checkbox" name="chk_education[]" value="UG" <?php if (isset($_GET['empid'])){ if (strpos($Education, 'UG') !== false) {echo ("checked");} }?>> UG<br>
                    <input type="checkbox" name="chk_education[]" value="PG" <?php if (isset($_GET['empid'])){ if (strpos($Education, 'PG') !== false) {echo ("checked");} }?>> PG<br>
                    <input type="checkbox" name="chk_education[]" value="PHD" <?php if (isset($_GET['empid'])){ if (strpos($Education, 'PHD') !== false) {echo ("checked");} }?>> PhD<br>
                </td>
        </tr>
        <tr><td colspan=2>Educational Qualification</td></tr>
        <tr><td colspan=2>
            <table id="tbl_eduquali" border=1>
                <tr><td>Course Name</td><td>Institution</td><td>Year of Passing</td><td>Grade</td><td>Action</td></tr>
                <tr>
                    <td><input type="text" id="txt_course" name="txt_course"></td>
                    <td><input type="text" id="txt_institution" name="txt_institution"></td>
                    <td><input type="text" id="txt_yrofpassing" name="txt_yrofpassing"></td>
                    <td><input type="text" id="txt_grade" name="txt_grade"></td>
                    <td><input type="button" id="btn_add_eduquali" name="btn_add_eduquali" value="Add"></td>
                </tr>
                    <?php 
                    if (isset($_GET['empid'])){
                        $SelectQualiQuery = "SELECT * FROM education_qual WHERE emp_id=$EmpId AND active=1";
                        $SelectQualiSql = mysqli_query($dbConn,$SelectQualiQuery);
                        if(($SelectQualiSql == true) && (mysqli_num_rows($SelectQualiSql)>0)){
                                while ($Row = mysqli_fetch_assoc($SelectQualiSql)){
                                    $CourseName = $Row["course_name"];
                                    $InstituteName = $Row["institute_name"];
                                    $YrsOfPass = $Row["year_passed"];
                                    $Grade = $Row["grade"];?>
                                    <tr>
                                        <td><input type="hidden" id="hid_course[]" name="hid_course[]" value="<?php echo $CourseName;?>"><?php echo $CourseName?></td>
                                        <td><input type="hidden" id="hid_institution[]" name="hid_institution[]" value="<?php echo $InstituteName;?>"><?php echo $InstituteName?></td>
                                        <td><input type="hidden" id="hid_yrofpassing[]" name="hid_yrofpassing[]" value="<?php echo $YrsOfPass;?>"><?php echo $YrsOfPass?></td>
                                        <td><input type="hidden" id="hid_grade[]" name="hid_grade[]" value="<?php echo $Grade?>"><?php echo $Grade?></td>
                                        <!-- <td><?php echo $Row["emp_id"];?></td> -->
                                        <td><input type="button" id="btn_delete" name="btn_delete" value="Delete"></td>
                                    </tr>
                                <?}
                        }
                    }?>
            </table>
        </td></tr>
        <tr><td colspan=2>Carrier Experience</td></tr>
        <tr><td colspan=2>
            <table id="tbl_carrierexp" border=1>
                <tr><td>Firm/Company Name</td><td>Role Played</td><td>Years of Experience</td><td>Skill Set</td><td>Action</td></tr>
                <tr>
                    <td><input type="text" id="txt_compname" name="txt_compname"></td>
                    <td><input type="text" id="txt_roleplayed" name="txt_roleplayed"></td>
                    <td><input type="text" id="txt_yrofexp" name="txt_yrofexp"></td>
                    <td><input type="text" id="txt_skillset" name="txt_skillset"></td>
                    <td><input type="button" id="btn_add_carrierexp" name="btn_add_carrierexp" value="Add"></td>
                </tr>
                <tr>
                    <?php if (isset($_GET['empid'])){
                        $SelectCarrExpQuery = "SELECT * FROM carrier_exp WHERE emp_id=$EmpId AND active=1";
                        $SelectCarrSql = mysqli_query($dbConn,$SelectCarrExpQuery);
                        if(($SelectCarrSql == true) && (mysqli_num_rows($SelectCarrSql)>0)){
                            while ($Row = mysqli_fetch_assoc($SelectCarrSql)){
                                $CompName = $Row["company_name"];
                                $RolePlayed = $Row["role_played"];
                                $YrsOfExp = $Row["year_exp"];
                                $SkillSet = $Row["skill_set"];?>
                                <tr>
                                    <td><input type="hidden" id="hid_compname[]" name="hid_compname[]" value="<?php echo $CompName;?>"><?php echo $CompName?></td>
                                    <td><input type="hidden" id="hid_roleplayed[]" name="hid_roleplayed[]" value="<?php echo $RolePlayed;?>"><?php echo $RolePlayed?></td>
                                    <td><input type="hidden" id="hid_yrofexp[]" name="hid_yrofexp[]" value="<?php echo $YrsOfExp;?>"><?php echo $YrsOfExp?></td>
                                    <td><input type="hidden" id="hid_skillset[]" name="hid_skillset[]" value="<?php echo $SkillSet?>"><?php echo $SkillSet?></td>
                                    <td><input type="button" id="btn_delete" name="btn_delete" value="Delete"></td>
                                </tr>
                            <?}
                        }
                    }?>
                </tr>
            </table>
        </td></tr>
        <tr>
            <td colspan=2 align="center">
                <?php
                if (isset($_GET['empid'])){?>
                    <input type="button" id="btn_newemp" name="btn_newemp" value="New Employee Registration">
                    <input type="submit" id="btn_update" name="btn_update" value="Update">
                <?php
                }else{?>
                    <input type="submit" id="btn_save" name="btn_save" value="Save">
                <?php
                }?>
                <input type="button" id="btn_view" name="btn_view" value="View">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
<script>
$(document).ready(function() {
    var EduQuali = 0;
    var EmpCarrier = 0;
    var msg = "<?php echo $msg;?>";
    if (msg != ""){
        alert(msg);
        // window.location.replace("EmployeeRegistration.php");
    }
    $('body').on('click','#btn_view',function(){
        window.location.replace("EmpDetailsView.php");
    });
    $('body').on('click','#btn_newemp',function(){
        window.location.replace("EmployeeRegistration.php");
    });
    $('body').on('click','#btn_add_eduquali',function(){
        var CourseName = $("#txt_course").val();
        var Institution = $("#txt_institution").val();
        var YrsOfPass = $("#txt_yrofpassing").val();
        var Grade = $("#txt_grade").val();
        var Rowstr = '<tr><td><input type="hidden" id="hid_course[]" name="hid_course[]" value="'+CourseName+'">'+CourseName+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_institution[]" name="hid_institution[]" value="'+Institution+'">'+Institution+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_yrofpassing[]" name="hid_yrofpassing[]" value="'+YrsOfPass+'">'+YrsOfPass+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_grade[]" name="hid_grade[]" value="'+Grade+'">'+Grade+'</td>';
        Rowstr += '<td><input type="button" id="btn_delete" name="btn_delete" value="Delete"></td></tr>';
        $("#tbl_eduquali").append(Rowstr);
        EduQuali = 1;
        $("#txt_course").val("");
        $("#txt_institution").val("");
        $("#txt_yrofpassing").val("");
        $("#txt_grade").val("");
    });
    $('body').on('click','#btn_add_carrierexp',function(){
        var CompName = $("#txt_compname").val();
        var RolePlayed = $("#txt_roleplayed").val();
        var YrsOfExp = $("#txt_yrofexp").val();
        var SkillSet = $("#txt_skillset").val();
        var Rowstr = '<tr><td><input type="hidden" id="hid_compname[]" name="hid_compname[]" value="'+CompName+'">'+CompName+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_roleplayed[]" name="hid_roleplayed[]" value="'+RolePlayed+'">'+RolePlayed+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_yrofexp[]" name="hid_yrofexp[]" value="'+YrsOfExp+'">'+YrsOfExp+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_skillset[]" name="hid_skillset[]" value="'+SkillSet+'">'+SkillSet+'</td>';
        Rowstr += '<td><input type="button" id="btn_delete" name="btn_delete" value="Delete"></td></tr>';
        $("#tbl_carrierexp").append(Rowstr); 
        EmpCarrier = 1;
        $("#txt_compname").val("");
        $("#txt_roleplayed").val("");
        $("#txt_yrofexp").val("");
        $("#txt_skillset").val("");
    });
    $('body').on('click','#btn_delete',function(){
        $(this).closest("tr").remove();
    });
    $('body').on('click','#btn_save',function(event){

    });
    $('body').on('keyup','#SearchBox',function(){
         var SearchTxt= $("#SearchBox").val();
        $("#DispTable").find("tr:gt(0)").remove();
        $.post("SearchBox.php",{SearchTxt:SearchTxt, CurrentStaff:CurrentStaff},function(data){
            $("#DispTable").append(data);
        });
    });
});
</script>
