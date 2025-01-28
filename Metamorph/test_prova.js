/**
 * COME FUNZIA:
 *      dentro la funzione post bisogna mettere 2 parametri:
 *          - path che sarà tipo http://localhost/ ecc.
 *          - due parentesi graffe in cui mettere i dati che vuoi passare alla pg php
 *                  - la sintassi è { nome_variabile:valore, nome_variabile1:valore1 }
 */

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*86400e3));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; SameSite=None; Secure;" + expires + ";path=/";
}

$(document).ready( function () {
    setCookie("username","guest","1");
    $("#test_button").click(function () {
        // TODO: cambia i parametri della funzione post subito sotto se vuoi testare php diversi
        $.post("./API/cells/create_cell.php", {
            temperature : "12",

            humidity : '12',

            food : '12',

            date : '12/01/2020',

            larvae_count : '12',

            pupae_count : '12',

            adult_count : '12',

            total_individuals : '12',

            total_female : '12',

            total_male : '12'}).done(function (data) {
                $("#output_test").text(data);
            }).fail(function () {
                $("#output_test").text("fallita chiamata post");
            });
    });
});