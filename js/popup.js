
function createScrollDiv(image_urls, located, base_dir){
    var count = image_urls.length;
    var html = "<div id='popup-image-container'>";
    var width = count * 100;
    html += "<div class='popup-images' style='width: "+width+"px;'>"
    html += '<a id="story-link" href="/cs/list.php?location='+located+'">';
    for(i = 0; i < count; i++){
        var filepath = base_dir+image_urls[i];
        var offset = i*100;
        html += '<div class="item popup-image" id="popup-image-'+i+'" ';
        html += 'style="background-image: url(\''+filepath+'\'); ';
        html += 'left: '+offset+'px;"></div>';
    }
    html += '</a>';
    html += "</div>";
    html += "</div><hr />";
    return html;
}
