@include('layouts.head' )

<div class="content-dashboard">
    <div class="theme-side-menu">
        @include('layouts.left-menu' )
    </div>
    <div class="theme-element-dashboard">
        @include('layouts.navbar' )
        @yield('content' )
    </div>
</div>

@yield('javascript')

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/popper.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>

<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/clone.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line', // also try bar or other graph types

        // The data for our dataset
        data: {
            labels: ["Jan", "Fev", "Mars", "Avr", "Mai", "Juin", "Juil"],
            // Information about the dataset
            datasets: [{
                label: "Vente",
                backgroundColor: '#4dc5914d',
                borderColor: '#5FB512',
                data: [20, 50, 40, 60, 80, 90, 100],
            }]
        },

        // Configuration options
        options: {
            layout: {
                padding: 10,
            },
            legend: {
                position: 'bottom',
                display: false,
            },
            title: {
                display: false,
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'pourcentage de vente'
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Month of the Year'
                    }
                }]
            }
        }
    });

</script>
<script>
    $(function () {
        $('select').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
        });
    });
</script>
<script>
    var isAdvancedUpload = function() {
        var div = document.createElement('div');
        return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
    }();

    let draggableFileArea = document.querySelector(".drag-file-area");
    let browseFileText = document.querySelector(".browse-files");
    let uploadIcon = document.querySelector(".upload-icon");
    let dragDropText = document.querySelector(".dynamic-message");
    let fileInput = document.querySelector(".default-file-input");
    let cannotUploadMessage = document.querySelector(".cannot-upload-message");
    let cancelAlertButton = document.querySelector(".cancel-alert-button");
    let uploadedFile = document.querySelector(".file-block");
    let fileName = document.querySelector(".file-name");
    let fileSize = document.querySelector(".file-size");
    let progressBar = document.querySelector(".progress-bar");
    let removeFileButton = document.querySelector(".remove-file-icon");
    let uploadButton = document.querySelector(".upload-button");
    let fileFlag = 0;

    fileInput.addEventListener("click", () => {
        fileInput.value = '';
    });

    fileInput.addEventListener("change", e => {
        uploadIcon.innerHTML = 'check_circle';
        dragDropText.innerHTML = 'File Dropped Successfully!';
        document.querySelector(".label").innerHTML = `glisser-déposer ou <span class="browse-files"> <input type="file" class="default-file-input" style=""/> <span class="browse-files-text" style="top: 0;"> parcourir d'autres fichiers</span></span>`;
        uploadButton.innerHTML = `Upload`;
        fileName.innerHTML = fileInput.files[0].name;
        fileSize.innerHTML = (fileInput.files[0].size/1024).toFixed(1) + " KB";
        uploadedFile.style.cssText = "display: flex;";
        progressBar.style.width = 0;
        fileFlag = 0;
    });

    uploadButton.addEventListener("click", () => {
        let isFileUploaded = fileInput.value;
        if(isFileUploaded != '') {
            if (fileFlag == 0) {
                fileFlag = 1;
                var width = 0;
                var id = setInterval(frame, 50);
                function frame() {
                    if (width >= 390) {
                        clearInterval(id);
                        uploadButton.innerHTML = `<span class="material-icons-outlined upload-button-icon">Element </span> Chargé !`;
                    } else {
                        width += 5;
                        progressBar.style.width = width + "px";
                    }
                }
            }
        } else {
            cannotUploadMessage.style.cssText = "display: flex; animation: fadeIn linear 1.5s;";
        }
    });

    cancelAlertButton.addEventListener("click", () => {
        cannotUploadMessage.style.cssText = "display: none;";
    });

    if(isAdvancedUpload) {
        ["drag", "dragstart", "dragend", "dragover", "dragenter", "dragleave", "drop"].forEach( evt =>
            draggableFileArea.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
            })
        );

        ["dragover", "dragenter"].forEach( evt => {
            draggableFileArea.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
                uploadIcon.innerHTML = 'file_download';
                dragDropText.innerHTML = 'Drop your file here!';
            });
        });

        draggableFileArea.addEventListener("drop", e => {
            uploadIcon.innerHTML = 'check_circle';
            dragDropText.innerHTML = 'File Dropped Successfully!';
            document.querySelector(".label").innerHTML = `drag & drop ou <span class="browse-files"> <input type="file" class="default-file-input" style=""/> <span class="browse-files-text" style="top: -23px; left: -20px;"> parcourir d'autres fichiers</span> </span>`;
            uploadButton.innerHTML = `Upload`;

            let files = e.dataTransfer.files;
            fileInput.files = files;
            fileName.innerHTML = files[0].name;
            fileSize.innerHTML = (files[0].size/1024).toFixed(1) + " KB";
            uploadedFile.style.cssText = "display: flex;";
            progressBar.style.width = 0;
            fileFlag = 0;
        });
    }

    removeFileButton.addEventListener("click", () => {
        uploadedFile.style.cssText = "display: none;";
        fileInput.value = '';
        uploadIcon.innerHTML = 'file_upload';
        dragDropText.innerHTML = 'Drag & drop any file here';
        document.querySelector(".label").innerHTML = `ou <span class="browse-files"> <input type="file" class="default-file-input"/> <span class="browse-files-text">Parcourir les fichier</span> <span>from device</span> </span>`;
        uploadButton.innerHTML = `Upload`;
    });
</script>

