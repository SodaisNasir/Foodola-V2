<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Pizza Blitz Reciept</title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<style>
    
     .scroll {
    
    
    width: 80px;
    

    
}
    
</style>
<body>
<div class="container ">
<div class="row invoice row-printable">
    <div class="col-md-4" style="margin:0 auto;">
        <!-- col-lg-12 start here -->
        <div class="panel panel-default plain" id="dash_0">
            <!-- Start .panel -->
            <div class="panel-body p30">
                <div class="row">
                    <!-- Start .row -->
                    <div class="col-lg-6">
                        <!-- col-lg-6 start here -->
                        <!--<div class="invoice-logo"><img width="100" src="https://c8.alamy.com/comp/PCYG1J/pizzeria-fast-food-logo-or-label-happy-chef-holding-pizza-and-scapula-in-hands-vector-illustration-PCYG1J.jpg" alt="Invoice logo"></div>-->
                    </div>
                    <!-- col-lg-6 end here -->
                    <div class="col-lg-6">
                        <!-- col-lg-6 start here -->
                        <div class="invoice-from">
                            <ul class="list-unstyled text-right">
                                <li>Pizza Blitz</li>
                                <li>2500 Ridgepoint Dr, Suite 105-C</li>
                            </ul>
                        </div>
                    </div>
                    <!-- col-lg-6 end here -->
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="invoice-details mt25">
                            <div class="well">
                                <ul class="list-unstyled mb0">
                    
                                    <li><strong>Invoice</strong> # <?php echo mt_rand(1111,9999) ?></li>
                                    <li><strong>Invoice Date:</strong> <?php echo date('l') ?>, <?php echo date("Y/m/d") ?></li>
                                    <li><strong>Invoice Time:</strong> <?php echo date('h:i:s') ?></li>
                                </ul>
                            </div>
                        </div>
                        <!--<div class="invoice-to mt25">-->
                        <!--    <ul class="list-unstyled">-->
                        <!--        <li><strong>Invoiced To</strong></li>-->
                        <!--        <li>Jakob Smith</li>-->
                        <!--        <li>Roupark 37</li>-->
                        <!--        <li>New York, NY, 2014</li>-->
                        <!--        <li>USA</li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                        <div class="invoice-items">
                            <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="per70 text-center">Product</th>
                                            <th class="per5 text-center">Qty</th>
                                            <th class="per25 text-center">Price</th>
                                            <th class="per25 text-center">Addons</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="cart-wrapper">
                                        <?php
                                      include_once('connection.php');
                                      $order_id = $_GET['order_id'];
                                      $sql="SELECT products.name, orders.order_total_price, order_details.qty, order_details.cost, order_details.price, order_details.addons FROM `order_details` INNER JOIN products On products.id = order_details.product_id
                                      INNER JOIN orders On orders.id = order_details.order_id WHERE `order_id` = $order_id";
                                      $result = mysqli_query($conn,$sql);
                                      $index = 0;
                                     
                                    foreach($result as $row){   
                                    
                                      $addons = json_decode($row['addons']);
                                      ?>
                                      
                                     <tr>
                                          <td name='name'><?php echo $row['name'] ?></td>
                                          <td name='qty'><?php echo $row['qty'] ?></td>
                                          <td name='price'><?php echo $row['price'] ?></td>
                                          <td name='addon_name'>
                                              <?php 
                                               foreach($addons as $addon){
                                                  echo ($addon->addon_name)," ", "X"," " ;echo $row['qty']," = " ;echo ($addon->addon_price),"<br>" ;
                                               }
                                              ?>
                                          </td>
                                          
                                       
                                        </tr> 
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="per5 text-center "colspan="3">Subtotal</th>
                                      <td name='price'><?php echo $row['order_total_price'] ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-footer mt25">
                            <button id="btnPrint" class="hidden-print btn btn-primary" style="margin-bottom:50px">Print</button>
                        </div>
                    </div>
                    <!-- col-lg-12 end here -->
                </div>
                <!-- End .row -->
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- col-lg-12 end here -->
</div>
</div>

   


<style type="text/css">
body{
    margin-top:10px;
    background:#eee;    
}

</style>

// <script>

// window.onload = function() {
//   updateCartUI()
// };

      
// function getproducts(){
    
//     let cartMap = new Map()
//     const cart = localStorage.getItem("cart")  
//     console.log('items=====.',cart)
//     if(cart===null || cart.length===0)  return cartMap
//         return new Map(Object.entries(JSON.parse(cart)))
// }



// function updateCartUI(){
//     let items = getproducts()
//     console.log('asdasdasdasd',items)
//     const cartWrapper = document.querySelector('.cart-wrapper')
//     cartWrapper.innerHTML=""
    
//      let count = 0
//     let total = 0
//     let mytotal = 0
//     if(items === null) return
    
//     for(const [key, value] of items.entries()){
        
//         console.log('value',value)
//         const cartItem = document.createElement('tr')
//         let price = value.prod_price*value.qty
//         let pricexxx = value.prod_price*value.qty+mytotal
//         pricexxx = Math.round(pricexxx*100)/100
//         count+=1
//         total += pricexxx
//         total = Math.round(total*100)/100
//         //cartItem.innerHTML
//          output =
//         `

                          
//                                 <td>${value.prod_name}</td>
//                                 <td class="text-center">${value.qty}</td>
//                                 <td class="text-center">€ ${price}</td>
//                                 <td class="text-center">
                                
                                
                         
                            
                        
                   
//         `
//         console.log('mytotal',mytotal)
//         for (let i = 0; i < value.addons.length; i++) {
            
//             console.log('value.addons[i].addon_price',value.addons[i].addon_price)
            
//          mytotal =  parseInt(value.addons[i].addon_price)
        
//             output+= value.addons[i].addon_name+="," 
            
            
//         }
            
            
        
//             cartItem.innerHTML = output  +="</td><td class=\" ml-3\">"+"€"+pricexxx+"</td>"                  

//             cartWrapper.append(cartItem)  
        
//     }
//      const subtotal = document.getElementById("subtotal").innerHTML = total
//      const total_amount = document.getElementById("total_amount").value =  total;   
        

      
      
      
// };



// </script>


<script type="text/javascript">


const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});
document.getElementById("demo").innerHTML =
Math.floor(Math.random() * 10000);
</script>
</body>
</html>