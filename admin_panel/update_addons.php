<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully updated Addon.'){
         echo "<script>alert('Sucessfully updated Addon.')</script>";
        // header("Refresh: 1; url='update_addons.php'");
       }else{
          echo "<script>alert('changes made to data successfully!')</script>";
       }
     
  }   
?>


<html class="loading" lang="en" data-textdirection="ltr">

<style>

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width:50%;
  height:'auto';
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */

.modal-content-Updated {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height:300px;
  border-radius:10px;
}

.modal-content-Updated2 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  height:250px;
  border-radius:10px;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;

}
td[name="price"]::before {
    content: "€ ";
}

</style>  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta charset="UTF-8">
    <title><?php
       include('title.php');
       echo $pageTitle
    
    ?></title>
    <link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/validation/form-validation.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

  </head>
  
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">

    <!-- BEGIN: Header-->
  
    

    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <?php include('assets/Site_Bar.php') ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h2 class="content-header-title float-left mb-0">Manage Addon</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Addon
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">-->
          <!--  <div class="form-group breadcrum-right">-->
          <!--    <div class="dropdown">-->
          <!--      <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>-->
          <!--      <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a></div>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
        </div>
        <div class="content-body"><div class="row">
  <!--<div class="col-12">-->
  <!--    <p>Read full documnetation <a href="../../../../../../external.html?link=https://datatables.net/" target="_blank">here</a></p>-->
  <!--</div>-->
</div>
<!-- Zero configuration table -->
<section class="simple-validation">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Add More Addon</h4>
				</div>
				<div class="card-content">
                    <div class="card-body">
                        <!-- Addon Form -->
                        <form class="form-horizontal" action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <?php $idz = $_GET['id']; ?>
                                <input type="hidden" name="addon_id" value="<?php echo $idz; ?>">
                
                                <div id="dynamic_fields" class="col-md-12">
                                    <!-- Dynamic input fields will be appended here -->
                                </div>
                
                                <div class="col-sm-12">
                                    <button type="button" name="add" id="add" class="btn btn-primary mb-3">Add More Addon</button>
                                </div>
                
                                <div class="col-sm-12">
                                    <button type="submit" name="btnSubmit_insertMoreAddon" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                
               <div class="col-lg-6">
                            <!-- Row: CSV input and Sample Download Button -->
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="form-group ">
                                    <label for="csv-file" class="form-label mb-1">Choose a CSV file:</label>
                                    <input type="file" name="csv_file" class="form-control" id="csv-file">
                                </div>
                      
                            </div>
                        
                       
                                <button type="button" class="btn btn-primary" onclick="uploadCsv()" id="upload-button">
                                    Bulk Update
                                </button>
          
                        </div>

                        
                    </div>
                </div>

			</div>
		</div>
	</div>
</section>

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage Addon</h4>
                     <button type="button" class="btn btn-success mt-2" onclick="openMergeModal()">Merge Addons</button>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>S no.</th>
                                        <th>Addon ID</th>
                                        <th>Addon Name</th>
                                        <th>Addon Price</th>
                                        <th>Action</th>
              
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  include_once('connection.php');
                                  $sql="SELECT * FROM `addon_sublist` WHERE `ao_id` = ".$_GET['id'];
                                  $result = mysqli_query($conn,$sql);
                                  $index = 0;
                                  while($row = mysqli_fetch_array($result)){
                                      $sn = $index+1;
                                      echo "<tr data-id='{$row['as_id']}'>";
                                      echo "<td><input type='checkbox' name='selected_addons[]' value='{$row['as_id']}'></td>";
                                      echo "<td>{$sn}</td>";
                                      echo "<td>{$row['as_id']}</td>";
                                      echo "<td class='editable' contenteditable='true' data-field='as_name' name='cost'>{$row['as_name']}</td>";
                                      echo "<td class='editable' contenteditable='true' data-field='as_price' name='price'>{$row['as_price']}</td>";
                                      
                                    //   echo "<td><button class='btn btn-primary' onclick=\"openAddMore('{$row['as_id']}', '{$row['as_name']}', '{$row['as_price']}')\">Update</button></td>";
                            
                                      echo "<td>
                                      <button class='btn btn-success save-btn' style='display:none;'>Save</button>
                                      <button class='btn btn-danger mt-1' onclick=\"deleteRow('{$row['as_id']}')\">Delete</button>
                                      </td>";
                                      echo "</tr>";
                                      $index++;
                                  }
                                  ?>
                                </tbody>
                            </table>
                    
                          

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--/ Zero configuration table -->
<div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content-Updated2">

        <span  onclick="closeModel(1)" class="close">&times;</span>
        <h2>Update Image</h2>
         <br>

         <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
         <input hidden type="text" id="ProID" name="ProID">  
             <div class="col-sm-12">
                
                 <!--  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  type="text" name="tracking" placeholder="Tracking Number (Optional)"> 
                    </div>
                  </div> -->
                  <div class="form-group">
                    <div class="controls">
                      <input  type="file" name="updatedImage" class="form-control"/>
                    </div>
                  </div>
                </div>
        
       <button type="submit" name="btnUpdateProdImage" class="btn btn-primary">Submit</button>
       </form>
      </div>
    
    </div>
