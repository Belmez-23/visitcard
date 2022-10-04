// https://stashable.wordpress.com/2018/12/30/make-a-dress-up-game-using-javascript-html-and-css/

window.onload = init;

// генерация случайного числа
function random(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function init() {
    let hb = document.getElementById("hairback");
    hb.style.backgroundImage = "url(img/dressup/hairback.png)";

    dressup('hair', random(1, 3));
    dressup('shoe', random(1, 3));
    dressup('dress', random(1, 3));
}

function dressup(type, n) {
    switch (type) {
        case ('hair') :
            elemId = 'hairfront';
            type = elemId;
            break;
        case ('shoe') :
            elemId = 'shoes';
            break;
        case ('dress') :
            elemId = 'clothes';
            break;
    }

    let elem = document.getElementById(elemId);

    elem.style.width = clothes.style.width;
    elem.style.height = clothes.style.height;
    elem.style.position = 'absolute';
    elem.style.backgroundImage = "url(img/dressup/" + type + n + ".png)";
}

/*
function nextdress() {
    console.log(state.d);

    if (++state.d > 3) {
        state.d = 1;
    }

    let dress = document.getElementById("clothes");
    dress.style.width = clothes.style.width;
    dress.style.height = clothes.style.height;
    dress.style.position = 'absolute';
    dress.style.backgroundImage = "url(img/dressup/dress" + state.d + ".png)";
}

function nextshoe() {
    console.log(state.s);

    if (++state.s > 3) {
        state.s = 1;
    }

    let shoe = document.getElementById("shoes");
    shoe.style.width = clothes.style.width;
    shoe.style.height = clothes.style.height;
    shoe.style.position = 'absolute';
    shoe.style.backgroundImage = "url(img/dressup/shoe" + state.s + ".png)";
}

function nexthair() {
    console.log(state.h);

    if (++state.h > 3) {
        state.h = 1;
    }


    let hf = document.getElementById("hairfront");
    hf.style.width = clothes.style.width;
    hf.style.height = clothes.style.height;
    hf.style.position = 'absolute';
    hf.style.backgroundImage = "url(img/dressup/hairfront" + state.h + ".png)";
}
*/