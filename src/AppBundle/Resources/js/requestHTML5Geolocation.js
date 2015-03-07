window.onload = function () {
    var latitude,
        longitude;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                sendPosition();
            },
            function (error) {
                var url = document.URL.replace(/\/$/, ""),
                    form = document.createElement("FORM");

                form.method = "POST";
                form.style.display = "none";
                form.action = url;
                document.body.appendChild(form);
                input = document.createElement("INPUT");
                input.type = "hidden";
                input.name = "html5Geolocation";
                input.value = false;
                form.appendChild(input);
                form.submit();
            });
    }

    function sendPosition() {
        var url = document.URL.replace(/\/$/, ""),
            form = document.createElement("FORM");

        form.method = "POST";
        form.style.display = "none";
        form.action = url;
        document.body.appendChild(form);
        input = document.createElement("INPUT");
        input.type = "hidden";
        input.name = "latitude";
        input.value = latitude;
        form.appendChild(input);
        input = document.createElement("INPUT");
        input.type = "hidden";
        input.name = "longitude";
        input.value = longitude;
        form.appendChild(input);
        input = document.createElement("INPUT");
        input.type = "hidden";
        input.name = "html5Geolocation";
        input.value = true;
        form.appendChild(input);
        form.submit();
    }
};
/*

 else {
 console.log('3');
 var url = document.URL.replace(/\/$/, ""),
 form = document.createElement("FORM");

 form.method = "POST";
 form.style.display = "none";
 form.action = url;
 document.body.appendChild(form);
 input = document.createElement("INPUT");
 input.type = "hidden";
 input.name = "geolocation";
 input.value = false;
 form.appendChild(input);
 form.submit();
 }

 */


/*Get gen
 var myObject =
 {
 latitude: latitude,
 longitude: longitude
 };
 var shallowEncoded = $.param( myObject, true );
 var url = document.URL;
 console.log(url + shallowEncoded);
 window.location.replace(url + shallowEncoded);
 */

/*Pretty uri
 var url = document.URL.replace(/\/$/, "");
 window.location.replace(url + '/' + latitude + '/' + longitude);
 */

//
///**
// * Takes a URL and goes to it using the POST method.
// * @param {string} url  The URL with the GET parameters to go to.
// * @param {boolean=} multipart  Indicates that the data will be sent using the
// *     multipart enctype.
// */
//function postURL(url, multipart) {
//    var form = document.createElement("FORM");
//    form.method = "POST";
//    if (multipart) {
//        form.enctype = "multipart/form-data";
//    }
//    form.style.display = "none";
//    document.body.appendChild(form);
//    form.action = url.replace(/\?(.*)/, function (_, urlArgs) {
//        urlArgs.replace(/\+/g, " ").replace(/([^&=]+)=([^&=]*)/g, function (input, key, value) {
//            input = document.createElement("INPUT");
//            input.type = "hidden";
//            input.name = decodeURIComponent(key);
//            input.value = decodeURIComponent(value);
//            form.appendChild(input);
//        });
//        return "";
//    });
//    form.submit();
//}
//