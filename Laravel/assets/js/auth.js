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



 function login(){
          const email = document.getElementById("login_email").value;
          const password=document.getElementById("login_password").value;
          const token='as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';
          
          var formdata=new FormData();
          formdata.append('email',email);
          formdata.append('password',password);
          formdata.append('token',token);
          
          var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/login.php',requestOptions)
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
        document.getElementById("login_email").value='';
         document.getElementById("login_password").value='';
         window.location.href = 'profile.html';
    }else{
         $(".alert").addClass("alert-danger");
          document.getElementById('error_alert').innerHTML=result.message;
         $('.alert').show();
         setTimeout(removeDiv, 5000);
   
      
    }
})
  .catch(error => console.log('error', error));
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