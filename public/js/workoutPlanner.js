let movedCards = [];

// Extracts card data from a card element
const getCardData = (cardElement) => {
    if (!cardElement) throw new Error('Card element is required');
    const card = $(cardElement);
    const id = card.attr("id")?.replace('card-', '');
    const [name, description, type, strengthLevel] = card.find("h4, p").map((_, el) => $(el).text()).get();
    const sets = parseInt($('#setsInput').val()) || 1;
    const order = parseInt($('#orderInput').val()) || 1;
    const reps = parseInt($('#repsInput').val()) || 1;
    return { id, name, description, type, strengthLevel, sets, order, reps };
}

// Moves a card to a target wrapper
const moveCardToWrapper = (card, targetWrapper) => {
    if (!card || !targetWrapper) throw new Error('Both card and targetWrapper are required');
    card.appendTo(targetWrapper);
}

// Updates the movedCards array based on the cardData and direction of movement
const updateMovedCards = (cardData, isMovingRight) => {
    if(!cardData || typeof isMovingRight !== 'boolean') throw new Error('Both cardData and isMovingRight are required');
    isMovingRight ? movedCards = movedCards.filter((c) => c.id !== cardData.id) : movedCards.push(cardData);
}

// Moves a card and updates the movedCards array
const moveCard = (cardElement) => {
    if(!cardElement) throw new Error('Card element is required');
    const cardData = getCardData(cardElement);
    const isMovingRight = $(cardElement).closest(".wrapper-left").length > 0;
    moveCardToWrapper($(cardElement), isMovingRight ? ".wrapper-right" : ".wrapper-left");
    updateMovedCards(cardData, isMovingRight);
}

// Clears a table
const clearTable = (table) => {
    if (!table) throw new Error('Table is required');
    table.innerHTML = '';
}

// Creates a table header
const createTableHeader = (table) => {
    if(!table) throw new Error('Table is required');
    const headerRow = table.createTHead().insertRow();
    ["", "Name", "Description", "Type", "Strength Level", "Sets", "Reps", "Order"]
        .forEach(text => headerRow.appendChild(document.createElement("th")).textContent = text);
}

// Handles the click event for the saveExercise button
$(".saveExercise").click(() => {
    $.ajax({
        url: "addExerciseToWorkout", 
        type: "POST",
        data: { movedCards: movedCards },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: (response) => {
            const table = document.getElementById("exercisesTable");
            if(table) {
                clearTable(table);
                createTableHeader(table);
                populateTable(table, response);
                $("#exerciseModal").modal("show");
            }
        },
        error: () => location.reload(),
    });
});

// Populates a table with response data
const populateTable = (table, response) => {
    if(!table || !Array.isArray(response)) throw new Error('Both table and response are required');
    response.forEach((exercise, i) => {
        const row = table.insertRow();
        populateRowWithExerciseData(row, exercise, i);
    });
}

// Populates a table row with exercise data
const populateRowWithExerciseData = (row, exercise, i) => {
    populateRowWithMainData(row, exercise);
    populateRowWithInputData(row, exercise, i);
    appendIdInput(row, exercise, i);
}

// Populates a table row with main exercise data
const populateRowWithMainData = (row, exercise) => {
    ["imageUrl", "name", "description", "type", "strengthLevel"].forEach((key) => {
        if(exercise.hasOwnProperty(key)) {
            const cell = row.insertCell();
            cell.style.verticalAlign = "middle";
            populateCellWithKeyData(cell, key, exercise);
        }
    });
}

// Populates a table cell with specific key data
const populateCellWithKeyData = (cell, key, exercise) => {
    if (key === "imageUrl") {
        const img = document.createElement("img");
        img.src = exercise[key];
        img.className = "planner-image"
        cell.appendChild(img);
    } else if (key === "description") {
        const div = document.createElement("div");
        div.className = "planner-description";
        
        div.textContent = exercise[key];
        cell.appendChild(div);
    } else {
        cell.textContent = exercise[key];
    }
}

// Populates a table row with input data
const populateRowWithInputData = (row, exercise, i) => {
    ["sets", "reps", "order"].forEach((key) => {
        const cell = row.insertCell();
        cell.className = "planner-input";
        appendInputToCell(cell, key, exercise, i);
    });
}

// Appends an input to a table cell
const appendInputToCell = (cell, key, exercise, i) => {
    const input = document.createElement("input");
    input.type = "number";
    input.name = `exercises[${i}][${key}]`;
    input.min = 1; 
    input.value = exercise[key] || 1; 
    input.className = "planner-exercise-input";
    cell.appendChild(input);
}

// Appends an id input to a table row
const appendIdInput = (row, exercise, i) => {
    if(exercise.hasOwnProperty('id')) {
        const idInput = document.createElement("input");
        idInput.type = "hidden";
        idInput.name = `exercises[${i}][id]`;
        idInput.value = exercise.id;
        row.appendChild(idInput);
    }
}