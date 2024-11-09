<?php  
$dbConn = mysqli_connect('localhost','root','','test_06092024');

if (isset($_POST["btn_qual"])){
    $SelectEmpDtlsQuery = "SELECT e.*, q.*
    FROM employee e
    INNER JOIN education_qual q ON e.emp_id = q.emp_id;";
}else{
    $SelectEmpDtlsQuery = "SELECT e.*, c.*
    FROM employee e
    INNER JOIN carrier_exp c ON e.emp_id = c.emp_id;";
}
// echo ($SelectEmpDtlsQuery);

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
    <?php if (isset($_POST["btn_qual"])){?>
        <input type="submit" id="btn_carrier" name="btn_carrier" value="View Carrier Experience">
    <?php } else{?>
        <input type="submit" id="btn_qual" name="btn_qual" value="View Academic Details">
    <?php } ?>
    <table>
        <tr><td></td></tr>
        <tr><td>Emp No</td><td>Emp Name</td><td>Qualification</td>
            <?php if (isset($_POST["btn_qual"])){?>
                <td>Company</td><td>Role</td><td>Year of Exp</td><td>Skill Set</td><td>Edit</td><td>Delete</td></tr>
            <?php }else{?> 
                <td>Company</td><td>Role</td><td>Year of Exp</td><td>Skill Set</td><td>Edit</td><td>Delete</td></tr>
            <?php }?>
        <?php 
        $sql = "SELECT DISTINCT emp_id FROM emp_exp_details";
        $result = mysqli_query($connectVar, $sql);
        
        $SelectEmpDtlsSql = mysqli_query($dbConn,$SelectEmpDtlsQuery);   
        if (($SelectEmpDtlsSql == true) && (mysqli_num_rows($SelectEmpDtlsSql)>0)){
            $TotalRecords = mysqli_num_rows($SelectEmpDtlsSql);   
            $DataExists = 1;
        }
        if ($DataExists == 1){
            while ($Row = mysqli_fetch_assoc($SelectEmpDtlsSql)){?>
                <tr>
                    <td><?php echo $Row["emp_no"];?></td>
                    <td><?php echo $Row["emp_name"];?></td>
                    <td><?php echo $Row["education"];?></td>
                    <?php if (isset($_POST["btn_qual"])){?>
                        <td><?php echo $Row["course_name"];?></td>
                        <td><?php echo $Row["institute_name"];?></td>
                        <td><?php echo $Row["year_passed"];?></td>
                        <td><?php echo $Row["grade"];?></td>
                    <?php
                    }else{?>
                        <td><?php echo $Row["company_name"];?></td>
                        <td><?php echo $Row["role_played"];?></td>
                        <td><?php echo $Row["year_exp"];?></td>
                        <td><?php echo $Row["skill_set"];?></td>
                    <?php }?>
                    <td>
                        <a href="EmployeeRegistration.php?empid=<?php echo($Row["emp_id"]);?>" title="<?php echo($Row["emp_id"]);?>">Edit</a>
                    </td>
                    <td>
                        <a href="EmployeeRegistration.php?empid=<?php echo($Row["emp_id"]);?>&delete=DEL" title="<?php echo($Row["emp_id"]);?>">Delete</a>
                    </td>
                </tr>
            <?php
            }
            // $CompName = $Row["company_name"];
            // $RolePlayed = $Row["roleplayed"];
            // $YrsOfExp = $Row["year_exp"];
            // $SkillSet = $Row["skill_set"];
        }?>
    </table>
    </form>
</body>
</html>
<script>
$(document).ready(function() {
    $('body').on('keyup','#SearchBox',function(){
        var Rowstr = '<tr><td><input type="hidden" id="hid_bidder_id[]" name="hid_bidder_id[]" class="tboxsmclass" value="'+BidderId+'">'+BidderName+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_instype[]" name="hid_instype[]" class="tboxsmclass" value="'+InsType+'">'+InsType+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_insno[]" name="hid_insno[]" class="tboxsmclass" value="'+InsNo+'">'+InsNo+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_bankname[]" name="hid_bankname[]" class="tboxsmclass" value="'+BankName+'">'+BankName+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_branch[]" name="hid_branch[]" class="tboxsmclass" value="'+Branch+'">'+Branch+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_dt_of_issue[]" name="hid_dt_of_issue[]" class="tboxsmclass" value="'+DtOfIssue+'">'+DtOfIssue+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_dt_of_exp[]" name="hid_dt_of_exp[]" class="tboxsmclass" value="'+DtOfExp+'">'+DtOfExp+'</td>';
        Rowstr += '<td><input type="hidden" id="hid_amount[]" name="hid_amount[]" class="tboxsmclass" value="'+Amount+'">'+Amount+'</td>';
        Rowstr += '<td><input type="button" id="btn_delete" name="btn_delete"></td></tr>';
        $("#BGFDRtable").append(Rowstr );
        index++
    });
    
});
       
</script>