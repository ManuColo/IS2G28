$(document).ready(function() {
  $('.btn-answer').click(function() {
    console.log(this);
    console.log($(this));
    console.log($(this).next());    
    // Ocultar boton para responder pregunta
    $(this).addClass('hidden');    
    // Mostrar panel que contiene el formulario para responder pregunta
    $(this).next().removeClass('hidden');
    
  });
});