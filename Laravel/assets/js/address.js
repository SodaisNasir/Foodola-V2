let usercheck1=JSON.parse(localStorage.getItem('USER'));
if(usercheck1 === null){
     window.location.href = '403.html';
     document.getElementById("auth").innerHTML=` <a class="nav-link" href="auth.html">Registrieren/Anmelden</a>`
}else{
     document.getElementById("auth").innerHTML=` <a class="nav-link" onclick='logout()'>Ausloggen</a>`
}
function logout(){
      localStorage.clear();
  
  // Redirect the user to the home page
  window.location.href = 'index.html'; 
}

var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/getareas.php", requestOptions)
  .then(response => response.json())
  .then(result =>{
    
      if(result.status===true){
          let data='';
          console.log('ok');
          var code_data=result.Data;
          for(let i = 0; i < code_data.length;i++){
           data += `<option value="${code_data[i].postal_code}" onclick='shipping_cost(${i})'>${code_data[i].postal_code}</option>`;

          }
            document.getElementById("postal_code").innerHTML=data;
      }
  })
  .catch(error => console.log('error', error));
let selectedIndex = ''; 
function add_address(){
     let address1=document.getElementById("address1").value;
     let address2=document.getElementById("address2").value;
      let city=document.getElementById("city").value;
      let area=document.getElementById("area").value;
        let postal_code=document.getElementById("postal_code").value;
           let state=document.getElementById("state").value;
           
           var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/getareas.php", requestOptions)
  .then(response => response.json())
  .then(result =>{
    
      if(result.status===true){
          let data='';
          console.log('ok');
          var code_data=result.Data;
         // Initialize with -1, meaning no match found
for (let i = 0; i < code_data.length; i++) {
  if (code_data[i].postal_code == postal_code) {
    selectedIndex += code_data[i].min_order_price; 
    
    break; // Exit the loop since we found a match
  }
}

console.log(selectedIndex)
     let shipping=document.getElementById("shipping_cost").value;
         let address={
             'address1':address1,
             'address2':address2,
             'city':city,
             'area':area,
             'postal_code':postal_code,
             'state':state,
             'min_order':selectedIndex
         }
          let address_storage = JSON.parse(localStorage.getItem("Address")) || [];


console.log(address_storage)
// Add the 'address' object to the 'address_storage' array
address_storage.push(address);
console.log(address_storage)
// Save the updated 'address_storage' array back to localStorage
localStorage.setItem('Address', JSON.stringify(address_storage));
  window.location.href = 'address.html';
      }
  })
  .catch(error => console.log('error', error));
//   window.location.href = 'address.html';
   document.getElementById("address1").value='';
    document.getElementById("address2").value='';
    document.getElementById("area").value='';
     document.getElementById("city").value='';
      document.getElementById("postal_code").value='';
      document.getElementById("state").value='';
  


  
 
}

   let address = JSON.parse(localStorage.getItem('Address')) || [];
     if(address.length>0){
         let data=''
         for(let i = 0 ; i < address.length; i++){
             data+=`<div class='col-md-12 col-sm-12'><div class="mb-0" style="display: flex;width: 100%;background: #ffc107;
    padding: 5px;
    height: auto;
    margin-top: 5px;border-radius: 10px;"> 
                    
                    <p style="margin-left: 5px;width:260px;"><strong>Address 1: </strong>${address[i].address1}<br><strong>Address 2: </strong>${address[i].address2}<br><strong>City: </strong>${address[i].city}<br><strong>Area: </strong>${address[i].area}<br><strong>Postal Code: </strong>${address[i].postal_code}</p>
                      <button type='button'onclick='edit_address(${i})' data-toggle="modal" data-target="#myeditAddress" style="margin-left:auto;border:2px;height: 30px;
    width: 30px;"><strong style='color:red;'><i class="fa fa-pencil" aria-hidden="true"></i>
</strong></button> <button type='button' style="margin-left:auto;height: 30px;
    width: 30px;border:2px;" onclick='delete_address(${i})'><strong style='color:red;'><i class="fa fa-trash" aria-hidden="true"></i>
</strong></button>
                  </div></div>`
         }
         document.getElementById('add-body').innerHTML = data;
     }else{
          document.getElementById('add-body').innerHTML = 'Keine Adresse';
     }
     
     
     function delete_address(i){
            let address = JSON.parse(localStorage.getItem('Address'))
            address.splice(i,1);
      localStorage.setItem('Address', JSON.stringify(address));
      
       if(address.length>0){
         let data=''
         for(let i = 0 ; i < address.length; i++){
             data+=`<div class='col-md-12 col-sm-12'><div class="mb-0" style="display: flex;width: 100%;background: #ffc107;
    padding: 5px;
    height: auto;
    margin-top: 5px;border-radius: 10px;"> 
                    
                    <p style="margin-left: 5px;width:260px;"><strong>Address 1: </strong>${address[i].address1}<br><strong>Address 2: </strong>${address[i].address2}<br><strong>City: </strong>${address[i].city}<br><strong>Area: </strong>${address[i].area}<br><strong>Postal Code: </strong>${address[i].postal_code}</p>
                      <button type='button' onclick='edit_address(${i})' data-toggle="modal" data-target="#myeditAddress" style="margin-left: auto;border:2px;height: 30px;
    width: 30px;"><strong style='color:red;'><i class="fa fa-pencil" aria-hidden="true"></i>
</strong></button> <button type='button' style="margin-left:auto;height: 30px;
    width: 30px;border:2px;" onclick='delete_address(${i})'><strong style='color:red;'><i class="fa fa-trash" aria-hidden="true"></i>
</strong></button>
               </div>   </div>`
         }
         document.getElementById('add-body').innerHTML = data;
     }else{
          document.getElementById('add-body').innerHTML = 'Keine Adresse';
     }
     }
     
     
     
     
     
    function edit_address(i){
        
          let address = JSON.parse(localStorage.getItem('Address'))
          if (i >= 0 && i < address.length) {
    let selectedAddress = address[i]; // Retrieve the address at index 'i'
    // Now you have the 'selectedAddress' that you can edit or use as needed
    console.log(selectedAddress.state);
    
      document.getElementById("address12").value=selectedAddress.address1;
    document.getElementById("address22").value=selectedAddress.address2;
    document.getElementById("area2").value=selectedAddress.area;
     document.getElementById("city2").value=selectedAddress.city;
      document.getElementById("postal_code2").value=selectedAddress.postal_code;
      document.getElementById("state2").value=selectedAddress.state;
        document.getElementById("edit_btn").innerHTML=`<button class="btn btn-warning" type="button" onclick='edit_i_address(${i})'>Save</button>`;
 
      var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/getareas.php", requestOptions)
  .then(response => response.json())
  .then(result =>{
    
      if(result.status===true){
          let data='';
          console.log('ok');
          var code_data=result.Data;
          for(let i = 0; i < code_data.length;i++){
           data += `<option value="${code_data[i].postal_code}" onclick='shipping_cost(${i})'>${code_data[i].postal_code}</option>`;

          }
            document.getElementById("postal_code2").innerHTML=data;
      }
  })
  .catch(error => console.log('error', error));
  } else {
    console.log('Index out of range.');
  }
         
    }
    
    
    
    function shipping_cost(i){
    var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/getareas.php", requestOptions)
  .then(response => response.json())
  .then(result =>{
    
      if(result.status===true){
          let data='';
          console.log('ok');
          var code_data=result.Data;
       
         
          
            document.getElementById("shipping_cost").value=code_data[i].min_order_price;
            console.log(document.getElementById("shipping_cost").value)
      }
  })
  .catch(error => console.log('error', error));

}



