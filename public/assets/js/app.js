const burgerBtn = document.querySelector(".fa-bars");
const closeBtn = document.querySelector("#closeSide");
const sideBar = document.querySelector("header aside");
const body = document.querySelector("body");
const dropDownBtn = document.querySelector(".fa-sort-down");
const dropDownMenu = document.querySelector(".dropdown-menu");
const avatarInput = document.querySelector(".avatar");
const avatarImg = document.querySelector("#avatar_img");
const projectInput = document.querySelector(".project_imgs");


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

if (avatarInput) {
    avatarInput.addEventListener("change", ()=>{
        const file = avatarInput.childNodes[0].files[0];
        console.log(file);
        if (file) {
            avatarImg.src = URL.createObjectURL(file);
        }
    })
}

if (projectInput) {
    // files = [];
    
    projectInput.addEventListener("change", ()=>{
        const template = document.querySelector("#template_project");
        const imgList = document.querySelector('.img-list');
        
        const files = projectInput.childNodes[1].files;
        // console.log(files);

        // for (const key in files) {
        //     delete files[key];
        // }
        // console.log(files);

        while (imgList.lastElementChild) {
            imgList.removeChild(imgList.lastElementChild);
        }

        for (const file of files) {
            const clone = document.importNode(template.content, true);
            
            //Image
            const imgProject = clone.querySelector(".project-img");
            imgProject.src = URL.createObjectURL(file);
    
            imgList.appendChild(clone);
        }
    })
}


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

