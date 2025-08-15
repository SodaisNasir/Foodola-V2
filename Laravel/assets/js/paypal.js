$(document).ready(function(){
    let usercheck1=JSON.parse(localStorage.getItem('USER'));
if(usercheck1 === null){
    window.location.href = '403.html';
     document.getElementById("auth").innerHTML=` <a class="nav-link" href="auth.html">Registrieren/Anmelden</a>`
}else{
     document.getElementById("auth").innerHTML=` <a class="nav-link" onclick='logout()'>Ausloggen</a>`
}
})

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
function logout(){
      localStorage.clear();
  
  // Redirect the user to the home page
  window.location.href = 'index.html'; 
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
  
         

$(document).ready(function() {
  var $form = $("#payment-form");

  $form.on('submit', function(e) {
    
      
      
      
      
      
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey('pk_live_51LlaKbKyS5chIvjo7MImS7c73gYG6V6sOoDwmO6rOKi2zoZrBaYjC22LVykI9TUS3Bdi1atCuKbUKyiEEyJd9J06009YkZmkv8');
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
    if (response.error) {
      $('.error')
        .removeClass('hide')
        .find('.alert')
        .text(response.error.message);
    } else {
      // token contains id, last4, and card type
      var token = response['id'];
      // insert the token into the form so it gets submitted to the server
      $form.find('input[type=text]').empty();
      $form.append("<input type='hidden' name='reservation[stripe_token]' value='" + token + "'/>");
   const stripeApiKey = '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'; // Replace with your Stripe API key
     var x = localStorage.getItem("cart");

// let cart=JSON.parse('x');


let cart=JSON.parse(x);
let total=0;
// console.log(total);
for(var a = 0 ; a < cart.length ; a++){
   var num = Number(cart[a].product_net_total)
 
    total+=num
  
}
const chargeData = {
  amount: parseFloat(total)*100, // Amount in cents
  currency: 'usd',
  source: token, // Replace with a valid test card token
  description: 'Example charge',
};

fetch('https://api.stripe.com/v1/charges', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${stripeApiKey}`,
    'Content-Type': 'application/x-www-form-urlencoded',
  },
  body: new URLSearchParams(chargeData).toString(),
})
.then(response => response.json())
.then(data => {
  console.log('Charge created:', data);
  

 var a = localStorage.getItem("address");

// let cart=JSON.parse('x');


var o = localStorage.getItem("order_type");
let type=JSON.parse(o);
let address=JSON.parse(a);
var u = localStorage.getItem("USER");

// let cart=JSON.parse('x');


let user=JSON.parse(u);
let additionNotes='';

console.log(user.user_id);
console.log(address.address1);
console.log(address.address2);
console.log(address.city);
console.log(address.area);
console.log(address.state);
console.log(total);
console.log(address.postal_code);
console.log(cart);
 let shippingcost = JSON.parse(localStorage.getItem('shipping'));

     
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
formdata.append('payment_type', 'online');
formdata.append('payment_status', 'paid');
formdata.append('order_type', type);
formdata.append('transaction_id', data.id);
formdata.append('payment_method', 'stripe');
formdata.append('additional_notes', additionNotes); // Fixed typo: 'addtional_notes' to 'additional_notes'
formdata.append('Shipping_cost', shippingcost);
formdata.append('Shipping_postal_code', address.postal_code);
formdata.append('order_datails', x); // Fixed typo: 'order_datails' to 'order_details'
console.log(formdata);
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
    // alert(result[0].Message);
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
})
.catch(error => {
  console.error('Error creating charge:', error);
});
  
    }
  }
})






var x = localStorage.getItem("cart");

// let cart=JSON.parse('x');


let cart=JSON.parse(x);

let total=0;
// console.log(total);
for(var a = 0 ; a < cart.length ; a++){
   var num = Number(cart[a].product_net_total)
 
    total+=num
  
}






paypal

  .Buttons({
      style: {
    layout:  'vertical',
    color:   'blue',
    shape:   'rect',
    label:   'paypal'
  },
    createOrder: function (data, actions) {
      // This function is called when the user clicks the PayPal button.
      // You should define and return an order object here.
      return actions.order.create({
        purchase_units: [
          {
            amount: {
                 currency_code: 'USD',
              value: total, // The amount you want to charge the user
             
            },
            item_list:{
                items:cart,
            },
          },
        ],
       
      });
    },
    client: {
        /* steps for generating credentials ...
           1) go to "My Apps & Credentials" at https://developer.paypal.com/developer/applications/
           2) under "REST API Apps" click "Create App" button
           3) click on that app to get "Client ID" Credentials
           4) by default you are under the sandbox tab so you'll get the sandbox Credentials
           5) You may also get the live credentials -- you may want to ensure that you are not using the live credentials
        */
        sandbox: 'AYv5BhA5WVUDCfqcCSTh_V4bsuKEaOwrNkIEZs_Pyu6s_uIAq2-RDNbcRDu9TC1uegTad_Gb9gr9Qa1d' // from test1 app
      },
    onApprove: function (data, actions) {
      // This function is called when the payment is approved by the user.
      // You can execute actions like capturing the payment here.
      return actions.order.capture().then(function (details) {
        
        console.log('Payment completed:', details);
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

console.log(user.user_id);
console.log(address.address1);
console.log(address.address2);
console.log(address.city);
console.log(address.area);
console.log(address.state);
console.log(total);
console.log(address.postal_code);
console.log(cart);
 let shippingcost = JSON.parse(localStorage.getItem('shipping'));
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
formdata.append('payment_type', 'online');
formdata.append('payment_status', 'paid');
formdata.append('order_type', type);
formdata.append('payment_method', 'paypal');
formdata.append('transaction_id', details.id);
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
      });
    },
     onCancel: function(data) {
    // Handle the cancellation event
       alert('Die Zahlung wurde vom Benutzer storniert');
    console.log('Payment was canceled by the user');
    // You can redirect or show a cancellation message here
  },
  })
  
  .render('#paypal-button'); // Specify the ID of the HTML element where you want to render the PayPal button.



