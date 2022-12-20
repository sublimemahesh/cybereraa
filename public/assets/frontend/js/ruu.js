
function a(val) {
    if (val == null) {
        val = 'NULL';
    }
    alert(val);
}


function _IdVal(val) {
    v = document.getElementById(val).value;
    alert(v);
}


function setSrcByClass(className, src) {
    let elems = document.querySelectorAll("." + className);
    for (let i = 0; i < elems.length; i++) {
        elems[i].src = src;
    }
}


function ImgChange(imageSources,className) {
//var imageSources = ["./images/down/balance.png", "./images/down/825508.png"]

    var index = 0;
    setInterval(function () {
        if (index === imageSources.length) {
            index = 0;
        }
        //console.log(document.getElementsByClassName("image").src = imageSources[index]);
        setSrcByClass(className, imageSources[index])
        index++;
    }, 2000);
}
