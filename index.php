<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <title>Progress Bar Upload</title>
</head>
<body>
    <div class="container p-5 text-center">
        <div class="header bg-primary p-4 rounded text-white w-50 mx-auto">Ajax Image Upload with Progress Bar</div>
        <form id='uploadform'>
            <label style="display: block;">
                <img id="uploadimage2" src="img/featured.gif" style="width: 300px;
                height: 300px;
                cursor: pointer;
                object-fit: cover;
                object-position: center top;
                padding: 6px;
                border-radius: 13xp;
                border: 1px solid;
                border-radius: 6px;
                margin: 11px;">
                <input type="file" name="filename" style="display: none;" id="uploadimage_src" onchange="imagepreview_upload(event)">
            </label>
            <div class="container w-50 mx-auto" id="progress" style="display: none;">
            <hr>
            <div class="progress" style="height: 26px;">
                 <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">Uploading (0%)</div>
                </div>
              <hr>  
            </div>
            <div class="form-group">
                <input type="submit" value="Upload" class="btn btn-primary">
            </div>
        </form>
       
    </div>
    <script>
        //Declaring the ajax on submit function
       $(document).ready(function () {
           $(uploadform).submit(function (e) { 
                var progress = $('.progress-bar');
                var progressCon = $('#progress');
               e.preventDefault();
               if ($('#uploadimage_src').val() == '') {
                   alert('Please selet file');
                   return;
               }
               $.ajax({
                   type: "POST",
                   url: "upload.php",
                   data: new FormData(uploadform),
                   cache:false,
                   contentType: false,
                   processData: false,
                   beforeSend: () => {
                        console.log('Image processing');
                        $(progressCon).slideDown();
                   },
                   xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            console.log(percentComplete);
                            //Do something with upload progress here
                            $(progress).attr("aria-valuenow", percentComplete.toFixed(0));
                            $(progress).width(percentComplete.toFixed(0)+'%');
                            $(progress).text('Uploading ('+percentComplete.toFixed(2)+'%)');
                        }
                    }, false);
                    return xhr;
                    },
                   success: function (response) {
                       console.log(response);
                       $(progress).text('Uploaded (100%)');
                       $(progress).addClass('bg-success');
                       $('#uploadimage2').attr('src', 'img/featured.gif');
                       setTimeout(() => {
                           $(progressCon).fadeOut(() => {
                            $(progress).removeClass('bg-success');
                            $(progress).addClass('bg-primary');
                            $(progress).attr("aria-valuenow", '0');
                            $(progress).width('0%');
                            $(progress).text('Uploading (0%)');
                           });
                       }, 3000);
                   }
               });
           });
       });

       function imagepreview_upload(event) {
            var reader = new FileReader();
            var imagefield = document.getElementById('uploadimage2');

            reader.onload = function() {
                if (reader.readyState == 2) {
                    imagefield.src = reader.result;
                    // console.log(reader.result);
                }
            }
            reader.readAsDataURL(event.target.files[0]);

        }
    </script>
</body>
</html>