<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#btn2").click(function(){
     var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         var data = this.responseText;
         $('#dynamic_fields').append(data);
      }
    }
    xmlhttp.open("GET", "phpfiles/getproducts.php", true);
    xmlhttp.send();
    // 
    // i++;
  });
});
</script>
</head>
<body>

<!--<Select>-->
<!--  <li>List item 1</li>-->
<!--  <li>List item 2</li>-->
<!--  <li>List item 3</li>-->
<!--</Select>-->
     
                        <div id="dynamic_fields" class="col-md-12">
                            <h4>Add Items</h4>
                        </div>
<button id="btn2">Append list item</button>

</body>
</html>
