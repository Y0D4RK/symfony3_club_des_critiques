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



// Gestion du choix de l'admin pour le filtrage des salons
function callSalonSearchBar(filter_name){
  var filtername = filter_name;

  if(filtername == 'titre'){
    $('#salonFilterBar').empty();
    $('#salonFilterBar').html('<input type="text" id="salonSearchBar" class="search_bar" onkeyup="salonSearchBarFunction(1)" placeholder="Recherche par titre...">');
  } else if(filtername == 'oeuvre'){
    $('#salonFilterBar').empty();
    $('#salonFilterBar').html('<input type="text" id="salonSearchBar" class="search_bar" onkeyup="salonSearchBarFunction(2)" placeholder="Recherche par oeuvre...">');
  } else {
    alert("Erreur: Veuillez contacter l\'administration");
  }
}

function salonSearchBarFunction(nbCell){
  var choix = nbCell;

  //Déclaration des variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("salonSearchBar");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableSalons");
  tr = table.getElementsByTagName("tr");

  // Loop sur tout les rows, et cache ceux qui ne matchent pas la Recherche
  for (i = 0; i < tr.length; i++){
    // Recherche de la colonne spécifiée dans les crochets
    td = tr[i].getElementsByTagName("td")[choix];
    if (td) {
       if (td.innerHTML.toUpperCase().indexOf(filter) > -1){
         tr[i].style.display = "";
       } else {
         tr[i].style.display = "none";
       }
    }
  }
}




// Gestion du choix de l'admin pour le filtrage des users
function callUserSearchBar(filter_name){
  var filtername = filter_name;

  if(filtername == 'surnom'){
    $('#userFilterBar').empty();
    $('#userFilterBar').html('<input type="text" id="userSearchBar" class="search_bar" onkeyup="userSearchBarFunction(0)" placeholder="Recherche par pseudo...">');
  } else if(filtername == 'nom'){
    $('u#serFilterBar').empty();
    $('#userFilterBar').html('<input type="text" id="userSearchBar" class="search_bar" onkeyup="userSearchBarFunction(1)" placeholder="Recherche par nom...">');
  } else if(filtername == 'prenom'){
    $('#userFilterBar').empty();
    $('#userFilterBar').html('<input type="text" id="userSearchBar" class="search_bar" onkeyup="userSearchBarFunction(2)" placeholder="Recherche par prenom...">');
  } else if(filtername == 'email'){
    $('#userFilterBar').empty();
    $('#userFilterBar').html('<input type="text" id="userSearchBar" class="search_bar" onkeyup="userSearchBarFunction(3)" placeholder="Recherche par email...">');
  } else {
    alert("Erreur: Veuillez contacter l\'administration");
  }
}

function userSearchBarFunction(nbCell){
  var choix = nbCell;

  //Déclaration des variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("userSearchBar");
  filter = input.value.toUpperCase();
  table = document.getElementById("tableUsers");
  tr = table.getElementsByTagName("tr");

  // Loop sur tout les rows, et cache ceux qui ne matchent pas la Recherche
  for (i = 0; i < tr.length; i++){
    // Recherche de la colonne spécifiée dans les crochets
    td = tr[i].getElementsByTagName("td")[choix];
    if (td) {
       if (td.innerHTML.toUpperCase().indexOf(filter) > -1){
         tr[i].style.display = "";
       } else {
         tr[i].style.display = "none";
       }
    }
  }
}