<div id="myModal_Add" class="modal">

      <!-- Modal content -->
      <div class="modal-content-Updated">

        <span onclick="closeModel(2)" class="close">&times;</span>
        <h2>Update Addons</h2>
         <br>
         <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
        
             <div class="col-sm-12">
                 <input class="form-control"  value="" type="text" name="as_id" id="as_id" placeholder="Enter user name" hidden> 
                 
                 
                  
                 <!--<div class="form-group">-->
                 <!--   <div class="controls">-->
                 <!--       <input class="form-control"  value="" type="text" name="ao_title" id="ao_title" placeholder="Enter Addon Title" > -->
                 <!--   </div>-->
                 <!-- </div>-->
                  
                <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  value="" type="text" name="as_name" id="as_name" placeholder="Enter Addon Name" > 
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control" step="0.1"  value="" type="number" name="as_price" id="as_price" placeholder="Enter Addon Price" > 
                    </div>
                  </div>
                  
                  
                  
          
                  
                <!--updatefeaturedProduct-->
            
                
                </div>
        
       <button type="submit" name="updateSubAddon" class="btn btn-primary">Save</button>
       </form>
      </div>
    
    </div>
<!-- Merge Addons Modal -->
<div class="modal fade" id="mergeAddonsModal" tabindex="-1" role="dialog" aria-labelledby="mergeAddonsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="mergeAddonsForm">
        <div class="modal-header">
          <h5 class="modal-title" id="mergeAddonsModalLabel">Merge Selected Addons</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="merged_name">New Addon Name</label>
            <input type="text" class="form-control" id="merged_name" name="merged_name" placeholder="Enter merged addon name" required>
          </div>
          <input type="hidden" name="selected_addons" id="selected_addons_input">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Merge</button>
        </div>
      </form>
    </div>
  </div>
</div>
    
    



<!--/ Scroll - horizontal and vertical table -->

        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- End: Customizer-->
  
    <!-- Buynow Button-->
    <!--<div class="buy-now"><a href="../../../../../../external.html?link=https://1.envato.market/vuexy_admin" target="_blank" class="btn btn-danger">Buy Now</a>-->

    <!--</div>-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>



    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.min.js"></script>
    <script src="app-assets/js/core/app.min.js"></script>
    <script src="app-assets/js/scripts/components.min.js"></script>
    <script src="app-assets/js/scripts/customizer.min.js"></script>
    <script src="app-assets/js/scripts/footer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/datatables/datatable.min.js"></script>


    <!-- END: Page JS-->
    
<script>


$(document).ready(function() {
  var i = 1;
  $('#add').click(function() {
   
      $('#dynamic_fields').append('<div class="row"><div class="col-sm-6" ><div class="form-group"><input type="text" name="addon_name[]" class="form-control" placeholder="Add On" required ></div></div><div class="col-sm-6" ><div class="form-group"><input type="number" step="0.01" name="addon_price[]" class="form-control" placeholder="Add On Price" required ></div></div></div>')
      i++;

  });
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    i--;
    $('#row' + button_id + '').remove();
  });
});

var modal = document.getElementById("myModal");
var modal_Add = document.getElementById("myModal_Add");
 function openModal(id){
        document.getElementsByName('userID')[0].value = id;
        modal.style.display = "block";
 }
function openAddMore(id,subname,cost){

    //document.getElementById('ao_title').value = proname;

      document.getElementById('as_name').value = subname;
      document.getElementById('as_price').value = cost;
    //   document.getElementById('ProDis').value = discount;
    //   document.getElementById('ProDes').value = des;
       document.getElementById('as_id').value = id;
    
      modal_Add.style.display = "block";
     

 }
  function openimagemodel(id,index){
     

      modal.style.display = "block";
      document.getElementById('ProID').value = id;
     

 }
 var span = document.getElementsByClassName("close")[0];
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    
  }else if(event.target == modal_Add){
     modal_Add.style.display = "none";
  }
}
 function closeModel(id) {
  if(id == 1){
      modal.style.display = "none";
  }else{
      modal_Add.style.display = "none";
  }
  
}

