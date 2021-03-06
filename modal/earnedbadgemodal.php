<?php

// $connect = new PDO("mysql:host=localhost; dbname=scout;", "root", "");
$connect = new PDO("mysql:host=us-cdbr-east-03.cleardb.com; dbname=heroku_d1dabaaefc9d538;", "b9cd122ae5026e", "287b0048");

// $query = "SELECT * FROM sections ORDER BY SectionID ASC";
// $statement = $connect->prepare($query);
// $statement->execute();
// $result = $statement->fetchALL();

// function fill_select_box($connect)
// {
//     $output = '';
//     $query = "SELECT * FROM category ORDER BY CategoryName ASC";
//     $statement = $connect->prepare($query);
//     $statement->execute();
//     $result = $statement->fetchAll();
//     foreach ($result as $row) {
//         $output .= '<option value="'.$row["CategoryID"].'">'.$row["CategoryName"].'</option>';
//     }
//     return $output;
// }
?>

<script>
function getMember(val)
{
    $.ajax({
        type: "POST",
        url: "get_Member.php",
        data: 'SectionID=' + val,
        success: function(data){
            $("#members").html(data);
        }
    });
}
function getDetail(val)
{
    $.ajax({
        type: "POST",
        url: "get_Detail.php",
        data: 'MemberID=' + val,
        success: function(data){
            $("#details").html(data);
        }
    });
}
function getBadge(val)
{
    $.ajax({
        type: "POST",
        url: "get_badge.php",
        data: 'CategoryID=' + val,
        success: function(data){
            $("#badges").html(data);
        }
    });
}
function getLevel(val)
{
    $.ajax({
        type: "POST",
        url: "get_level.php",
        data: 'CategoryID=' + val,
        success: function(data){
            $("#levels").html(data);
        }
    });
}

$(document).ready(function() {
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#DateMe").attr("value", today);
});
</script>

<style>
    input {
  border-top-style: hidden;
  border-right-style: hidden;
  border-left-style: hidden;
  border-bottom-style: none;
  background-color: white;
}

.no-outline:focus {
  outline: none;
}

.disabled:hover {
    cursor:not-allowed;
 }

 .btn[disabled] {
  pointer-events: none;
}
</style>

<div id="EarnedBadgeModal" class="modal fade"> 
 <?php
 include('style/modal.php');
 ?>
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header" onLoad="getDetail(this.value);">                        
                     <h3 class="modal-title">Earned Badge for<input class="no-outline" id="MemberName"></input>
                     </h3>  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>  
                <div class="modal-body">  
                     <form method="post" id="earned_badge_form">      
                          <select name='MemberID' id='Member' class="form-control input-value" hidden>
                            <option value="">Member Name</option>
                              <?php
                              $query = "SELECT * FROM members ORDER BY MemberID ASC";
                              $statement = $connect->prepare($query);
                              $statement->execute();
                              $result = $statement->fetchALL();
                                foreach ($result as $row) {
                                    echo '<option value="'.$row["MemberID"].'">'.$row["MemberName"].'</option>';
                                }
                              ?>        
                          </select> 
                          <!-- <input type="text" name="MemberID" id="Member" class="form-control validate" >  -->
                       
                          
                         
                          <select name='SectionID' id='Section' class="form-control input-value" hidden>
                            <option value="">Select Section</option>
                              <?php
                              $query = "SELECT * FROM sections ORDER BY SectionID ASC";
                              $statement = $connect->prepare($query);
                              $statement->execute();
                              $result = $statement->fetchALL();
                                foreach ($result as $row) {
                                    echo '<option value="'.$row["SectionID"].'">'.$row["SectionName"].'</option>';
                                }
                              ?>        
                            </select>  
                          <!-- <input type="text" name="SectionID" id="Section" value="SectionID" class="form-control validate" >  -->
                         
                          
                          <!-- <input type="hidden" name="ColorID" id="Color" value="Colors" class="form-control validate" >  -->
                          <select name='ColorID' id='Color' class="form-control input-value" hidden>
                            <option value="">Select Section</option>
                              <?php
                              $query = "SELECT * FROM colors ORDER BY ColorID ASC";
                              $statement = $connect->prepare($query);
                              $statement->execute();
                              $result = $statement->fetchALL();
                                foreach ($result as $row) {
                                    echo '<option value="'.$row["ColorID"].'">'.$row["Color"].'</option>';
                                }
                              ?>        
                            </select>
                            <br />
                          <select name='CategoryID' class="form-control mb-2" id="category" onChange="getBadge(this.value); getLevel(this.value);" required>
                            <option value="">Select Category</option>
                                <?php
                                $query = "SELECT * FROM category ";
                                $result = mysqli_query($con, $query);
                                while ($row=mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value = "<?php echo $row["CategoryID"]; ?>"> <?php echo $row["CategoryName"]; ?> </option>
                                <?php
                                }
                                ?>                   
                            </select> 
                            <br />
                          <select name='BadgeID' class="form-control mb-2" id="badges" required>
                          <option value = "">Select Badge</option> 
                          <option value = "<?php echo $row["BadgeID"]; ?>"> <?php echo $row["BadgeName"]; ?> </option>              
                            </select> 
                            <br />
                           
                          <select name='LevelID' class="form-control mb-2" id="levels" required> 
                          <option value = "">Select Level</option> 
                          <option value = "<?php echo $row["LevelID"]; ?>"> <?php echo $row["Levels"]; ?> </option> 
                           
                            </select>
                            <label>Date Registered</label>  
                            <!-- <input type="date" name="Date" id="DateMe" class="form-control date" />   -->
                            <input type='date' id="DateMe" name="DateReceived" placeholder="YYYY-MM-DD" class="form-control date"> 
                            </br> 
                             
                          <select name='AdminID' class="form-control mb-2" id="admin" required>
                          <option value="">Tested By</option>
                                <?php
                                $query = "SELECT * FROM admin ";
                                $result = mysqli_query($con, $query);
                                while ($row=mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value = "<?php echo $row["AdminID"]; ?>"> <?php echo $row["FName"]; ?> </option>
                                <?php
                                }
                                ?>                   
                            </select><br /> 
                          <input type="hidden" name="user" id="user" />  
                          <input type="hidden" name="operations" id="operations" />
                          <input type="submit" name="actions" id="actions" class="btn btn-success" value="Earned_Badge" />
                     </form>  
                </div>  
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                <!-- <input type="hidden" name="operation" id="operation" />
                <input type="submit" name="action" id="action" class="btn btn-success" value="AddBadge" /> -->
            </div>  
           </div>  
      </div>  
 </div>  
<!-- 
<script type="text/javascript" language="javascript" >
// script for disabling button if validation on input field is false
$(function() {
    // $("#actions").css("visibility", "hidden");
    $('#actions').attr('disabled', 'disabled');

    $("#earned_badge_form select").bind("change", function() { 
        if ($("#category").val().length > 0 && $("#badges").val().length > 0 && $("#levels").val().length > 0 && $("#admin").val().length > 0) {
          //  $("#actions").css("visibility", "visible");
          $('#actions').removeAttr('disabled');
        } else {
          //  $("#actions").css("visibility", "hidden");
           $('#actions').attr('disabled', 'disabled');
        }
    });
});

</script> -->

<script src="jquery.js"></script>
<script src="parsley.min.js"></script>

<script>

    $(document).ready(function() {
        $("#earned_badge_form").parsley();
    });

</script>
