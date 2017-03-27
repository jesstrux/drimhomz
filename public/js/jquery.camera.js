/**
* jQuery Camera
* ------------------------------------------
* Created by Sakol Assawasagool <http://www.koobitor.com>
*
* @license Dual licensed under the MIT or GPL Version 2 licenses
* @version 0.1.0
*/

// the semi-colon before the function invocation is a safety 
// net against concatenated scripts and/or other plugins 
// that are not closed properly.
;(function ( $, window, document, undefined ) {

  var video;
  var canvas;
  var ctx;
  var localMediaStream;
  var settings;

  // undefined is used here as the undefined global 
  // variable in ECMAScript 3 and is mutable (i.e. it can 
  // be changed by someone else). undefined isn't really 
  // being passed in so we can ensure that its value is 
  // truly undefined. In ES5, undefined can no longer be 
  // modified.
  
  // window and document are passed through as local 
  // variables rather than as globals, because this (slightly) 
  // quickens the resolution process and can be more 
  // efficiently minified (especially when both are 
  // regularly referenced in your plugin).

  // Create the defaults once
  var camera = 'camera',
      defaults = {
        resolution: "HD",
        front: false,
        snap: function(result) {},
        reset: function(result) {},
        flip: function(facing){}
      };

  // The actual plugin constructor
  function Plugin( element, options ) {
      this.$element = $(element);

      // jQuery has an extend method that merges the 
      // contents of two or more objects, storing the 
      // result in the first object. The first object 
      // is generally empty because we don't want to alter 
      // the default options for future instances of the plugin
      this.options = $.extend( {}, defaults, options);

      settings = $.extend( {}, defaults, options);
      
      this._defaults = defaults;
      this._name = camera;

      this.init();
  }

  Plugin.prototype.init = function () {
    // Place initialization logic here
    // You already have access to the DOM element and
    // the options via the instance, e.g. this.$element 
    // and this.options

    plugin = this;

    var $elements = [

      $('<video>', {
        id: 'camera-video',
        autoplay: 'autoplay'
      }),

      $('<img>', {
        id: 'camera-img'
      }),

      $('<canvas>', {
        id: 'camera-canvas'
      }),

      // $('<div>', {
      //   id: 'camera-flip',
      //   html: $('<img>', {
      //           src: 'data:image/png;base64,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'
      //         })
      // }),

      $('<div>', {
        id: 'camera-take',
        html: $('<img>', {
                src: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAAMFBMVEUAAADp6enz8/Py8vLp6enq6urx8fH9/f34+Pjr6+v5+fn29vbx8fH5+fn29vb///9uAR3/AAAAD3RSTlMAwu3as5mB/vXUP1Fmmbdt0FhcAAABmklEQVR42u3Y227DIBBF0cNwCRfX8/9/24dUwqmwcZihlVrWa2JtJQY0AsuyLMvypQRnXrlQdAuJ24xaJxOfowwNjq85yBH3REjxHXlio4JE5PkVy3cRRhm+L2FM4Hd4jMj8njzxpVc6f5b+1uf34YZgqOIRVJmABs/afOMc1EeN81yfw1HhOUr/AJEz/Y0nF3HAcunpYuvoraTHivxsxGx42sykCBUcFZoQ2fDdph2xt6eZ8YhDm1OMeJzxapGEc0kpQrhCOhFcU4kYXDMaERx92MjRfmDk4bs/hFqvycgjW3uoDIedL4+genD1QCWO0NkhYusHJI2k0y/VD5I04m5EnDTi6+rlV3Ud+1+M6P9d81+84hLe+WhXXMKMKp5MuarHCh7NDb/JIwkHtjVXJO2jPuw22j1g5GHJrUkSR/r3GVlpWsEVVooQzpE40p8ljOKYatFmWRrpX8tGVolUvjMHiyJV6NyHiSIV+ZIB5OKJWRzpW5E/ESGegwZuB4X3gzxH/4jQv7Q1rM80bkq0bWjIwegJGcuy/EufJpgcOKWitosAAAAASUVORK5CYII='
              })
      }),

      $('<div>', {
        id: 'camera-retake',
        html: $('<img>', {
                src: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAAMFBMVEUAAADv7+/k5OTe3t7n5+f5+fnZ2dnR0dHd3d3b29vu7u7u7u7f39+0tLTa2tr///+OSmDuAAAAD3RSTlMA9uS78P64Bc6LiMtnPKTGYFoFAAAA/0lEQVR42u3a0WrEIBCFYUdzEm018/5vW1htIcWtdsfSbTn/3SD4Xaqge6rKnQ73p8oCaD8grjEi9IsgZa3RD3YjQwfBmxHRYShWBDouGY1Ske1OFYlGJGtFXLe9rnoiRJ4BKaGTb8jZra1K6JS6BnRp3UMg6OJAxIpkLEY21+mUpfniGPu3eXNpaBxQa2GMKBEiH0m8Xl722qdx+y7yUsfXhrhaup5H+/Xp4IkQIUKECBEiRIgQIUKECBEiRIgQIfJTCOzI/H8FufU+pHwrNiTX2q7+Ou4ziLU0RjargTJGThgRcROJzUCeQQpMRnBTHYLHjeRmOz0eaguH+53eAC/Z0Ft5nCI5AAAAAElFTkSuQmCC'
              })
      })
    
    ];

    this.$element
        .css("position", "relative")
        .append($elements);
    
    video = document.querySelector("video");
    canvas = document.querySelector("canvas");
    ctx = canvas.getContext("2d");
    localMediaStream = null;

    this.$element.css({
      width: "640px",
      height: "360px",
      margin: "auto"
    });

    switch(this.options.resolution){
     
      case "GVGA":
        this.options.width = 320;
        this.options.height = 180;
        break;
   
      case "VGA":
        this.options.width = 640;
        this.options.height = 480;
        this.$element.css("height", this.options.height);
        $("#camera-img, #camera-video").css("height", this.options.height);
        break;
   
      default:
        this.options.width = 1920;
        this.options.height = 1080;
        
    }

    settings = this.options;

    canvas.width = this.options.width;
    canvas.height = this.options.height;

    var constraints = { 
      video: { 
        minWidth: this.options.width,
        minHeight: this.options.height,
        facingMode: (this.options.front? "user" : "environment")
      } 
    };

    // Older browsers might not implement mediaDevices at all, so we set an empty object first
    if (navigator.mediaDevices === undefined) {
      navigator.mediaDevices = {};
    }

    // Some browsers partially implement mediaDevices. We can't just assign an object
    // with getUserMedia as it would overwrite existing properties.
    // Here, we will just add the getUserMedia property if it's missing.
    if (navigator.mediaDevices.getUserMedia === undefined) {
      navigator.mediaDevices.getUserMedia = function(constraints) {

        // First get ahold of the legacy getUserMedia, if present
        var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

        // Some browsers just don't implement it - return a rejected promise with an error
        // to keep a consistent interface
        if (!getUserMedia) {
          return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
        }

        // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
        return new Promise(function(resolve, reject) {
          getUserMedia.call(navigator, constraints, resolve, reject);
        });
      }
    }

    navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream) {
      var vid;
      vid = document.getElementById("camera-video");
      localMediaStream = stream;

      // Older browsers may not have srcObject
      if ("srcObject" in video) {
        vid.srcObject = stream;
      } else {
        // Avoid using this in new browsers, as it is going away.
        vid.src = window.URL.createObjectURL(stream);
      }
      video.onloadedmetadata = function(e) {
        vid.play();
      };
    })
    .catch(function(err) {
      console.log("Error! " + err.name + ": " + err.message);
    });

    // bind button
    $("#camera-take").bind("click", snap);
    $("#camera-retake").bind("click", reset);

    function snap() {
      if (localMediaStream) {
        ctx.drawImage(video, 0, 0, settings.width, settings.height);
        $("#camera-img").attr("src", canvas.toDataURL("image/webp"));
        $("#camera-img, #camera-retake").show();
        $("#camera-video, #camera-take").hide();
        settings.snap.call(undefined, canvas.toDataURL("image/webp"));
      }else{
        settings.snap.call(undefined, "can't get localMediaStream");
      }
    }

    function reset(){
      $("#camera-video, #camera-take").show();
      $("#camera-img, #camera-retake").hide();
      settings.reset.call(undefined, "rest");
    }

    function flip(){
      settings.front = !settings.front;
      settings.flip.call(undefined, settings.front);
    }

  };

  // A really lightweight plugin wrapper around the constructor, 
  // preventing against multiple instantiations
  $.fn[camera] = function ( options ) {
    return this.each(function () {
      if (!$.data(this, 'plugin_' + camera)) {
        $.data(this, 'plugin_' + camera, 
        new Plugin( this, options ));
      }
    });
  }

})( jQuery, window, document );