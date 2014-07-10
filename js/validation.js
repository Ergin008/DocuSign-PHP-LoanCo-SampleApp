/**
 * Validate the string is an email address.
 */
function checkEmail (strng) {
    var error="";
    if (strng == "") {
        error = "You didn't enter an email address.<br/>";
    }

    var emailFilter=/^.+@.+\..+$/;
    if (!(emailFilter.test(strng))) { 
       error = "Please enter a valid email address.<br/>";
    }
    else {
       var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
         if (strng.match(illegalChars)) {
          error = "The email address contains illegal characters.<br/>";
       }
    }
    return error;    
}

/**
 * Validate the string is a number.
 */
function checkPhone (strng) {
    var error = "";
    if (strng == "") {
        error = "You didn't enter a phone number.<br/>";
    }

    var stripped = strng.replace(/[\(\)\.\-\ ]/g, '');
    if (isNaN(parseInt(stripped))) {
        error = "The phone number contains illegal characters.";
    }
    
    if (!(stripped.length == 10)) {
	    error = "The phone number is the wrong length. Make sure you included an area code.<br/>";
    }
    return error;
}

/**
 * Validate the value is a float.
 */
function checkFloat(val, name) {
    var error = "";
    if (val == "") {
        error = name + " is required <br/>";
    }

    var regExp = /(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/;
    if (regExp.test(val) == false ) {
           error = name + " is not in the right format.<br/>";
    }

    return error;
}

/**
 * Validate the string is a valid password.
 */
function checkPassword (strng) {
    var error = "";
    if (strng == "") {
        error = "You didn't enter a password.<br/>";
    }

    var illegalChars = /[\W_]/;
    if ((strng.length < 6) || (strng.length > 8)) {
       error = "The password is the wrong length.<br/>";
    }
    else if (illegalChars.test(strng)) {
      error = "The password contains illegal characters.<br/>";
    } 
    else if (!((strng.search(/(a-z)+/)) && (strng.search(/(A-Z)+/)) && (strng.search(/(0-9)+/)))) {
       error = "The password must contain at least one uppercase letter, one lowercase letter, and one numeral.<br/>";
    }  
    return error;    
}    

/**
 * Validate the string is a valid username.
 */
function checkUsername (strng) {
    var error = "";
    if (strng == "") {
        error = "You didn't enter a username.<br/>";
    }

    var illegalChars = /\W/; // allow letters, numbers, and underscores
    if ((strng.length < 4) || (strng.length > 10)) {
       error = "The username is the wrong length.<br/>";
    }
    else if (illegalChars.test(strng)) {
        error = "The username contains illegal characters.<br/>";
    }
    return error;
}       

/**
 * Validate the string is not empty.
 */
function isEmpty(strng, elementName) {
    var error = "";
    if (strng.length == 0) {
        error = elementName + " is required.<br/>";
    }
    return error;	  
}

/**
 * Validate the string is not different from "Can't touch this!". 
 */
function isDifferent(strng) {
    var error = ""; 
    if (strng != "Can\'t touch this!") {
        error = "You altered the inviolate text area.<br/>";
    }
    return error;
}

/**
 * Validate the checkbox value is set.
 */
function checkRadio(checkvalue) {
    var error = "";
    if (!(checkvalue)) {
        error = "Please check a radio button.<br/>";
    }
    return error;
}

/**
 * Validate a dropdown choice was made. 
 */
function checkDropdown(choice) {
    var error = "";
    if (choice == 0) {
        error = "You didn't choose an option from the drop-down list.<br/>";
    }    
    return error;
}    