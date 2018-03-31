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