let movedCards = [];

// Extracts card data from a card element
const getCardData = (cardElement) => {
    if (!cardElement) throw new Error('Card element is required');
    const id = cardElement.id.replace('card-', '');
    const [name, description, type, strengthLevel] = Array.from(cardElement.querySelectorAll("h4, p")).map(el => el.textContent);
    const sets = parseInt(document.getElementById('setsInput').value) || 1;
    const order = parseInt(document.getElementById('orderInput').value) || 1;
    const reps = parseInt(document.getElementById('repsInput').value) || 1;
    return { id, name, description, type, strengthLevel, sets, order, reps };
}

// Moves a card to a target wrapper
const moveCardToWrapper = (card, targetWrapper) => {
    if (!card || !targetWrapper) throw new Error('Both card and targetWrapper are required');
    targetWrapper.appendChild(card);
}

// Handles the click event for the saveExercise button
document.querySelector(".saveExercise").addEventListener('click', () => {
    fetch("addExerciseToWorkout", {
        method: "POST",
        headers: { 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ movedCards: movedCards })
    })
    .then(response => response.json())
    .then(response => {
        const table = document.getElementById("exercisesTable");
        if(table) {
            clearTable(table);
            createTableHeader(table);
            populateTable(table, response);
            new bootstrap.Modal(document.getElementById('exerciseModal')).show();
        }
    })
    .catch(() => location.reload());
});