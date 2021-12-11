//navbar

	let active=document.getElementById("active");
	let navNormal=document.getElementById("navNormal");
	let ul=document.getElementById("oculto");
	let contador=0;

	active.addEventListener("click",function() {
		
		contador++;
		if(contador%2==1) {
			navNormal.style.height="100vh";
			active.className="bi bi-x-lg";
			navNormal.style.display="flex";
			oculto.style.display="flex";
			
			oculto.style.height="100vh";
		} else {
			navNormal.style.height="10vh";
			active.className="bi bi-list";
			navNormal.style.display="none";
			
			oculto.style.height="0%";
		}
	});



window.onload=function() {
	var contenedor_carga=document.getElementById("contenedor_carga");
	contenedor_carga.style.visibility="hidden";
	contenedor_carga.style.opacity="0";
	contenedor_carga.style.display="none";
}

var contadorExc=0;
