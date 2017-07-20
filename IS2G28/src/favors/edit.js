$(document).ready(function() {
  
  var favorPhotoControl = $('#favor_photo');
      
  /**
   * Manejador del click en el checkbox para remover foto del favor 
   */
  $('#favor_photo_deleted_flag').click(function() {        
    if ($(this).prop('checked')) {
      // Si el checkbox está marcado,
      // Resetear e inhabilitar campo para subir nueva foto          
      resetInputFileElement(favorPhotoControl);
      favorPhotoControl.prop('disabled', true);                    
    } else {
      // Habilitar campo para subir nueva foto
      favorPhotoControl.prop('disabled', false);          
    }        
  });

  function resetInputFileElement(element) {
    element.wrap('<form>').closest('form').get(0).reset();
    element.unwrap();
  };
  
})();

