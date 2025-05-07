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


user =JSON.parse(localStorage.getItem("USER"));
if(user!=null){
     document.getElementById("upname").innerHTML=user.name;
     document.getElementById("upemail").innerHTML=user.email;
    document.getElementById("name").value=user.name;
     document.getElementById("email").value=user.email;
      document.getElementById("phone").value=user.phone;
}else{
      document.getElementById("upname").innerHTML='';
     document.getElementById("upemail").innerHTML='';
    document.getElementById("name").value='';
     document.getElementById("email").value='';
      document.getElementById("phone").value='';
}
address =JSON.parse(localStorage.getItem("Address"));
if(user!=null){
    document.getElementById("address1").value='';
    document.getElementById("address2").value='';
    document.getElementById("area").value='';
     document.getElementById("city").value='';
      document.getElementById("postal_code").value='';
      document.getElementById("state").value='';
}else{
       document.getElementById("address1").value='';
    document.getElementById("address2").value='';
    document.getElementById("area").value='';
     document.getElementById("city").value='';
      document.getElementById("postal_code").value='';
      document.getElementById("state").value='';
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
let selectedIndex = ''; 
function edit_profile(){
    
     let name=document.getElementById("name").value;
     let email=document.getElementById("email").value;
      let phone=document.getElementById("phone").value;
     let token='as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';
     let user_id=user.user_id;
      var formdata=new FormData();
      formdata.append('name',name);
          formdata.append('email',email);
          formdata.append('phone',phone);
          formdata.append('token',token);
           formdata.append('user_id',user_id);
          
          var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/editprofile.php',requestOptions)
.then(response=>response.json()).then(result => {
    if(result.status===true){
       let user =JSON.parse(localStorage.getItem("USER")) || [];
     console.log(user)
       console.log(result.data)
       let data=result.data;
       console.log(user)
       if(user.length > 0){
             console.log('Have a value');
             user.splice(0,1);
             
         localStorage.setItem('USER',JSON.stringify(data));
       }else{
            localStorage.setItem('USER',JSON.stringify(data));
       }
       
         window.location.href = 'profile.html';
    }else{
       alert(result.message);
    }
})
  .catch(error => console.log('error', error));
    
    

        
      }
function logout(){
      localStorage.clear();
  
  // Redirect the user to the home page
  window.location.href = 'index.html'; 
}
console.log(selectedIndex)
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