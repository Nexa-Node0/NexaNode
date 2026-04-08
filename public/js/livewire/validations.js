// ─── Helpers ────────────────────────────────────────────────────
function showError(el, msg) {
    el.textContent = msg;
    el.classList.remove("hidden");
}
function clearError(el) {
    el.textContent = "";
    el.classList.add("hidden");
}

// ─── Date Validation ────────────────────────────────────────────
const startDateInput = document.getElementById("start_date");
const targetDateInput = document.getElementById("target_date");
const startDateError = document.getElementById("start_date_error");
const targetDateError = document.getElementById("target_date_error");
const today = new Date().toISOString().split("T")[0];
startDateInput.setAttribute("min", today);

startDateInput.addEventListener("change", () => {
    if (!startDateInput.value || startDateInput.value < today) {
        showError(startDateError, "Start date cannot be in the past.");
        startDateInput.value = "";
        return;
    }
    clearError(startDateError);
    const nextDay = new Date(startDateInput.value);
    nextDay.setDate(nextDay.getDate() + 1);
    targetDateInput.setAttribute("min", nextDay.toISOString().split("T")[0]);
    if (targetDateInput.value)
        targetDateInput.dispatchEvent(new Event("change"));
});

targetDateInput.addEventListener("change", () => {
    if (!targetDateInput.value) return clearError(targetDateError);
    if (!startDateInput.value) {
        showError(targetDateError, "Please select a start date first.");
        targetDateInput.value = "";
        return;
    }
    if (targetDateInput.value <= startDateInput.value) {
        showError(targetDateError, "Target date must be after the start date.");
        targetDateInput.value = "";
        return;
    }
    clearError(targetDateError);
});

// ─── Reference Files ────────────────────────────────────────────
const dropZone = document.getElementById("drop-zone");
const fileInput = document.getElementById("file-input");
const fileList = document.getElementById("file-list");
let selectedFiles = [];

dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("border-black/60");
});
dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("border-black/60");
});
dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("border-black/60");
    addFiles(e.dataTransfer.files);
});
dropZone.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", () => {
    addFiles(fileInput.files);
    fileInput.value = "";
});

function addFiles(files) {
    Array.from(files).forEach((file) => {
        if (
            !selectedFiles.some(
                (f) => f.name === file.name && f.size === file.size,
            )
        )
            selectedFiles.push(file);
    });
    renderFileList();
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderFileList();
}

function formatSize(bytes) {
    return bytes < 1024 * 1024
        ? (bytes / 1024).toFixed(1) + " KB"
        : (bytes / (1024 * 1024)).toFixed(1) + " MB";
}

function renderFileList() {
    fileList.innerHTML = "";
    selectedFiles.forEach((file, index) => {
        const item = document.createElement("div");
        item.className =
            "flex items-center justify-between bg-black/5 border border-black/10 rounded-lg px-4 py-2 text-sm primary-font";
        const info = document.createElement("div");
        info.className = "flex items-center gap-3 truncate";
        info.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-black/40 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.4 6.585a6 6 0 108.486 8.486L20.5 13" />
        </svg>
        <span class="truncate text-black/80">${file.name}</span>
        <span class="text-black/30 shrink-0">${formatSize(file.size)}</span>`;
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className =
            "text-black/30 hover:text-red-500 transition ml-3 shrink-0";
        btn.textContent = "✕";
        btn.addEventListener("click", () => removeFile(index));
        item.appendChild(info);
        item.appendChild(btn);
        fileList.appendChild(item);
    });
}

// ─── Assets Files ────────────────────────────────────────────────
const assetsDropZone = document.getElementById("assets-drop-zone");
const assetsInput = document.getElementById("assets-input");
const assetsList = document.getElementById("assets-list");
let selectedAssets = [];

assetsDropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    assetsDropZone.classList.add("border-black/60");
});
assetsDropZone.addEventListener("dragleave", () => {
    assetsDropZone.classList.remove("border-black/60");
});
assetsDropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    assetsDropZone.classList.remove("border-black/60");
    addAssets(e.dataTransfer.files);
});
assetsDropZone.addEventListener("click", () => assetsInput.click());
assetsInput.addEventListener("change", () => {
    addAssets(assetsInput.files);
    assetsInput.value = "";
});

function addAssets(files) {
    Array.from(files).forEach((file) => {
        if (
            !selectedAssets.some(
                (f) => f.name === file.name && f.size === file.size,
            )
        )
            selectedAssets.push(file);
    });
    renderAssetsList();
}

function removeAsset(index) {
    selectedAssets.splice(index, 1);
    renderAssetsList();
}

function formatAssetSize(bytes) {
    return bytes < 1024 * 1024
        ? (bytes / 1024).toFixed(1) + " KB"
        : (bytes / (1024 * 1024)).toFixed(1) + " MB";
}

function renderAssetsList() {
    assetsList.innerHTML = "";
    selectedAssets.forEach((file, index) => {
        const item = document.createElement("div");
        item.className =
            "flex items-center justify-between bg-black/5 border border-black/10 rounded-lg px-4 py-2 text-sm primary-font";
        const info = document.createElement("div");
        info.className = "flex items-center gap-3 truncate";
        info.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-black/40 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.4 6.585a6 6 0 108.486 8.486L20.5 13" />
        </svg>
        <span class="truncate text-black/80">${file.name}</span>
        <span class="text-black/30 shrink-0">${formatAssetSize(file.size)}</span>`;
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className =
            "text-black/30 hover:text-red-500 transition ml-3 shrink-0";
        btn.textContent = "✕";
        btn.addEventListener("click", () => removeAsset(index));
        item.appendChild(info);
        item.appendChild(btn);
        assetsList.appendChild(item);
    });
}

