
$(document).ready(function() {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        return false;
    });
    
    
});

 var o = JSON.parse(localStorage.getItem("order_type"));
 if(o === null){
      document.getElementById("delivery").style.backgroundColor='#ffc107';
      document.getElementById("pickup").style.backgroundColor='#ffc107';
    
 }else{
      console.log(o )
     console.log(o == "delivery" )
     if(o === 'delivery'){
          document.getElementById("delivery").style.backgroundColor='green';
      document.getElementById("pickup").style.backgroundColor='transparent';
     }else if(o === 'pickup') {
         document.getElementById("pickup").style.backgroundColor='green';
      document.getElementById("delivery").style.backgroundColor='transparent';
     }
 }

var selector = '.navbar-nav li';

$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

document.addEventListener('DOMContentLoaded', function () {
    // Your code that manipulates the DOM goes here
    show_more_deal(); // Call your function here if needed
});



let usercheck=JSON.parse(localStorage.getItem('USER'));
console.log(usercheck)
if(usercheck == null){
     document.getElementById("auth").innerHTML=` <a class="nav-link" href="auth.html">Register/Login</a>`
}else{
     document.getElementById("auth").innerHTML=` <a class="nav-link" onclick='logout()'>Logout</a>`
}
function logout(){
      localStorage.clear();
  
  // Redirect the user to the home page
  window.location.href = 'index.html'; 
}



