// Cuando la página cargue.
$(document).ready(function() {

    // current_user es una variable definida en read_user.php
    var reseller_name = current_user;
    // Mostrar la primera lista de usuarios al cargar la página.
    showUsersFirstPage(reseller_name);


    // Cuando la paginación sea pulsada.
    $(document).on('click', '.pagination li', function() {

        // Obtener url json.
        var json_url = $(this).find('a').attr('data-page');

        // Mostar usuarios creados por un reseller especifico.
        // $("#pagination_here li").empty();
        // $("#users_list tr").empty();
        showUsers(json_url);
    });
});


function showUsersFirstPage(reseller_name) {

    var json_url = APP_ROOT + "user/read_paging.php?reseller_name=" + reseller_name;

    // Mostar usuarios creados por un reseller especifico.
    showUsers(json_url);
}


function showUsers(json_url) {

    // Obtener lista de usuarios desde la API.
    $.getJSON(json_url, function(data) {

        var read_users_html = "";
        var read_pagination_html = "";

        // HTML para mostrar la lista de usuarios creados por un reseller especifico.
        //console.log(data.records);

        $.each(data.records, function(clave, valor) {

            read_users_html += "<tr>";
            read_users_html += "<td>" + valor.id + "</td>";
            read_users_html += "<td>" + valor.user_name + "</td>";
            read_users_html += "<td>" + valor.password + "</td>";
            read_users_html += "<td>" + valor.credits + "</td>";
            read_users_html += "</tr>";
        });

        // Insertando la lista de usuarios.
        $("#users_list").html(read_users_html);

        // pagination
        if (data.paging) {

            // first page
            if (data.paging.first != "") {
                read_pagination_html += "<li class='page-item'><a class='page-link' data-page='" + data.paging.first + "'>First Page</a></li>";
            }

            // Recorrer las páginas
            $.each(data.paging.pages, function(key, val) {
                var active_page = val.current_page == "yes" ? "class='page-item active'" : "class='page-item'";
                read_pagination_html += "<li " + active_page + "><a class='page-link' data-page='" + val.url + "'>" + val.page + "</a></li>";
            });

            // last page
            if (data.paging.last != "") {
                read_pagination_html += "<li class='page-item'><a class='page-link' data-page='" + data.paging.last + "'>Last Page</a></li>";
            }
        }

        // Insertando la paginación.
        $("#pagination_here").html(read_pagination_html);
    });
}