<?php
ob_start();
session_start();

if (isset($_POST['convert'])) {
  // Check if a file was uploaded
  if (!empty($_FILES['video_file_name']['tmp_name'])) {
      $inputFileName = $_FILES['video_file_name']['name'];
      $inputFile = $_FILES['video_file_name']['tmp_name'];

      $filenameWithoutExtension = pathinfo($inputFileName, PATHINFO_FILENAME);

      // Check file extension
      $allowedExtensions = array('mp4', 'mkv', 'flv', 'vob', 'ogv', 'ogg', 'avi', 'wmv', 'mov', 'mpeg', 'mpg');
      $uploadedFileExt = pathinfo($_FILES['video_file_name']['name'], PATHINFO_EXTENSION);
      if (!in_array($uploadedFileExt, $allowedExtensions)) {
          echo "
          <script>
            alert('File format not supported.');
            window.location.href = 'hero_section.php';
          </script>
          ";
          exit; // Stop further execution of the code
      }


      // Check file size (limit to 150MB)
      $maxFileSize = 150 * 1024 * 1024; // 150MB in bytes
      $uploadedFileSize = $_FILES['video_file_name']['size'];
      if ($uploadedFileSize > $maxFileSize) {
          echo "
          <script>
            alert('File size exceeds the limit of 150MB.');
            window.location.href = 'hero_section.php';
          </script>
          ";
          exit; // Stop further execution of the code
      }

      // Generate a unique name for the output file
      $outputFileName = $filenameWithoutExtension . '.webm';
      $outputFile = './storage/' . $outputFileName; // Update the path to your desired location

      $ffmpegPath = './ffmpeg/bin/ffmpeg.exe';

      $cmd = "\"$ffmpegPath\" -i \"$inputFile\" -c:v libvpx -crf 10 -b:v 1M -c:a libvorbis \"$outputFile\" 2>&1";

      // Execute the FFmpeg command
      exec($cmd, $output, $returnCode);

      if ($returnCode === 0) {
          // Conversion successful
          $_SESSION['converted_file'] = $outputFile;
      } else {
          // Conversion failed
          echo 'Conversion failed. Error code: ' . $returnCode;
          echo 'Error message: ';
          print_r($output);
      }

      echo "
      <script>
        setTimeout(() => {
          document.querySelector('.converted').classList.remove('hidden');
        }, 100);
        setTimeout(() => {
          document.querySelector('.converted').classList.add('hidden');
          document.location.href = 'download.php';
        }, 1500);
      </script>
      ";
  } else {
    echo "
    <script>
      alert('No file uploaded.');
      window.location.href = 'hero_section.php';
    </script>
    ";
  }
}




if(isset($_POST['unlink'])){
  $storagePath = './storage/';

  // Retrieve a list of files in the storage directory
  $fileList = glob($storagePath . '*');
  
  // Loop over the file list and delete each file
  foreach ($fileList as $filePath) {
      if (is_file($filePath)) {
          unlink($filePath);
      }
  }

  $_SESSION['converted_file'] = null;
  echo
  "
  <script>
    document.location.href = 'hero_section.php';
  </script>

  ";
}



?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="./root_files/assets/bootstrap-5.1.3-dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="./root_files/assets/icons/fontawesome/css/all.css">
    <link rel="stylesheet" href="./root_files/assets/css/general_styles.css" />
    <link rel="stylesheet" href="./root_files/assets/css/add.video.css">
    <title>MIGASA COURSEWARE</title>
  </head>


  <div class="converted hidden position-fixed" style="top: 0; left: 0; z-index: 9999;">
    <div class="invalid_modal_container">
      <div class="invalid_modal d-flex flex-column" style="background: #ddf5d9; color: #444">
        <div class="h2">
        ✅ CONVERTED SUCCESSFULLY!
        </div>
      </div>
    </div>
  </div>

  <script src="./root_files/assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
    <script src="./root_files/assets/js/jquery-3.5.1.min.js"></script>
    <script src="./root_files/assets/js/add_video.js"></script>
  </body>
</html>