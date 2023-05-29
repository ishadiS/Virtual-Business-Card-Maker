"use strict";

$('#code').qrcode({ 
    render: "canvas",
    text: card_url
}); 

function xiazai() {
    var data = $("canvas")[0].toDataURL().replace("image/png", "image/octet-stream;");
    var filename = "qr-code.png";
    var saveLink= document.createElement('a');
    saveLink.href = data;
    saveLink.download = filename;
    saveLink.click()
}