$(document).ready(function() {

    $("#a_credits").keyup(function() {
        validar_creditos();
    });

    // Cuando la paginación sea pulsada.
    $(document).on('submit', '#create_users_form', function() {
        event.preventDefault();

        /**
         * Convierte un valor dado en javascript a una cadena  JSON, 
         * opcionalmente reemplaza valores si es especificada la función 
         * de remplazo, esta se encuentra en el archivo app.js.
         * 
         * https://developer.mozilla.org/es/docs/Web/JavaScript/Referencia/Objetos_globales/JSON/stringify
         */
        var form_data = JSON.stringify($(this).serializeObject());
        console.log(form_data);

        // Ahora enviaremos los datos al servidor/API.
        $.ajax({
            url: APP_ROOT + "user/create.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function(result) {

                console.log(result);
                console.log(result.reseller_credits);

                $('#modal-body-text').html(result.message);
                $('#exampleModalCenter').modal('show');


                var reseller_name = $('#res_name').val();
                var users_quantity = $('#u_quantity').val();
                // Mostrar la lista de usuarios creados.
                showUsersFirstPage(reseller_name, users_quantity);


                // Actualizando los creditos.
                $("#reseller_credits").html(result.reseller_credits);
                $('#create_users_form').trigger("reset");

            },
            error: function(xhr, resp, text) {

                // Mostrar el error por consola.
                console.log(xhr, resp, text);
            }
        });

        return false;

    });


    // Cuando la paginación sea pulsada.
    $(document).on('click', '.pagination li', function() {

        // Obtener url json.
        var json_url = $(this).find('a').attr('data-page');

        // Mostar usuarios creados por un reseller especifico.
        // $("#pagination_here li").empty();
        // $("#users_list tr").empty();
        showUsersCreated(json_url);
    });

});


function showUsersFirstPage(reseller_name, users_quantity) {

    var json_url =
        APP_ROOT + "user/read_paging.php?reseller_name=" + reseller_name + "&users_quantity=" + users_quantity;

    // Mostar usuarios creados por un reseller especifico.
    showUsersCreated(json_url);
}


function showUsersCreated(json_url) {

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


function validar_creditos() {
    var a = $('#u_quantity').val();
    var b = $('#a_credits').val();
    var res = b * a;

    var btn = $("#btn_create_users");


    // Variable en read_user.php
    console.log(a, b, r_credits, res);

    if (res > r_credits || a <= 0 || b <= 0) {
        alert("creditos insuficientes");
        btn.prop('disabled', true);
    } else {
        btn.prop('disabled', false);
    }
}