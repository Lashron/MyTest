<?php  
$dbConn = mysqli_connect('localhost','root','','test_06092024');

// if (isset($_POST["btn_qual"])){
//     $SelectEmpDtlsQuery = "SELECT e.*, q.*
//     FROM employee e
//     INNER JOIN education_qual q ON e.emp_id = q.emp_id;";
// }else{
//     $SelectEmpDtlsQuery = "SELECT e.*, c.*
//     FROM employee e
//     INNER JOIN carrier_exp c ON e.emp_id = c.emp_id;";
// }
// echo ($SelectEmpDtlsQuery);
$SelectEmpDtlsQuery = "SELECT e. * , q. * , c. *
FROM employee e
JOIN education_qual q ON e.emp_id = q.emp_id
JOIN carrier_exp c ON e.emp_id = c.emp_id
WHERE q.active =1
AND c.active =1
ORDER BY e.emp_id,q.edcate_qual_id,c.carrier_exp_id ASC";
$SelectEmpDtlsSql = mysqli_query($dbConn,$SelectEmpDtlsQuery);
if (($SelectEmpDtlsSql == true) && (mysqli_num_rows($SelectEmpDtlsSql)>0)){
    while ($Row=mysqli_fetch_assoc($SelectEmpDtlsSql)){
        $EmpDtArr[$Row['emp_id']] = array("EmpId" => $Row['emp_id'], "EmpNo" => $Row['emp_no'], "EmpName" => $Row['emp_name'],  "Quali" => $Row['education']);
        $EmpEduDtArr[$Row['emp_id']][$Row['edcate_qual_id']] = array("Course"=>$Row['course_name'], "InstituteName"=>$Row['institute_name'], "YearPassed"=>$Row['year_passed'], "Grade"=>$Row['grade']);
        $EmpCarrDtArr[$Row['emp_id']][$Row['carrier_exp_id']] = array("Company"=>$Row['company_name'], "RolePlayed"=>$Row['role_played'], "YrOfExp"=>$Row['year_exp'], "SkillSet"=>$Row['skill_set']);
    }
}
// print_r($EmpDtArr);?><br><br><?php
// print_r($EmpEduDtArr);?><br><br><?php
// print_r($EmpCarrDtArr);?><br><br><?php
// echo count($EmpDtArr);?><br><br><?php
// echo count($EmpEduDtArr);?><br><br><?php
// echo count($EmpCarrDtArr);?><br><br><?php


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table {
            display: table;
            border: 2px solid black;
            width: 100%;
            border-collapse: collapse;
        }
        .table1 {
            display: table;
            width: 100%;
            border:none;
            height:100%;
            grid-template-columns: repeat(4, 1fr); /* Create 4 equal columns */
            /* border-collapse: collapse; */

        }
        .row {
            display: table-row;
            /* border: 2px solid #ddd; */

            /* border: 1px solid black; */
        }
        .cell {
            display: table-cell;
            border: 2px solid black;
            /* padding: 8px; */
        }
        .cell1 {
            display: table-cell;
            border: 1px solid #ddd;
            /* border:none; */
            padding: 8px;
            /* width: 25%; */
            /* white-space: nowrap;  */
        }
        .headcell1{

        }
        .header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .table-container {
    overflow-x: auto; /* Allows horizontal overflow */
    width: 100%; /* Ensures the container takes full width */
}
.widthpx{
    width: 700px;
}
.pertg10{
    width: 10%;
}
.pertg20{
    width: 20%;
}
.pertg30{
    width: 30%;
}
.pertg40{
    width: 40%;
}

    </style>
</head>
<body>
    <form method="POST" action="">
    <div class="table-container">
    
    <div class="table">
    <div class="row header">
        <div class="cell">Employee ID</div>
        <div class="cell">Employee Name</div>
        <div class="cell">Qualification</div>
        <div class="cell">
            <div class="table1 widthpx">
                <!-- <div class="row">
                    <div class="cell1">Educational Qualification</div>
                </div> -->
                <div class="row">
                    <div class="cell1 pertg30">Course</div>
                    <div class="cell1 pertg40">Institute</div>
                    <div class="cell1 pertg10">Year Passed</div>
                    <div class="cell1 pertg10">Grade</div>
                </div>
            </div>    
        </div>
        <div class="cell">
            <div class="table1 widthpx">
            <div class="row">
                <div class="cell1 pertg30">Company</div>
                <div class="cell1 pertg30">Role Played</div>
                <div class="cell1 pertg10">Year of Exp</div>
                <div class="cell1 pertg30">Skill Set</div>
            </div>
            </div>
        </div>
        <div class="cell">Edit</div>
        <div class="cell">Delete</div>
       
    </div>

    <?php foreach ($EmpDtArr as $EmpId => $EmpDetails): ?>
        <div class="row">
            <div class="cell"><?php echo $EmpDetails['EmpNo']; ?></div>
            <div class="cell"><?php echo $EmpDetails['EmpName']; ?></div>
            <div class="cell"><?php echo $EmpDetails['Quali']; ?></div>
            <div class="cell" colspan="2">
                <?php if (isset($EmpEduDtArr[$EmpId])): ?>
                    <div class="table1">
                        <?php foreach ($EmpEduDtArr[$EmpId] as $EduDetails): ?>
                            <div class="row">
                                <div class="cell1 pertg30"><?php echo $EduDetails['Course']; ?></div>
                                <div class="cell1 pertg40"><?php echo $EduDetails['InstituteName']; ?></div>
                                <div class="cell1 pertg10"><?php echo $EduDetails['YearPassed']; ?></div>
                                <div class="cell1 pertg10"><?php echo $EduDetails['Grade']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    No educational details available
                <?php endif; ?>
            </div>
            <div class="cell" colspan="2">
            <?php if (isset($EmpCarrDtArr[$EmpId])): ?>
                    <div class="table1">
                        <?php foreach ($EmpCarrDtArr[$EmpId] as $CarrDetails): ?>
                            <div class="row">
                                <div class="cell1 pertg30"><?php echo $CarrDetails['Company']; ?></div>
                                <div class="cell1 pertg30"><?php echo $CarrDetails['RolePlayed']; ?></div>
                                <div class="cell1 pertg10"><?php echo $CarrDetails['YrOfExp']; ?></div>
                                <div class="cell1 pertg30"><?php echo $CarrDetails['SkillSet']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    No educational details available
                <?php endif; ?>
            </div>
            <div class="cell">                        
                <a href="EmployeeRegistration.php?EmpId=<?php echo($EmpDetails['EmpId']);?>" title="<?php echo($EmpDetails['EmpId']);?>">Edit</a>
            </div>
            <div class="cell">
                <a href="EmployeeRegistration.php?EmpId=<?php echo($EmpDetails['EmpId']);?>&delete=DEL" title="<?php echo($EmpDetails['EmpId']);?>">Delete</a>
            </div>
            
        </div>
    <?php endforeach; ?>
</div>
                </div>



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