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

function openModaladdon(type) {
  
        var modal = document.getElementById('myproduct');
  modal.style.display = 'block';
  
  
  
}
function closeModaladdon(type) {
  
   $('#closeButton').click(function() {
    $('#myproduct').hide();
});
        var closeButton = document.getElementById("closeButton");
 console.log( closeButton);
        closeButton.addEventListener("click", function() {
            // Your custom handling code here
            console.log("Close button clicked!");
        });
  
}

  
  
  

localStorage.removeItem("dealaddon");
localStorage.removeItem("dealdress");
localStorage.removeItem("dealtype");
// function openModaltype(type) {
   
//          var modal2 = document.getElementById('mytype');
//   modal2.style.display = 'block';
//   console.log(type)
  
  
// }
// function openModaldressing(type) {
  
//     console.log(data2)
//          var modal3 = document.getElementById('mydressing');
//   modal3.style.display = 'block';
//   document.getElementById('dressing_box').innerHTML =data2;
    
  
// }




 let deal_products = JSON.parse(localStorage.getItem('deal_product')) || [];
    if(deal_products.length > 0){
         localStorage.removeItem('deal_product');
    }
function getUrlParameter(name) {
  name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  var results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Retrieve the 'id' parameter from the URL
var id = getUrlParameter('id');

var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};
let dealss_data='';
fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/get_deals.php", requestOptions)
  .then(response => response.json())  // Parse response as JSON
  .then(result => {
    if (result.status === true) {
      var dealsData = result.deals_data; 
      dealss_data=dealsData// Extract deals_data from the result
      console.log(dealss_data)
       for (var i = 0; i < dealss_data.length; i++) {
         
    if (dealss_data[i].deal_id == id) {
     console.log(dealss_data[i]) // Return the matched deal object
       const formattedPrice = Number(dealss_data[i].deal_cost).toFixed(2);
       var data = `
            <div class="product_img">
                <img src="https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${dealss_data[i].deal_image}" id='product_img' class="img-fluid w-100">
            </div>
              <div class="product-details" style='text-align:start;'>
                <h4 style='font-size:20px;text-align:start;'><a href="" style='text-align:start;'><strong style='font-size:20px;color:black;'>Title:</strong> <span id='productname'> ${dealss_data[i].deal_name}</span></a></h4>
                <p  style='font-size:18px;height:auto;text-align:start;'><strong style='font-size:20px;color:black;text-align:start;font-weight:900;'>Description:</strong> <span id='productdescription'> ${dealss_data[i].deal_description}</span></p>
                <div class="product-price" style='text-align:start;'><strong style='font-size:20px;color:black;'>Price: € </strong><span id='fixed_price'>${formattedPrice}</span></div>
                 <div style='text-align:start;'><strong style='font-size:20px;color:black;'>Deal Items: </strong><span id='itemCount'>${dealss_data[i].deal_items_number}</span></div>
                <input type='hidden' id=pro_id value='${dealss_data[i].deal_id}'>
                 <input type='hidden' id=cost value='${dealss_data[i].deal_cost}'>
                 <input type='hidden' id=pro_pri value='${dealss_data[i].deal_price}'>
                 
                 
                </div>`;
                
                
                
                        document.getElementById('product_box').innerHTML = data;
                        let pri=parseFloat(dealss_data[i].deal_price)
                          document.getElementById('product_price').innerHTML =pri.toFixed(2);
                           document.getElementById('net_price').innerHTML =pri.toFixed(2);
                        //   let deals_item=dealss_data[i].deal_items
                        //   let item='';
                        //   let item_product='';
                    let deals_item = dealss_data[i].deal_items;
// let itemHTML = ''; // Changed the variable name to make it more descriptive
// for (let j = 0; j < deals_item.length; j++) {
//     let item_product = deals_item[j].items_products; // Use 'j' here, not 'i'
//     let titleDisplayed = false; // Add a flag to track if the title has been displayed
//     for (let k = 0; k < item_product.length; k++) {
//         if (!titleDisplayed) {
//             itemHTML += `<span style='font-weight:bolder;color:#ffc107;'>${deals_item[j].item_title}</span><br>`;
//             titleDisplayed = true; // Set the flag to true to indicate the title has been displayed
//         }
//         itemHTML += `
//                     <p class="mb-0" style="display: flex;width: 100%;">   <input type='hidden' value='${item_product[k].prod_id}'> <input type='hidden' value='${deals_item[j].item_id}'> <button name= "language" data-toggle="modal" data-target="#myproduct" onclick='deal_product(${item_product[k].prod_id},${deals_item[j].item_id},"${item_product[k].prod_name}")'  id="checkbox" required style='padding: 5px;
//     background-color: transparent;margin-top:10px;
//     border-radius: 10px;'><span id='name_${item_product[k].prod_id}' style='margin-left:10px;'>${item_product[k].prod_name}</span></button><br></p>`;
//     }
// }

// document.getElementById('deals_items').innerHTML = `<div><strong style='font-size:20px;color:black;text-align:center;'>Deal Items: </strong><br>${itemHTML}<br></div><br>`;
let itemHTML = ''; // Changed the variable name to make it more descriptive
for (let j = 0; j < deals_item.length; j++) {
    let item_product = deals_item[j].items_products; // Use 'j' here, not 'i'
    let titleDisplayed = false; // Add a flag to track if the title has been displayed
    for (let k = 0; k < item_product.length; k++) {
        if (!titleDisplayed) {
            itemHTML += `<span style='font-weight:bolder;color:#ffc107;font-size:20px'>${deals_item[j].item_title}</span><br>`;
            titleDisplayed = true; // Set the flag to true to indicate the title has been displayed
        }

        let productNameHTML = `<span id='name_${item_product[k].prod_id}' style='margin-left:10px;'>${item_product[k].prod_name}</span>`;

        // Check if the title is "Getränke nach wahl" or "Getränke Nach Wahl"
        if (
            deals_item[j].item_title.toLowerCase() === 'getränke nach wahl' ||
            deals_item[j].item_title.toLowerCase() === 'getränke nach wahl'
        ) {
            itemHTML += `
                <p class="mb-0" style="display: flex;width: 100%;">
                    <input type='hidden' value='${item_product[k].prod_id}'>
                    <input type='hidden' value='${deals_item[j].item_id}'>
                    <button name="language" onclick='deal_product(${item_product[k].prod_id},${deals_item[j].item_id},"${item_product[k].prod_name}",${deals_item[j].num_of_free_items})' id="checkbox_${item_product[k].prod_id}_${deals_item[j].item_id}" required style='padding: 5px;
                        background-color: transparent;margin-top:10px;
                        border-radius: 10px;'>${productNameHTML}</button><br>
                </p><div id='product_id_${deals_item[j].item_id}'><div><div id='type_id_${item_product[k].prod_id}'><div><div id='dressing_id_${item_product[k].prod_id}'><div>`;
        } else {
            // Default HTML structure
            itemHTML += `
                <p class="mb-0" style="display: flex;width: 100%;">
                    <input type='hidden' value='${item_product[k].prod_id}'>
                    <input type='hidden' value='${deals_item[j].item_id}'>
                    <button name="language" data-toggle="modal" data-target="#myproduct" onclick='deal_product(${item_product[k].prod_id},${deals_item[j].item_id},"${item_product[k].prod_name}",${deals_item[j].num_of_free_items})' id="checkbox_${item_product[k].prod_id}_${deals_item[j].item_id}" required style='padding: 5px;
                        background-color: transparent;margin-top:10px;
                        border-radius: 10px;'>${productNameHTML}</button><br>
                </p><div id='product_id_${deals_item[j].item_id}'></div><div id='type_id_${item_product[k].prod_id}'></div><div id='dressing_id_${item_product[k].prod_id}'></div>`;
        }
    }
}

document.getElementById('deals_items').innerHTML = `<div><strong style='font-size:20px;color:black;text-align:center;'>Deal Items: </strong><br>${itemHTML}<br></div><br>`;

}}
    } else {
      console.error("Error:", result);
    }
  })
  .catch(error => console.error('error', error));
  
  
  function deal_product(id,item_id,name,free){
      console.log(id,item_id);
    
      console.log(item_id)
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
                      
                          
                     
                        
                        if(dealsData.addons[0] != undefined){
                             document.getElementById('addon_title').innerHTML =dealsData.addons[0].ao_title;
                                document.getElementById('addon_main').innerHTML =name;
                               
                             const addons=dealsData.addons[0].ao_data;
                             data2=''
                              let dealaddon= JSON.parse(localStorage.getItem('dealaddon')) || [];
                              console.log(item_id)
                                console.log(dealaddon)
                                let check_addon=dealaddon.filter(item => item.item_id == item_id);
                                console.log(check_addon)
                                if(check_addon.length>0){
                                      document.getElementById('free_addon').innerHTML ='';
                                    data2 = `<p style='text-align:center;'>Are you sure to reset previous selected Addons?</p><div><button class='btn btn-warning' onclick='yes_click(${item_id},${id})' data-dismiss="modal">Yes</button><button class='btn btn-warning' data-dismiss="modal" style='margin-left:90px;'>No</button></div>`
                                       console.log(check_addon)
                                }else{
                             console.log('addons'+dealsData.addons[0])
                             addons.forEach(function(resp, index){
                                
                                     const formattedPrice = Number(resp.as_price).toFixed(2);
                                  const checkboxId = `s${index + 1}`;
                                 data2+=`<div for='${checkboxId}' class="mb-0" style="display: flex;width: 100%;"> 
                                   <p class="mb-0">  <input type= "hidden" name= "id" value="${id}" id="id_data"></p> 
                                    <p class="mb-0">  <input type= "hidden" name= "id" value="${item_id}" id="id_item"></p> 
                                  <p class="mb-0">  <input type= "hidden" name= "id" value="${resp.as_id}" id="as_${checkboxId}"></p> 
                    <p class="mb-0">  <input type= "hidden" name= "language" value="${resp.as_price}" id="${checkboxId}"></p> 
                    
                    <p style="margin-left: 5px;width:50%;" id="name_${checkboxId}">${resp.as_name}</p> 
                    	<div class="qty" style='margin-left:auto'>
                        <span class="minus2" onclick="minus2('${checkboxId}','${free}')">-</span>
                        
                        <input type="text" class="count" id='qty_${checkboxId}' name="qty" value="0">
                          
                        <span class="plus2" onclick="plus2('${checkboxId}','${free}')">+</span>
                    </div>
                    <p style="margin-left: auto;" >€<span id='addon_price_${checkboxId}'>${formattedPrice}</span></p>
                  </div>`
                                
                                    
                                 
                                   
                  console.log(resp.as_price)
                             })}
                             console.log(id)
                             var type='Addon';
                              openModaladdon(type)
                              document.getElementById('addon_box').innerHTML =data2;
                              
                               document.getElementById('addon_text').innerHTML='Addon Price';
              document.getElementById('add_on_price').innerHTML=0;
             
                        }
                        
                       
                        
                        if(dealsData.type[0] != undefined){
                              document.getElementById('addon_title').innerHTML =dealsData.type[0].type_title;
                               document.getElementById('addon_main').innerHTML =name;
                                 document.getElementById('free_addon').innerHTML ='';
                              type=dealsData.type[0].type_data;
                             data2=''
                              let dealtype= JSON.parse(localStorage.getItem('dealtype')) || [];
                              console.log(item_id)
                                console.log(dealtype)
                                let check_addon=dealtype.filter(item => item.item_id == item_id && item.prod_id == id);
                                console.log(check_addon)
                                if(check_addon.length>0){
                                    data2 = `<p style='text-align:center;'>Sind Sie sicher, dass die zuvor ausgewählten Typen zurückgesetzt werden?</p><div><button class='btn btn-warning' onclick='yes_click_type(${item_id},${id})' data-dismiss="modal">Ja</button><button class='btn btn-warning' data-dismiss="modal" style='margin-left:90px;'>NEIN</button></div>`
                                       console.log(check_addon)
                                }else{
                             type.forEach(function(resp, index){
                                  const checkboxId = `s${index + 1}`;
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                                  <p class="mb-0">  <input type= "hidden" name= "id" value="${id}" id="id_type"></p> 
                                    <p class="mb-0">  <input type= "hidden" name= "id" value="${item_id}" id="id_item_type"></p> 
                    <p class="mb-0">  <input type= "checkbox" name= "language" onclick="type_checkbox_click('${checkboxId}')" value= "Cheese" id="checkbox_${checkboxId}"></p> 
                    <input type= "hidden" name= "id" value= "${resp.ts_id}" id="ts_${checkboxId}">
                    <p style="margin-left: 5px;margin-top: -5px" id='type_name_${checkboxId}'>${resp.ts_name}</p> 
                  </div>`
                             
                    console.log(resp.ts_name)
                             })}
                             console.log(id)
                               var type='type'
                              openModaladdon(type)
                              document.getElementById('addon_box').innerHTML =data2;
                             
                        }
                        
                        if(dealsData.dressing[0] != undefined){
                              document.getElementById('addon_title').innerHTML =dealsData.dressing[0].dressing_title;
                               document.getElementById('addon_main').innerHTML =name;
                                document.getElementById('free_addon').innerHTML ='';
                              console.log(dealsData.dressing[0].dressing_title)
                               const addons=dealsData.dressing[0].dressing_data;
                             data2=''
                              let dealtype= JSON.parse(localStorage.getItem('dealdress')) || [];
                              console.log(item_id)
                                console.log(dealtype)
                                let check_addon=dealtype.filter(item => item.item_id == item_id && item.prod_id == id);
                                console.log(check_addon)
                                if(check_addon.length>0){
                                    data2 = `<p style='text-align:center;'>Sind Sie sicher, den zuvor ausgewählten Verband zurückzusetzen?</p><div><button class='btn btn-warning' onclick='yes_click_dressing(${item_id},${id})' data-dismiss="modal">Ja</button><button class='btn btn-warning' data-dismiss="modal" style='margin-left:90px;'>NEIN</button></div>`
                                       console.log(check_addon)
                                }else{
                             addons.forEach(function(resp, index){
                                  const checkboxId = `s${index + 1}`;
                                 data2+=`<div for= "${checkboxId}" class="mb-0" style="display: flex;width: 100%;"> 
                                    <p class="mb-0">  <input type= "hidden" name= "id" value="${id}" id="id_dressing"></p> 
                                    <p class="mb-0">  <input type= "hidden" name= "id" value="${item_id}" id="id_item_dressing"></p> 
                    <p class="mb-0">  <input type= "checkbox" name= "language" onclick="dressing_click('${checkboxId}')" value= "Cheese" id="dressing_${checkboxId}"></p> 
                      <input type= "hidden" name= "id" value= "${resp.ds_id}" id="ds_${checkboxId}">
                    <p style="margin-left: 5px;margin-top: -5px" id="dressing_name_${checkboxId}">${resp.dressing_name}</p> 
                  </div>`
                           console.log(resp.dressing_name)
                             })}
                             console.log(id)
                             var type='dressing'
                             openModaladdon(type)
                             document.getElementById('addon_box').innerHTML =data2;
                              
                         }
                      // console.log(dealsData);           // Log the entire dealsData object
// console.log(dealsData.addons);    // Log the addons property
// console.log(dealsData.addons[0]);
                    } else {
                        console.error("Error:", result.Data);
                    }
                })
                .catch(error => console.error('Error:', error));
                var product_deal= document.getElementById('name_'+id).innerHTML;
     var dealProduct = JSON.parse(localStorage.getItem('deal_product')) || [];

// Assuming 'deal_id' and 'item_id' are defined somewhere
var deal_id = item_id;

// Check if 'deal_id' already exists in the array
var existingDealIndex = dealProduct.findIndex(function (item) {
  return item.id_item === deal_id;
});
let eik_save='';
if (existingDealIndex !== -1) {
  // 'deal_id' exists in the array, so remove the existing item
  eik_save=dealProduct[existingDealIndex].prod_id
  dealProduct.splice(existingDealIndex, 1);
} 

// Add the new 'deal_data' object to the array
var deal_data = {
  id_item: item_id,
  prod_id: id,
  prod_name: product_deal,
  old_prod_id: eik_save
  
};
dealProduct.push(deal_data);

// Update the 'deal_product' array in localStorage
var pd=localStorage.setItem('deal_product', JSON.stringify(dealProduct));
let dealproduct= JSON.parse(localStorage.getItem('deal_product')) || [];
if(dealproduct.length>0){
    for(let i = 0 ; i < dealproduct.length ; i++){
        if(dealproduct[i].old_prod_id != '' ){
             var colour =  document.getElementById(`checkbox_${dealproduct[i].old_prod_id}_${dealproduct[i].id_item}`);
              colour.style.backgroundColor = 'transparent';
               colour.style.color = 'black';
               let dealdress= JSON.parse(localStorage.getItem('dealdress')) || []
               console.log(dealproduct[i].id_item,dealproduct[i].old_prod_id)
               let exist=dealdress.filter(item => item.item_id == dealproduct[i].id_item && item.prod_id == dealproduct[i].old_prod_id);
                 let existarray=dressingArray.filter(item => item.item_id == dealproduct[i].id_item && item.prod_id == dealproduct[i].old_prod_id);
               console.log(dressingArray)
               if(exist.length > 0 && existarray.length > 0){
                   dressingArray.length = 0;
                   localStorage.removeItem('dealdress');
               }
               
               
                let dealtype= JSON.parse(localStorage.getItem('dealtype')) || []
               console.log(dealproduct[i].id_item,dealproduct[i].old_prod_id)
               let existtype=dealtype.filter(item => item.item_id == dealproduct[i].id_item && item.prod_id == dealproduct[i].old_prod_id);
                 let existtypearray=typeArray.filter(item => item.item_id == dealproduct[i].id_item && item.prod_id == dealproduct[i].old_prod_id);
               console.log(dressingArray)
               if(existtype.length > 0 && existtypearray.length > 0){
                   typeArray.length = 0;
                   localStorage.removeItem('dealtype');
               }
                console.log(dressingArray)
        }
        var colour =  document.getElementById(`checkbox_${dealproduct[i].prod_id}_${dealproduct[i].id_item}`);
        console.log(colour)
       colour.style.backgroundColor = 'green';
        colour.style.color = 'white';
    }
}
console.log(pd)
console.log(id)
        }
        function yes_click_type(item_id,id){
              let dealaddon= JSON.parse(localStorage.getItem('dealtype')) || [];
                            
                                console.log(dealaddon)
                                   let check_addon=dealaddon.filter(item => item.prod_id == id);
                                   console.log(check_addon);
                                   if (check_addon.length > 0) {
                                       for(let i = 0 ; i < check_addon.length ; i++){
                                             let index = dealaddon.indexOf(check_addon[i]);
    if (index !== -1) {
        dealaddon.splice(index, 1);
                                       }
  
    }
}
console.log(dealaddon)
// Update the local storage with the modified dealaddon array
localStorage.setItem('dealtype', JSON.stringify(dealaddon));

   
     let select_addon=typeArray.filter(item => item.prod_id == id);
                                   console.log(select_addon);
                                   if (select_addon.length > 0) {
                                       for(let i = 0 ; i < select_addon.length ; i++){
                                             let index = typeArray.indexOf(select_addon[i]);
    if (index !== -1) {
        typeArray.splice(index, 1);
                                       }
  
    }
}
   document.getElementById(`type_id_${id}`).innerHTML ='';
    var colour =  document.getElementById(`checkbox_${id}_${item_id}`);
        console.log(colour)
       colour.style.backgroundColor = 'transparent';
        colour.style.color = 'black';
 console.log(typeArray);
        }
        function yes_click_dressing(item_id,id){
              let dealaddon= JSON.parse(localStorage.getItem('dealdress')) || [];
                            
                                console.log(dealaddon)
                                   let check_addon=dealaddon.filter(item => item.prod_id == id);
                                   console.log(check_addon);
                                   if (check_addon.length > 0) {
                                       for(let i = 0 ; i < check_addon.length ; i++){
                                             let index = dealaddon.indexOf(check_addon[i]);
    if (index !== -1) {
        dealaddon.splice(index, 1);
                                       }
  
    }
}
console.log(dealaddon)
// Update the local storage with the modified dealaddon array
localStorage.setItem('dealdress', JSON.stringify(dealaddon));

   
     let select_addon=dressingArray.filter(item => item.prod_id == id);
                                   console.log(select_addon);
                                   if (select_addon.length > 0) {
                                       for(let i = 0 ; i < select_addon.length ; i++){
                                             let index = dressingArray.indexOf(select_addon[i]);
    if (index !== -1) {
        dressingArray.splice(index, 1);
                                       }
  
    }
}
   document.getElementById(`dressing_id_${id}`).innerHTML ='';
    var colour =  document.getElementById(`checkbox_${id}_${item_id}`);
        console.log(colour)
       colour.style.backgroundColor = 'transparent';
        colour.style.color = 'black';
 console.log(dressingArray);
        }
function yes_click(item_id,id){
       let dealproduct= localStorage.getItem('deal_product') || [];
   console.log(dealproduct);
      let dealaddon= JSON.parse(localStorage.getItem('dealaddon')) || [];
                            
                                console.log(dealaddon)
                                   let check_addon=dealaddon.filter(item => item.item_id == item_id);
                                   console.log(check_addon);
                                   if (check_addon.length > 0) {
                                       for(let i = 0 ; i < check_addon.length ; i++){
                                             let index = dealaddon.indexOf(check_addon[i]);
    if (index !== -1) {
        dealaddon.splice(index, 1);
                                       }
  
    }
}
console.log(dealaddon)
// Update the local storage with the modified dealaddon array
localStorage.setItem('dealaddon', JSON.stringify(dealaddon));

   
     let select_addon=selectedAddons.filter(item => item.item_id ==item_id);
                                   console.log(select_addon);
                                   if (select_addon.length > 0) {
                                       for(let i = 0 ; i < select_addon.length ; i++){
                                             let index = selectedAddons.indexOf(select_addon[i]);
    if (index !== -1) {
        selectedAddons.splice(index, 1);
                                       }
  
    }
}
   document.getElementById(`product_id_${item_id}`).innerHTML ='';
   var colour =  document.getElementById(`checkbox_${id}_${item_id}`);
        console.log(colour)
       colour.style.backgroundColor = 'transparent';
        colour.style.color = 'black';
        
console.log(item_id,id)
  let dealproductArray = JSON.parse(dealproduct);

let check_find = dealproductArray.findIndex(item => item.id_item === item_id && item.prod_id === id);
console.log(dealproductArray);
console.log(check_find);

if (check_find !== -1) {
  dealproductArray.splice(check_find, 1);
  console.log(dealproductArray);

  // If you need to convert it back to a JSON string
  dealproduct = JSON.stringify(dealproductArray);
   localStorage.setItem('deal_product', JSON.stringify(dealproductArray));
}
   console.log(dealproductArray);
 console.log(selectedAddons);
 
}
  function plus2(checkboxId,free) {
       let minus=1;
      const nameElement = document.getElementById(`name_${checkboxId}`);
    const qtyInput = document.getElementById(`qty_${checkboxId}`);
    const quantity = parseInt(qtyInput.value) + 1;
     price=parseFloat(document.getElementById(checkboxId).value);
     const name = nameElement.textContent;
       const quantity_value= parseFloat(document.getElementById('quantity_value').value);
       const id_item = document.getElementById(`id_item`).value;
       let total=0;
       console.log(id_item);
         console.log(checkboxId);
        console.log(qtyInput.value);
          const existItems = selectedAddons.filter(item => item.item_id === id_item);
           console.log(existItems);
          if(existItems.length > 0){
              let quan=0;
for (const addon of existItems) {
    quan += addon.free_quantity;
}
console.log(quan)
if(existItems.length >= free ||  quan >= free){
    const existingAddonIndex = existItems.findIndex(item => item.item_id === id_item && item.as_name === name);
    console.log(existingAddonIndex)
    if(existingAddonIndex != -1){
        if(selectedAddons[existingAddonIndex].free_quantity >0){
              let calculate=quantity - selectedAddons[existingAddonIndex].free_quantity
 qtyInput.value = quantity;
       total=calculate*price;
         document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
       console.log('347')
        }else{
              qtyInput.value = quantity;
       total=quantity*price;
         document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
        console.log('351')
        }
    }else{
         qtyInput.value = quantity;
       total=quantity*price;
         document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
        console.log('356')
    }
   
  
}else{
   qtyInput.value = quantity;
     total=quantity*0;
}
          }
            qtyInput.value = quantity;
   
     document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
		      
		        
    updateAddon(checkboxId, quantity,free,minus);
    net_addon=parseFloat(document.getElementById('add_on_price').innerHTML);
    net_price=parseFloat(document.getElementById('product_price').innerHTML);
    
    net_total=net_price+(net_addon*quantity_value);
    // console.log('net_addon'+  net_addon);
    // console.log('net_price'+  net_price);
    // console.log('net_total'+ net_total);
  
   document.getElementById('net_price').innerHTML=net_total.toFixed(2);
}

function minus2(checkboxId,free) {
    let minus=0;
     const nameElement = document.getElementById(`name_${checkboxId}`);
    const qtyInput = document.getElementById(`qty_${checkboxId}`);
    const quantity = parseInt(qtyInput.value);
     const price=parseFloat(document.getElementById(checkboxId).value);
      const quantity_value= parseFloat(document.getElementById('quantity_value').value);
      const name = nameElement.textContent;
    if (quantity > 0) {
    //     qtyInput.value = quantity - 1;
        
    //   total=parseInt(qtyInput.value)*price;
    
     const id_item = document.getElementById(`id_item`).value;
       let total=0;
       console.log(id_item);
         console.log(checkboxId);
        console.log(qtyInput.value);
          const existItems = selectedAddons.filter(item => item.item_id === id_item);
           console.log(existItems);
          if(existItems.length > 0){
              let quan=0;
for (const addon of existItems) {
    quan += addon.free_quantity;
}
console.log(quan)
if( quan >= free){
    const existingAddonIndex = selectedAddons.findIndex(item => item.item_id === id_item && item.as_name === name);
    
    if(existingAddonIndex>-1){
        if(selectedAddons[existingAddonIndex].free_quantity > 0){
           
  qtyInput.value = quantity - 1;
           let calculate= qtyInput.value - selectedAddons[existingAddonIndex].free_quantity
           console.log(calculate)
           if(calculate >=0){
               total=parseInt(calculate)*price;
           }else{
                total=parseInt(calculate)*0;
           }
     
        document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
        console.log('423')
        }else{
              qtyInput.value = quantity - 1;
        
      total=parseInt(qtyInput.value)*price;
        document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
         console.log('430')
        }
    }else{
         qtyInput.value = quantity - 1;
        
      total=parseInt(qtyInput.value)*price;
        document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
         console.log('437')
    }
   
  
}else{
 
                
                for (const addon of existItems) {
    quan += addon.free_quantity;

             
      }
          let newarray = selectedAddons.findIndex(item => item.item_id === id_item && item.as_name === name);
      if(selectedAddons[newarray].free_quantity > 0 && selectedAddons[newarray].quantity < 1 ) {
           qtyInput.value = quantity - 1;
           
       
      total=parseInt(qtyInput.value)*0;
       document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
       console.log('451')
      }else{
            qtyInput.value = quantity - 1;
        
      total=parseInt(qtyInput.value)*price;
		        document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
		          console.log('451')
      }
      
        console.log(selectedAddons)
     
}
          }else{
                  qtyInput.value = quantity - 1;
        
      total=parseInt(qtyInput.value)*price;
		        document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
          }
    //           qtyInput.value = quantity - 1;
        
    //   total=parseInt(qtyInput.value)*price;
		  //      document.getElementById('addon_price_'+checkboxId).innerHTML=total.toFixed(2)
        updateAddon(checkboxId, quantity - 1,free,minus);
          net_addon=parseFloat(document.getElementById('add_on_price').innerHTML);
    net_price=parseFloat(document.getElementById('product_price').innerHTML);
    
    net_total=net_price+(net_addon*quantity_value);
    // console.log('net_addon'+  net_addon);
    // console.log('net_price'+  net_price);
    // console.log('net_total'+ net_total);
  
   document.getElementById('net_price').innerHTML=net_total.toFixed(2);
  
   
    }
}
const selectedAddons = [];
const  dressingArray=[];
const  typeArray=[];
function updateAddon(checkboxId, quantity,free,minus) {
    const nameElement = document.getElementById(`name_${checkboxId}`);
    const qtyInput = document.getElementById(`qty_${checkboxId}`);
const id_data = document.getElementById(`id_data`).value;
const id_item = document.getElementById(`id_item`).value;
const addonPriceElement = document.getElementById(`addon_price_${checkboxId}`);
const ids = document.getElementById(`as_${checkboxId}`);

const name = nameElement.textContent; // You need to define 'nameElement' or retrieve it from the DOM.
const qty = parseInt(qtyInput.value);
const price = parseFloat(addonPriceElement.textContent);
const id = parseFloat(ids.value);

const existingAddonIndex = selectedAddons.findIndex(item => item.item_id === id_item && item.as_name === name);


if (existingAddonIndex !== -1) {
    console.log(existingAddonIndex)
  
    if (quantity === 0) {
        // Remove the item if quantity is 0
        selectedAddons.splice(existingAddonIndex, 1);
          const existItems = selectedAddons.filter(item => item.item_id === id_item);
        
         for(let i = 0 ; i < existItems.length ; i++){
              quan=0;
                for (const addon of existItems) {
    quan += addon.free_quantity;
}
      if(quan < free ){
              if(existItems[i].quantity >0){
                  console.log('yes')
                 let newarray = selectedAddons.findIndex(item => item.item_id === existItems[i].item_id && item.as_name === existItems[i].as_name);
                  selectedAddons[newarray].quantity=selectedAddons[newarray].quantity - 1
                  selectedAddons[newarray].free_quantity=selectedAddons[newarray].free_quantity+1;
                 selectedAddons[newarray].totalPrice = selectedAddons[newarray].sum*selectedAddons[newarray].quantity;
                   document.getElementById('addon_price_'+selectedAddons[newarray].line_number).innerHTML=selectedAddons[newarray].totalPrice.toFixed(2)
              }else{
                   console.log('no')
              }
      }else{
          console.log(quan + ' and ' + free)
      }
          }
    } else {
        console.log(selectedAddons[existingAddonIndex].item_id);
      const existItems = selectedAddons.filter(item => item.item_id === selectedAddons[existingAddonIndex].item_id);

        console.log(existItems);
        
        
      let quan=0;
for (const addon of existItems) {
    quan += addon.free_quantity;
}
console.log(quan)
if(existItems.length >= free ||  quan >= free){
    if(selectedAddons[existingAddonIndex].free_quantity >0){
        if(minus === 1){
            let calculate=quantity-selectedAddons[existingAddonIndex].free_quantity
            selectedAddons[existingAddonIndex].quantity = calculate;
        selectedAddons[existingAddonIndex].totalPrice = price;
          console.log('plus wala')
        }else{
            if(selectedAddons[existingAddonIndex].quantity > 0){
                  let calculate=quantity-selectedAddons[existingAddonIndex].free_quantity
                  console.log(calculate+','+'yeh raha')
                selectedAddons[existingAddonIndex].quantity = calculate;
                if(selectedAddons[existingAddonIndex].quantity === 0){
                      selectedAddons[existingAddonIndex].totalPrice = 0;
                }else{
                     selectedAddons[existingAddonIndex].totalPrice = price;
                }
              console.log('549')
          for(let i = 0 ; i < existItems.length ; i++){
                for (const addon of existItems) {
    quan += addon.free_quantity;
}
      if(quan < free ){
              if(existItems[i].quantity >0){
                
                 let newarray = selectedAddons.findIndex(item => item.item_id === existItems[i].item_id && item.as_name === existItems[i].as_name);
                  selectedAddons[newarray].quantity=selectedAddons[newarray].quantity - 1
                  selectedAddons[newarray].free_quantity=selectedAddons[newarray].free_quantity+1;
                 selectedAddons[newarray].totalPrice = price*selectedAddons[newarray].quantity;
              }
      }
          }
      
        console.log(selectedAddons)
            }else{
                 selectedAddons[existingAddonIndex].free_quantity = quantity;
        selectedAddons[existingAddonIndex].totalPrice = price;
             console.log('569')
          for(let i = 0 ; i < existItems.length ; i++){
              quan=0;
                for (const addon of existItems) {
    quan += addon.free_quantity;
}
      if(quan < free ){
              if(existItems[i].quantity >0){
                  console.log('yes')
                 let newarray = selectedAddons.findIndex(item => item.item_id === existItems[i].item_id && item.as_name === existItems[i].as_name);
                  selectedAddons[newarray].quantity=selectedAddons[newarray].quantity - 1
                  selectedAddons[newarray].free_quantity=selectedAddons[newarray].free_quantity+1;
                 selectedAddons[newarray].totalPrice = selectedAddons[newarray].sum*selectedAddons[newarray].quantity;
                   document.getElementById('addon_price_'+selectedAddons[newarray].line_number).innerHTML=selectedAddons[newarray].totalPrice.toFixed(2)
              }else{
                   console.log('no')
              }
      }else{
          console.log(quan + ' and ' + free)
      }
          }
      
        console.log(selectedAddons)
            }
        }
          
    }else{
          selectedAddons[existingAddonIndex].quantity = quantity;
        selectedAddons[existingAddonIndex].totalPrice = price;
        console.log('591')
    }
  
   
}else{
     selectedAddons[existingAddonIndex].free_quantity = quantity;
     selectedAddons[existingAddonIndex].totalPrice = 0;
     console.log('598')
        
}
       
    }
} else if (quantity > 0) {
    // Add a new item to the array
    const existitem_id=selectedAddons.filter(item => item.item_id === id_item);
    let quan=0;
      console.log(existitem_id)
    if(existitem_id.length>0){
      
        for (let i=0 ; i < existitem_id.length ; i++) {
    quan += existitem_id[i].free_quantity;
}
console.log(quan)
    }

 

console.log(quan)
if(existitem_id.length >= free ||  quan >= free){
    selectedAddons.push({
        prod_id: id_data,
        item_id: id_item,
        as_name: name,
        as_id: id,
        free_quantity:0,
        line_number:checkboxId,
        quantity:quantity,
        as_price: price,
        sum: price *quantity,
        totalPrice: price * quantity,
    });
    
}else{
   selectedAddons.push({
        prod_id: id_data,
        item_id: id_item,
        as_name: name,
        as_id: id,
        free_quantity:quantity,
         line_number:checkboxId,
        quantity:0,
        as_price: price,
        sum: price *quantity,
        totalPrice: 0,
    });
}

   

    
}

let totalPrice = 0;

    for (const addon of selectedAddons) {
    totalPrice += addon.totalPrice;
}



document.getElementById('add_on_price').innerHTML = totalPrice.toFixed(2);
console.log(selectedAddons);
 localStorage.setItem('dealaddon', JSON.stringify(selectedAddons));
  let dealaddon= JSON.parse(localStorage.getItem('dealaddon')) || [];
 const matchingAddons =dealaddon.filter(addon => addon.prod_id == id_data && addon.item_id == id_item);
 console.log(matchingAddons)
var p_data = ""; // Start the unordered list

for (var i = 0; i < matchingAddons.length; i++) {
    var total_q = matchingAddons[i].free_quantity + matchingAddons[i].quantity;

    // Create a list item with separate lines for each piece of information
      p_data += `<div class="mb-0" style="display: flex; width: 100%;">
                     <p style='color:green;padding-left:5px'>${matchingAddons[i].as_name}</p>
                    <p style='color:green;padding-left:10px'>${total_q}</p>
                        <p style='color:green;padding-left:5px'>X</p>
                        <p style='color:green;padding-left:5px'>${matchingAddons[i].totalPrice}</p>
                </div>`;
      
}





 console.log(p_data)
 pro =document.getElementById(`product_id_${id_data}`)
 document.getElementById(`product_id_${id_item}`).innerHTML=p_data;
 console.log( pro)
//     const nameElement = document.getElementById(`name_${checkboxId}`);
//     const qtyInput = document.getElementById(`qty_${checkboxId}`);
//      const id_data = document.getElementById(`id_data`).value;
//      const id_item = document.getElementById(`id_item`).value;
//     const addonPriceElement = document.getElementById(`addon_price_${checkboxId}`);
//       const ids = document.getElementById(`as_${checkboxId}`);
//       console.log(ids);
    
//     const name = nameElement.textContent;
//     const qty = parseInt(qtyInput.value);
//     const price = parseFloat(addonPriceElement.textContent);
//     const id = parseFloat(ids.value);

//     const existingAddonIndex = selectedAddons.findIndex(item => item.as_name === name);
//     if (existingAddonIndex !== -1) {
//         if (quantity === 0) {
//             selectedAddons.splice(existingAddonIndex, 1);
//         } else {
//             selectedAddons[existingAddonIndex].quantity = quantity;
//             selectedAddons[existingAddonIndex].totalPrice = price;
//         }
//     } else if (quantity > 0) {
//         selectedAddons.push({
//             prod_id:id_data,
//             item_id:id_item,
//             as_name: name,
//             as_id:id,
//             quantity: quantity,
//             as_price:price,
//             sum: price * quantity,
//             totalPrice: price * quantity,
            
//         });
//     }
// let totalPrice = 0;
//     for (const addon of selectedAddons) {
//         totalPrice += addon.totalPrice;
//     }
//     document.getElementById('add_on_price').innerHTML=totalPrice;
//     console.log(selectedAddons)
    
    
    
}
function type_checkbox_click(checkboxId) {
    const checkbox = document.getElementById(`checkbox_${checkboxId}`);
    const title=document.getElementById('addon_title');
     const id=document.getElementById(`ts_${checkboxId}`);
       const id_data = document.getElementById(`id_type`).value;
const id_item = document.getElementById(`id_item_type`).value;
     console.log(id);
    const typeNameElement = document.getElementById(`type_name_${checkboxId}`);
   const typeName = typeNameElement.innerHTML;
        const ids = id.value;
        const titles = title.innerHTML;
    const existingIndex =  typeArray.findIndex(item => item.prod_id === id_data && item.ts_name === typeName);

    if (checkbox.checked) {
        // const typeName = typeNameElement.innerHTML;
        // const ids = id.value;
        // const titles = title.innerHTML;
        // typeArray.push({
        //     ts_name: typeName,
        //     ts_id:ids,
        //     type_title: titles,
            
        // });
         if (existingIndex === -1) {
        typeArray.push({
            prod_id: id_data,
            item_id: id_item,
             ts_name: typeName,
            ts_id:ids,
            type_title: titles,
        });
    }
    } else {
        const typeName = typeNameElement.innerHTML;
       if (existingIndex !== -1) {
        typeArray.splice(existingIndex, 1);
    }
    }

    // Display the updated type array for testing
      localStorage.setItem('dealtype', JSON.stringify(typeArray));
  let dealtype= JSON.parse(localStorage.getItem('dealtype')) || [];
   let dealproduct= JSON.parse(localStorage.getItem('deal_product')) || [];
   const matchingdress =dealproduct.findIndex(addon => addon.prod_id == id_data && addon.id_item == id_item);
  console.log(dealproduct[matchingdress]);
  if(dealproduct[matchingdress].old_prod_id !== ''){
      document.getElementById(`type_id_${dealproduct[matchingdress].old_prod_id}`).innerHTML='';
  }
   const matchingAddons =dealtype.filter(addon => addon.prod_id == id_data && addon.item_id == id_item);
  
 console.log(matchingAddons)
 let p_data='';
 for(var i = 0 ; i < matchingAddons.length ; i++ ){
     total_q=matchingAddons[i].free_quantity + matchingAddons[i].quantity
     p_data += ` <div class="mb-0" style="display: flex; width: 100%;">
                   <p style='color:green;padding-left:5px'>${matchingAddons[i].ts_name}</p>
                   
                </div>`
    
 }
 console.log(p_data)
 pro =document.getElementById(`dressing_id_${id_data}`)
 document.getElementById(`type_id_${id_data}`).innerHTML=p_data;
 console.log( pro)
    
}

function dressing_click(checkboxId) {
    const checkbox = document.getElementById(`dressing_${checkboxId}`);
     const title=document.getElementById('addon_title');
     const id=document.getElementById(`ds_${checkboxId}`);
     const id_data = document.getElementById(`id_dressing`).value;
const id_item = document.getElementById(`id_item_dressing`).value;
     console.log(checkbox);
    const typeNameElement = document.getElementById(`dressing_name_${checkboxId}`);
     const typeName = typeNameElement.innerHTML;
        const ids = id.value;
        const titles = title.innerHTML;
    const existingIndex = dressingArray.findIndex(item => item.prod_id === id_data && item.dressing_name === typeName);

if (checkbox.checked) {
    // If the object doesn't exist, push it into the array
    if (existingIndex === -1) {
        dressingArray.push({
            prod_id: id_data,
            item_id: id_item,
            dressing_name: typeName,
            ds_id: ids,
            dressing_title: titles,
        });
    }
} else {
    // If the object exists, remove it from the array
    if (existingIndex !== -1) {
        dressingArray.splice(existingIndex, 1);
    }
}

    // if (checkbox.checked) {
    //     const typeName = typeNameElement.innerHTML;
    //     const ids = id.value;
    //     const titles = title.innerHTML;
    //     dressingArray.push({
    //         prod_id: id_data,
    //         item_id:id_item,
    //         dressing_name: typeName,
    //         ds_id:ids,
    //         dressing_title: titles,
            
    //     });
    // } else {
    //     const typeName = typeNameElement.innerHTML;
    //     const index = dressingArray.indexOf(typeName);
    //     if (index !== -1) {
    //         dressingArray.splice(index, 1);
    //     }
       
    // }
  console.log(dressingArray)
    // Display the updated type array for testing
     localStorage.setItem('dealdress', JSON.stringify(dressingArray));
  let dealdress= JSON.parse(localStorage.getItem('dealdress')) || [];
  let dealproduct= JSON.parse(localStorage.getItem('deal_product')) || [];
   const matchingdress =dealproduct.findIndex(addon => addon.prod_id == id_data && addon.id_item == id_item);
  console.log(dealproduct[matchingdress]);
  if(dealproduct[matchingdress].old_prod_id !== ''){
      document.getElementById(`dressing_id_${dealproduct[matchingdress].old_prod_id}`).innerHTML='';
  }
  const matchingAddons =dealdress.filter(addon => addon.prod_id == dealproduct[matchingdress].prod_id && addon.item_id == dealproduct[matchingdress].id_item);
 console.log(matchingAddons)
 let p_data='';
 for(var i = 0 ; i < matchingAddons.length ; i++ ){
     total_q=matchingAddons[i].free_quantity + matchingAddons[i].quantity
     p_data += `<div class="mb-0" style="display: flex; width: 100%;">
                   <p style='color:green;padding-left:5px'>${matchingAddons[i].dressing_name}</p>
                   
                </div>`
 }
 console.log(p_data)
 pro =document.getElementById(`dressing_id_${dealproduct[matchingdress].prod_id}`)
 document.getElementById(`dressing_id_${dealproduct[matchingdress].prod_id}`).innerHTML=p_data;
 console.log(pro)
    
}
 function minus(){
           const price= parseFloat(document.getElementById('fixed_price').innerHTML);
           
            const quantity= parseFloat(document.getElementById('quantity_value').value);
            const exact_quantity=quantity-1;
            const total= price*exact_quantity
            if( exact_quantity <1){
                 document.getElementById('product_price').innerHTML=price.toFixed(2);
                
                   total_price=document.getElementById('add_on_price').innerHTML.toFixed(2);
               if(total_price !=null){
                 const total_net= Number(total_price)*exact_quantity
                   net_price=Number(total_net)+total;
                   document.getElementById('net_price').innerHTML=net_price;
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

function add_to_cart() {
    $('#addd_tooo').alert()
    const itemCount = document.getElementById('itemCount').innerHTML;
    let deal_product = JSON.parse(localStorage.getItem('deal_product')) || [];
    if(deal_product.length == itemCount){
        console.log('all fine')
        selectedAddons.forEach(item => {
  item.quantity = item.free_quantity + item.quantity;
});
        console.log(selectedAddons)
        
         console.log(typeArray)
         console.log(dressingArray)
         let deal_details=[];
            for (let i = 0; i < deal_product.length; i++) {
        const prod_id = deal_product[i].prod_id;
console.log('deal_prdo'+'='+prod_id)
        // Find the matching prod_id in selectedAddons
       const matchingAddons = selectedAddons.filter(addon => addon.prod_id == prod_id && addon.item_id == deal_product[i].id_item);
         const matchingtype = typeArray.filter(addon => addon.prod_id == prod_id && addon.item_id ==  deal_product[i].id_item);
          const matchingdressing = dressingArray.filter(addon => addon.prod_id == prod_id && addon.item_id ==  deal_product[i].id_item);
console.log(matchingAddons)
     
            // Create a new object with the required information
          const dealDetail = {
    item_id: deal_product[i].id_item,
    prod_id: prod_id,
    prod_name: deal_product[i].prod_name,
    items_products: [{
        prod_id: prod_id,
        addons: matchingAddons,
        type:matchingtype,
        dressing:matchingdressing
    }]
};

            // Push the dealDetail into the deal_details array
            deal_details.push(dealDetail);
      
            }     
            console.log(deal_details)

         
    const productImageElement = document.getElementById('product_img');
    let productImageSrc = productImageElement.src;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const newCartItem = {
        'id':document.getElementById('pro_id').value,
        'deal_id':document.getElementById('pro_id').value,
        'product_name': document.getElementById('productname').innerHTML,
        'product_description': document.getElementById('productdescription').innerHTML,
        'product_quantity': document.getElementById('quantity_value').value,
        'quantity': document.getElementById('quantity_value').value,
         'cost': document.getElementById('cost').value,
         'discount':0,
          'price': document.getElementById('pro_pri').value,
        'product_image': productImageSrc,
        'product_net_total': document.getElementById('net_price').innerHTML,
      'is_deal':'yes' ,
      'deal_items': [] // Initialize it as an empty array
};

// Now, you can populate the 'deal_items' array with actual deal items
newCartItem.deal_items = deal_details;
        cart.push(newCartItem);
         console.log(newCartItem)
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
    for (const addon of cart) {
        totalPrice += parseFloat(addon.product_net_total);
        
    }
      $(".alert").addClass("alert-info");
          document.getElementById('error_alert').innerHTML='Erfolgreich in den Warenkorb gelegt';
         $('.alert').show();
         setTimeout(removeDiv, 5000);
    document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
    console.log( cart);
    }else{
         $(".alert").addClass("alert-danger");
          document.getElementById('error_alert').innerHTML='Wählen Sie zunächst den Artikel Artikel aus';
         $('.alert').show();
         setTimeout(removeDiv, 5000);
       
    }
    
   return itemCount;
    
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
     'deal_items': [] // Initialize it as an empty array
};

// Now, you can populate the 'deal_items' array with actual deal items
newCartItem.deal_items = deal_details;
console.log(newCartItem.deal_items)
        cart.push(newCartItem);
    

         
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
    for (const addon of cart) {
        totalPrice += parseFloat(addon.product_net_total);
        
    }
    document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);

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
        totalPrice= parseInt(totalPrice)+shipping
        document.getElementById('add_cart_shipping').innerHTML=totalPrice.toFixed(2);
         document.getElementById('add_cart_total').innerHTML=totalPrice.toFixed(2);
    }else{
        document.getElementById('add_cart_shipping').innerHTML=0;
    }
    
     
   }
     
    // console.log(cart);
}

// function show_more_deal(i){
//     let cart2 = JSON.parse(localStorage.getItem('cart')) || [];
//      let info=cart2[i].deal_items;
//      if(info.length > 0){
//     for(let x = 0; x < info.length; x++){
//         console.log(info[x].prod.name);
//     }
// }
// }
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

// Set a timeout to call the removeDiv function after 5 seconds (5000 milliseconds)


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




