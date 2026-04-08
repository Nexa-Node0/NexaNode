// ─── Tab Switch ──────────────────────────────────────────────
function switchTab(tab) {
  const loginForm = document.getElementById("login-form");
  const registerForm = document.getElementById("register-form");
  const tabLogin = document.getElementById("tab-login");
  const tabRegister = document.getElementById("tab-register");

  if (tab === "login") {
    loginForm.classList.remove("hidden");
    registerForm.classList.add("hidden");
    tabLogin.classList.add("bg-white", "text-black");
    tabLogin.classList.remove("text-white/50");
    tabRegister.classList.remove("bg-white", "text-black");
    tabRegister.classList.add("text-white/50");
  } else {
    registerForm.classList.remove("hidden");
    loginForm.classList.add("hidden");
    tabRegister.classList.add("bg-white", "text-black");
    tabRegister.classList.remove("text-white/50");
    tabLogin.classList.remove("bg-white", "text-black");
    tabLogin.classList.add("text-white/50");
  }
}

// ─── Show/Hide Password ──────────────────────────────────────
function togglePassword(inputId, iconId) {
  const input = document.getElementById(inputId);
  input.type = input.type === "password" ? "text" : "password";
}

// ─── Helpers ─────────────────────────────────────────────────
function showError(id, msg) {
  const el = document.getElementById(id);
  el.textContent = msg;
  el.classList.remove("hidden");
}
function clearError(id) {
  const el = document.getElementById(id);
  el.textContent = "";
  el.classList.add("hidden");
}

// ─── Password Strength ───────────────────────────────────────
document.getElementById("reg_password").addEventListener("input", function () {
  const val = this.value;
  let strength = 0;
  if (val.length >= 8) strength++;
  if (/[A-Z]/.test(val)) strength++;
  if (/[0-9]/.test(val)) strength++;
  if (/[^A-Za-z0-9]/.test(val)) strength++;

  const colors = [
    "bg-red-500",
    "bg-orange-400",
    "bg-yellow-400",
    "bg-green-400",
  ];
  const labels = ["", "Weak", "Fair", "Good", "Strong"];

  for (let i = 1; i <= 4; i++) {
    const bar = document.getElementById(`strength-${i}`);
    bar.className = `h-[3px] flex-1 rounded-full transition-all duration-300 ${i <= strength ? colors[strength - 1] : "bg-white/10"}`;
  }
  document.getElementById("strength-label").textContent = labels[strength];
});

// ─── Login Validation ────────────────────────────────────────
document.getElementById("login-form").addEventListener("submit", function (e) {
  e.preventDefault();
  let isValid = true;

  const email = document.getElementById("login_email");
  const password = document.getElementById("login_password");

  if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    showError("login_email_error", "Please enter a valid email address.");
    isValid = false;
  } else clearError("login_email_error");

  if (!password.value.trim()) {
    showError("login_password_error", "Password is required.");
    isValid = false;
  } else clearError("login_password_error");

  if (!isValid) return;

  const formData = new FormData(this);
  fetch(this.action, {
    method: "POST",
    body: formData,
    headers: {
      "X-CSRF-TOKEN":
        document.querySelector('meta[name="csrf-token"]')?.content || "",
    },
  })
    .then((res) => res.json())
    .then((data) => console.log("Login success:", data))
    .catch((err) => console.error("Login error:", err));
});

// ─── Register Validation ─────────────────────────────────────
document
  .getElementById("register-form")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    let isValid = true;

    const firstname = document.getElementById("reg_firstname");
    const lastname = document.getElementById("reg_lastname");
    const email = document.getElementById("reg_email");
    const password = document.getElementById("reg_password");
    const confirm = document.getElementById("reg_password_confirm");
    const terms = document.getElementById("reg_terms");

    if (!firstname.value.trim()) {
      showError("reg_firstname_error", "First name is required.");
      isValid = false;
    } else clearError("reg_firstname_error");

    if (!lastname.value.trim()) {
      showError("reg_lastname_error", "Last name is required.");
      isValid = false;
    } else clearError("reg_lastname_error");

    if (
      !email.value.trim() ||
      !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)
    ) {
      showError("reg_email_error", "Please enter a valid email address.");
      isValid = false;
    } else clearError("reg_email_error");

    if (!password.value || password.value.length < 8) {
      showError(
        "reg_password_error",
        "Password must be at least 8 characters.",
      );
      isValid = false;
    } else clearError("reg_password_error");

    if (confirm.value !== password.value) {
      showError("reg_confirm_error", "Passwords do not match.");
      isValid = false;
    } else clearError("reg_confirm_error");

    if (!terms.checked) {
      showError("reg_terms_error", "You must agree to the Terms of Service.");
      isValid = false;
    } else clearError("reg_terms_error");

    if (!isValid) return;

    const formData = new FormData(this);
    fetch(this.action, {
      method: "POST",
      body: formData,
      headers: {
        "X-CSRF-TOKEN":
          document.querySelector('meta[name="csrf-token"]')?.content || "",
      },
    })
      .then((res) => res.json())
      .then((data) => console.log("Register success:", data))
      .catch((err) => console.error("Register error:", err));
  });
