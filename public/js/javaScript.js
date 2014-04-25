window.onload = function () {
window.setTimeout( vanishText, 3000 ); // 3000 is 3 seconds
}

function vanishText() {
var divs = document.getElementsByName( 'ddiv' );
for (var i=0;i<divs.length;i++)
{ 
divs[i].style.visibility = 'hidden';
}
} 

function getUsuarios(){
	var roles = document.getElementsByName("rol");
	     for(i=0;i<roles.length;i++){
               if(roles[i].checked) {
                    var rol=roles[i];
               }
          }
          


	req = new XMLHttpRequest();
	req.onreadystatechange=llenar;
	req.open("GET", "/procesos/usuariosRoles?rol="+rol.value, true);
	req.send(null);

}

function llenar(){
	if(req.readyState==4)
	document.getElementById("usuarios").innerHTML = req.responseText;
}

function getUsers(value){
          var boxes = document.getElementsByName("boxes");
          for(i=0;i<boxes.length;i++){
               boxes[i].style.visibility="hidden";
               boxes[i].style.display="none";
               var arrInputs = boxes[i].childNodes;
                    for(j=0;j<arrInputs.length;j++){   
                    arrInputs[j].checked = false;
                    }         
          }
     	document.getElementById(value).style.visibility="";
     	document.getElementById(value).style.display="";
}

