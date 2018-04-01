$(document).ready(function() {

    $("#a_credits, #u_quantity").keyup(function() {
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

});

function validar_creditos() {
    var a = $('#u_quantity').val();
    var b = $('#a_credits').val();
    var c = $("#reseller_credits").val();
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