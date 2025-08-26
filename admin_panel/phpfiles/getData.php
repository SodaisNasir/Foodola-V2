

<?php 

$addonid = $_GET['addon_id'];
$typeid = $_GET['type_id'];
$dressingid = $_GET['dressing_id'];
include_once('../assets/connection.php');
  $addonz = "SELECT `as_id`, `ao_id`,`ao_title`, `as_name`, `as_price` FROM `addon_sublist` WHERE `ao_id` = $addonid ";
  $resultz = mysqli_query($con,$addonz);
  $no_of_itemsz = mysqli_num_rows($resultz);
  if($no_of_itemsz > 0){
      ?><h6 style="margin-left:25px" class="cardtitle">Addons:</h6> <?php } ?>
       <div class="scroll"> 
       <?php
       $index = 0;
  foreach($resultz as $rowx){
  ?>
        <div class="row ml-2">
            <label for="checkid"  style="word-wrap:break-word;font-size:11px;">
            <!--<input name="checkid"  type="checkbox" value="test" />-->
            <label style="width:210px;"><?php echo $rowx['as_name'] ?></label> <label style="margin-right:50px"> €<?php echo $rowx['as_price'] ?></label>
             <?php echo '<button type="button" onclick="minusAddons(\''. $index .'\' ,\''. $rowx['as_id'] .'\' , \''. $rowx['as_name'] .'\' , \''. $rowx['as_price'] .'\')"  >-</button>'; ?>
            <input disabled name="qty_addons" type="text" value=0 style="width:30px;padding-left:6px">
             <?php echo '<button type="button" onclick="addAddons(\''. $index .'\' ,\''. $rowx['as_id'] .'\' , \''. $rowx['as_name'] .'\' , \''. $rowx['as_price'] .'\')"  >+</button>'; ?>
            </label>
        </div>
<?php $index++; } ?>  
  </div>    
  
   <div  class="row ml-2"  style ="width : 50% !important;">
           
            <?php 
            
            $sql = "SELECT `ts_id`, `type_title`, `type_title_user`, `ts_name` FROM `types_sublist` WHERE `type_id` = $typeid";
            $execute = mysqli_query($con,$sql);
            $no_of_itemst = mysqli_num_rows($execute);
            if($no_of_itemst > 0){
                ?><h6 style="margin-left:5px;margin-top:15px" class="cardtitle">Types :</h6> <select id="type_box" class="form-control" > <?php } ?>  
            
            <?php 
            while($rowtype = mysqli_fetch_array($execute)){
               echo "<option value='{$rowtype['ts_id']}'>{$rowtype['ts_name']}</option>"; 
            }
            ?>  
           </select>
        </div>


    <!--For Dressing List-->
<?php 
 
  $dressingd = "SELECT `ds_id`, `dressing_title`, `dressing_title_user`, `dressing_name` FROM `dressing_sublist` WHERE `dressing_id` = $dressingid";
  $resultd = mysqli_query($con,$dressingd);
  $no_of_itemsd = mysqli_num_rows($resultd);
  $dressingtittle = mysqli_fetch_array($resultd);
  if($no_of_itemsd > 0){
      ?><h6 style="margin-left:25px;margin-top:15px" class="cardtitle"><?php echo $dressingtittle['dressing_title_user'] ?> Dressing :</h6> <?php } ?>
       <div class="scroll"> 
       <?php
foreach($resultd as $rowd){
  ?>
        <div class="row ml-2">
            <label for="checkid"  style="word-wrap:break-word;font-size:11px;">
            <!--<input name="checkid"  type="checkbox" value="test" />-->
            <?php echo "<input type='checkbox' name='dressing_box{$dressingid}' value='{$rowd['ds_id']},{$rowd['dressing_name']}' />"; ?>
            <?php echo $rowd['dressing_name'] ?> 
            </label>
        </div>
<?php } ?>  
</div>    