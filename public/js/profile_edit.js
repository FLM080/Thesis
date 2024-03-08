let editCred = document.querySelector(".edit-cred");
let editDet = document.querySelector(".edit-det");
let editSlider = document.querySelector(".edit-slider");
let formSection = document.querySelector(".edit-form-section");

editCred.addEventListener("click", () => {
    editSlider.classList.add("edit-moveslider");
    formSection.classList.add("edit-form-section-move");
});

editDet.addEventListener("click", () => {
    editSlider.classList.remove("edit-moveslider");
    formSection.classList.remove("edit-form-section-move");
});