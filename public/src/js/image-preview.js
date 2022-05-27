window.addEventListener("loading", (event) => {
    const fileInput = document.querySelector("#imageInput");
    const customLabel = document.querySelector(".custom-file-label");
    const imgPreview = document.querySelector("#img-preview");

    let isLoading = event.detail.loading;

    if (!isLoading && fileInput.value != "") {
        customLabel.innerText = fileInput.files[0].name;

        const filePict = new FileReader();
        filePict.readAsDataURL(fileInput.files[0]);

        filePict.onload = (e) => {
            imgPreview.src = e.target.result;
        };
    }
});
