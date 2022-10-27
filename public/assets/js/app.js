const burgerBtn = document.querySelector(".fa-bars");
const closeBtn = document.querySelector("#closeSide");
const sideBar = document.querySelector("header aside");
const body = document.querySelector("body");
const dropDownBtn = document.querySelector(".fa-sort-down");
const dropDownMenu = document.querySelector(".dropdown-menu");
const avatarInput = document.querySelector(".avatar");
const avatarImg = document.querySelector("#avatar_img");
const projectInput = document.querySelector(".project_imgs");
const projectInput2 = document.querySelector(".project_imgs2");
const companyInfo = document.querySelector("#company_info");
const companyInfoInputs = document.querySelectorAll("#company_info input");
const ParticulierInput = document.querySelector(".InputParticulier");
const CompanyInput = document.querySelector(".InputCompany");


if (ParticulierInput) {

    if (ParticulierInput.checked) {
        companyInfo.classList.add('hide');
    }else if (CompanyInput.checked){
        companyInfo.classList.remove('hide');
    }

    ParticulierInput.addEventListener("change",()=>{
        companyInfo.classList.add('hide');
        localStorage.removeItem('isCompany');
        for (const input of companyInfoInputs) {
            input.value = "";
        }
    })

    CompanyInput.addEventListener("change",()=>{
        companyInfo.classList.remove('hide');
        localStorage.setItem('isCompany', true);
    })
    
}

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
    
    projectInput.addEventListener("change", ()=>{
        const template = document.querySelector("#template_project");
        const imgList = document.querySelector('.img-list');
        
        const files = projectInput.childNodes[1].files;

        while(imgList.lastElementChild){
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

if (projectInput2) {
    
    projectInput2.addEventListener("change", ()=>{
        const template = document.querySelector("#template_project2");
        const imgList = document.querySelector('.img-list2');

        let files = projectInput2.childNodes[1].files;

        while(imgList.lastElementChild){
            imgList.removeChild(imgList.lastElementChild);
        }
        
        for (const file of files) {
            const clone = document.importNode(template.content, true);

            //Image
            const imgProject = clone.querySelector(".project-img2");
            imgProject.src = URL.createObjectURL(file);
            
            imgList.appendChild(clone);
        }
    })
}

// if (projectInput) {
    
//     projectInput.addEventListener("change", ()=>{
//         const template = document.querySelector("#template_project");
//         const imgList = document.querySelector('.img-list');
        
//         const files = projectInput.childNodes[1].files;
//         console.log(files[0].name);

//         for (const file of files) {
//             const clone = document.importNode(template.content, true);
            
//             //Image
//             const imgProject = clone.querySelector(".project-img");
//             imgProject.src = URL.createObjectURL(file);
    
//             imgList.appendChild(clone);
//         }
//         if (imgList) {
//             const images = document.querySelectorAll(".template_card")
//             console.log(images);
//             for (const image of images) {
//                 image.addEventListener("click", ()=>{
//                     imgList.removeChild(image)
//                 })
//             }
//         }
//     })

// }

// if (projectInput2) {
//     const template = document.querySelector("#template_project2");
//     const imgList = document.querySelector('.img-list2');

//     // const form = document.forms[0];
//     // console.log(form);

//     // let displayedFiles = [];
//     // const request = new XMLHttpRequest();
//     // let files = new FormData(form);
//     // console.log(files);
    
//     // request.open("POST", API_ENDPOINT, true);
//     // request.onreadystatechange = () => {
//     //   if (request.readyState === 4 && request.status === 200) {
//     //     console.log(request.responseText);
//     //   }
//     // };

//     projectInput2.addEventListener("change", ()=>{

//         let index = 0;

//         let inputFiles = projectInput2.childNodes[3].files;
//         console.log(inputFiles);

//         let filesArray = Array.from(inputFiles);
//         filesArray.forEach(element => {
//             displayedFiles.push(element)
//         });
//         // console.log(filesArray);
        
//         for (const file of inputFiles) {
//             const clone = document.importNode(template.content, true);
            
//             let count = index++
            
//             //Image
//             const imgProject = clone.querySelector(".project-img2");
//             imgProject.src = URL.createObjectURL(file);
            
//             imgProject.setAttribute("id", count );
            
//             console.log(file.name);
            
//             imgList.appendChild(clone);
//             // filesArray.push(file);
//         }
//         for (const value of files.values()) {
//             console.log(value);
//         }
//         if (imgList) {
//             const images = document.querySelectorAll(".template_card")
//             // console.log(images);
//             for (const image of images) {
//                 const indexImg = image.children[0].children[0].id;
//                 image.addEventListener("click", ()=>{
//                     imgList.removeChild(image);
//                     files.delete(indexImg);
//                     inputFiles = files;
//                     // for (const value of files.values()) {
//                     //     console.log(value);
//                     // }
//                 })
//             }
//         }
//         files.set('bad_logo_example', );
        

//         console.log(inputFiles);
//         // for (const value of inputFiles.values()) {
//         //     console.log(value);
//         // }
//     })

// }

burgerBtn.addEventListener("click", ()=>{
    sideBar.classList.add("active");
    body.classList.add("stop-scrolling");
})

closeBtn.addEventListener("click", ()=>{
    sideBar.classList.remove("active");
    body.classList.remove("stop-scrolling");
})

if (dropDownBtn) {
    dropDownBtn.addEventListener("click", ()=>{
        dropDownMenu.classList.toggle("menu_active");
    })
}

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