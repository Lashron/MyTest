<?php
session_start();
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

?>
<?php 
$dbConn = mysqli_connect('localhost','root','','jemimah');
$dbConn2 = mysqli_connect('localhost','root','','wmbook');
// if ($mysqli->connect_error) {
//     die("Connection failed: " . $mysqli->connect_error);
// }
 if (!$dbConn){
    die('Connection Error: '. mysqli_connect_error());
}else{
// echo 'Connection Success';
}
print_r($_GET);
$CurrStaffId = $_SESSION["sid"];
echo("Current Stf id: ".$CurrStaffId);
$msg = '';
$StaffNameArr = array();
$SelectStaffQuery = "SELECT * FROM staff WHERE active = 1";
$SelectStaffSql = mysqli_query($dbConn2,$SelectStaffQuery);
if(($SelectStaffSql == true) && (mysqli_num_rows($SelectStaffSql) > 0)){ 
    while($Row = mysqli_fetch_object($SelectStaffSql)){
        $StaffNameArr[$Row->staffid] = $Row->staffname;
    }
}
// echo($CurrStaffId);
// echo($_GET["Id"]);
// if(isset($_GET["Id"])){
if ((isset($_POST["hid_mast_id"]))||(isset($_GET["Id"]))){
    // $EstimateName = $_POST["txt_est_name"];
    if (isset($_POST["hid_mast_id"])){
        $MastID = $_POST["hid_mast_id"];
    }else{
        $MastID = $_GET["Id"];
    }
    // $MastID = $_GET["Id"];
    $SelectQuery = "SELECT assigned_to FROM partab_master WHERE mast_id=$MastID";
    $SelectSql = mysqli_query($dbConn,$SelectQuery);
    // echo($SelectQuery);
    if ($SelectSql == true){
        if ($SelectSql > 0){
            // echo("true1");
            $RowAssignedStaff = mysqli_fetch_assoc($SelectSql);
            $AssignedStaffStr = $RowAssignedStaff["assigned_to"];
        }
    }
    // echo ("$AssignedStaffStr");
    $AssignStaffArray = explode(',',$AssignedStaffStr);
    $StaffCount = count($AssignStaffArray);
    // echo $StaffCount;
    for ($i = 0; $i < $StaffCount; $i++) {
        // echo $AssignStaffArray[$i] . "<br>";
        if ($CurrStaffId == $AssignStaffArray[$i]){
            // echo ("I am ".$AssignStaffArray[$i]);
            // $CurrStaffId = $AssignStaffArray[$i];
            $NextStaffId = $AssignStaffArray[$i+1];
            $PrevStaffId = $AssignStaffArray[$i-1];
        }
    }
    $EstCreatingStaffId = $AssignStaffArray[0];
    $ApprovingAuth = $AssignStaffArray[$StaffCount-1];
    // echo ("Approving Authority: ".$AssignStaffArray[$StaffCount-1]);
    echo ("EST Creating staff  :".$EstCreatingStaffId);
    echo ("Current Staff    :".$CurrStaffId);
    // echo ("Previ :".$PrevStaffId);
    // echo ("Approving Authority Name: ".$StaffNameArr[$AssignStaffArray[$StaffCount-1]]);
    // echo ("From  :".$StaffNameArr[$CurrStaffId]);
    // echo ("To    :".$StaffNameArr[$NextStaffId]);
    // echo ("Previ :".$StaffNameArr[$PrevStaffId]);
}

