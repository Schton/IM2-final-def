document.getElementById('uploadButton').addEventListener('click', function() {
    document.getElementById('fileID').click();
});

document.getElementById('fileID').addEventListener('change', function() {
    var fileName = this.files[0].name;
    var uploadButtonText = document.getElementById('uploadButton');
    uploadButtonText.textContent = fileName;
});

document.querySelector('.submit-button').addEventListener('click', function(event) {
    document.getElementById('orderForm').submit();
});
