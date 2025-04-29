    
       var params = new URLSearchParams(window.location.search);
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
// Get the 'id' parameter from the URL
var id = params.get('id');



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
          console.log(formattedPrice);
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