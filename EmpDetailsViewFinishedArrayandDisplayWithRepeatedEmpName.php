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
        $EmpDtArr[$Row['emp_id']] = array("EmpId" => $Row['emp_id'], "EmpName" => $Row['emp_name'],  "Quali" => $Row['education']);
        $EmpEduDtArr[$Row['emp_id']][$Row['edcate_qual_id']] = array("Course"=>$Row['course_name'], "Grade"=>$Row['grade']);
        $EmpCarrDtArr[$Row['emp_id']][$Row['carrier_exp_id']] = array("Company"=>$Row['company_name'], "RolePlayed"=>$Row['role_played']);
    }
}
print_r($EmpDtArr);?><br><br><?php
print_r($EmpEduDtArr);?><br><br><?php
print_r($EmpCarrDtArr);?><br><br><?php
echo count($EmpDtArr);?><br><br><?php
echo count($EmpEduDtArr);?><br><br><?php
echo count($EmpCarrDtArr);?><br><br><?php


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
            width: 100%;
            border-collapse: collapse;
        }
        .row {
            display: table-row;
        }
        .cell {
            display: table-cell;
            border: 1px solid #ddd;
            padding: 8px;
        }
        .header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
    <?php if (isset($_POST["btn_qual"])){?>
        <input type="submit" id="btn_carrier" name="btn_carrier" value="View Carrier Experience">
    <?php } else{?>
        <input type="submit" id="btn_qual" name="btn_qual" value="View Academic Details">
    <?php } ?>

   <?php // Loop through the two-dimensional array and display the values
foreach ($EmpDtArr as $empId => $empDetails) {
    echo "<p>Employee ID: " . $empDetails['EmpId'] . "</p>";
    echo "<p>Employee Name: " . $empDetails['EmpName'] . "</p>";
    echo "<p>Qualification: " . $empDetails['Quali'] . "</p>";

    // Check if there are educational details for this employee
    if (isset($EmpEduDtArr[$empId])) {
        echo "<p>Educational Details:</p>";
        echo "<ul>";
        foreach ($EmpEduDtArr[$empId] as $eduDetails) {
            echo "<li>Course: " . $eduDetails['Course'] . ", Grade: " . $eduDetails['Grade'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No educational details available.</p>";
    }

    echo "<hr>";
}



?>

<div class="table">
    <div class="row header">
        <div class="cell">Employee ID</div>
        <div class="cell">Employee Name</div>
        <div class="cell">Qualification</div>
        <div class="cell">Course</div>
        <div class="cell">Grade</div>
    </div>

    <?php foreach ($EmpDtArr as $empId => $empDetails): ?>
        <?php if (isset($EmpEduDtArr[$empId])): ?>
            <?php foreach ($EmpEduDtArr[$empId] as $eduDetails): ?>
                <div class="row">
                    <div class="cell"><?php echo $empDetails['EmpId']; ?></div>
                    <div class="cell"><?php echo $empDetails['EmpName']; ?></div>
                    <div class="cell"><?php echo $empDetails['Quali']; ?></div>
                    <div class="cell"><?php echo $eduDetails['Course']; ?></div>
                    <div class="cell"><?php echo $eduDetails['Grade']; ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row">
                <div class="cell"><?php echo $empDetails['EmpId']; ?></div>
                <div class="cell"><?php echo $empDetails['EmpName']; ?></div>
                <div class="cell"><?php echo $empDetails['Quali']; ?></div>
                <div class="cell" colspan="2">No educational details available</div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>









    <table>
        <tr><td>Emp ID</td><td>Emp Name</td><td>Qualification</td><td></td><td></td><td></td></tr>
        
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