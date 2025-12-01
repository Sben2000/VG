// add class "active" to element on button press
let connexion = document.querySelector("connexion");

// later, check if class "active" has been added to element
function checkIfActive() {
  if (connexion.classList.contains("hidden")) {
    console.log("connexion is hidden");
    // do something here if the class exists
  } else {
    console.log("connexion is not hidden");
    // do something else here if the class does not exist
  }
}