if (isset($_POST["btn_save"])){
    // if (isset($_POST["btn_save"]) == "Save"){
    $EstimateName = $_POST["txt_est_name"];
    $AssignedTostr = '27,12,91,3';
    // $AssignedToArr = explode(',',$AssignedTostr);
    // echo $AssignedToArr[0];
    // $FromStaffId = $AssignedToArr[0];
    // $ToStaffId = $AssignedToArr[1];
    // echo (count($AssignedToArr));

    $SaveESTQuery = "UPDATE partab_master SET estimate_name='$EstimateName' WHERE mast_id=$MastID";
    // $SaveQuery = "INSERT INTO partab_master (estimate_name,assigned_to) VALUES ('$EstimateName','$AssignedTostr')";
    // $SaveQuery = "INSERT INTO partab_master (estimate_name,assigned_to,from_staffid) VALUES ('$EstimateName','$AssignedTostr')";
    // $SaveQuery = "INSERT INTO partab_master (estimate_name,assigned_to,from_staffid,to_staffid,action) VALUES ('$EstimateName','$AssignedTostr',$FromStaffId,$ToStaffId,'FW')";
    $SaveESTSql = mysqli_query($dbConn,$SaveESTQuery);
    if ($SaveESTSql == true){
            $msg = "Estimate Details Saved Successfully..!!";
    }else{
            $msg = "Error : Estimate Details Not Saved";
    }
}
if (isset($_POST["btn_update"])){
    // echo("forwarded");
    // echo ($_POST["txt_est_name"]);
    // echo ($_POST["hid_mast_id"]);
    $EstimateName = $_POST["txt_est_name"];
    $MastID = $_POST["hid_mast_id"];
    $UpdateQuery = "UPDATE partab_master SET estimate_name='$EstimateName' WHERE mast_id=$MastID";
    $Updatesql = mysqli_query($dbConn,$UpdateQuery);
    // echo ($UpdateQuery);
    if ($Updatesql == true){
        $msg = "Estimate Details Updated Successfully..!!";
    }else{
        $msg = "Error : Estimate Details Not Updated";
    }
}
if (isset($_POST["btn_forward"])){
    // echo("Forwarded");
    $EstimateName = $_POST["txt_est_name"];
    // $MastID = $_POST["hid_mast_id"];
    $UpdateQuery = "UPDATE partab_master SET estimate_name='$EstimateName', from_staffid=$CurrStaffId, to_staffid=$NextStaffId, action='FW' WHERE mast_id=$MastID";
    $Updatesql = mysqli_query($dbConn,$UpdateQuery);
    // echo ($UpdateQuery);
    if ($Updatesql == true){
        $SaveQuery = "INSERT INTO estimate_detail (mast_id,estimate_name,from_staffid,to_staffid,action) VALUES ($MastID,'$EstimateName',$CurrStaffId,$NextStaffId,'FW')";
        $SaveSql = mysqli_query($dbConn,$SaveQuery);
        if ($SaveSql == true){
            $msg = "Estimate Forwarded Successfully..!!";
        }else{
            $msg = "Error : Estimate Not Forwarded";
        }
    }
}
if (isset($_POST["btn_backward"])){
    // echo("Backward");
    $EstimateName = $_POST["txt_est_name"];
    // $MastID = $_POST["hid_mast_id"];
    $UpdateQuery = "UPDATE partab_master SET estimate_name='$EstimateName', from_staffid=$CurrStaffId, to_staffid=$PrevStaffId, action='BW' WHERE mast_id=$MastID";
    $Updatesql = mysqli_query($dbConn,$UpdateQuery);
    if ($Updatesql == true){
        $SaveQuery = "INSERT INTO estimate_detail (mast_id,estimate_name,from_staffid,to_staffid,action) VALUES ($MastID,'$EstimateName',$CurrStaffId,$PrevStaffId,'BW')";
        $SaveSql = mysqli_query($dbConn,$SaveQuery);
        if ($SaveSql == true){
            $msg = "Estimate Returned back Successfully..!!";
        }else{
            $msg = "Error : Estimate Not Returned";
        }
    }
}
if (isset($_POST["btn_Approve"])){
    // echo("Approved");
    $EstimateName = $_POST["txt_est_name"];
    // $MastID = $_POST["hid_mast_id"];
    $UpdateQuery = "UPDATE partab_master SET estimate_name='$EstimateName', from_staffid=0, to_staffid=0, action='AP' WHERE mast_id=$MastID";
    $Updatesql = mysqli_query($dbConn,$UpdateQuery);
    if ($Updatesql == true){
        $SaveQuery = "INSERT INTO estimate_detail (mast_id,estimate_name,from_staffid,to_staffid,action) VALUES ($MastID,'$EstimateName',0,0,'AP')";
        $SaveSql = mysqli_query($dbConn,$SaveQuery);
        if ($SaveSql == true){
            $msg = "Estimate Approved Successfully..!!";
        }else{
            $msg = "Error : Estimate Not Approved";
        }
    }
}

if (isset($_GET["Id"])){
    // echo($MastID);
    $MastID = $_GET["Id"];
    // echo($MastID);
    $SelectQuery = "SELECT * FROM partab_master WHERE mast_id=$MastID";
    $SelectSql = mysqli_query($dbConn,$SelectQuery);
    // echo($SelectQuery);
    if ($SelectSql == true){
        if ($SelectSql > 0){
            // echo("true1");
            $RowForEdit = mysqli_fetch_assoc($SelectSql);
        }
    }
}
// $ViewQuery = "SELECT * From partab_master";
$ViewQuery = "SELECT * From partab_master WHERE to_staffid=$CurrStaffId";
echo($ViewQuery);
$ViewSql = mysqli_query($dbConn,$ViewQuery);
if ($ViewSql == true){
    if (mysqli_num_rows($ViewSql)>0){
        $DataExists = 1;
    }
}
?>
<style>
body {
    font-family: Arial, sans-serif;
}
.viewtable{
    border: 1px solid black;
    border-collapse: separate;
    border-spacing: 0px;
    min-width: max-content;
    /* height: 300px; */
}
th{
    position: sticky;
    top: 0px;
    background-color:teal;
    color:white
}
.table-wrapper{
    max-height: 300px;
    max-width: 900px;
    overflow-x: scroll;
    overflow-y: scroll;
    margin:20 px;
}
.viewtable th, .viewtable td{
    border: 1px solid black;
}
.container {
    width: 100%;
}