let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
console.log(cart2.length)
if(cart2.length>0){
     document.getElementById("cart_count").innerHTML = cart2.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
function openNav() {
       let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
    document.getElementById("mySidebar").style.width = "340px";

    
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
           margin-top: -15px;cursor:pointer;" onclick="show_more_deal('${i}')">Zeig mehr</p>
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
           margin-top: -15px;cursor:pointer;" onclick="show_more('${i}')">Zeig mehr</p>
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
     for (const addon of cart2) {
        totalPrice += parseFloat(addon.product_net_total);
        
    }
    document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
  
console.log(cart2.length)
if(cart2.length>0){
     document.getElementById("cart_count").innerHTML = cart2.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
  let address = JSON.parse(localStorage.getItem('address'));
   if(address != null){
  let data_address='';
 data_address+=` <p style="margin-left: 5px;"><strong>Address 1: </strong>${address.address1}<br><strong>Address 2: </strong>${address.address2}<br><strong>City: </strong>${address.city}<br><strong>Area: </strong>${address.area}<br><strong>Postal Code: </strong>${address.postal_code}</p>`
    document.getElementById("add_info").innerHTML =data_address;
    let min_order=parseInt(address.min_order);
    if(totalPrice < address.min_order ){
        let shipping=10;
        totalPrice= parseInt(totalPrice)+shipping
        document.getElementById('add_cart_shipping').innerHTML=shipping;
         document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
          localStorage.setItem('shipping', JSON.stringify(shipping));
    }else{
        document.getElementById('add_cart_shipping').innerHTML=0;
         localStorage.setItem('shipping', JSON.stringify(0));
    }
    
     
   }else{
         document.getElementById("add_info").innerHTML =null;
     }
  }
  function show_more_deal(i){
    let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
//     if(cart2[i].is_deal == 'yes' ){
//         let info=cart2[i];
//      console.log(info)
//      if(info.length > 0){
//     for(let x = 0; x < info.length; x++){
//         console.log(info[x].prod.name);
//     }
// }
//     }
// if (cart2[i].is_deal === 'yes') {
//     if (cart2[i].product_name) { // Check if deal_name property exists
//         let info = cart2[i].deal_items;

//         console.log(info);
//         if (info.length > 0) {
//             var data='';
//             for (let x = 0; x < info.length; x++) {
//                 console.log(info[x].prod_name);
               
//          data+=`<div style='font_size:12px;font-weight:900' id='addons_prod_deal_${i}'>${info[x].prod_name}</div>
//             <p style='font_size:12px;font-weight:900' id='addons_txt_deal_${i}'></p>
//             <div class='addon_cart' id='addon_cart_deal_${i}'>
            
//             </div>
              
//             <p style='font_size:12px;font-weight:900' id='type_txt_deal_${i}'></p>
//              <div class='type_cart' id='type_cart_deal_${i}'>
//             </div>
             
//             <p style='font_size:12px;font-weight:900' id='dressing_txt_deal_${i}'></p>
//              <div class='dressing_cart' id='dressing_cart_deal_${i}'>
//             </div>`
              
            
//             document.getElementById('details_cart').innerHTML=data;
//              for(let j = 0; j < info[x].items_prdoucts['0'].addons.length; x++){
//           data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
//                     <p style="margin-left: 5px;" id="addon_quantity_cart_${checkboxId}">${resp.quantity}</p> 
//                     <p style="margin-left: 5px;" id="addon_name_cart_${checkboxId}">${resp.as_name}</p>
//                       <p style="margin-left: auto;text-align:left;" id="addon_price_cart_${checkboxId}">$ ${resp.totalPrice}</p> 
//                   </div>`
//                              }
//                              // // console.log(info.length);
//                               document.getElementById('addon_cart_'+index).innerHTML =data2;
//         }
//     } else {
//         console.log('deal_name is not defined for this item.');
//     }
// }






// }
if (cart2[i].is_deal === 'yes') {
    if (cart2[i].product_name) { // Check if deal_name property exists
        let info = cart2[i].deal_items;

        console.log(info);
        if (info.length > 0) {
            let data = '';
           for (let i = 0; i < cart2.length; i++) {
    if (cart2[i].is_deal === 'yes') {
        if (cart2[i].product_name) { // Check if product_name property exists
            let info = cart2[i].deal_items;
            console.log(info);
            if (info.length > 0) {
                let itemHTML = ''; // Initialize itemHTML here

               for (let x = 0; x < info.length; x++) {
    let cartItem = info[x];
    console.log(cartItem.prod_name);
    
    // Assuming 'x' is the index of the current cart item
    itemHTML += `<span style='font-weight:bolder;color:#ffc107;'>${cartItem.prod_name}</span><br>`;
    
    let addonsDisplayed = false; // Add a flag to track if the "Addons" title has been displayed
    
    for (let j = 0; j < cartItem.items_products.length; j++) {
        let product = cartItem.items_products[j];
        
        if (product.addons) {
            for (let k = 0; k < product.addons.length; k++) {
                if (!addonsDisplayed) {
                    // Display the "Addons" title only if it hasn't been displayed yet for this cart item
                    itemHTML += `<span style='font-weight:bolder;color:red;'>Add-ons</span><br>`;
                    addonsDisplayed = true; // Set the flag to true to indicate the "Addons" title has been displayed
                }

                let resp = product.addons[k];
                console.log(resp);

                itemHTML += `<div class="mb-0" style="display: flex; width: 100%;">
                    <p style="margin-left: 5px;" id="addon_quantity_cart_${k}">${resp.quantity}</p>
                    <p style="margin-left: 5px;" id="addon_name_cart_${k}">${resp.as_name}</p>
                    <p style="margin-left: auto; text-align: left;" id="addon_price_cart_${k}">€ ${resp.totalPrice}</p>
                </div>`;
            }
        }
         if (product.type) {
            for (let k = 0; k < product.type.length; k++) {
                if (!addonsDisplayed) {
                    // Display the "Addons" title only if it hasn't been displayed yet for this cart item
                    itemHTML += `<span style='font-weight:bolder;color:red;'>Typ</span><br>`;
                    addonsDisplayed = true; // Set the flag to true to indicate the "Addons" title has been displayed
                }

                let resp = product.type[k];
                console.log(resp);

                itemHTML += `<div class="mb-0" style="display: flex; width: 100%;">
                   <p style="margin-left: 5px;" id="addon_name_cart_${k}">${resp.ts_name}</p>
                   
                </div>`;
            }
        }
         if (product.dressing) {
            for (let k = 0; k < product.dressing.length; k++) {
                if (!addonsDisplayed) {
                    // Display the "Addons" title only if it hasn't been displayed yet for this cart item
                    itemHTML += `<span style='font-weight:bolder;color:red;'>Dressing</span><br>`;
                    addonsDisplayed = true; // Set the flag to true to indicate the "Addons" title has been displayed
                }

                let resp = product.dressing[k];
                console.log(resp);

                itemHTML += `<div class="mb-0" style="display: flex; width: 100%;">
                 <p style="margin-left: 5px;" id="addon_name_cart_${k}">${resp.dressing_name}</p>
                   
                </div>`;
            }
        }
    }
}

                const addonCartElement = document.getElementById(`addon_cart_deal_${i}`);
                if (addonCartElement) {
                    console.log(itemHTML);
                    addonCartElement.innerHTML = itemHTML;
                } else {
                    console.error(`Element not found: addon_cart_deal_${i}`);
                }
            }
        } else {
            console.log('product_name is not defined for this item.');
        }
    }
}
          
        }
    } else {
        console.log('product_name is not defined for this item.');
    }
}


if(cart2.length>0){
     document.getElementById("cart_count").innerHTML = cart2.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
}
  function show_more(index){
     let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
     let info=cart2[index].addons;
      let info_type=cart2[index].types;
       let info_dressing=cart2[index].dressing;
     // // console.log(info);
     if(info.length>0){
                                  document.getElementById('addons_txt_'+index).innerHTML='Addons';
                             data2='';
                          
                            info.forEach(function(resp, index){
                                  const checkboxId = `${index + 1}`;
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                    <p style="margin-left: 5px;" id="addon_quantity_cart_${checkboxId}">${resp.quantity}</p> 
                    <p style="margin-left: 5px;" id="addon_name_cart_${checkboxId}">${resp.as_name}</p>
                      <p style="margin-left: auto;text-align:left;" id="addon_price_cart_${checkboxId}">€ ${resp.totalPrice}</p> 
                  </div>`
                             })
                             // // console.log(info.length);
                              document.getElementById('addon_cart_'+index).innerHTML =data2;
     }       // // console.log(info_type.length);
                               if(info_type.length>0){
                                  document.getElementById('type_txt_'+index).innerHTML='Type';
                             data2='';
                          
                           info_type.forEach(function(resp, index){
                                  const checkboxId = `${index + 1}`;
                                 
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                    <p style="margin-left: 5px;" id="addon_name_cart_${checkboxId}">${resp.ts_name}</p>
                    
                  </div>`
                             })
                              // // console.log(info_type.length);
                    document.getElementById('type_cart_'+index).innerHTML =data2
                               }
                                 if(info_dressing.length>0){
                                  document.getElementById('dressing_txt_'+index).innerHTML='Dressing';
                             data2='';
                          
                            info_dressing.forEach(function(resp, index){
                                  const checkboxId = `${index + 1}`;
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                    <p style="margin-left: 5px;" id="addon_name_cart_${checkboxId}">${resp.dressing_name}</p>
                    
                  </div>`
                             })
                              // // console.log(info_dressing.length);
                              document.getElementById('dressing_cart_'+index).innerHTML =data2;
  }
      console.log(cart2.length)
if(cart2.length>0){
     document.getElementById("cart_count").innerHTML = cart2.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
  }
  function remove_product(index){
      let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
      cart2.splice(index,1);
      localStorage.setItem('cart', JSON.stringify(cart2));
   
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
           margin-top: -15px;cursor:pointer;" onclick="show_more_deal('${i}')">Zeig mehr</p>
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
           margin-top: -15px;cursor:pointer;" onclick="show_more('${i}')">Zeig mehr</p>
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
     for (const addon of cart2) {
        totalPrice += parseFloat(addon.product_net_total);
        
    }
    document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
    // // console.log("Item removed successfully.");
    console.log(cart2.length)
if(cart2.length>0){
     document.getElementById("cart_count").innerHTML = cart2.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
let address = JSON.parse(localStorage.getItem('address'));
   if(address != null){
  let data_address='';

    let min_order=parseInt(address.min_order);
    if(totalPrice < address.min_order ){
        let shipping=10;
        totalPrice= parseInt(totalPrice)+shipping
        document.getElementById('add_cart_shipping').innerHTML=shipping.toFixed(2);
         document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
          

      localStorage.setItem('shipping', JSON.stringify(shipping));
    }else{
        document.getElementById('add_cart_shipping').innerHTML=0;
         localStorage.setItem('shipping', JSON.stringify(0));
    }
  }
  }
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    console.log(cart2.length)
if(cart2.length>0){
     document.getElementById("cart_count").innerHTML = cart2.length;
}else{
    document.getElementById("cart_count").innerHTML = 0;
}
  }


const rightBtn = document.querySelector('#right-button');
const leftBtn = document.querySelector('#left-button');

rightBtn.addEventListener("click", function(event) {
  const conent = document.querySelector('#content');
  conent.scrollLeft += 500;
  event.preventDefault();
});

leftBtn.addEventListener("click", function(event) {
  const conent = document.querySelector('#content');
  conent.scrollLeft -= 500;
  event.preventDefault();
});

//   const token={
//     token:'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC',
//   }

//   const req=new XMLHttpRequest();
//   req.open('POST','https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/get_deals.php');

//   req.setRequestHeader('Content-Type', 'application/json');

// //   Set up CORS-related headers
//   req.setRequestHeader('Access-Control-Allow-Origin', '*');
//   req.setRequestHeader('Access-Control-Allow-Headers', 'Content-Type');
//   req.send(JSON.stringify(token))
//   req.addEventListener('load',function(){
     
//     if(req.status===200){
//         const res =JSON.parse(req.responseText);
//         // // console.log(res);
//     }else{
//         throw new Error('bad request');
//     }
      
//   })
  
//   const token = {
//   token: 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC',
// };

// const requestOptions = {
//   method: 'POST',
//   body:{token:'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC',},
// };
// // // console.log('Request:', requestOptions);
// fetch('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/get_deals.php', requestOptions)
//   .then(response => {
//     if (response.ok) {
//       return response.json();
//     } else {
//       throw new Error('Bad request');
//     }
//   })
//   .then(data => {
//     // // console.log(data);
//   })
//   .catch(error => {
//     console.error(error);
//   });
var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};
let deals_data='';
fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/get_deals.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.status === true) {
      var dealsData = result.deals_data; 
      deals_data=dealsData// Extract deals_data from the result
      var data=''
         dealsData.forEach(function(resp){
               const formattedPrice = Number(resp.deal_price).toFixed(2);
             data+=` <div class="col-md-6 col-lg-4 col-xl-3 col-sm-12 mt-3">
        <center>
        <div class="product-card" onclick='button_deal(${resp.deal_id})'>
            <div class="badge">Hot</div>
            <div class="product-tumb">
                <img src="https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${resp.deal_image}" alt="">
            </div>
            <div class="product-details">
              
                <h4 style='font-size:15px;overflow: hidden;text-overflow: ellipsis;white-space:nowrap;position: relative;'><a href="">${resp.deal_name}</a></h4>
                <p style='height:50px;height:75px;overflow: hidden;text-overflow: ellipsis;white-space: normal;position: relative;'>${resp.deal_description}</p>
                <div class="product-bottom-details">
                    <div class="product-price">€ ${formattedPrice}</div>
                    <div class="product-links">
                        
                        <a onclick='button_deal(${resp.deal_id})'><i class="fa fa-shopping-cart"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </center>
    </div>`
         })
         
      document.getElementById('product_deal').innerHTML=data;
      // // console.log(data);

      // Now you can work with the extracted deals_data array
    } else {
      console.error("Error:", result);
    }
  })
  .catch(error => console.error('error', error));
var formdata2 = new FormData();
formdata2.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata2,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/productlist_by_discount.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.Status === true) {
      var dealsData = result.Data; // Extract deals_data from the result
      var data = '';

      dealsData.forEach(function(resp) {
            const formattedPrice = Number(resp.price).toFixed(2);
        data += `<div class="col-md-6 col-lg-4 col-xl-3 col-sm-12 mt-3">
          <center>
            <div class="product-card" onclick='further_detail(${resp.id})'>
              <div class="badge">${resp.discount}%</div>
              <div class="product-tumb">
                <img src="https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${resp.image}" alt="">
              </div>
              <div class="product-details">
                <h4 style='font-size:15px;overflow: hidden;text-overflow: ellipsis;white-space:nowrap;position: relative;'><a href="">${resp.name}</a></h4>
                <p  style='height:50px;height:75px;overflow: hidden;text-overflow: ellipsis;white-space: normal;position: relative;'>${resp.description}</p>
                <div class="product-bottom-details">
                  <div class="product-price">€ ${formattedPrice}</div>
                  <div class="product-links">
                  
                    <a onclick='further_detail(${resp.id})'><i class="fa fa-shopping-cart"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </center>
        </div>`;
      });

      document.getElementById('product_discount').innerHTML = data;
      // // console.log(dealsData);
    } else {
      console.error("Error:", dealsData);
    }
  })
  .catch(error => console.error('error', error));
  
  
  
  var formdata3 = new FormData();
formdata3.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata3,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/getAll_subcategories.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.status === true) {
      var dealsData = result.Data; // Extract deals_data from the result
      var data = '';

      dealsData.forEach(function(resp) {
        data += `  <div class="internal">
              <button class="btn btn-warning box" type="button" onclick='show_category("${resp.id}", "${resp.name}")' style="border-radius:20px;width:auto;">${resp.name}</button>
            </div>`;
      });

      document.getElementById('content').innerHTML = data;
     
    } else {
      console.error("Error:", dealsData);
    }
  })
  .catch(error => console.error('error', error));
  
  
  function show_category(id,name){
   
      var formdata3 = new FormData();
formdata3.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");
formdata3.append("category_id", id);

var requestOptions = {
  method: 'POST',
  body: formdata3,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/get_products_by_categoryzz.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.status === true) {
      var dealsData = result.data; // Extract deals_data from the result
       document.getElementById('category_title').innerHTML = name;
      var data = '';

      dealsData.forEach(function(resp) {
            const formattedPrice = Number(resp.price).toFixed(2);
        data += `<div class="col-md-6 col-lg-4 col-xl-3 col-sm-12 mt-3">
          <center>
            <div class="product-card" onclick='further_detail(${resp.product_id})'>
              <div class="badge">${resp.discount}%</div>
              <div class="product-tumb">
                <img src="https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${resp.img}" alt="">
              </div>
              <div class="product-details">
                <h4 style='font-size:15px;overflow: hidden;text-overflow: ellipsis;white-space:nowrap;position: relative;'><a href="">${resp.name}</a></h4>
                <p  style='height: 75px;overflow: hidden;text-overflow: ellipsis;white-space: normal;position: relative;'>${resp.description}</p>
                <div class="product-bottom-details">
                  <div class="product-price">€ ${formattedPrice}</div>
                  <div class="product-links">
                   
                    <a href="#" onclick='further_detail(${resp.product_id})'><i class="fa fa-shopping-cart"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </center>
        </div>`;
      });

      document.getElementById('product_category').innerHTML = data;
     // // console.log(data);
    } else {
      console.error("Error:", dealsData);
    }
  })
  .catch(error => console.error('error', error));
  }
    function closeModal() {
  var modal = document.getElementById('myModalOrder');
  modal.style.display = 'none';
}

function closeModalcard() {
  var modal = document.getElementById('myModalAddress');
  modal.style.display = 'none';
    var modal_background = document.getElementsByClassName('modal-backdrop');
  
  // Iterate through the elements with the class "modal-backdrop"
  for (var i = 0; i < modal_background.length; i++) {
    modal_background[i].classList.remove('show');
}
}
function openModal() {
  var modal = document.getElementById('myModalOrder');
  modal.style.display = 'block';
}
  
  
  function cash(){
      var x = localStorage.getItem("cart");

// let cart=JSON.parse('x');


let cart=JSON.parse(x);
let total=0;
// console.log(total);
for(var a = 0 ; a < cart.length ; a++){
   var num = Number(cart[a].product_net_total)
 
    total+=num
  
}

 var a = localStorage.getItem("address");

// let cart=JSON.parse('x');


let address=JSON.parse(a);
var u = localStorage.getItem("USER");

// let cart=JSON.parse('x');
var o = localStorage.getItem("order_type");
let type=JSON.parse(o);

let user=JSON.parse(u);
let additionNotes='';
 let shippingcost = JSON.parse(localStorage.getItem('shipping'));
console.log(shippingcost)
console.log(user.user_id);
console.log(address.address1);
console.log(address.address2);
console.log(address.city);
console.log(address.area);
console.log(address.state);
console.log(total);
console.log(address.postal_code);
console.log(cart);

  var formdata = new FormData();

// Append data to the FormData object
formdata.append('user_id', user.user_id);
formdata.append('token', 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC');
formdata.append('Shipping_address', address.address1);
formdata.append('Shipping_address_2', address.address2);
formdata.append('Shipping_city', address.city);
formdata.append('Shipping_area', address.area);
formdata.append('Shipping_state', address.state);
formdata.append('order_total_price', total);
formdata.append('payment_type', 'cash');
formdata.append('order_type', type);
formdata.append('payment_method', 'cash');
formdata.append('payment_status', 'unpaid');
formdata.append('additional_notes', additionNotes); // Fixed typo: 'addtional_notes' to 'additional_notes'
formdata.append('Shipping_cost', shippingcost);
formdata.append('Shipping_postal_code', address.postal_code);
formdata.append('order_datails', x); // Fixed typo: 'order_datails' to 'order_details'

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/placeOrder_zee.php', requestOptions)
  .then(response => {
  if (!response.ok) {
    throw new Error('Network response was not ok');
  }
  return response.text(); // Get the response content as text
})
.then(responseText => {
  var message = responseText;

  // Attempt to parse responseText as JSON if it's not empty
  if (responseText.trim() !== '') {
    return JSON.parse(responseText);
  }
  return null; // Return null if the response is empty
})
.then(result => {
  if (result !== null) {
    // Show the message from the response in an alert
    closeModalcard();
    openModal();
    $('#myModalOrder').modal('show');
    document.getElementById('modal-body-order').innerHTML=result[0].Message;
    console.log('Result:', result);
     localStorage.removeItem("cart");
  setTimeout(function() {
  window.location.href = 'index.html';
}, 4000);
  } else {
    console.log('Response is empty or not JSON.');
  }
})
.catch(error => {
  console.error('Error:', error.message);
});
  }
  
  function profile_btn_address(){
      var u = localStorage.getItem("USER");

// let cart=JSON.parse('x');


let user=JSON.parse(u);

if(u!=null){
  window.location.href = "address.html";
}else{
    alert('Bitte loggen Sie sich zuerst ein')
}
  }
  
  function profile_btn(){
      var u = localStorage.getItem("USER");

// let cart=JSON.parse('x');


let user=JSON.parse(u);

if(u!=null){
  window.location.href = "profile.html";
}else{
    alert('Bitte loggen Sie sich zuerst ein')
}
  }
  
  
  
  function checkout(){
       var o = localStorage.getItem("order_type");
      
        var u = localStorage.getItem("USER");
// let cart=JSON.parse('x');
let user=JSON.parse(u);

var a = localStorage.getItem("address");

let address=JSON.parse(a);
 var x = localStorage.getItem("cart");





if(x!=null && x.length>2){
  if(u!=null && a!=null){
   if(o != null){
        let shippingcost=document.getElementById('add_cart_shipping').innerHTML;
console.log(shippingcost)
      localStorage.setItem('shipping', JSON.stringify(shippingcost));
  window.location.href = "paypal.html";
   }else{
         alert('Wählen Sie den Bestelltyp aus')
   }
    
}else{
    alert('Bitte melden Sie sich zuerst an oder fügen Sie die vollständige Adresse hinzu')
} 
}else{
      alert('Einkaufswagen ist leer')
}



  }
  
  
 

  
//   function strip_payment(){
//       var stripe = Stripe('pk_test_51KsK97HmIepslB4LEJkmrrFr3zQw4CbcrKSxYQuktQVJlgfDyoaBsHok4tuHShl1EHEKc5nsoopEJ56b6iSRgMuD00PdiTFJJ6');
        //  var x = localStorage.getItem("cart");

// let cart=JSON.parse('x');


// let cart=JSON.parse(x);
// let total=0;
// // console.log(total);
// for(var a = 0 ; a < cart.length ; a++){
//   var num = Number(cart[a].product_net_total)
 
//     total+=num
  
// }


//   const transformedItems = cart.map((item) => ({
//     price_data: {
//       currency: "usd",
//       product_data: {
//         name: item.product_name,
//         images: item.product_image,
//         description: item.product_description,
//       },
//       unit_amount: item.price * 100,
//     },
//     quantity: item.qty,
//   }));

//   if (req.method === "POST") {
//     try {
//       // Create Checkout Sessions from body params.
//       const session = stripe.checkout.sessions.create({
//         line_items: transformedItems,
//         mode: "payment",
//         success_url: 'index.html',
//         cancel_url: `paypal.html.html`,
        
//       });
//       res.redirect(303, session.url);
//     } catch (err) {
//       res.status(err.statusCode || 500).json(err.message);
//     }
//   } else {
//     res.setHeader("Allow", "POST");
//     res.status(405).end("Method Not Allowed");
//   }
// }                        
 
//   function findDealById(id) {
//   for (var i = 0; i < deals_data.length; i++) {
     
//     if (deals_data[i].deal_id == id) {
//       return deals_data[i]; // Return the matched deal object
//     }
//   }
//   return null; // Return null if the deal is not found
// }

// // Function to handle the button click event
// function button_deal(id) {
//   var deal = findDealById(id);

//   if (deal) {
//     console.log('Deal found:', deal);
//     // Here, you can do something with the found deal object
//   } else {
//     console.log('Deal not found');
//   }
// }


function button_deal(id) {
      window.location.href = `deal.html?id=${id}`;
}
function manage_address(){
     let address = JSON.parse(localStorage.getItem('Address')) || [];
     if(address.length>0){
         let data=''
         for(let i = 0 ; i < address.length; i++){
             data+=`<div class="mb-0" style="display: flex;width: 100%;background: #ffc107;
    padding: 5px;
    height: 150px;
    margin-top: 5px;border-radius: 10px;"> 
                      <p class="mb-0">  <input type= "checkbox" onclick='address_checkbox(${i})' id='address_checkbox_${i}' name= "language" value= "Cheese"></p> 
                    <p style="margin-left: 5px;"><strong>Address 1: </strong>${address[i].address1}<br><strong>Address 2: </strong>${address[i].address2}<br><strong>City: </strong>${address[i].city}<br><strong>Area: </strong>${address[i].area}<br><strong>Postal Code: </strong>${address[i].postal_code}</p>
                       <p style="margin-left: 5px;"><strong style='color:red;'>Min Order: </strong>€ ${address[i].min_order}</p>
                  </div>`
         }
         document.getElementById('modal-body').innerHTML = data;
     }else{
          document.getElementById('modal-body').innerHTML = 'No Address';
     }
}

function address_checkbox(i) {
    let address = JSON.parse(localStorage.getItem('Address'));
    let final_address=address[i];
    let checkbox = document.getElementById('address_checkbox_' + i);
    
    if (checkbox.checked) {
         localStorage.setItem('address', JSON.stringify(final_address));
    } else {
        final_address=null;
        localStorage.setItem('address', JSON.stringify(final_address));
        console.log('unchecked');
    }
     let address2 = JSON.parse(localStorage.getItem('address'));
     if(address2 != null){
          let data_address='';
 data_address+=` <p style="margin-left: 5px;"><strong>Address 1: </strong>${address2.address1}<br><strong>Address 2: </strong>${address2.address2}<br><strong>City: </strong>${address2.city}<br><strong>Area: </strong>${address2.area}<br><strong>Postal Code: </strong>${address2.postal_code}</p>`
    document.getElementById("add_info").innerHTML =data_address;
    let totalPrice =document.getElementById('add_cart_total').innerHTML
    let min_order=parseInt(address2.min_order);
    console.log(totalPrice);
      if(totalPrice < min_order){
        let shipping=10;
        totalPrice= parseInt(totalPrice)+shipping
        document.getElementById('add_cart_shipping').innerHTML=shipping;
         document.getElementById('add_cart_total').innerHTML=totalPrice;
          localStorage.setItem('shipping', JSON.stringify(shipping));
    }else{
        document.getElementById('add_cart_shipping').innerHTML=0;
         localStorage.setItem('shipping', JSON.stringify(0));
    }
    
     }else{
         document.getElementById("add_info").innerHTML =null;
     }
 
  }
//   async function strip_checkout() {
  


//  let cvc = document.getElementById("cvc").value;
//  let expDate=document.getElementById("expiry").value;
//   let name=document.getElementById("name").value;
//   let number=document.getElementById("number").value;
//     const values = {
//       values: {
//         cvc: cvc,
//         expiry: expDate,
//         name: name,
//         // number: data.cardNumber
//         number: number,
//       },
//     };


// const stripeApiKey = 'sk_test_51NyJy5L08MjzSNOljPEocDpiVnB7FWXfc5FNeNJpyKddz5UxXkRdRIF0X0KqleiHe4ijQetpYGCm2zNP6iSAM9bL00AOpYzBWN'; // Replace with your Stripe API key
// const chargeData = {
//   amount: 200, // Amount in cents
//   currency: 'usd',
//   source: 'tok_visa', // Replace with a valid test card token
//   description: 'Example charge',
// };

// fetch('https://api.stripe.com/v1/charges', {
//   method: 'POST',
//   headers: {
//     'Authorization': `Bearer ${stripeApiKey}`,
//     'Content-Type': 'application/x-www-form-urlencoded',
//   },
//   body: new URLSearchParams(chargeData).toString(),
// })
// .then(response => response.json())
// .then(data => {
//   console.log('Charge created:', data);
//     var x = localStorage.getItem("cart");

// // let cart=JSON.parse('x');


// let cart=JSON.parse(x);
// let total=0;
// // console.log(total);
// for(var a = 0 ; a < cart.length ; a++){
//   var num = Number(cart[a].product_net_total)
 
//     total+=num
  
// }

//  var a = localStorage.getItem("address");

// // let cart=JSON.parse('x');


// let address=JSON.parse(a);
// var u = localStorage.getItem("USER");

// // let cart=JSON.parse('x');


// let user=JSON.parse(u);
// let additionNotes='';

// console.log(user.user_id);
// console.log(address.address1);
// console.log(address.address2);
// console.log(address.city);
// console.log(address.area);
// console.log(address.state);
// console.log(total);
// console.log(address.postal_code);
// console.log(cart);
// var shippingcost= document.getElementById('add_cart_shipping').innerHTML;
//  console.log(shippingcost)
//   var formdata = new FormData();

// // Append data to the FormData object
// formdata.append('user_id', user.user_id);
// formdata.append('token', 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC');
// formdata.append('Shipping_address', address.address1);
// formdata.append('Shipping_address_2', address.address2);
// formdata.append('Shipping_city', address.city);
// formdata.append('Shipping_area', address.area);
// formdata.append('Shipping_state', address.state);
// formdata.append('order_total_price', total);
// formdata.append('payment_type', 'online');
// formdata.append('payment_status', 'paid');
// formdata.append('additional_notes', additionNotes); // Fixed typo: 'addtional_notes' to 'additional_notes'
// formdata.append('Shipping_cost', shippingcost);
// formdata.append('Shipping_postal_code', address.postal_code);
// formdata.append('order_datails', x); // Fixed typo: 'order_datails' to 'order_details'

// var requestOptions = {
//   method: 'POST',
//   body: formdata,
//   redirect: 'follow'
// };

// fetch('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/placeOrder_zee.php', requestOptions)
//   .then(response => {
     
//   if (!response.ok) {
//     throw new Error('Network response was not ok');
//   }
//   return response.text(); // Get the response content as text
// })
// .then(responseText => {
//   var message = responseText;

//   // Attempt to parse responseText as JSON if it's not empty
//   if (responseText.trim() !== '') {
//     return JSON.parse(responseText);
//   }
//   return null; // Return null if the response is empty
// })
// .then(result => {
//   if (result !== null) {
//     // Show the message from the response in an alert
//     alert(result[0].Message);
//     console.log('Result:', result);
//      localStorage.removeItem("cart");
//   } else {
//     console.log('Response is empty or not JSON.');
//   }
// })
// .catch(error => {
//   console.error('Error:', error.message);
// });
// })
// .catch(error => {
//   console.error('Error creating charge:', error);
// });
  
// }




function pickup(){
     localStorage.removeItem("order_type");
       document.getElementById("delivery").style.backgroundColor='#ffc107';
      document.getElementById("pickup").style.backgroundColor='#ffc107';
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
       document.getElementById("delivery").style.backgroundColor='transparent';
      document.getElementById("pickup").style.backgroundColor='green';
       document.getElementById("modal-body-pickup").innerHTML=result.Message+`<br>  <footer>
              
               </footer>`
    } else {
        document.getElementById("modal-body-pickup").innerHTML=result.Message
    
    }
  })
  .catch(error => console.error('error', error));
  
}


function delivery(){
   console.log('ok')
    localStorage.removeItem("order_type");
      document.getElementById("delivery").style.backgroundColor='#ffc107';
      document.getElementById("pickup").style.backgroundColor='#ffc107';
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
       document.getElementById("delivery").style.backgroundColor='green';
      document.getElementById("pickup").style.backgroundColor='transaparent';
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
      document.getElementById("delivery").style.backgroundColor='green';
      document.getElementById("pickup").style.backgroundColor='transparent';
}