/*
 * Bootstrap Image Gallery JS Demo
 * https://github.com/blueimp/Bootstrap-Image-Gallery
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint unparam: true */
/*global blueimp, $ */

$(function () {
    'use strict';

    $('#image-gallery-button').on('click', function (event) {
        event.preventDefault();
        blueimp.Gallery($('#links a'), $('#blueimp-gallery').data());
    });

   /* var current_url = window.location.href.replace("/index.php","");
    var dir = current_url+"/img";
    var fileextension = ".jpg";
    $.ajax({
        //This will retrieve the contents of the folder if the folder is configured as 'browsable'
        url: dir+'/thumbnails',
        success: function (data) {
            var linksContainer = $('#links');

            //$("#fileNames").html('<ul>');
            //List all png or jpg or gif file names in the page
            $(data).find("a:contains(" + fileextension + ")").each(function () {
            var filename = this.href.replace(window.location.host, "").replace("https://", "").replace("/MetaImage","").replace(".jpg","");


            var thumbnails = dir+"/thumbnails" + filename;
            var img = dir + filename.substring(0,filename.length-2) + ".jpg";

            $('<a/>')
                .append($('<img>').prop('src', thumbnails))
                .prop('href', img)
                .prop('title', filename)
                .attr('data-gallery', '')
                .appendTo(linksContainer);
        });
        }
    });*/
});
