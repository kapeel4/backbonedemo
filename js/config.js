 require.config({
    // Initialize the application with the main application file
    deps: ["js/main","jquery.validate"],

    baseUrl: "",

    paths: {
      // Libraries
      "text" : "js/lib/text",
      "jquery": "js/lib/jquery.min",
      //"fileupload" :"js/lib/jquery.fileupload-image",
      //"fileuploadprocess" : "js/lib/jquery.fileupload-process",
      "fileupload" : "js/lib/jquery.uploadify",
      //"fileuploadify" : "js/lib/jquery.uploadify.min"
      "alertify" : "js/lib/alertify.min",
      "colorbox" : "js/lib/jquery.colorbox-min",
      "lodash" : "js/lib/lodash.min",
      "backbone": "js/lib/backbone.min",
      "jquery.validate" : "js/lib/jquery.validate"
    },

    shim: {
      "backbone": {
        deps: ["lodash", "jquery"],
        exports: "Backbone"
      },
      "jquery.validate" : {
          deps : ['jquery']
      },
      "colorbox" : {
        deps : ['jquery']
      }
     
    }
  });