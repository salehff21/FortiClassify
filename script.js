function checkPasswordStrength() {
    var password = document.getElementById("password").value;
    var strengthBar = document.getElementById("password-strength");
    var strengthText = document.getElementById("strength-text");

    var strength = 0;

    if (password.length >= 1) strength++; // 
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++; 
    if (/[0-9]/.test(password)) strength++; 
    if (/[@$!%*?&]/.test(password)) strength++; 

    strengthBar.classList.remove("weak", "medium", "strong");

    if (strength === 0) {
        strengthText.textContent = "";
        strengthBar.style.backgroundColor = "#ddd"; 
    } else if (strength === 1) {
        strengthBar.classList.add("weak");
        strengthText.textContent = "Weak";
        strengthBar.style.backgroundColor = "red"; 
    } else if (strength === 2) {
        strengthBar.classList.add("medium");
        strengthText.textContent = "Medium";
        strengthBar.style.backgroundColor = "orange";
    } else {
        strengthBar.classList.add("strong");
        strengthText.textContent = "Strong";
        strengthBar.style.backgroundColor = "green";
    }
}