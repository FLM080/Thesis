document.addEventListener("DOMContentLoaded", function() {
    let editCred = document.querySelector(".edit_cred");
    let editDet = document.querySelector(".edit_det");
    let editSlider = document.querySelector(".edit_slider");
    let formSection = document.querySelector(".edit_form-section");

    editCred.addEventListener("click", () => {
        editSlider.classList.add("edit_moveslider");
        formSection.classList.add("edit_form-section-move");
    });

    editDet.addEventListener("click", () => {
        editSlider.classList.remove("edit_moveslider");
        formSection.classList.remove("edit_form-section-move");
    });
});