$(function () {
    'use strict';

    $('#image-gallery-button').on('click', function (event) {
        event.preventDefault();
        blueimp.Gallery($('#links a'), $('#blueimp-gallery').data());
    });

    var dir = "https://21102541.users.info.unicaen.fr/MetaImage/img";
    var fileextension = ".jpg";
    $.ajax({
        //This will retrieve the contents of the folder if the folder is configured as 'browsable'
        url: dir+'/thumbnails',
        success: function (data) {
            var linksContainer = $('#links');

            console.log("test");
            //$("#fileNames").html('<ul>');
            //List all png or jpg or gif file names in the page
            $(data).find("a:contains(" + fileextension + ")").each(function () {
            var filename = this.href.replace(window.location.host, "").replace("https://", "").replace("/MetaImage","").replace(".jpg","");
            console.log("filename:",filename);


            var thumbnails = dir+"/thumbnails" + filename;
            var img = dir + filename.substring(0,filename.length-2) + ".jpg";
            console.log(img);

            $('<a/>')
                .append($('<img>').prop('src', thumbnails))
                .prop('href', img)
                .prop('title', filename)
                .attr('data-gallery', '')
                .appendTo(linksContainer);
        });
        }
    });
});
