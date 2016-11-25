/**
 * Created by Owden on 3/8/16.
 */
/*
 * @author Owden Godson
 * Validate international Tel numbers
 */
/*Start Tel numbers validation*/
var     errorMsg = $("#error-msg"),
    telInput = $(".phoneNumber"),
    validMsg = $("#valid-msg");

//Initialize Plugin
telInput.intlTelInput({
    // allowDropdown: false,
    // autoHideDialCode: false,
    // autoPlaceholder: false,
    // dropdownContainer: "body",
    //excludeCountries: ["us"],
    geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    // initialCountry: "auto",
    // nationalMode: false,
    // numberType: "MOBILE",
    // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
    preferredCountries: ['tz', 'ke','ug','rw'],
    separateDialCode: true,
    utilsScript: "intlTelInput/js/utils.js"
});

var reset = function() {
    telInput.removeClass("error");
    errorMsg.addClass("hide");
    validMsg.addClass("hide");
};

// on blur: validate
telInput.blur(function() {
    reset();
    if ($.trim(telInput.val())) {
        if (telInput.intlTelInput("isValidNumber")) {
            validMsg.removeClass("hide");
        } else {
            telInput.addClass("error");
            errorMsg.removeClass("hide");
        }
    }
});
// on keyup / change flag: reset
telInput.on("keyup change", reset);
/*Finish International Tel Number validation*/
