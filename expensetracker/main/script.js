// script.js
function toggleOtherDescription() {
    var descriptionSelect = document.getElementById("description");
    var customDescriptionInput = document.getElementById("othersDescription");

    customDescriptionInput.style.display = descriptionSelect.value === "Others" ? "inline" : "none";
}

toggleOtherDescription();
