function jsonCheckEmail(json) {
  // Controllo il campo exists ritpornato da json
  if ((formStatus.email = !json.exists)) {
    document.querySelector(".email").classList.remove("rosso");
    document.querySelector(".email span").textContent = "";
  } else {
    document.querySelector(".email span").textContent = "Email già utilizzata";
    document.querySelector(".email").classList.add("rosso");
  }
  checkForm();
}

function jsonCheckUsername(json) {
  // controllo il campo exists ritornato dal json
  if ((formStatus.username = !json.exists)) {
    document.querySelector(".username").classList.remove("rosso");
    document.querySelector(".username span").textContent = "";
  } else {
    document.querySelector(".username span").textContent =
      "Username non valido";
    document.querySelector(".username").classList.add("rosso");
  }
  checkForm();
}

function fetchResponse(response) {
  if (!response.ok) return null;
  console.log(response);
  return response.json();
}

function checkPassword(event) {
  const passwordInput = document.querySelector(".password input");
  if ((formStatus.password = passwordInput.value.length >= 8)) {
    document.querySelector(".password").classList.remove("rosso");
    document.querySelector(".password span").textContent = "";
  } else {
    document.querySelector(".password").classList.add("rosso");
    document.querySelector(".password span").textContent =
      "Password troppo corta";
  }
}

function checkConfirmPassword(event) {
  const confirmPasswordInput = document.querySelector(".confirmPassword input");
  if (
    (formStatus.password =
      confirmPasswordInput.value ===
      document.querySelector(".password input").value)
  ) {
    document.querySelector(".confirmPassword").classList.remove("rosso");
    document.querySelector(".confirmPassword span").textContent = "";
  } else {
    document.querySelector(".confirmPassword").classList.add("rosso");
    document.querySelector(".confirmPassword span").textContent =
      "Confirm password diversa dalla password inserita";
  }
}

function checkUsername(event) {
  const input = document.querySelector(".username input");
  console.log("hw1_chk_username.php?q=" + encodeURIComponent(input.value));

  if (!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
    input.parentNode.parentNode.querySelector("span").textContent =
      "Username non valido, sono ammessi lettere, numeri e underscore di max. 15 caratteri";
    input.parentNode.parentNode.classList.add("rosso");
    formStatus.username = false;
    checkForm();
  } else {
    fetch("hw1_chk_username.php?q=" + encodeURIComponent(input.value))
      .then(fetchResponse)
      .then(jsonCheckUsername);
  }
}

function checkEmail(event) {
  const emailInput = document.querySelector(".email input");
  if (
    !/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\a@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      String(emailInput.value).toLowerCase()
    )
  ) {
    document.querySelector(".email span").textContent = "Email non valido";
    document.querySelector(".email").classList.add("rosso");
    formStatus.email = false;
    checkForm();
  } else {
    fetch("hw1_chk_email.php?q=" + encodeURIComponent(emailInput.value))
      .then(fetchResponse)
      .then(jsonCheckEmail);
  }
}

function checkForm() {
  // Controlla che tutti i campi siano pieni
  Object.keys(formStatus).length !== 6 ||
    // Controlla che i campi non siano false
    Object.values(formStatus).includes(false);
}

const formStatus = { upload: true };
document
  .querySelector(".username input")
  .addEventListener("blur", checkUsername);
document.querySelector(".email input").addEventListener("blur", checkEmail);
document
  .querySelector(".password input")
  .addEventListener("blur", checkPassword);
document
  .querySelector(".confirmPassword input")
  .addEventListener("blur", checkConfirmPassword);

if (document.querySelector(".rosso") !== null) {
  checkUsername(); 
  checkEmail();
}
