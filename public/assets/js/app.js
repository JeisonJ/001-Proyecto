/** 
 * Variable para almacenar la ubicación/url del proyecto
 * definida en el archivo de configuración.
 * Para ser usada en las url's de la api.
 */
var APP_ROOT;

// Cargar el archivo de configuración.
$.getJSON("../config.json", function(data) {
    APP_ROOT = data.url.root;
});



/** Función para convertir valores obtenidos del formulario a formato json.
 * 
 * https://api.jquery.com/serializeArray/
 * https://api.jquery.com/jquery.fn.extend/
 * https://stackoverflow.com/questions/4083351/what-does-jquery-fn-mean
 */

$.fn.serializeObject = function() {

    var records = {};
    var a = this.serializeArray();

    /**
     * Iterar sobre un objeto jQuery, ejecutando una función para 
     * cada elemento coincidente.
     *
     * https://api.jquery.com/each/
     */
    $.each(a, function() {

        if (records[this.name] !== undefined) {

            if (!records[this.name].push) {
                records[this.name] = [records[this.name]];
            }

            records[this.name].push(this.value || '');

        } else {
            records[this.name] = this.value || '';
        }
    });

    return records;
};