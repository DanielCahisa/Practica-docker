const OJO=document.querySelector(".ojo");
OJO.addEventListener("click",cambio);

function cambio (){
   
let imagen=OJO.getAttribute("src");

    if(imagen=="../img/ojo2.png"){
       OJO.src="../img/ojo.png";
       document.querySelector("#contrasenya").setAttribute("type","password");
    } else {
        OJO.src="../img/ojo2.png";
        document.querySelector("#contrasenya").setAttribute("type","text");
    }
}