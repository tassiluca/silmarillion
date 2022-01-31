/**
 * Hashes the password in order to NOT send it unencrypted.
 * @param {form} form: the submitted form
 * @param {string} password: the password to hash
 * @param {string} nameAttr: the name attribute of password input to replace.
 */
function formHash(form, password, nameAttr) {
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = nameAttr;
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    password.value = "";
}