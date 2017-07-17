function search(urlApi){
    // console.log('this function runs !');
    var search = $("#search").val();
    console.log(search);

    $.ajax({
        url: urlApi + search,
        dataType: "json",
        type: "GET",

        success: function(data){
            //console.log(data);
            for(i = 0; i < data.items.length; i++){
                $('#results').append("<div class='panel panel-default'>"
                                        +"<div class='panel-heading'>"
                                            + "<span class='text-left'><strong>" + data.items[i].volumeInfo.title + "</strong></span>"
                                            + "<span class='pull-right'><em>" + data.items[i].volumeInfo.authors + "</em></span>"
                                        + "</div>"
                                        + "<div class='panel-body'>"
                                            + "<img src='"+ data.items[i].volumeInfo.imageLinks.smallThumbnail + "' class='img-responsive img-rounded'> <br> <hr>"
                                            + "<p>" + data.items[i].volumeInfo.description + "</p>"
                                        + "</div>"
                                        + "<div class='panel-footer'>"
                                            + "<span class='text-left'>" + data.items[i].volumeInfo.publisher + "</span>"
                                            + "<span class='pull-right'>" + data.items[i].volumeInfo.publishedDate + "</span>"
                                        + "</div>"
                                    +"</div>");
            }
        },

    });
}

$("#button").click(function(){
    $("#results").empty();
    search("https://www.googleapis.com/books/v1/volumes?q=");
});