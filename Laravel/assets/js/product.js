$('document').ready(function(){
    $('.alert').hide();
})
let usercheck1=JSON.parse(localStorage.getItem('USER'));
if(usercheck1 === null){
     document.getElementById("auth").innerHTML=` <a class="nav-link" href="auth.html">Registrieren/Anmelden</a>`
}else{
     document.getElementById("auth").innerHTML=` <a class="nav-link" onclick='logout()'>Ausloggen</a>`
}
function logout(){
      localStorage.clear();
  
  // Redirect the user to the home page
  window.location.href = 'index.html'; 
}


   const addons=''
         const typeArray = []; 
           const dressingArray = [];
        function further_detail(id) {
            var formdata = new FormData();
            formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");
            formdata.append("product_id", id);
            
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };

            fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/get_further_product_byid.php", requestOptions)
                .then(response => response.json())
                .then(result => {
                    if (result.Status === true) {
                        var dealsData = result.Data;
                          const formattedPrice = Number(dealsData.price).toFixed(2);
                        var data = `
            <div class="product_img">
                <img src="https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${dealsData.image}" id='product_img' class="img-fluid w-100">
            </div>
              <div class="product-details" style='text-align:start;'>
                <h4 style='font-size:20px;text-align:start;'><a href="" style='text-align:start;'><strong style='font-size:20px;color:black;'>Titel:</strong> <span id='productname'> ${dealsData.name}</span></a></h4>
                <p  style='font-size:18px;height:auto;text-align:start;'><strong style='font-size:20px;color:black;text-align:start;font-weight:900;'>Beschreibung:</strong> <span id='productdescription'> ${dealsData.description}</span></p>
                <div class="product-price" style='text-align:start;'><strong style='font-size:20px;color:black;'>Preis: € </strong><span id='fixed_price'>${formattedPrice}</span>
                <input type='hidden' id=pro_id value='${dealsData.id}'></div>
                 <input type='hidden' id=cost value='${dealsData.cost}'></div>
                  <input type='hidden' id=discount value='${dealsData.discount}'></div>
                   <input type='hidden' id='pro_pri' value='${dealsData.price}'></div>
                 
                </div>`;
                        document.getElementById('product_box').innerHTML = data;
                          let pri=parseFloat(dealsData.price)
                          document.getElementById('product_price').innerHTML =pri.toFixed(2);
                     
                       console.log(pri.toFixed(2))
                           document.getElementById('net_price').innerHTML =pri.toFixed(2);
                          
                        
                        
                        if(dealsData.addons[0] != undefined){
                             document.getElementById('addon_title').innerHTML =dealsData.addons[0].ao_title;
                             const addons=dealsData.addons[0].ao_data;
                             data2=''
                             addons.forEach(function(resp, index){
                                   const formattedPrice = Number(resp.as_price).toFixed(2);
                                  const checkboxId = `s${index + 1}`;
                                 data2+=`<div for='${checkboxId}' class="mb-0" style="display: flex;width: 100%;"> 
                                  <p class="mb-0">  <input type= "hidden" name= "id" value="${resp.as_id}" id="as_${checkboxId}"></p> 
                    <p class="mb-0">  <input type= "hidden" name= "language" value="${resp.as_price}" id="${checkboxId}"></p> 
                    
                    <p style="margin-left: 5px;width:50%;" id="name_${checkboxId}">${resp.as_name}</p> 
                    	<div class="qty" style='margin-left:auto'>
                        <span class="minus2" onclick="minus2('${checkboxId}')">-</span>
                        
                        <input type="text" class="count" id='qty_${checkboxId}' name="qty" value="0">
                          
                        <span class="plus2" onclick="plus2('${checkboxId}')">+</span>
                    </div>
                    <p style="margin-left: auto;">€<span id='addon_price_${checkboxId}'> ${formattedPrice}</span></p>
                  </div>`
                             })
                             
                              document.getElementById('addon_box').innerHTML =data2;
                               document.getElementById('addon_text').innerHTML='Addon Price';
              document.getElementById('add_on_price').innerHTML=0;
             
                        }
                        
                       
                        
                        if(dealsData.type[0] != undefined){
                              document.getElementById('type-title').innerHTML =dealsData.type[0].type_title;
                              type=dealsData.type[0].type_data;
                             data2=''
                             type.forEach(function(resp, index){
                                  const checkboxId = `s${index + 1}`;
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                    <p class="mb-0">  <input type= "checkbox" name= "language" onclick="type_checkbox_click('${checkboxId}')" value= "Cheese" id="checkbox_${checkboxId}"></p> 
                    <input type= "hidden" name= "id" value= "${resp.ts_id}" id="ts_${checkboxId}">
                    <p style="margin-left: 5px;" id='type_name_${checkboxId}'>${resp.ts_name}</p> 
                  </div>`
                             })
                             
                              document.getElementById('type_box').innerHTML =data2;
                             
                        }
                        
                        if(dealsData.dressing[0] != undefined){
                              document.getElementById('dressing-title').innerHTML =dealsData.dressing[0].dressing_title;
                               const addons=dealsData.dressing[0].dressing_data;
                             data2=''
                             addons.forEach(function(resp, index){
                                  const checkboxId = `s${index + 1}`;
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                    <p class="mb-0">  <input type= "checkbox" name= "language" onclick="dressing_click('${checkboxId}')" value= "Cheese" id="dressing_${checkboxId}"></p> 
                      <input type= "hidden" name= "id" value= "${resp.ds_id}" id="ds_${checkboxId}">
                    <p style="margin-left: 5px;" id="dressing_name_${checkboxId}">${resp.dressing_name}</p> 
                  </div>`
                             })
                             
                              document.getElementById('dressing_box').innerHTML =data2;
                              
                        }
                      // console.log(dealsData);           // Log the entire dealsData object
// console.log(dealsData.addons);    // Log the addons property
// console.log(dealsData.addons[0]);
                    } else {
                        console.error("Error:", result.Data);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Extract the product ID from the URL query parameters
        function getProductIdFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }

        // Call further_detail when the page loads, passing the extracted 'id'
        const productId = getProductIdFromUrl();
        further_detail(productId);
        
        
        function minus(){
           const price= parseFloat(document.getElementById('fixed_price').innerHTML);
           
            const quantity= parseFloat(document.getElementById('quantity_value').value);
            const exact_quantity=quantity-1;
            const total= price*exact_quantity
            if( exact_quantity <1){
                 document.getElementById('product_price').innerHTML=price.toFixed(2);
                
                   total_price=document.getElementById('add_on_price').innerHTML;
               if(total_price !=null){
                  const total_net= Number(total_price)*exact_quantity
                   net_price=Number(total_net)+total;
                   document.getElementById('net_price').innerHTML=net_price.toFixed(2);
               }
                
            }else{
                 document.getElementById('product_price').innerHTML=total.toFixed(2);
                  total_price=document.getElementById('add_on_price').innerHTML;
               if(total_price !=null){
                  const total_net= Number(total_price)*exact_quantity
                   net_price=Number(total_net)+total;
                   document.getElementById('net_price').innerHTML=net_price.toFixed(2);
               }
            }
           
           
        }
         function plus(){
           const price= parseFloat(document.getElementById('fixed_price').innerHTML);
            const quantity= parseFloat(document.getElementById('quantity_value').value);
            const exact_quantity=quantity+1;
            const total= price*exact_quantity
            document.getElementById('product_price').innerHTML=total.toFixed(2);
              total_price=document.getElementById('add_on_price').innerHTML;
               if(total_price !=null){
                  const total_net= Number(total_price)*exact_quantity
                   net_price=Number(total_net)+total;
                   document.getElementById('net_price').innerHTML=net_price.toFixed(2);
               }
        }
        
//       function checkbox_click(id) {
  
//     // console.log(id);
//   check=document.getElementById(id);
//   addon='addon_price_'+id;
//       const price =parseFloat(document.getElementById(addon).innerHTML); // Use parseFloat for decimal values
//       let total = parseFloat(document.getElementById('add_on_price').innerHTML);
       
        

// // console.log(price);
//       if (check.checked) {
        
//         total += price;
//          // console.log(total);
        
               
             
//               document.getElementById('add_on_price').innerHTML=total;
//               total_product= document.getElementById('product_price').innerHTML;
//               totals=Number(total_product)+total;
//               document.getElementById('net_price').innerHTML=totals;
              
        
          
//       } else {
//           total -= price;
//           document.getElementById('addon_text').innerHTML='Addon Price';
//               document.getElementById('add_on_price').innerHTML=total;
//               total_product= document.getElementById('product_price').innerHTML;
//               totals=Number(total_product)+total;
//               document.getElementById('net_price').innerHTML=totals;
//       }

//     //   document.getElementById('product_price').innerHTML = total; // Display total with two decimal places
//     }
//   function add_to_cart(){
//       cart=[];
//       insert={
//           'product_name': document.getElementById('productname').innerHTML,
//           'product_description': document.getElementById('productdescription').innerHTML,
//           'product_quantity':document.getElementById('quantity_value').value,
//           'product_net_total':document.getElementById('net_price').innerHTML,
//       }
//       // console.log(insert);
//   }
  
// //   	$(document).ready(function(){
// // 		    $('.count').prop('disabled', true);
// //   			$(document).on('click','.plus2',function(){
// // 				$('.count').val(parseInt($('.count').val()) + 1 );
// //     		});
// //         	$(document).on('click','.minus2',function(){
// //     			$('.count').val(parseInt($('.count').val()) - 1 );
// //     				if ($('.count').val() == 0) {
// // 						$('.count').val(1);
// // 					}
// //     	    	});
// //  		});
 		
 		
//  		function minus2(id){
//  		    qty='qty_'+id;
//  		    count=parseInt(document.getElementById(qty).value)-1;
//  		    price=parseFloat(document.getElementById(id).value);
//  		    // console.log(count);
//  		    if(count > 0){
//  		         // console.log(count+count);
//  		          document.getElementById(qty).value= count
//  		    }else{
//  		         document.getElementById(qty).value= 0;
//  		         count=count+1
 		         
//  		    }
 		   
 		    
//  		      total=count*price;
//  		        document.getElementById('addon_price_'+id).innerHTML=total
 		       
 		  
 		   
//  		}
//  			function plus2(id){
//  			       qty='qty_'+id;
//  		    count=parseInt(document.getElementById(qty).value)+1;
//  		       price=parseFloat(document.getElementById(id).value);
//  		       document.getElementById(qty).value= count
 		      
//  		      total=count*price;
//  		       document.getElementById('addon_price_'+id).innerHTML=total
//  		       // console.log(  document.getElementById('addon_price_'+id).innerHTML=total)
//  		      check=document.getElementById(id);
 		   
//   addon='addon_price_'+id;
//       const price2 =parseFloat(document.getElementById(addon).innerHTML); // Use parseFloat for decimal values
//       let total2 = parseFloat(document.getElementById('add_on_price').innerHTML);
       
        

// // console.log(price2);
//       if (check.checked) {
        
//         total2 += price2;
//          // console.log(total2);
        
               
             
//               document.getElementById('add_on_price').innerHTML=total2;
//               total_product= document.getElementById('product_price').innerHTML;
//               totals=Number(total_product)+total2;
//               document.getElementById('net_price').innerHTML=totals;
              
        
          
//       }
//  		   // console.log(total2);
 		  
//  		}

const selectedAddons = [];

function plus2(checkboxId) {
    const qtyInput = document.getElementById(`qty_${checkboxId}`);
    const quantity = parseInt(qtyInput.value) + 1;
     price=parseFloat(document.getElementById(checkboxId).value);
       const quantity_value= parseFloat(document.getElementById('quantity_value').value);
    qtyInput.value = quantity;
      total=quantity*price;
		        document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
		        
    updateAddon(checkboxId, quantity);
    net_addon=parseFloat(document.getElementById('add_on_price').innerHTML);
    net_price=parseFloat(document.getElementById('product_price').innerHTML);
    
     net_total=net_price+(net_addon*quantity_value);
    // console.log('net_addon'+  net_addon);
    // console.log('net_price'+  net_price);
    // console.log('net_total'+ net_total);
  
   document.getElementById('net_price').innerHTML=net_total.toFixed(2);
}

function minus2(checkboxId) {
    const qtyInput = document.getElementById(`qty_${checkboxId}`);
    const quantity = parseInt(qtyInput.value);
     const price=parseFloat(document.getElementById(checkboxId).value);
       const quantity_value= parseFloat(document.getElementById('quantity_value').value);
    if (quantity > 0) {
        qtyInput.value = quantity - 1;
        
      total=parseInt(qtyInput.value)*price;
		        document.getElementById('addon_price_'+checkboxId).innerHTML=total
        updateAddon(checkboxId, quantity - 1);
          net_addon=parseFloat(document.getElementById('add_on_price').innerHTML);
    net_price=parseFloat(document.getElementById('product_price').innerHTML);
    
    net_total=net_price+(net_addon*quantity_value);
    // console.log('net_addon'+  net_addon);
    // console.log('net_price'+  net_price);
    // console.log('net_total'+ net_total);
  
   document.getElementById('net_price').innerHTML=net_total.toFixed(2);
  
   
    }
}

function updateAddon(checkboxId, quantity) {
    const nameElement = document.getElementById(`name_${checkboxId}`);
    const qtyInput = document.getElementById(`qty_${checkboxId}`);
    const addonPriceElement = document.getElementById(`addon_price_${checkboxId}`);
      const ids = document.getElementById(`as_${checkboxId}`);
      console.log(ids);
    
    const name = nameElement.textContent;
    const qty = parseInt(qtyInput.value);
    const price = parseFloat(addonPriceElement.textContent);
    const id = parseFloat(ids.value);

    const existingAddonIndex = selectedAddons.findIndex(item => item.as_name === name);
    if (existingAddonIndex !== -1) {
        if (quantity === 0) {
            selectedAddons.splice(existingAddonIndex, 1);
        } else {
            selectedAddons[existingAddonIndex].quantity = quantity;
            selectedAddons[existingAddonIndex].totalPrice = price;
        }
    } else if (quantity > 0) {
        selectedAddons.push({
            as_name: name,
            as_id:id,
            quantity: quantity,
            as_price:price,
            sum: price * quantity,
            totalPrice: price * quantity,
            
        });
    }
let totalPrice = 0;
    for (const addon of selectedAddons) {
        totalPrice += addon.totalPrice;
    }
    document.getElementById('add_on_price').innerHTML=totalPrice.toFixed(2);
    
    
}





function type_checkbox_click(checkboxId) {
    const checkbox = document.getElementById(`checkbox_${checkboxId}`);
    const title=document.getElementById('type-title');
     const id=document.getElementById(`ts_${checkboxId}`);
     console.log(id);
    const typeNameElement = document.getElementById(`type_name_${checkboxId}`);

    if (checkbox.checked) {
        const typeName = typeNameElement.innerHTML;
        const ids = id.value;
        const titles = title.innerHTML;
        typeArray.push({
            ts_name: typeName,
            ts_id:ids,
            type_title: titles,
            
        });
    } else {
        const typeName = typeNameElement.innerHTML;
        const index = typeArray.indexOf(ts_name);
        if (index !== -1) {
            typeArray.splice(index, 1);
        }
    }

    // Display the updated type array for testing
    
}

function dressing_click(checkboxId) {
    const checkbox = document.getElementById(`dressing_${checkboxId}`);
     const title=document.getElementById('dressing-title');
     const id=document.getElementById(`ds_${checkboxId}`);
     console.log(id);
    const typeNameElement = document.getElementById(`dressing_name_${checkboxId}`);

    if (checkbox.checked) {
        const typeName = typeNameElement.innerHTML;
        const ids = id.value;
        const titles = title.innerHTML;
        dressingArray.push({
            dressing_name: typeName,
            ds_id:ids,
            dressing_title: titles,
            
        });
    } else {
        const typeName = typeNameElement.innerHTML;
        const index = dressingArray.indexOf(typeName);
        if (index !== -1) {
            dressingArray.splice(index, 1);
        }
       
    }
 // console.log(dressingArray)
    // Display the updated type array for testing
    
}
// function add_to_cart(){
//       cart=[];
//       const productImageElement = document.getElementById('product_img');
//     let productImageSrc = productImageElement.src;

//       insert={
//           'product_name': document.getElementById('productname').innerHTML,
//           'product_description': document.getElementById('productdescription').innerHTML,
//           'product_quantity':document.getElementById('quantity_value').value,
//           'product_image':productImageSrc,
//           'product_net_total':document.getElementById('net_price').innerHTML,
//           'addons':selectedAddons,
//           'type':typeArray,
//           'dressing':dressingArray
//       }
//       cart.push(insert);
      
    
      
//   }


function add_to_cart() {
    const productImageElement = document.getElementById('product_img');
    let productImageSrc = productImageElement.src;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const newCartItem = {
        'id':document.getElementById('pro_id').value,
        'product_id':document.getElementById('pro_id').value,
        'product_name': document.getElementById('productname').innerHTML,
        'product_description': document.getElementById('productdescription').innerHTML,
        'product_quantity': document.getElementById('quantity_value').value,
        'quantity': document.getElementById('quantity_value').value,
         'cost': document.getElementById('cost').value,
          'discount': document.getElementById('discount').value,
          'price': document.getElementById('pro_pri').value,
        'product_image': productImageSrc,
        'product_net_total': document.getElementById('net_price').innerHTML,
        'addons': selectedAddons,
        'types': typeArray,
        'dressing': dressingArray
    };

    // Check if a similar item exists in the cart
    const existingCartItemIndex = cart.findIndex(item =>
        item.product_name === newCartItem.product_name &&
        item.product_description === newCartItem.product_description &&
        item.product_image === newCartItem.product_image &&
        JSON.stringify(item.addons) === JSON.stringify(newCartItem.addons) &&
        JSON.stringify(item.types) === JSON.stringify(newCartItem.types) &&
        JSON.stringify(item.dressing) === JSON.stringify(newCartItem.dressing)
    );
   // console.log(JSON.stringify(newCartItem.addons))
// console.log( existingCartItemIndex);
    if (existingCartItemIndex !== -1) {
        // Update quantities and total for the existing item
        cart[existingCartItemIndex].product_quantity = (
            parseInt(cart[existingCartItemIndex].product_quantity) +
            parseInt(newCartItem.product_quantity)
        ).toString();
        cart[existingCartItemIndex].quantity = (
            parseInt(cart[existingCartItemIndex].quantity) +
            parseInt(newCartItem.quantity)
        ).toString();
        cart[existingCartItemIndex].product_net_total = (
            parseFloat(cart[existingCartItemIndex].product_net_total) +
            parseFloat(newCartItem.product_net_total)
        ).toFixed(2);
    } else {
        // Push the new item to the cart
        cart.push(newCartItem);
    }
 $(".alert").addClass("alert-info");
          document.getElementById('error_alert').innerHTML='Erfolgreich in den Warenkorb gelegt';
         $('.alert').show();
         setTimeout(removeDiv, 5000);
  
    console.log( cart);
    
    // Save the updated cart to local storage
    localStorage.setItem('cart', JSON.stringify(cart));
     let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
    
    
    data ='';
  
   for(let i=0;i<cart2.length;i++){
        if(cart2[i].is_deal == 'yes'){
            data+=`<div class="cart_bar">
        
                <p>${cart2[i].product_quantity}x </p>
           
         
                <div class="cart_img">
                    <img src="${cart2[i].product_image}" class="img-thumbnail" alt="">
                </div>
           
                <div class="cart_title">
                    <p style="font-size: 12px;">${cart2[i].product_name}</p>
                </div>
           <div class="cart_price">
                <p>€ ${cart2[i].product_net_total}</p>
               </div>
          <div class="delete_button">
                <p style="color: red;font-size:15px" onclick="remove_product('${i}')"><i class="fa fa-trash" aria-hidden="true"></i></p>
               </div>
            </div><p style="color: red;font-size:10px;text-align:center;height: 15px;
           margin-top: -15px;cursor:pointer;" onclick="show_more_deal('${i}')">Show more</p>
            <div class="details_cart">
           
                    <div class='addon_cart' id='addon_cart_deal_${i}'></div>
                    
            </div>`
        }else{
             data+=`<div class="cart_bar">
        
                <p>${cart2[i].product_quantity}x </p>
           
         
                <div class="cart_img">
                    <img src="${cart2[i].product_image}" class="img-thumbnail" alt="">
                </div>
           
                <div class="cart_title">
                    <p style="font-size: 12px;">${cart2[i].product_name}</p>
                </div>
           <div class="cart_price">
                <p>€ ${cart2[i].product_net_total}</p>
               </div>
          <div class="delete_button">
                <p style="color: red;font-size:15px" onclick="remove_product('${i}')"><i class="fa fa-trash" aria-hidden="true"></i></p>
               </div>
            </div><p style="color: red;font-size:10px;text-align:center;height: 15px;
           margin-top: -15px;cursor:pointer;" onclick="show_more('${i}')">Show more</p>
            <div class="details_cart">
            <p style='font_size:12px;font-weight:900' id='addons_txt_${i}'></p>
            <div class='addon_cart' id='addon_cart_${i}'>
            
            </div>
            <p style='font_size:12px;font-weight:900' id='type_txt_${i}'></p>
             <div class='type_cart' id='type_cart_${i}'>
            </div>
            <p style='font_size:12px;font-weight:900' id='dressing_txt_${i}'></p>
             <div class='dressing_cart' id='dressing_cart_${i}'>
            </div>
            </div>`
        }
   }
    
    document.getElementById("cart_bar").innerHTML=data;
    let totalPrice = 0;
    for (const addon of cart) {
        totalPrice += parseFloat(addon.product_net_total);
        
    }
    document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
    console.log(cart.length)
if(cart.length>0){
     document.getElementById("cart_count").innerHTML = cart.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
let address = JSON.parse(localStorage.getItem('address'));
   if(address != null){
  let data_address='';

    let min_order=parseInt(address.min_order);
    if(totalPrice < address.min_order ){
        let shipping=10;
        totalPrice= toFixed(totalPrice)+shipping
        document.getElementById('add_cart_shipping').innerHTML=totalPrice.toFixed(2);
         document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
    }else{
        document.getElementById('add_cart_shipping').innerHTML=0;
    }}
    // console.log(cart);
}


function removeDiv() {
    var element = document.getElementById("myElement");
    if (element.classList.contains("alert-danger")) {
            // Step 3: If it has the class, remove it.
             $('.alert').removeClass("alert-danger");
        }
          if (element.classList.contains("alert-info")) {
            // Step 3: If it has the class, remove it.
             $('.alert').removeClass("alert-info");
        }
  
 $('.alert').hide();
 // Hide the div
}

function pickup(){
     localStorage.removeItem("order_type");
     var formdata3 = new FormData();
formdata3.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata3,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/check_restruant_timings.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.status === true) {
     localStorage.setItem('order_type', JSON.stringify('pickup'));
      document.getElementById("modal-body-pickup").innerHTML=result.Message+`<br>  <footer>
              
               </footer>`
    } else {
        document.getElementById("modal-body-pickup").innerHTML=result.Message
    
    }
  })
  .catch(error => console.error('error', error));
  
}


function delivery(){
    localStorage.removeItem("order_type");
     var formdata3 = new FormData();
formdata3.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata3,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/check_restruant_timings.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.status === true) {
     localStorage.setItem('order_type', JSON.stringify('delivery'));
      document.getElementById("modal-body-delivery").innerHTML=result.Message+`<br>  <footer>
              
               </footer>`
    } else {
        document.getElementById("modal-body-delivery").innerHTML=result.Message+`<br>  <footer style='display:flex;padding:5px;'>
               <button type="button" class='btn btn-warning' data-dismiss="modal"  style='font-size:17px;font-weight:bolder;text-align:center;'>Ok</button>

               </footer>`
    
    }
  })
  .catch(error => console.error('error', error));
  
}


function okdelivery(){
     localStorage.setItem('order_type', JSON.stringify('delivery'));
}