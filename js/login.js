var up=document.getElementById("up");
var overlay=document.getElementById("overlay");
var card1=document.getElementById("card1");
var tituloOverlay=document.getElementById("tituloOverlay");
var parrafoOverlay=document.getElementById("parrafoOverlay");
var elementosLogin=document.getElementById("elementosLogin");
var signUp=document.getElementById("signUp");
var contador=0;

up.addEventListener("click",function() {
   contador++;
   //detectamos el ancho de la pantalla
   let ancho=screen.width;
  
   if(contador%2==1) {
       signUp.style.visibility="visible";
       overlay.style.transition="all 1s";
       elementosLogin.style.transition="all 1s";
       if(ancho>=992) {//dispositivos grandes
        overlay.style.transform="translateX(-100%)";
        elementosLogin.style.transform="translateX(10vh)";  
        signUp.style.transform="translateX(0vh)";   
       } else {//dispositivos pequeños
        overlay.style.transform="translateY(-100vh)";
       }
       //cambio de texto
       tituloOverlay.innerText="Welcome Back!";
       parrafoOverlay.innerText="To keep connected with us please login with your personal info";
       up.innerText="SIGN IN";
   } else {

       elementosLogin.style.visibility="visible";
       overlay.style.transition="all 1s";
       signUp.style.transition="all 1s";
       if(ancho>=992) {//dispositivos grandes
         overlay.style.transform="translateX(0vh)";
         elementosLogin.style.transform="translateX(0vh)";
         signUp.style.transform="translateX(-8vh)";  
       } else {//dispositivos pequeños
         overlay.style.transform="translateY(0vh)";
       }

       //cambio de texto
       tituloOverlay.innerText="Hello, Friend!";
       parrafoOverlay.innerText="Enter your personal details and start journey with us";
       up.innerText="SIGN UP";
   }
  
});

