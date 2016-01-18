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

    // Load demo images from flickr:
    /*$.ajax({
        // Flickr API is SSL only:
        // https://code.flickr.net/2014/04/30/flickr-api-going-ssl-only-on-june-27th-2014/
        url: 'https://api.flickr.com/services/rest/',
        data: {
            format: 'json',
            method: 'flickr.interestingness.getList',
            api_key: '7617adae70159d09ba78cfec73c13be3' // jshint ignore:line
        },
        dataType: 'jsonp',
        jsonp: 'jsoncallback'
    }).done(function (result) {
        var linksContainer = $('#links'),
            baseUrl;
        // Add the demo images as links with thumbnails to the page:
        $.each(result.photos.photo, function (index, photo) {
            baseUrl = 'https://farm' + photo.farm + '.static.flickr.com/' +
                photo.server + '/' + photo.id + '_' + photo.secret;
            $('<a/>')
                .append($('<img>').prop('src', baseUrl + '_s.jpg'))
                .prop('href', baseUrl + '_b.jpg')
                .prop('title', photo.title)
                .attr('data-gallery', '')
                .appendTo(linksContainer);
        });
    });*/

    $('#image-gallery-button').on('click', function (event) {
        event.preventDefault();
        blueimp.Gallery($('#links a'), $('#blueimp-gallery').data());
    });

    var dir = "img/";
    var fileextension = ".jpg";
    $.ajax({
        //This will retrieve the contents of the folder if the folder is configured as 'browsable'
        url: 'https://21101130.users.info.unicaen.fr/MetaImage/img/thumbnails',
        success: function (data) {
            var linksContainer = $('#links');

            console.log("test");
            //$("#fileNames").html('<ul>');
            //List all png or jpg or gif file names in the page
            $(data).find("a:contains(" + fileextension + ")").each(function () {
            var filename = this.href.replace(window.location.host, "").replace("https://", "").replace("/MetaImage","").replace(".jpg","");
            console.log("filename:",filename);


            var baseUrl = "https://21101130.users.info.unicaen.fr/MetaImage/img";
            var thumbnails = baseUrl+"/thumbnails" + filename;
            var img = baseUrl + filename.substring(0,filename.length-2) + ".jpg";
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
