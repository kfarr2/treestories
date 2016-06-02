
function createCarousel(img_urls, located, base_dir){
    var count = 0;
    if(img_urls != null){
        count = img_urls.length;
    }
    console.log(count);
    var html = "<div id='popup-image-container'>";
    if(count == 0){
        html += '<a href="/cs/list.php?location='+located+'">';
        html += '<div id="story-link" style="background-image: url(\''+base_dir+'pictures/tree.png\');"';
        html += "></div></a>";
    } else if(count == 1){
        html += '<a href="/cs/list.php?location='+located+'">';
        html += '<div id="story-link" style="background-image: url(\''+base_dir+img_urls[0]+'\');"';
        html += "></div></a>";
    } else {
        html += "<div id='carousel' class='carousel slide' data-ride='carousel'>";
        html += "<ol class='carousel-indicators'>";

        for(i=0; i<count; i++){
            html += "<li data-target='#carousel' data-slide-to=\""+i+"\" ";
            if(i==0){
                html += "class='active' ";
            }
            html += "></li>";
        }
        html += "</ol>";
        html += "<div class='carousel-inner' role='listbox'>";
        for(i=0; i<count; i++){
            html += '<div class="item';
            if(i==0){
                html += ' active';
            }
            html += '" role="listbox">';
            html += '<a href="/cs/list.php?location='+located+'">';
            html += '<div id="story-link" style="background-image: url(\''+base_dir+img_urls[i]+'\');"';
            html += "></div></a></div>";
        }
        html += "</div>";
        html += '<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">';
        html += '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
        html += '<span class="sr-only">Previous</span>';
        html += '</a>';
        html += '<a class="right carousel-control" href="#carousel" role="button" data-slide="next">';
        html += '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
        html += '<span class="sr-only">Next</span>';
        html += '</a>';
        html += "</div>";
    }
    html += "</div>";
    return html;
}