function edit_i_address(i){
     let address1=document.getElementById("address12").value;
     let address2=document.getElementById("address22").value;
      let city=document.getElementById("city2").value;
      let area=document.getElementById("area2").value;
        let postal_code=document.getElementById("postal_code2").value;
           let state=document.getElementById("state2").value;
           
           
             let address = JSON.parse(localStorage.getItem('Address'))
          if (i >= 0 && i < address.length) {
    let selectedAddress = address[i]; // Retrieve the address at index 'i'
    selectedAddress.address1=address1;
    selectedAddress.address2=address2;
    selectedAddress.city=city;
     selectedAddress.area=area;
   selectedAddress.postal_code=postal_code;
   selectedAddress.state=state
    localStorage.setItem('Address', JSON.stringify(address));
      var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/getareas.php", requestOptions)
  .then(response => response.json())
  .then(result =>{
    
      if(result.status===true){
          let data='';
          console.log('ok');
          var code_data=result.Data;
          for(let i = 0; i < code_data.length;i++){
           data += `<option value="${code_data[i].postal_code}" onclick='shipping_cost(${i})'>${code_data[i].postal_code}</option>`;

          }
            document.getElementById("postal_code2").innerHTML=data;
      }
  })
  .catch(error => console.log('error', error));
   window.location.href = 'address.html';

  } else {
    console.log('Index out of range.');
  }
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