window.onload = function () {
window.setTimeout( vanishText, 8000 ); // 3000 is 3 seconds
}

    var timer;
    var status = 1;

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
            
     	        status = 1;
        timer = setTimeout(function() {
            if (status == 1) {
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
        }, 500);
}

function getUsers2(value){
        clearTimeout(timer);
        status = 0;
          var boxes = document.getElementsByName("boxes");
          for(i=0;i<boxes.length;i++){
               boxes[i].style.visibility="hidden";
               boxes[i].style.display="none";
               var arrInputs = boxes[i].childNodes;
                    for(j=0;j<arrInputs.length;j++){   
                    arrInputs[j].checked = false;
                    }         
          }
          var boxes = document.getElementById(value).childNodes;
               for(j=0;j<boxes.length;j++){   
                    boxes[j].checked = true;
               }            
          
     	document.getElementById(value).style.visibility="";
     	document.getElementById(value).style.display="";
}


