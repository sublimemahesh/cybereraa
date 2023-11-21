var cssAraay = new Map([
    ['c', ['color', '']],
    ['bgc', ['background-color', '']],
    ['bg-img', ['background-image', '']],
    ['bgr', ['background-repeat', '']],
    ['bgp', ['background-position', '']],
    ['bgs', ['background-size', 'px']],
    ['bg-att', ['background-attachment', '']],
    ['opt', ['opacity', 'px']],
    ['ff', ['font-family', '']],
    ['fs', ['font-size', 'px']],
    ['fw', ['font-weight', 'px']],
    ['fsy', ['font-style', '']],
    ['ta', ['text-align', '']],
    ['td', ['text-decoration', '']],
    ['tt', ['text-transform', '']],
    ['lh', ['line-height', 'px']],
    ['ls', ['letter-spacing', '']],
    ['ws', ['word-spacing', '']],
    ['w', ['width', 'px']],
    ['h', ['height', 'px']],
    ['mt', ['margin-top', 'px']],
    ['mr', ['margin-right', 'px']],
    ['mb', ['margin-bottom', 'px']],
    ['ml', ['margin-left', 'px']],
    ['pt', ['padding-top', 'px']],
    ['pr', ['padding-right', 'px']],
    ['pb', ['padding-bottom', 'px']],
    ['pl', ['padding-left', 'px']],
    ['brr', ['border', 'px']],
    ['bw', ['border-width', 'px']],
    ['bs', ['border-style', '']],
    ['bc', ['border-color', '']],
    ['br', ['border-radius', 'px']],
    ['bsz', ['box-sizing', 'px']],
    ['p', ['position', '']],
    ['t', ['top', 'px']],
    ['r', ['right', 'px']],
    ['b', ['bottom', 'px']],
    ['l', ['left', 'px']],
    ['f', ['float', 'px']],
    ['cer', ['clear', '']],
    ['dis', ['display', '']],
    ['ovf', ['overflow', '']],
    ['z', ['z-index', '']],
]);




function checkDeviceSize() {

    devil_default();


    const width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

    if (width < 576) {
        it = "[data-dxs]";
        it2 = "data-dxs";
        devil(it, it2);
    } else if (width >= 576 && width < 768) {
        it = "[data-dsm]";
        it2 = "data-dsm";
        devil(it, it2);
    } else if (width >= 768 && width < 992) {
        it = "[data-dmd]";
        it2 = "data-dmd";
        devil(it, it2);
    } else if (width >= 992 && width < 1200) {
        it = "[data-dlg]";
        it2 = "data-dlg";
        devil(it, it2);
    } 
    
}



checkDeviceSize();
window.addEventListener('resize', checkDeviceSize);


function devil_default() {
    
    var elements = document.querySelectorAll('[data-devil]');
     if (elements.length > 0) {
         for (var a = 0; a < elements.length; a++) {
             var element = elements[a];
             element.style = null;
 
             spaceArray = element.getAttribute('data-devil').split(" ");
 
             for (var i = 0; i < spaceArray.length; i++) {
                 myArray = spaceArray[i].split(":");
                 for (var [id, values] of cssAraay) {
                     if (id === myArray[0]) {
                         element.style[values[0]] = myArray[1] + values[1];
                     }
                 }
             }
         }
     } else {
         console.log('No elements with data-devil attribute found.');
     }
 }


function devil(it, it2) {
   //alert(it2);
    var elements = document.querySelectorAll(it);

    if (elements.length > 0) {
        for (var a = 0; a < elements.length; a++) {
            var element = elements[a];
          

            spaceArray = element.getAttribute(it2).split(" ");

            for (var i = 0; i < spaceArray.length; i++) {
                myArray = spaceArray[i].split(":");
                for (var [id, values] of cssAraay) {
                    if (id === myArray[0]) {
                        element.style[values[0]] = myArray[1] + values[1];
                    }
                }
            }
        }
    } else {
        console.log('No elements with data-devil attribute found.');
    }
}






