<?php include('assets/header.php') ?>
<!DOCTYPE html>

<?php

  if(isset($_GET['Massage'])){
      if($_GET['Massage'] == 'Sucessfully updated Dressing.'){
         echo "<script>alert('Sucessfully updated Dressing.')</script>";
        // header("Refresh: 1; url='update_dressing.php'");
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
</style>  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
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
    
<!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">-->
<!--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">-->


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
                <h2 class="content-header-title float-left mb-0">Manage Dressing</h2>
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Dressing
                    

                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
             
            </div>
          </div>
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
					<h4 class="card-title">Add More Addon Dressing</h4>
				</div>
				<div class="card-content">
					<div class="card-body">
					<form class="form-horizontal" action="phpfiles/insertions.php" method="POST" enctype="multipart/form-data">
							<div class="row">
					<?php $idz =  $_GET['id']; ?>
    			    	
    		            <Input hidden type="text" name="addon_id" value="<?php echo $idz; ?>"></input>      
    			    
                        <div id="dynamic_fields" class="col-md-12">
                            
                        </div>
						<div class="col-sm-12">
							<button type="button" name="add" id="add"    class="btn btn-primary mb-2">Add More Addon Dressing</button>
    			    	</div>
                 
							<button type="Submit" name="btnSubmit_insertMoreAddonDressing"  class="btn btn-primary ml-2">Submit</button>
							
						</form>
						
						
						   
					</div>
					
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
</section>




<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage Dressing</h4>
                                                             <button type="button" class="btn btn-success mt-2" onclick="openMergeModal()">Merge Dressing</button>
                </div>
        
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <p class="card-text"></p>
                        <div class="table-responsive">
                           <!-- Add this in your table area -->
<div class="mb-3" id="example_wrapper"></div>
                            
                            <table id="example" class="table">
                                <thead>
                                   <tr>
                                       
                                        <th>Select</th>
                                        <th>S no.</th>
                                        <th>Dressing ID</th>
                                        <th>Dressing Title</th>
                                        <th>Dressing Name</th>
                                        <th>Dressing Name for users</th>
                                        <th>Dressing Price</th>
                                        <th>Save</th>
                                        <!--<th>Update</th>-->
                                        <th>Delete</th>
                                      </tr>
                                </thead>
                                <tbody>
                                      <?php
                                      include_once('connection.php');
                                      $sql="SELECT `ds_id`, `dressing_id`, `dressing_title`, `dressing_title_user`, `dressing_name`, `price` FROM `dressing_sublist` WHERE `dressing_id` = ".$_GET['id'];
                                      $result = mysqli_query($conn,$sql);
                                      $index = 0;
                                      while($row = mysqli_fetch_array($result)){
                                          $sn = $index+1;
                                          echo "<tr data-id='{$row['ds_id']}'>";
                                            echo "<td><input type='checkbox' name='selected_dressing[]' value='{$row['ds_id']}'></td>";
                                            echo "<td>{$sn}</td>";
                                            echo "<td>{$row['ds_id']}</td>";
                                            echo "<td class='editable' contenteditable='false' name='dressing_title' data-field='dressing_title' >{$row['dressing_title']}</td>";
                                            echo "<td class='editable' contenteditable='true' ts_name='dressing_name' data-field='dressing_name'>{$row['dressing_name']}</td>";
                                            echo "<td class='editable' contenteditable='false' name='dressing_title_user' data-field='dressing_title_user'>{$row['dressing_title_user']}</td>";
                                            echo "<td class='editable' contenteditable='false' name='dressing_price' data-field='dressing_price'>{$row['price']}</td>";
                                            
                                            echo "<td><button class='btn btn-success save-btn' style='display:none;'>Save</button></td>";    
                                            
                                            
                                            // echo '<td><button class="btn btn-primary" onclick="openAddMore(\''. $row['ds_id'] .'\' ,\''.$row['dressing_name'].'\', \''.$row['dressing_title'].'\')">Update</button></td>';

                                              echo '<td><button class="btn btn-danger" onclick="deleteRow(\''. $row['ds_id'] .'\')">Delete</button></td>';
                                          echo "</tr>";
                                          $index++;
                                      }
                                      
                                      ?>
                                    
                                </tbody>
                                <tfoot>
  <tr>
    <th>Select</th>
    <th>S no.</th>
    <th>Dressing ID</th>
    <th>Dressing Title</th>
    <th>Dressing Name</th>
    <th>Dressing Name for users</th>
    <th>Dressing Price</th>
    <th>Save</th>
    <!--<th>Update</th>-->
    <th>Delete</th>
  </tr>
</tfoot>
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
        <h2>Update Dressing</h2>
         <br>
         <form method="POST" action="phpfiles/insertions.php" enctype="multipart/form-data">
        
             <div class="col-sm-12">
                 <input class="form-control"  value="" type="text" name="ds_id" id="ds_id" placeholder="Enter user name" hidden> 
                 <input class="form-control"  value="<?php echo $_GET['id']; ?>" type="text" name="d_id" id="d_id" placeholder="Enter user name" hidden> 
                 
                  
                <!-- <div class="form-group">-->
                <!--    <div class="controls">-->
                <!--        <input class="form-control"  value="" type="text" name="dressing_title" id="dressing_title" placeholder="Enter Dressing Title" > -->
                <!--    </div>-->
                <!--  </div>-->
                  
                <!--<div class="form-group">-->
                <!--    <div class="controls">-->
                <!--        <input class="form-control"  value="" type="text" name="dressing_title_user" id="dressing_title_user" placeholder="Enter Dressing Name" > -->
                <!--    </div>-->
                <!--  </div>-->
                  
                  <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  value="" type="text" name="dressing_name" id="dressing_name" placeholder="Enter Dressing Name" > 
                    </div>
                  </div>
                  
                  
                    <div class="form-group">
                    <div class="controls">
                        <input class="form-control"  value="" type="text" name="dressing_title" id="dressing_title" placeholder="Enter Dressing title" > 
                    </div>
                  </div>
                  

                
                </div>
        
       <button type="submit" name="updateSubDressings" class="btn btn-primary">Save</button>
       </form>
      </div>
    
    </div>
    
<!-- Merge Addons Modal -->
<div class="modal fade" id="mergeDressingModal" tabindex="-1" role="dialog" aria-labelledby="mergeDressingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="mergeDressingForm">
        <div class="modal-header">
          <h5 class="modal-title" id="mergeDressingModalLabel">Merge Selected Addons</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="merged_name">New Dressing Name</label>
            <input type="text" class="form-control" id="merged_name" name="merged_name" placeholder="Enter merged dressing name" required>
          </div>
          <input type="hidden" name="selected_dressing" id="selected_dressing_input">
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


$(document).ready(function () {
  var i = 1;

$('#add').click(function () {
    $('#dynamic_fields').append(`
      <div id="row-hgj-${i}" class="row mb-2">
        <div class="col-sm-5">
          <input type="text" name="addon_name[]" class="form-control" placeholder="Add On" required>
        </div>
        <div class="col-sm-5">
          <input type="Number" name="addon_price[]" step="0.1" class="form-control" placeholder="Add On Price" required>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-danger btn_remove" data-id="row-hgj-${i}">Remove</button>
        </div>
      </div>
    `);
    i++;
});

  $(document).on('click', '.btn_remove', function () {
    var rowId = $(this).data('id');
    $('#' + rowId).remove();
  });
});



var modal = document.getElementById("myModal");
var modal_Add = document.getElementById("myModal_Add");
 function openModal(id){
        document.getElementsByName('userID')[0].value = id;
        modal.style.display = "block";
 }
 
function openAddMore(id,cost,proname){

    document.getElementById('dressing_title').value = proname;
    document.getElementById('dressing_name').value = cost;
    document.getElementById('ds_id').value = id;
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
      req.open("get","assets/Actions.php?FunctionName=DeleteDressing&id="+id,true);
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
$(document).ready(function () {
    // Show Save button when title is edited
    $('.editable').on('input', function () {
        $(this).closest('tr').find('.save-btn').show();
    });

    // Save updated title
    $('.save-btn').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = row.find('[data-field="dressing_title"]').text().trim();
        const dressing_title_user = row.find('[data-field="dressing_title_user"]').text().trim();
        const dressing_name = row.find('[data-field="dressing_name"]').text().trim();
  console.log('Sending:', { id: id, dressing_title: title, dressing_title_user: dressing_title_user, dressing_name: dressing_name })

        $.ajax({
            url: '../API/update_subdressing_inline.php',
            method: 'POST',
            dataType: 'json',
            data: {
                id: id,
                title: title,
                dressing_title_user:dressing_title_user,
                dressing_name:dressing_name
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


<script>
$(document).ready(function () {
    var table = $('#example').DataTable(
        {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: [0, 2, 3] // only export visible content columns
                }
            },
            {
    extend: 'csvHtml5',
    text: 'CSV',
    filename: 'dressing_csv',
    bom: true,
    exportOptions: {
        columns: [1, 3, 2], // ds_id, dressing_title, dressing_title_user, dressing_name
        format: {
            header: function (data, columnIdx) {
                switch(columnIdx) {

                    case 1: return 'ds_id';
                    case 3: return 'dressing_name';
                    case 2: return 'dressing_title_user';
                    default: return data;
                }
            }
        }
    }
},
            {
                extend: 'pdfHtml5',
                text: 'Pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ]
    });
});




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
        url: '../API/update_bulk_dressing.php', // Or pass this via argument
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
    $("input[name='selected_dressing[]']:checked").each(function() {
        selected.push($(this).val());
    });

    if (selected.length === 0) {
        alert("Please select at least one dressing to merge.");
        return;
    }

    $('#selected_dressing_input').val(selected.join(','));

    $('#mergeDressingModal').modal('show');
}

$('#mergeDressingForm').on('submit', function(e) {
    e.preventDefault();

    const merged_name = $('#merged_name').val();
    const selected_dressing = $('#selected_dressing_input').val();

    console.log('Data :', {
        new_dressing_title: merged_name,
        selected_dressing_ids: selected_dressing
    });

    $.ajax({
        url: '../API/merge_dressing.php', // your backend merge logic file
        type: 'POST',
        data: {
            new_dressing_title: merged_name,
            selected_dressing_ids: selected_dressing
        },
        success: function(response) {
            alert("Dressing merged successfully!");
            location.reload(); // Refresh the page to show updates
        },
        error: function() {
            alert("An error occurred while merging.");
        }
    });
});
</script>





  </body>
  <!-- END: Body-->

<!-- Mirrored from pixinvent.com/demo/vuexy-html-bootstrap-admin-template/html/ltr/vertical-menu-template-semi-dark/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 16 Apr 2020 21:22:58 GMT -->
</html>