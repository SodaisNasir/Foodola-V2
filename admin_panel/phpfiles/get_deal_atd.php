

<?php 

$addonid = $_GET['addon_id'];
$typeid = $_GET['type_id'];
$dressingid = $_GET['dressing_id'];
$dealid = $_GET['deal_id'];
$index_range = $_GET['index_range'];
$num_free_items = 0;

include_once('../assets/connection.php');

if($addonid != null && $addonid != -1){
?>
<div>
<?php 

$sql = "SELECT `ao_id`, `ao_title` FROM `addon_list` WHERE `ao_id` = '$addonid'";
$exec = mysqli_query($con,$sql);
$addt = mysqli_fetch_array($exec);

$sql_free = "SELECT `di_id`, `deal_id`, `di_title`, `di_num_free_items`, `deal_subdata` FROM `deal_items` WHERE `deal_id` = '$dealid'";
$exec_sql_free = mysqli_query($con,$sql_free);
$nfit = mysqli_fetch_array($exec_sql_free);
$num_free_items = $nfit['di_num_free_items'] != null ? $nfit['di_num_free_items'] : 0;


$addonz = "SELECT `as_id`, `ao_id`,`ao_title`, `as_name`, `as_price` FROM `addon_sublist` WHERE `ao_id` = $addonid ";
$resultz = mysqli_query($con,$addonz);
?>    
<h6 style="margin-left:5px" class="cardtitle">Add-On : <?php echo $addt['ao_title'] ?></h6>
<div style="height : 150px" class="scroll"> 

       <?php
       $index = 0;
  foreach($resultz as $rowx){
  ?>
        <div class="row ml-2">
            <label for="checkid"  style="word-wrap:break-word;font-size:11px;">
            <!--<input name="checkid"  type="checkbox" value="test" />-->
            <label style="width:210px;"><?php echo $rowx['as_name'] ?></label> <label style="margin-right:50px"> €<?php echo $rowx['as_price'] ?></label>
             <?php echo '<button type="button" onclick="minusAddonsDeal(\''. $index_range .'\' ,\''. $index .'\' ,\''. $rowx['as_id'] .'\' , \''. $rowx['as_name'] .'\' , \''. $rowx['as_price'] .'\', \''. $num_free_items .'\')"  >-</button>'; ?>
        <?php echo "<input disabled name='qty_addons$index_range' type='text' value=0 style='width:30px;padding-left:6px'>"?>
             <?php echo '<button type="button" onclick="addAddonsDeal(\''. $index_range .'\' ,\''. $index .'\' ,\''. $rowx['as_id'] .'\' , \''. $rowx['as_name'] .'\' , \''. $rowx['as_price'] .'\', \''. $num_free_items .'\')"  >+</button>'; ?>
            </label>
        </div>
<?php $index++; } ?>  


</div>
<div style="margin-left:5px;margin-bottom:10px;" class="row">
<h6 style="margin-left:10px;" class="cardtitle">Free Addons : <?php echo $num_free_items ?></h6>

</div>
</div>
<?php } if($typeid != null && $typeid != -1){ 
     $sql = "SELECT `ts_id`, `type_title`, `type_title_user`, `ts_name` FROM `types_sublist` WHERE `type_id` = $typeid";
            $execute = mysqli_query($con,$sql);

?>

    <h6 style="margin-left:5px;" class="cardtitle">Types :</h6>
            
            <?php 
            echo "<select id='type_box_deal$index_range'  onchange='onChangeTypeBox($index_range)' class='form-control' > ";
             echo "<Option disabled selected id=0>Select one of the type</Option>";
            while($rowtype = mysqli_fetch_array($execute)){
               echo "<option value='{$rowtype['ts_id']}'>{$rowtype['ts_name']}</option>"; 
            }
            echo "</select>"; 
            ?>  
<?php } if($dressingid != null && $dressingid != -1){

  $dressingd = "SELECT `ds_id`, `dressing_title`, `dressing_title_user`, `dressing_name` FROM `dressing_sublist` WHERE `dressing_id` = $dressingid";
  $resultd = mysqli_query($con,$dressingd);

  $dressingtittle = mysqli_fetch_array($resultd);
?>
<h6 style="margin-left:5px;margin-top:15px" class="cardtitle"><?php echo $dressingtittle['dressing_title_user'] ?> Dressing :</h6>
       <div  style="height : 80px" class="scroll"> 
       <?php
foreach($resultd as $rowd){
  ?>
        <div class="row ml-2">
            <label for="checkid"  style="word-wrap:break-word;font-size:11px;">
            <!--<input name="checkid"  type="checkbox" value="test" />-->
            <?php echo "<input type='checkbox' onchange='onDressingChecks($index_range)' name='dressing_box{$index_range}' value='{$rowd['ds_id']},{$rowd['dressing_name']}' />"; ?>
            <?php echo $rowd['dressing_name'] ?> 
            </label>
        </div>
<?php } }?>  
