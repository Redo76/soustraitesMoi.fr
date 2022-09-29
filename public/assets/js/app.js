const burgerBtn = document.querySelector(".fa-bars");
const closeBtn = document.querySelector(".fa-xmark");
const sideBar = document.querySelector("header aside");
const body = document.querySelector("body");
const dropDownBtn = document.querySelector(".fa-sort-down");
const dropDownMenu = document.querySelector(".dropdown-menu");


burgerBtn.addEventListener("click", ()=>{
    sideBar.classList.add("active");
    body.classList.add("stop-scrolling");
})

closeBtn.addEventListener("click", ()=>{
    sideBar.classList.remove("active");
    body.classList.remove("stop-scrolling");
})

dropDownBtn.addEventListener("click", ()=>{
    dropDownMenu.classList.toggle("menu_active");
})

function moveToSelected(element) {

    if (element == "next") {
        var selected = $(".selected").next();
    } else if (element == "prev") {
        var selected = $(".selected").prev();
    } else {
        var selected = element;
    }

    let next = $(selected).next();
    let prev = $(selected).prev();
    let prevSecond = $(prev).prev();
    let nextSecond = $(next).next();

    $(selected).removeClass().addClass("selected");

    $(prev).removeClass().addClass("prev");
    $(next).removeClass().addClass("next");

    $(nextSecond).removeClass().addClass("nextRightSecond");
    $(prevSecond).removeClass().addClass("prevLeftSecond");

    $(nextSecond).nextAll().removeClass().addClass('hideRight');
    $(prevSecond).prevAll().removeClass().addClass('hideLeft');

}

// Evenement 
$(document).keydown(function (e) {
    switch (e.which) {
        case 37: // gauche
            moveToSelected('prev');
            break;

        case 39: // droite
            moveToSelected('next');
            break;

        default: return;
    }
    e.preventDefault();
});

$('#carousel div').click(function () {
    moveToSelected($(this));
});

$('#prev').click(function () {
    moveToSelected('prev');
});

$('#next').click(function () {
    moveToSelected('next');
});