function deleteRow(id){
    var req = new XMLHttpRequest();
      req.open("get","assets/Actions.php?FunctionName=DeleteCampaigndelete&id="+id,true);
      req.send();
      req.onreadystatechange = function(){
          if(req.readyState==4 && req.status==200){
             alert('Row has been deleted!');
             location.reload();
              
          }
      };
}

function toggle(status,id){
      var req = new XMLHttpRequest();
      req.open("get","assets/Actions.php?FunctionName=ToggleCampaignPro&id="+id+"&status="+status,true);
      req.send();
      req.onreadystatechange = function(){
          if(req.readyState==4 && req.status==200){
             alert('Status has been updated!');
             location.reload();
              
          }
      };
}
</script>    
<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
    extend: 'csvHtml5',
    text: 'CSV',
    filename: 'addon_export',
    bom: true,
    exportOptions: {
        columns: [1, 2, 3],
        format: {
            header: function (data, columnIdx) {
                switch(columnIdx) {
                    case 1: return 'as_id';
                    case 2: return 'as_name';
                    case 3: return 'as_price';
                    default: return data;
                }
            },
            body: function (data, row, column, node) {
                if (column === 3) {
                    // Remove HTML and non-numeric characters
                    const plain = $('<div>').html(data).text(); // decode HTML entities
                    return plain.replace(/[^\d.-]/g, '').trim(); // keep only numbers
                }
                return data;
            }
        }
    }
},
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Export all columns (or specify the ones you need)
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Export all columns (or specify the ones you need)
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Export all columns (or specify the ones you need)
                }
            }
        ]
    });
});

</script>

<script>
    function uploadCsv() {
    var fileInput = document.getElementById('csv-file');
    var file = fileInput.files[0];

    if (!file) {
        alert('Please select a CSV file.');
        return;
    }

    var formData = new FormData();
    formData.append('csv_file', file);

    $.ajax({
        url: '../API/update_bulk_addons.php', // Or pass this via argument
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#upload-button').prop('disabled', true).text('Uploading...');
        },
        success: function (response) {
            console.log('Raw response:', response);

            try {
                var res = (typeof response === 'object') ? response : JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message); // ✅ This should now show
                    location.reload();   // ✅ This should now trigger
                } else {
                    alert(res.message);
                }
            } catch (e) {
                console.error('JSON parse error:', e);
                alert('Unexpected response from server.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while uploading.');
        },
        complete: function () {
            $('#upload-button').prop('disabled', false).text('Bulk Submit');
        }
    });
}

</script>
<script>
function openMergeModal() {
    let selected = [];
    $("input[name='selected_addons[]']:checked").each(function() {
        selected.push($(this).val());
    });

    if (selected.length === 0) {
        alert("Please select at least one addon to merge.");
        return;
    }

    // Put selected addon IDs in hidden input
    $('#selected_addons_input').val(selected.join(','));

    // Open the modal
    $('#mergeAddonsModal').modal('show');
}

$('#mergeAddonsForm').on('submit', function(e) {
    e.preventDefault();

    const merged_name = $('#merged_name').val();
    const selected_addons = $('#selected_addons_input').val();
    
    // Log the data to the console for debugging
    console.log('Data :', {
        new_ao_title: merged_name,
        selected_ao_ids: selected_addons
    });

    $.ajax({
        url: '../API/merge_addons.php', // your backend merge logic file
        type: 'POST',
        data: {
            new_ao_title: merged_name,
            selected_ao_ids: selected_addons
        },
        success: function(response) {
            alert("Addons merged successfully!");
            location.reload(); // Refresh the page to show updates
        },
        error: function() {
            alert("An error occurred while merging.");
        }
    });
});
</script>


<script>
$(document).ready(function () {
    // Show Save button when title is edited
    $('.editable').on('input', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    // Save updated title
    $('.save-btn').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const as_name = row.find('[data-field="as_name"]').text().trim();
        const as_price = row.find('[data-field="as_price"]').text().trim();

        $.ajax({
            url: '../API/update_inline_addons.php',
            method: 'POST',
            dataType: 'json',
            data: {
                id: id,
                as_name: as_name,
                as_price : as_price

            },
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    row.find('.save-btn').hide();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr) {
                alert("Request failed: " + xhr.responseText);
            }
        });
    });
});
</script>








  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->
</html>