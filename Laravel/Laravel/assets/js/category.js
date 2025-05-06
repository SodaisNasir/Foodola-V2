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

 function menu_click(id) {
          console.log('hello')
        }
       var params = new URLSearchParams(window.location.search);

// Get the 'id' parameter from the URL
var id = params.get('id');

var formdata = new FormData();
formdata.append("token", "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC");
formdata.append("main_category_id", id);

var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch("https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/sub_categories.php", requestOptions)
  .then(response => response.json())
   .then(result => {
   
    if (result.status === true) {
        
      var dealsData = result.Data; // Extract deals_data from the result
      console.log(dealsData);
      var data = '';

      dealsData.forEach(function(resp) {
        data += `<div class="card 1" style="margin: 30px auto;
  width: 300px;
  height: 300px;
  border-radius: 40px;
   background-image:
    linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0,0, 1)),
   url('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/admin_panel/Uploads/${resp.img}');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  background-repeat: no-repeat;
  transition: 0.4s;" onclick='submenu_click(${resp.id})'>
  <div class="card_image"> </div>
  <div class="card_title title-white">
    <p>${resp.name}</p>
  </div>
</div>`;
      });

      document.getElementById('cards-list').innerHTML = data;
      // // console.log(dealsData);
    } else {
      console.error("Error:", dealsData);
    }
  })
  .catch(error => console.log('error', error));
  
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
  //   {
//       if(result.status === true){
//           var all_data=result.Data;
//           console.log(all_data);
//       }}