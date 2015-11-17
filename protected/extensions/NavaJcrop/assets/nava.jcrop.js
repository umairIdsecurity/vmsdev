/**
 * NavaJcrop class file.
 * This extension is a wrapper of http://blueimp.github.io/JavaScript-Load-Image/
 *
 * @author Le Phuong <notteen@gmail.com>
 * @website http://navagroup.net
 * @version 0.2
 * @license http://www.opensource.org/licenses/MIT
 */
$(function () {
    'use strict';
    if(unique != ''){
        var uniqueId = unique;
    } else {
        var uniqueId = '';
    }
    var minSize = [100,100/aspectRatio];
    var result = $('#jcrop_result'+uniqueId),
        exifNode = $('#exif'+uniqueId),
        thumbNode = $('#thumbnail'+uniqueId),
        actionsNode = $('#jcrop_actions'+uniqueId),
        currentFile,
        replaceResults = function (img) {
            var content;
            if (!(img.src || img instanceof HTMLCanvasElement)) {
                content = $('<span>Loading image file failed</span>');
                result.children().replaceWith(content);
            } else {
                result.append(img);
                result.attr('style',resultStyle);
                actionsNode.attr('style','text-align: center;');
                $('#JcropOverlay'+uniqueId).removeClass('hide');
                var imgNode = result.find('img, canvas'),
                    img = imgNode[0];
                imgNode.Jcrop({
                    aspectRatio: aspectRatio,
                    setSelect: [40, 40, img.width - 40, img.height - 40],
                    minSize: minSize,
                    allowSelect: false,
					onSelect: function (coords) {
						coordinates = coords;
					}
                });
            }
            if (img.getContext) {
                actionsNode.show();
            }
        },
        appendToDiv = function (img){
            var content;
            if (!(img.src || img instanceof HTMLCanvasElement)) {
                content = $('<span>Loading image file failed</span>');
                result.children().replaceWith(content);
                errorFunction();
            } else {
                var object = $('#jcrop_image'+uniqueId);
                object.attr('src',img.toDataURL());
                $('.jcrop-holder').remove();
                actionsNode.attr('style','display: none;');
                result.attr('style','');
                //$('canvas').remove();
                $('#JcropOverlay'+uniqueId).addClass('hide');
                successFunction(object,img.toDataURL());
            }
        },
        displayImage = function (file, options) {
            currentFile = file;
            if (!loadImage(file, replaceResults, options)) {
                result.children().replaceWith(
                    $('<span>Your browser does not support the URL or FileReader API.</span>')
                );
            }
        },
        displayExifData = function (exif) {
            var thumbnail = exif.get('Thumbnail'),
                tags = exif.getAll(),
                table = exifNode.find('table').empty(),
                row = $('<tr></tr>'),
                cell = $('<td></td>'),
                prop;
            if (thumbnail) {
                thumbNode.empty();
                loadImage(thumbnail, function (img) {
                    thumbNode.append(img).show();
                }, {orientation: exif.get('Orientation')});
            }
            for (prop in tags) {
                if (tags.hasOwnProperty(prop)) {
                    table.append(
                        row.clone()
                            .append(cell.clone().text(prop))
                            .append(cell.clone().text(tags[prop]))
                    );
                }
            }
            exifNode.show();
        },
        dropChangeHandler = function (e) {
            e.preventDefault();
            e = e.originalEvent;
            var target = e.dataTransfer || e.target,
                file = target && target.files && target.files[0],
                options = {
                    maxWidth: resultMaxWidth,
                    canvas: true
                };
            if (!file) {
                return;
            }
            thumbNode.hide();
            loadImage.parseMetaData(file, function (data) {
                if (data.exif) {
                    options.orientation = data.exif.get('Orientation');
                    displayExifData(data.exif);
                }
                displayImage(file, options);
            });
        },
        coordinates;
    if (window.createObjectURL || window.URL || window.webkitURL || window.FileReader) {
        result.children().hide();
    }
    $('#jcrop_fileinput'+uniqueId).on('change', dropChangeHandler);
    $('#jcrop_edit'+uniqueId).on('click', function (event) {
        event.preventDefault();
        var imgNode = result.find('img, canvas'),
            img = imgNode[0];
        imgNode.Jcrop({
            aspectRatio: aspectRatio,
            setSelect: [40, 40, img.width - 40, img.height - 40],
            minSize: minSize,
            allowSelect: false,
            onSelect: function (coords) {
                coordinates = coords;
            }
        }).parent().on('click', function (event) {
            event.preventDefault();
        });
    });
    $('#jcrop_crop'+uniqueId).on('click', function (event) {
        event.preventDefault();
        var img = result.find('img, canvas')[0];
        if (img && coordinates) {
            appendToDiv(loadImage.scale(img, {
                left: coordinates.x,
                top: coordinates.y,
                sourceWidth: coordinates.w,
                sourceHeight: coordinates.h,
                minWidth: resultMinWidth
            }), event);
            coordinates = null;
        }
    });
    $('#jcrop_cancel'+uniqueId).on('click', function (event) {
        $('.jcrop-holder'+uniqueId).remove();
        actionsNode.attr('style','display: none;');
        result.attr('style','max-width: 350px;');
        $('#JcropOverlay'+uniqueId).addClass('hide');
        $('canvas').remove();
    });
    $('#load_image'+uniqueId).hover(function(){
        $('#load_image_hover'+uniqueId).removeClass('hide');
    }, function(){
        $('#load_image_hover'+uniqueId).addClass('hide');
    });
});
