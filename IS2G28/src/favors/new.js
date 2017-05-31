$(document).ready(function() {
  $('#favor-form').submit(
    /**
     * Manejador que se ejecuta al solicitar el envio del formulario al servidor.
     * Valida que los datos del formulario sean correctos.
     * 
     * @returns {Boolean}
     */
    function() {        
      var form = $('#favor-form');
      var errors = {};                        
      // Remover errores del formulario
      removeFormErrors(form);        
      // Validar campos del formulario, obteniendo errores resultantes
      errors = validateFormFields();        
      // Comprobar si hay errores de validacion
      if (Object.keys(errors).length > 0) {
        // Notificar errores de validacion
        showFormErrors(form, errors);
        // Cancelar envio del formulario
        return false;
      }        
  });

  /**
   * Retorna una version limpia del valor de entrada dado.
   * Esto implica remover los espacios en blanco al comienzo y final del valor dado.
   * 
   * @param {string} value
   * @returns {string}
   */
  function cleanInput(value) {
    return $.trim(value);        
  }

  /**
   * Remover errores de los controles del formulario.
   * 
   * @param {type} form
   * @returns {undefined}
   */
  function removeFormErrors(form) {
    // Obtener controles del formulario
    var formControls = form.find(':input');
    // Remover error (si lo hubiera) para cada control del formulario
    formControls.each(function() {
      $(this).parent().parent().removeClass('has-error');                    
      if ($(this).next('.error').length > 0) {
        $(this).next().removeClass('show');  
        $(this).next().addClass('hidden');  
      }          
    });        
  }

  function validateFormFields() {
    var errors = {};        
    // Obtener campos del formulario
    var favorTitle = cleanInput($('#favor_title').val());
    var favorDescription = cleanInput($('#favor_description').val());      
    var favorCity = cleanInput($('#favor_city').val());
    var favorDeadline = cleanInput($('#favor_deadline').val());
    var favorPhoto = $('#favor_photo').val();                        

    // Validar datos introducidos en los campos del formulario
    if (favorTitle === '') {
      errors['favor_title'] = 'Titulo requerido';          
    }        
    if (favorDescription === '') {
      errors['favor_description'] = 'Descripcion requerida';          
    }        
    if (favorPhoto === '') {
      errors['favor_photo'] = 'Foto requerida';          
    }        
    if (favorCity === '') {
      errors['favor_city'] = 'Ciudad requerida';          
    }        
    if (favorDeadline === '') {
      errors['favor_deadline'] = 'Fecha limite requerida';          
    } else {          
      var deadline = moment(favorDeadline, "DD/MM/YYYY");
      // Comprobar si la fecha es valida o no
      if (!(deadline.isValid())) {
        errors['favor_deadline'] = 'Fecha limite invalida';
      } else  { // Fecha valida, verificar que no sea previa a la fecha actual            
        var now = moment();
        if (deadline.isBefore(now, 'day')) {
          errors['favor_deadline'] = 'La fecha limite no puede ser anterior a la fecha actual';              
        }             
      }
    }

    return errors;        
  }

  /**
   * Presenta los errores de validacion del formulario.
   * 
   * @param {type} form
   * @param {Object} errors
   */
  function showFormErrors(form, errors) {
    // Obtener controles del formulario
    var formControls = form.find(':input');
    // Mostrar errores en el formulario                
    formControls.each(function() {          
      if (errors[this.id]) {
        $(this).parent().parent().addClass('has-error');
        $(this).next().removeClass('hidden');
        $(this).next().addClass('show');
        $(this).next().html(errors[this.id]);
      }
    });
  }
  
});