.row {
    display: flex;
}

.column1 {
    flex: 100%;
    /* flex: 38%; */
    padding: 10px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    height: 50%;
}
.column2 {
    flex: 100%;
    /* flex: 75%; */
    padding: 10px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    height: 50%;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tender Name Entry Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<form method="POST" action="">
    <div class="container">
    <!-- <div class="row" > -->
        <div class="column1" style="background-color:pink">
            <table>
                <tr>
                    <td>
                        <?php 
                        if (isset($_GET['Id'])){
                            $BackBtnStr = "Return to ".$StaffNameArr[$PrevStaffId];
                            $ForwardBtnStr = "Forward to ".$StaffNameArr[$NextStaffId];
                            // echo (($CurrStaffId <> $EstCreatingStaffId));
                            // echo ($CurrStaffId);
                            // echo("*");
                            // echo ($EstCreatingStaffId);
                            if (($_GET['DispBtn'])=='FWBWAP'){
                                if ($CurrStaffId != $EstCreatingStaffId){?>
                                    <input type="submit" name="btn_backward" id="btn_backward" value="<?php echo ($BackBtnStr); ?>"><?php
                                }
                                if ($CurrStaffId == $ApprovingAuth){?>
                                    <input type="submit" name="btn_Approve" id="btn_Approve" value="Approve"><?php
                                }else{?>
                                    <input type="submit" name="btn_forward" id="btn_forward" value="<?php echo ($ForwardBtnStr); ?>"><?php 
                                }
                            }
                        }?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>Estimate Name</td><td><input type="text" id="txt_est_name" name="txt_est_name" value="<?php if (isset($_GET['Id'])) { echo($RowForEdit['estimate_name']);}?>" maxlength = "100"></td></tr>
                    <td><input type="hidden" id="hid_mast_id" name="hid_mast_id" value="<?php if (isset($_GET['Id'])) { echo($RowForEdit['mast_id']);}?>"></td>
                </tr>
            </table>
            <table>
            <tr><th>Item No</th><th>Item Description</th><th>Unit</th><th>Quantity</th><th>Rate</th><th>Action</th></tr>
            <tr>
                <td><input type="text" id="txt_item_no" name="txt_item_no"></td>
                <td><input type="text" id="txt_item_description" name="txt_item_description"></td>
                <td><input type="text" id="txt_Unit" name="txt_Unit"></td>
                <td><input type="text" id="txt_qty" name="txt_qty"></td>
                <td><input type="text" id="txt_rate" name="txt_rate"></td>
                <td><input type="button" id="btn_add" name="btn_add" value="Add"></td>
            </tr>
            <?php 
            $SelectItemDtQuery = "SELECT * FROM Parta_detail WHERE mast_id=$_GET['Id']";
            $SelectItemSql = mysqli_query($dbConn,$SelectItemDtQuery);
            if (($SelectItemSql == true) && (mysqli_num_rows($SelectItemSql)>0)){?>
            <tr><td><input type="hidden" id="hid_item_no[]" name="hid_bidder_id[]" class="tboxsmclass" value="'+BidderId+'">'+BidderName+'</td>';
            <td><input type="hidden" id="hid_item_description[]" name="hid_insno[]" class="tboxsmclass" value="'+InsNo+'">'+InsNo+'</td>';
            <td><input type="hidden" id="hid_unit]" name="hid_instype[]" class="tboxsmclass" value="'+InsType+'">'+InsType+'</td>';
            <td><input type="hidden" id="hid_bankname[]" name="hid_bankname[]" class="tboxsmclass" value="'+BankName+'">'+BankName+'</td>';
            <td><input type="hidden" id="hid_branch[]" name="hid_branch[]" class="tboxsmclass" value="'+Branch+'">'+Branch+'</td>';
            <td><input type="hidden" id="hid_dt_of_issue[]" name="hid_dt_of_issue[]" class="tboxsmclass" value="'+DtOfIssue+'">'+DtOfIssue+'</td>';
            <td><input type="button" id="btn_delete" name="btn_delete"></td></tr>';
                <tr>
                    <td><input type="text" id="txt_item_no" name="txt_item_no"></td>
                    <td><input type="text" id="txt_item_description" name="txt_item_description"></td>
                    <td><input type="text" id="txt_Unit" name="txt_Unit"></td>
                    <td><input type="text" id="txt_qty" name="txt_qty"></td>
                    <td><input type="text" id="txt_rate" name="txt_rate"></td>
                    <td><input type="button" id="btn_add" name="btn_add" value="Add"></td>
                </tr><?php
            }?>
            <tr>
                <?php
                if (isset($_GET['Id'])){
                    // echo("*****".$_GET['DispBtn']) ;
                    // echo("sdfegfgfg".((isset($_GET['DispBtn']))=="SAVEUPDATE"));
                    // echo("aaaaaaaaa".((isset($_GET['DispBtn']))=='FWBWAP'));

                    if ((($_GET['DispBtn']))=="SAVEUPDATE"){
                        if ($CurrStaffId != $EstCreatingStaffId){?>
                            <td><input type="submit" id="btn_update" name="btn_update" value="Update"></td>
                        <?php } else {?>
                            <td><input type="submit" id="btn_save" name="btn_save" value="Save"></td>
                        <?php }
                    }
                }?>
            </tr>
        </table>
        </div>
        <div class="column2" style="background-color:white,height:300px" > 
			<div><label>Search</label><input type="text" id="SearchBox" name="SearchBox"></div>
            <div class=" table-wrapper">
            <table class="viewtable" id="DispTable" name="DispTable" width="100%">
            <!-- <tr class="nomove"><th>Estimate Name</th><th></th></tr> -->
            <tr class="nomove"><th>Estimate Name</th><th>Assigned To</th><th colspan="2">Action</th></tr>
                <?php 
                if ($DataExists == 1){
                    while($Row = mysqli_fetch_assoc($ViewSql)){
                        $EditMastId = $Row["mast_id"];
                        $AssignedStaffStr = $Row["assigned_to"];
                        $AssignStaffArray = explode(',',$AssignedStaffStr);
                        $EstCreatingStaffId = $AssignStaffArray[0];
                        
                        // echo($AssignStaffArray[]);?>
                        <tr>
                            <td><?php echo ($Row["estimate_name"]);?></td>
                            <td><?php echo ($Row["assigned_to"]);?></td>
                            <?php ?>
                            <td><?php 
                            echo($AssignedStaffStr);
                            echo($AssignStaffArray[0]);
                            echo (($CurrStaffId <> $EstCreatingStaffId));
                            echo ($CurrStaffId);
                            echo("*");
                            echo ($EstCreatingStaffId);
                            ?>
                                <?php  if ($CurrStaffId != $EstCreatingStaffId){?>
                                    <a href="All_InOne.php?Id=<?php echo($EditMastId);?>&DispBtn=SAVEUPDATE" title="<?php echo($EditMastId);?>">Edit</a>
                                <?php }else{?>
                                    <a href="All_InOne.php?Id=<?php echo $EditMastId; ?>" title="<?php echo($EditMastId);?>">Create</a>
                                <?php }?>
                            </td>
                            <td><a href="All_InOne.php?Id=<?php echo($EditMastId);?>&DispBtn=FWBWAP" title="<?php echo($EditMastId);?>">Forward/Backward/Approve</a></td>
                            <td><a href="All_InOne.php?Id=<?php echo($EditMastId);?>" title="<?php echo($EditMastId);?>">Delete</a></td>
                        </tr>
                    <?php }
                }else{?>
                    <tr><td colspan="2">No Records found</td></tr>
                <?php 
                }?>
            </table>
            </div>
        </div>    
    <!-- </div> -->
    </div>
</form>
<!-- <div id="estview" style="background-color:blue">mgfbk</div> -->
</body>
</html>
<script>
$(document).ready(function() {
    // alert("loaded");
    var msg = "<?php echo $msg;?>";
    if (msg != ""){
        alert(msg);
        window.location.replace("All_InOne.php");
        // window.location.href = "https://www.example.com";
        // window.location.href = "All_InOne.php";
    }
    $('body').on('keyup','#btn_add',function(){
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
    $('body').on('click','#btn_delete',function(){
        alert("delete");
        $(this).closest("tr").remove();
    });



    // $("#estview").html("ViewEstimate.php");
    var CurrentStaff ="<?php echo $CurrStaffId;?>";
        alert(CurrentStaff);
    $('body').on('click','#btn_save',function(event){
    });
    $('body').on('keyup','#SearchBox',function(){
        // alert("");
        var SearchTxt= $("#SearchBox").val();
        $("#DispTable").find("tr:gt(0)").remove();
        $.post("SearchBox.php",{SearchTxt:SearchTxt, CurrentStaff:CurrentStaff},function(data){
            // alert("like ajax");
            $("#DispTable").append(data);
            // $("#DispTable").html(data);
        });
    });
});
       
</script>