//function muestraMensaje(){
//    alert('putoooooo');
//}
//
//function resalta(elevento){
//    var evento = elevento || window.event;
//    switch(evento.type){
//        case 'mouseover':
//            this.style.borderColor = 'black';
//            break;
//        case 'mouseout':
//            this.style.borderColor = 'silver';
//            break;            
//    }
//}
//window.onload = function(){
//    document.getElementById("formulario").onclick = muestraMensaje;
//    document.getElementById("formulario").onmouseover = resalta;
//    document.getElementById("formulario").onmouseout = resalta;
    
//}
function nobackbutton(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}	
}