// ─── Form Validation & Submit ────────────────────────────────────
document
    .getElementById("inquiry-form")
    .addEventListener("submit", function (e) {
        e.preventDefault();
        let isValid = true;

        function validate(id, errorId, message, condition) {
            const el = document.getElementById(id);
            const err = document.getElementById(errorId);
            if (condition(el)) {
                showError(err, message);
                isValid = false;
            } else clearError(err);
        }

        validate(
            "fullname",
            "fullname_error",
            "Name is required.",
            (el) => !el.value.trim(),
        );
        validate(
            "email",
            "email_error",
            "A valid email is required.",
            (el) =>
                !el.value.trim() ||
                !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value),
        );
        validate(
            "company_name",
            "company_name_error",
            "Company name is required.",
            (el) => !el.value.trim(),
        );
        validate(
            "service_types",
            "service_types_error",
            "Please select a service type.",
            (el) => !el.value,
        );
        validate(
            "description",
            "description_error",
            "Project description is required.",
            (el) => !el.value.trim(),
        );
        validate(
            "industry_types",
            "industry_types_error",
            "Please select an industry.",
            (el) => !el.value,
        );
        validate(
            "page_count",
            "page_count_error",
            "Please select number of pages.",
            (el) => !el.value,
        );
        validate(
            "contact_method",
            "contact_method_error",
            "Please select a contact method.",
            (el) => !el.value,
        );
        validate(
            "preferred_time",
            "preferred_time_error",
            "Please select a preferred time.",
            (el) => !el.value,
        );
        validate(
            "survey",
            "survey_error",
            "Please let us know how you heard about us.",
            (el) => !el.value.trim(),
        );

        // Optional URL
        const urlEl = document.getElementById("website_url");
        const urlErr = document.getElementById("website_url_error");
        if (urlEl.value.trim() && !/^https?:\/\/.+/.test(urlEl.value.trim())) {
            showError(
                urlErr,
                "Please enter a valid URL starting with https://",
            );
            isValid = false;
        } else clearError(urlErr);

        // Optional phone
        const phoneEl = document.getElementById("phone_number");
        const phoneErr = document.getElementById("phone_number_error");
        if (
            phoneEl.value.trim() &&
            !/^[0-9+\-\s()]{7,15}$/.test(phoneEl.value.trim())
        ) {
            showError(phoneErr, "Please enter a valid phone number.");
            isValid = false;
        } else clearError(phoneErr);

        // Radio: budget
        const budgetErr = document.getElementById("budget_error");
        if (!document.querySelector('input[name="budget"]:checked')) {
            showError(budgetErr, "Please select a budget range.");
            isValid = false;
        } else clearError(budgetErr);

        // Radio: has_branding
        const brandingErr = document.getElementById("has_branding_error");
        if (!document.querySelector('input[name="has_branding"]:checked')) {
            showError(
                brandingErr,
                "Please indicate if you have existing branding.",
            );
            isValid = false;
        } else clearError(brandingErr);

        // Radio: has_contents
        const contentsErr = document.getElementById("has_contents_error");
        if (!document.querySelector('input[name="has_contents"]:checked')) {
            showError(
                contentsErr,
                "Please indicate if you have content ready.",
            );
            isValid = false;
        } else clearError(contentsErr);

        // Dates
        if (!startDateInput.value) {
            showError(startDateError, "Please select a start date.");
            isValid = false;
        }
        if (!targetDateInput.value) {
            showError(targetDateError, "Please select a target launch date.");
            isValid = false;
        }

        if (!isValid) return;

        // Build FormData and append files
        const formData = new FormData(this);
        selectedFiles.forEach((file) =>
            formData.append("reference_files[]", file),
        );
        selectedAssets.forEach((file) =>
            formData.append("existing_assets[]", file),
        );

        fetch(this.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
        })
            .then((res) => res.json())
            .then((data) => {
                console.log("Success:", data);
                // handle success — redirect, show toast, etc.
            })
            .catch((err) => console.error("Error:", err));
    });
