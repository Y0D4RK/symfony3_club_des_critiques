$(document).ready(function () { // only begin once page has loaded
    $('#txtBookSearch').autocomplete({ // attach auto-complete functionality to textbox
        // define source of the data
        source: function (request, response) {
            // url link to google books, including text entered by user (request.term)
            var booksUrl = 'https://www.googleapis.com/books/v1/volumes?printType=books&q=' + encodeURIComponent(request.term);
            $.ajax({
                url: booksUrl,
                dataType: 'jsonp',
                success: function(data) {
                    response($.map(data.items, function (item) {
                        if (item.volumeInfo.authors && item.volumeInfo.title
                        && item.volumeInfo.industryIdentifiers && item.volumeInfo.publishedDate) {
                            return {
                                // label value will be shown in the suggestions
                                label: item.volumeInfo.title + ', ' + item.volumeInfo.authors[0] + ', ' + item.volumeInfo.publishedDate,
                                // value is what gets put in the textbox once an item selected
                                value: item.volumeInfo.title,
                                // other individual values to use later
                                title: item.volumeInfo.title,
                                author: item.volumeInfo.authors[0],
                                isbn: item.volumeInfo.industryIdentifiers,
                                publishedDate: item.volumeInfo.publishedDate,
                                image: (item.volumeInfo.imageLinks == null ? '' : item.volumeInfo.imageLinks.thumbnail),
                                description: item.volumeInfo.description
                            };
                        }
                    }));
                }
            });
        },
        select: function (event, ui) {
            console.log(ui.item);
            // what to do when an item is selected
            // first clear anything that may already be in the description
            $('.name_book').val("");
            $('.description_book').val("");
            $('.author_book').val("");
            $('.isbn_book').val("");
            $('.date_book').val("");
            $('.img_book').val("");
            // we get the currently selected item using ui.item
            // show a pic if we have one
            $('.name_book').val(ui.item.title);
            $('.description_book').val(ui.item.description);
            $('.category_book option[value=1]').attr('selected','selected');

            $('.author_book').val(ui.item.author);
            // and show the link to oclc (if we have an isbn number)
            if (ui.item.isbn && ui.item.isbn[0].identifier) {
                $('.isbn_book').val(ui.item.isbn[0].identifier);
            }
            $('.date_book').val(ui.item.publishedDate);
            $('.img_book').val(ui.item.image);

            //if it's an edit, change former picture
            if (ui.item.image != ""){
              $(".new_img").attr("src", ui.item.image);
            } else {
              $(".new_img").attr("src", "");
              $(".new_img").attr("alt","Pas d'image disponible pour "+ ui.item.title +" !'")
            }
        },
        minLength: 2 // set minimum length of text the user must enter
    });
});
