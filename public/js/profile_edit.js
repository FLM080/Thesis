let edit_cred = document.querySelector(".edit_cred");
let edit_det = document.querySelector(".edit_det");
let edit_slider = document.querySelector(".edit_slider");
let formSection = document.querySelector(".edit_form-section");
 
edit_cred.addEventListener("click", () => {
    edit_slider.classList.add("edit_moveslider");
    formSection.classList.add("edit_form-section-move");
});
 
edit_det.addEventListener("click", () => {
    edit_slider.classList.remove("edit_moveslider");
    formSection.classList.remove("edit_form-section-move");
});