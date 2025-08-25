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

function register(){
     const email = document.getElementById("email").value;
          const password=document.getElementById("password").value;
           const firstname=document.getElementById("firstname").value;
              const phone_code=document.getElementById("phone_code").value;
                const phone=document.getElementById("phone").value;
          const token='as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC';
          const phone_number = phone_code+phone;
         
          var formdata=new FormData();
          formdata.append('email',email);
            formdata.append('name',firstname);
             formdata.append('phone',phone_number);
              formdata.append('role_id',3);
          formdata.append('password',password);
          formdata.append('token',token);
          
          var requestOptions = {
  method: 'POST',
  body: formdata,
  redirect: 'follow'
};

fetch('https://xn--pizzablitzstringen-m3b.de/pizza_blitz/API/register.php',requestOptions)
.then(response=>response.json()).then(result => {
    if(result.status===true){
        
        
         var u = localStorage.getItem("USER");
// let cart=JSON.parse('x');
let user=JSON.parse(u);
console.log(user)
       console.log(result.data)
       let data=[];
        data=result.Data;
       console.log(user)
if (u != null && Array.isArray(u)) {
    console.log('Have a value');
    
    // Check if the array 'u' is not empty before attempting to splice
    if (u.length > 0) {
        u.splice(0, 1); // Remove the first element from the array
    }

    // Assuming 'data' is an object you want to store in localStorage
    localStorage.setItem('USER', JSON.stringify(data));
} else {
    localStorage.setItem('USER', JSON.stringify(data));
}
     
 window.location.href = "profile.html";
    }else{
        data=result.Message;
      alert(data)
    }
})
  .catch(error => console.log('error', error));
}