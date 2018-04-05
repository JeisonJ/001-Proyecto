$(document).ready(function() {

    $('#text-upper').keyup(function() {
        $(this).val($(this).val().toUpperCase());

    });

    $(document).on('submit', '#update-user-form', function() {
        event.preventDefault();

        var form_data = JSON.stringify($(this).serializeObject());
        console.log(form_data);


        $.ajax({
            url: APP_ROOT + "reseller/update.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function(result) {
                console.log(result);
            },
            error: function(xhr, resp, text) {

                // Mostrar el error por consola.
                console.log(xhr, resp, text);
            }
        });

        return false;

    });

});