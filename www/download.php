<?php
session_start();

if (isset($_SESSION['converted_file'])) {
    $convertedFilePath = $_SESSION['converted_file'];
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

        <div class="container">
          <div class="row">
            <div class="col-10 mx-auto">
              <form action="./convertVideo.php" method="POST" enctype="multipart/form-data">
                <div class="d-flex align-items-center justify-content-center w-100" style="min-height: 100vh;">
                <div class="input-group my-4">
                  <div class="">
                    <div class="d-flex align-items-center justify-content-center w-100 mt-4">
                      <h1 for="display-6 text-center" class="font-med" style="margin-bottom: -.2rem; color: #dd3a3a;">DOWNLOAD THE FILE <img src="./root_files/assets/img/download.png" width="30" alt="">
                      </h1>
                    </div>
                      <video controls width="100%" class="mt-4" style="box-shadow: 0 3px 20px #444;" src="<?php echo $convertedFilePath; ?>" type="video/webm">
                      </video>                        
                    </div>
                    <div class="d-flex align-items-center justify-content-center w-100 mt-4">
                      <button name="unlink" class="btn bgc-red-light px-5 py-2 font-med rounded-pill">Convert Another Video</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>



        <script src="./root_files/assets/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
        <script src="./root_files/assets/js/jquery-3.5.1.min.js"></script>
        <script src="./root_files/assets/js/add_video.js"></script>
      </body>
    </html>

    <?php
} else {
    echo 'Converted file not found.';
}
?>
