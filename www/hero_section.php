
<?php 
  include './root_files/includes/root_header.php'; 
  ?>
  
<style>
  /* Tooltip styling */
  [title]:hover:after {
    content: attr(title);
    padding: 5px 10px;
    color: #fff;
    background-color: #000;
    position: absolute;
    z-index: 1;
    top: 80%;
 

    white-space: nowrap;
    font-size: 12px;
    border-radius: 5px;
  }

  .progress {
      background-color: #ddd;
      height: 20px;
      margin: 20px 0;
      overflow: hidden;
    }

    #progressBar {
      background-color: #f20e0e;
      height: 100%;
      width: 0%;
      text-align: center;
      line-height: 20px;
      color: #fff;
      transition: width 0.1s ease-in-out;
    }
    .disabled-button {
      opacity: 0.5; /* Reduce opacity to visually indicate the button is disabled */
      pointer-events: none; /* Disable pointer events to prevent user interaction */
    }

  
</style>
  <body>

  <div class="container">
    <div class="row">
      <div class="col-10 mx-auto mb-5">
        <form action="./convertVideo.php" class="d-flex align-items-center justify-content-center w-100" style="min-height: 100vh;" method="POST" enctype="multipart/form-data">
          <div >
          <div class="input-group text-center">
              <div class="d-flex align-items-center justify-content-center w-100">
                <h1 for="display-6 text-center" class="font-med" style="color: #dd3a3a; text-align: center">VIDEO CONVERTER <img src="./root_files/assets/img/videos.png" width="40" alt="">
                </h1>
              </div>
              <div class="drop-zone rounded-3">
                <span class="drop-zone__prompt d-flex flex-column align-items-center">
                  <span class="d-flex flex-column justify-content-center">
                    <h4 class="drop-zone__prompt">Drop file here or click to convert</h4>
                    <p class="mt-1" style="color: #777; font-size: 15px;" class="text-center">Allowed extension types: mp4, mkv, flv, vob, ogv, ogg, avi, wmv, mov, mpeg, mpg</p>
                    <p class='txt-red-light font-med' style="font-size: 15px; margin-top: -.8rem;" class="text-center">File must be less than 150 megabytes</p>
                  </span>
                </span>
                <input type="file" id="fileInput" name="video_file_name" class="drop-zone__input">
              </div>
            </div>
            <div class="progress">
              <div id="progressBar"></div>
            </div>
            <div class="d-flex align-items-center justify-content-center w-100 mt-4">
              <button name="convert" onclick="uploadFile()" class="btn bgc-red-light px-5 py-2 font-med rounded-pill update">Convert Video</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
function uploadFile() {
  let upload = document.querySelector('.upload');
  let update = document.querySelector('.update');
  let discard = document.querySelector('.discard');

  update.classList.add('disabled-button'); // Apply the disabled style class

  var allowedFileTypes = ['mp4', 'mkv', 'flv', 'vob', 'ogv', 'ogg', 'avi', 'wmv', 'mov', 'mpeg', 'mpg'];

  // Get the file input element and selected file
  var fileInput = document.getElementById("fileInput");
  var file = fileInput.files[0];

  // Check if the file type is allowed
  var fileType = file.name.split('.').pop().toLowerCase();
  if (!allowedFileTypes.includes(fileType)) {
    return; // Exit the function if file type is not allowed
  }

  // Calculate the file size and estimated upload time
  var fileSize = file.size;
  var uploadTime = fileSize / 1000000 * 1; // Time in seconds (assuming 1Mbps upload speed)

  // Get the progress bar element and initialize progress to 0
  var progressBar = document.getElementById("progressBar");
  var progress = 0;

  // Create a new FormData object and append the file to it
  var formData = new FormData();
  formData.append("file", file);

  // Send the file to the server using AJAX and update progress bar
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/upload", true);
  xhr.upload.onprogress = function(event) {
    if (event.lengthComputable) {
      progress = Math.round((event.loaded / event.total) * 100);
      progressBar.style.width = progress + "%";
      progressBar.innerText = progress + "%";
    }
  };
  xhr.onload = function() {
    if (xhr.status == 200) {
      progressBar.style.width = "100%";
      setTimeout(function() {
        progressBar.innerText = "";
      }, 5000); // Clear the progress bar message after 5 seconds
    }
  };
  xhr.send(formData);
  
  // Start a timer to update the progress bar every second
  var interval = setInterval(function() {
    progress += 1;
    progressBar.style.width = progress + "%";
    progressBar.innerText = progress + "%";
    if (progress > 100) {
      clearInterval(interval);
      progressBar.innerText = "Processing video... Please wait for a moment.";
    }
  }, uploadTime * 10);
}

</script>



<?php include './root_files/includes/root_footer.php'; ?>
