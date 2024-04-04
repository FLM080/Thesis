let addedExercises = [];

document.querySelectorAll(".addExercise").forEach(function (button) {
    button.addEventListener("click", function () {
        var id = this.dataset.id;

        if (addedExercises.includes(id)) {
            return;
        }

        addedExercises.push(id);

        var row = this.parentElement.parentElement;
        var cells = Array.from(row.children);

        var newRow = document.createElement("tr");

        cells.forEach(function (cell, index) {
            if (index !== 0 && index !== cells.length - 1) {
                var newCell = document.createElement("td");
                newCell.classList.add("text-white", "text-center");

                var descriptionDiv = document.createElement("div");
                descriptionDiv.classList.add("exerciseDescription");
                descriptionDiv.textContent = cell.textContent;

                newCell.appendChild(descriptionDiv);
                newRow.appendChild(newCell);
            }
        });

        var imgCell = document.createElement("td");
        var img = document.createElement("img");
        img.src = cells[0].children[0].src;
        img.classList.add("exerciseTableImage");
        imgCell.appendChild(img);
        imgCell.classList.add("text-center");
        newRow.insertBefore(imgCell, newRow.firstChild);

        ["Sets", "Reps", "Order"].forEach(function (label, index) {
            var newCell = document.createElement("td");
            var input = document.createElement("input");
            input.type = "number";
            input.min = 1;
            input.value = 1;
            input.placeholder = label;
            input.classList.add("form-control");
            input.name = "exercises[" + id + "][" + label.toLowerCase() + "]";
            newCell.appendChild(input);
            newRow.appendChild(newCell);
        });

        var exerciseIdInput = document.createElement("input");
        exerciseIdInput.type = "hidden";
        exerciseIdInput.name = "exercises[" + id + "][exercise_id]";
        exerciseIdInput.value = id;
        newRow.appendChild(exerciseIdInput);

        var removeButtonCell = document.createElement("td");
        var removeButton = document.createElement("button");
        removeButton.textContent = "Remove";
        removeButton.classList.add("btn", "btn-danger", "removeExercise");
        removeButtonCell.appendChild(removeButton);
        removeButtonCell.classList.add("text-center");
        newRow.appendChild(removeButtonCell);

        document
            .querySelector("#selectedExercisesTable tbody")
            .appendChild(newRow);
    });
});

document.addEventListener("click", function (event) {
    if (event.target.matches(".removeExercise")) {
        var id = event.target.parentElement.parentElement.dataset.id;
        addedExercises = addedExercises.filter(function (exerciseId) {
            return exerciseId !== id;
        });
        event.target.parentElement.parentElement.remove();
    }
});
