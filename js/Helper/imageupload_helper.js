define(['jquery', 'backbone',"text!template/imageuploadTemplate.html", "fileupload"],
    function($, Backbone,imageuploadTemplate,fileupload) {
        var ContactimageuploadView = Backbone.View.extend({
            imgUrl : '',
            template: imageuploadTemplate,

            events: {

                "change .inputfile": "imageUpload"
            },
            initialize: function(options) {
                _.extend(this, options)
            },
            imageUpload: function(e) {


                var me = this;
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(readerEvent) {
                    var image = new Image();
                    image.onload = function(imageEvent) {
                        var canvas = document.createElement('canvas'),
                            width = image.width,
                            height = image.height;
                        canvas.width = width;
                        canvas.height = height;
                        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(event) {
                            if (xhr.readyState == 4) {
                                if (xhr.status == 200) {
                                    console.log('Image uploaded: ' + xhr.responseText);
                                    this.imgUrl = xhr.responseText;

                                } else {
                                    console.log('Image upload failure');
                                }
                            }
                        }.bind(this);
                        xhr.open('post', base_url + '/index.php/FileUpload/contactUpload', true);
                        xhr.send(canvas.toDataURL('image/jpeg'));

                    }.bind(this);
                    image.src = readerEvent.target.result;
                    //$('photo').append(image);
                }.bind(me);
                reader.readAsDataURL(file);
            },

            render: function() {


                var tmpl = _.template(this.template);

                this.$el.html(tmpl());
                //debugger;
                this.renderTo.append(this.el);

                return this;
            },
            getImageUrl : function(){
                return this.imgUrl;
            }

        });
        return ContactimageuploadView;

    });