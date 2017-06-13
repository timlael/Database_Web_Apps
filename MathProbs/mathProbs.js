// This function controls problem/category editing
// By default, the user sees no editing boxes
function showEditField(id) {
	var entryBoxString = "editInput";
	var buttonString = "edit";
	var id = id;
	var entryBoxOutput = entryBoxString.concat(id);
	var buttonOutput = buttonString.concat(id);
	var entryBoxElement = document.getElementById(entryBoxOutput);
	var buttonElement = document.getElementById(buttonOutput);
	
	if (entryBoxElement.style.display === "none"){
	    entryBoxElement.style.display = "block";
	    buttonElement.value = "Hide";
	}
    else{
        entryBoxElement.style.display = "none";
        buttonElement.value = "Edit";
    }
}
