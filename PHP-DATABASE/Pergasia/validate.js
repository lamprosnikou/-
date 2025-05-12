function validateForm() {
  let user = document.forms[0]["username"].value;
  let pass = document.forms[0]["password"].value;
  if (user.length < 4 || pass.length < 4) {
    alert("Ο χρήστης και ο κωδικός πρέπει να είναι τουλάχιστον 4 χαρακτήρες.");
    return false;
  }
  return true;
}
