CHUNK_SIZE = 1 * Math.pow(2, 20); // roughly 1mb

function getUUID(){
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
        return v.toString(16);
    });
}

// init the resumable file object
var r = new Resumable({
    target: "libs/store.php",
    testChunks: false,
    maxChunkRetries: 3,
    chunkRetryInterval: 1000,
    generateUniqueIdentifier: getUUID,
    chunkSize: CHUNK_SIZE,
    query: {"main_file_slug": window.location.toString().replace(/\/$/, '').split("/").pop()}
});

// update the progress bar
r.on('progress', function(){
    var percent = Math.ceil(this.progress()*100) + "%"
    $('#progress-bar').css('width', percent);
    $('#progress-bar').text(percent)
});

// when a new file is added, list it in the dropbox area
r.on('fileAdded', listFiles)

// if there is a problem uploading a file, we just quit and submit the form
// with the error listed
r.on('fileError', function(file, message){
    console.log(message)
    $('#error-message').val(message)
    $('#form').submit();
    r.cancel();
})

r.on('complete', function(){
    var directory = '/files/tmp/';
    var uuid = r.files[0].uniqueIdentifier;
    var filename = r.files[0].fileName;
    var full_path = directory + uuid + filename;
    var input = $("<input>").attr("id", "image-filepath").attr("type", "hidden").attr("name", "image-filepath").val(full_path);
    console.log(full_path);
    console.debug(input);
    if(accept(filename)){
        $("#form").append($(input));
        // we delay this a bit so the progress bar is updated to 100%
        setTimeout(function(){
            $('#form').submit();
        }, 1000);
    } else {
       document.cookie="message=ERROR: Files of that type are not allowed. Post was not submitted; expires="+Date.now()+10+"; path=/";
       window.location='/list.php';
    }
})

function listFiles(){
    var html = ["<ul>"]
    for(var i = 0; i < r.files.length; i++){
        html.push("<li><span data-index='" + i + "' class='remove-file glyphicon glyphicon-remove'></span>" + r.files[i].fileName + "</li>")
    }
    html.push("</ul>")
    $('#dropbox').html(html.join(""))
}

function dropbox(){
    if($('#popup').is(":visible")){
        $('#popup').ready(function(){
            // init these DOM objects for the file upload
            r.assignBrowse(document.getElementById("file"));
            r.assignDrop(document.getElementById("dropbox"));
            // start the upload process
        });
    } else {
        setTimeout(function(){ dropbox(); }, 50);
    }

    $('#submit-treestory').on("click", function(e){
        console.log(r.files.length);
        if(r.files.length > 0){
            r.upload();
            $(this).hide();
            $(".progress").show();
        } else {
            $("#form").submit();
        }
    });

    $('.leaflet-popup-close-button').click(function(){
        dropbox();
    });

    $('#dropbox').on("click", function(e){
        $('#file').click();
    })

    $('#dropbox').on('click', '.remove-file', function(e){
        e.stopPropagation();
        var index = parseInt($(this).data("index"))
        r.removeFile(r.files[index])
        listFiles();
    });
}
dropbox();

var accepted_filetypes = [
    'jpg',
    'png',
    'gif',
    'jpeg',
    'bmp'
];

function accept(filename){
    var ext = filename.split('.').pop();
    if(accepted_filetypes.indexOf(ext) == -1){
        return false;
    }
    return true;
}
