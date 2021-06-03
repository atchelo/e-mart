"use strict";
// Define your library strictly...
$(function() {
    onLoad();
});
let flareExample;

function onLoad() {
    var divHeight = $("#aniBox").height();
    var divWidth = $("#aniBox").width();
    flareExample = new FlareExample(document.getElementById("canvas"), function() {
        flareExample.load(baseUrl + '/js/emartLogin.flr', function(error) {
            if(error) {
                console.log("failed to load actor file...", error);
            }
        });
        flareExample.setSize(divHeight + 450, divHeight + 260);
        document.body.addEventListener('dragover', function(evt) {
            evt.stopPropagation();
            evt.preventDefault();
            evt.dataTransfer.dropEffect = "copy";
        }, true);
        document.body.addEventListener('dragleave', function(evt) {
            evt.stopPropagation();
            evt.preventDefault();
        });
        document.body.addEventListener("drop", function(evt) {
            // Reload another actor by dragging and dropping the file in.
            evt.stopPropagation();
            evt.preventDefault();
            const files = evt.dataTransfer.files;
            flareExample.load(files[0], function(error) {
                if(error) {
                    console.log("oh no", error);
                }
            });
        }, true);
    });
}
