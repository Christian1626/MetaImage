$(function() {
    var keywords = $('#keyword').val();
    var title = $('#title_photo').val();

    var query = keywords ? keywords: title;

    if(query) {
         $('#flickrGallery').load("ajax/flickrGallery.php",{query:query},function() {
            $(".loading").fadeOut("slow");
         });
    }

    $('.form-horizontal').submit(function() {
        if(confirm('Appliquer définitivement les modifications aux metadatas sur l\'image :'+$('#old_title_photo').val() + " ?")) {
            return true;
        } else {
            return false;
        }
    });

    $(document).on('change', '.btn-file :file', function() {
      var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });


    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

    });
   
});