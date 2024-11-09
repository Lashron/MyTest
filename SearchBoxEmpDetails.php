<?php 
// @ob_start();
$dbConn = mysqli_connect('localhost','root','','jemimah');
// $pageid		=	$_POST[pageid];
// if($pageid == 'AAAAAA'){
// echo($_SESSION["sid"]);
$SearchTxt = $_POST["SearchTxt"];
$CurrentStaff = $_POST["CurrentStaff"];                                                                                                                                                                                                         
if ($SearchTxt == ""){
    $SearchQuery = "SELECT * FROM estimate_master WHERE active = 1 AND to_staffid=$CurrentStaff";
    // $SearchQuery = "SELECT * FROM group_datasheet where active = 1 ORDER BY par_id asc";
}else{
    $SearchQuery = "SELECT * FROM estimate_master WHERE active = 1 AND to_staffid=$CurrentStaff AND estimate_name LIKE '%{$SearchTxt}%' OR assigned_to LIKE '%{$SearchTxt}%'";// ORDER BY type asc, group_id asc");
}    
    $SearchSql = mysqli_query($dbConn,$SearchQuery);
    if ($SearchSql == TRUE){
        if (mysqli_num_rows($SearchSql) >0){
            while ($Row = mysqli_fetch_assoc($SearchSql)){
                $EstName = $Row['estimate_name'];
                $AssignTo = $Row['assigned_to'];
                $ID = $Row['id'];
                $AssignToModifiedStr = $AssignTo;
                $EstNameModifiedStr = $EstName;
            if($SearchTxt != ""){
                $PositionInGrpDsc = stripos($EstName, $SearchTxt); 
                $PositionInAssignTo = stripos($AssignTo, $SearchTxt);
                $EstName_ExactStr = substr($EstName, $PositionInGrpDsc, strlen($SearchTxt));
                $AssignTo_ExactStr = substr($AssignTo, $PositionInAssignTo, strlen($SearchTxt));
                $NewText1 = "<b>$SearchTxt</b>";

                if ($PositionInAssignTo !== false) {
                    $AssignToModifiedStr = substr_replace($AssignTo, "<b><span style='color: red;'><u>$AssignTo_ExactStr</u></span></b>", $PositionInAssignTo, strlen($SearchTxt));
                }
                if ($PositionInGrpDsc !== false) {
                    $EstNameModifiedStr = substr_replace($EstName, "<B><span style='color: red;'><u>$EstName_ExactStr</u><span></B>", $PositionInGrpDsc, strlen($SearchTxt));
                }
            }
                echo "<tr class='labeldisplay'>
                        
                        <td>".$EstNameModifiedStr."</td>
                        <td>".$AssignToModifiedStr."</td>";
                        
                if($_SESSION['WcmsStaffRole'] == 7){
                    echo "<td class='tdrow' valign='middle' align='center'><button type='button' title='Edit' class='btn fa-btn-e gEdit' id='EBtn" . $ID . "' data-id='" . $ID . "'><i class='fa fa-edit'></i></button></td>
                        <td><button type='button' id='DBtn" . $ID . "' title='Delete' class='btn fa-btn-d gDel' data-id='" . $ID . "'><i class='fa fa-trash-o'></i></button></td>
                    </tr>";
                }
            }
        }else{
            echo '<tr><td colspan="2">No Records Found</td></tr>';
        }
    }else{
        echo'<tr><td>';
        echo ($SearchQuery);
        echo($_SESSION["sid"]);
        echo'<td><tr>';
        echo '<tr><td colspan="2">No Records Found</td></tr>';
    } 
    echo '</table>';
// }
?>