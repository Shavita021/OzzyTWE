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
