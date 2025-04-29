const csvApiEndpoints = {
    add_product: "add-product",
    add_sub_category: "add-sub-categories",
    add_addons: "store-addon",
    add_dressing: "store-dressing",
    add_types: "store-types",
    add_areas: "add-areas"
};

function uploadCsv(page) {
    const fileInput = document.getElementById("csv-file");
    const file = fileInput.files[0];
    console.log("Selected file:", file);

    if (!page) {
        console.error("No page specified.");
        showToast("Error: No page specified.", false);
        return;
    }
    
    let apiEndpoint = csvApiEndpoints[page];
    console.log("API Endpoint:", apiEndpoint);

    if (!apiEndpoint) {
        console.error("Invalid page:", page);
        showToast("Error: Invalid page.", false);
        return;
    }

    if (!file) {
        alert("Please select a CSV file.");
        return;
    }

    var data = new FormData();
    data.append("csv_file", file);

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function() {
        if (this.readyState === 4) {
            console.log("Response status:", this.status);
            console.log("Response text:", this.responseText);

            if (this.status === 201) {
                showToast("The CSV file has been uploaded successfully!", true);
            } else {
                showToast("Failed to upload the CSV file.", false);
            }
            fileInput.value = '';  // Clear the file input after upload
        }
    });

    xhr.open("POST", `https://foodola.foodola.shop/Laravel/api/${apiEndpoint}`);
    xhr.send(data);
}

function showToast(message, success) {
    let toastContainer = document.getElementById("toast-container");
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.id = "toast-container";
        toastContainer.className = "toast-container position-fixed bottom-0 end-0 p-3";
        document.body.appendChild(toastContainer);
    }

    const toastElement = document.createElement("div");
    toastElement.className = `toast align-items-center text-white border-0 ${success ? 'text-bg-success' : 'text-bg-danger'}`;
    toastElement.role = "alert";
    toastElement.ariaLive = "assertive";
    toastElement.ariaAtomic = "true";

    toastElement.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    toastContainer.appendChild(toastElement);

    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    // Remove the toast element after it hides
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastContainer.removeChild(toastElement);
    });
}

