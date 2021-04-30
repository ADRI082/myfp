$(document).ready(function(){

  /*if (window.location.pathname.includes("/crearPlantillaPresupuesto")) {
    var editor = CKEDITOR.replace( 'templatesPresupuesto' );
    CKFinder.setupCKEditor( editor, '/ckfinder/' );
  }*/


  $('#templatesPresupuesto').summernote({
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color'],
      ['insert', ['picture']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['style', ['style']],
      ['fontname', ['fontname']],
      ['table', ['table']],
      ['view', ['fullscreen', 'codeview', 'help']],
      ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
      ['float', ['floatLeft', 'floatRight', 'floatNone']],
      ['remove', ['removeMedia']]    
      ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
      ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],      
    ],
    
  });




});

