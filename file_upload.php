<?php 
    if (!empty($_GET["param1"])){
        $file = fopen("profile.txt", "w") or die("Unable to open file!");
        $txt = $_GET["param1"];
        fwrite($file, $txt);
        fclose($file);
    }

    if (isset($_POST['submit'])) {
        if (!empty($_FILES['upload']['name'])) {
            $file_name = $_FILES['upload']['name'];
            $file_size = $_FILES['upload']['size'];
            $file_tmp = $_FILES['upload']['tmp_name'];
            $target_dir = "uploads/".$file_name;

            $allowed_ext = array('png','jpg','jpeg');
            $file_ext = explode('.',$file_name);
            $file_ext = strtolower(end($file_ext));
            
            // Validate file ext
            if (in_array($file_ext,$allowed_ext)) {
                if ($file_size <= 1000000) {
                    move_uploaded_file($file_tmp,$target_dir);

                    $message = '<div class="alert alert-success" role="alert">
                    File uploaded
                  </div>'; 
                }else{
                    $message = '<div class="alert alert-danger" role="alert">
                    File is too large
                  </div>'; 
                }
            }else{
                $message = '<div class="alert alert-danger" role="alert">
                Invalide file type
              </div>';
            }

        }else{
            $message = '<div class="alert alert-danger" role="alert">
            Please choose a file
          </div>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css?ver=1.2.0" rel="stylesheet">
    <link href="css/font-awesome/css/all.min.css?ver=1.2.0" rel="stylesheet">
    <link href="css/main.css?ver=1.2.0" rel="stylesheet">

    <title>File upload</title>
</head>
<body>
    
    <div style="visibility: hidden;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <input type="file" name="upload" id="upload">
            <input type="submit" value="Submit" name="submit" id="submit">
        </form>
    </div>
   
<div class="container">
    <?php echo $message ?? null; ?>
    <!-- Header -->
    <header>
        <div class="pp-header">
            <nav class="navbar navbar-light">
                <div class="navbar">
                    <a id="icon">
                        <img style="cursor:pointer;" src="images/favicon.png" alt="Logo">
                    </a>
                    <span class="navbar-brand">Upload new photo</span>
                </div>
                <div style="width: 200px;height: 200px;">
                    <img class="profile" src=<?php
                                                $file = fopen("profile.txt", "r") or die("Unable to open file!");
                                                echo fread($file,filesize("profile.txt"));
                                                fclose($file);
                                            ?> width="100%" height="100%"/>
                </div>
            </nav>
        </div>
    </header>

    <!-- upload button -->
    <div class="container px-0 py-1">
        <div class="pp-category-filter">
            <div class="row">
                <div class="col-sm-12">
                    <a class="col-sm-12 btn btn-outline-primary" id="confirmButton">Upload</a>
                </div>
            </div>
        </div>
    </div>

    <!-- instruction message -->
    <div class=" container pp-section">
        <div class="row">
            <div class="col-md-9 col-sm-12 px-0">
                <h1 class="h3">Pick a picture from the librery</h1>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    
    <div class=" px-0">
        <div class="pp-gallery">
            <div class="card-columns">

                <!-- card -->
                <?php 
                    $folder = 'uploads';
                    $files = glob($folder . '/*');
                    $file_count = count($files);
                    foreach ($files as $key => $value) {
                        echo '<div class="card" data-groups="test">
                        <span class="pick c-'.$key.'">
                            <figure class="pp-effect">
                                <img  class="img-fluid" src='.$value.' alt="Nature"/>
                                <figcaption>
                                    <div class="h4">Pick</div>
                                </figcaption>
                            </figure>
                        </span>
                    </div>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    let uploadInput = document.querySelector("#upload");

    uploadInput.addEventListener('change',function(){
        if (uploadInput.files.length > 0) {
        console.log("File input contains a value.");
        document.querySelector("#confirmButton").classList.add("activeUpload");
        } else {
        console.log("File input does not contain a value.");
        }
    });


    let uploadIcon = document.querySelector("#icon");

    let confirmButton = document.querySelector("#confirmButton");
    let submitInput = document.querySelector("#submit");

    let pick = document.querySelectorAll(".pick");

    pick.forEach(element => {
            element.addEventListener('click', function() {
                let fileSource = element.querySelector(".img-fluid").getAttribute('src');
                window.location.href = "http://localhost/uploadFile/file_upload.php?param1=" + fileSource;
                console.log(fileSource);
        });
    });

    uploadIcon.addEventListener('click', function() {
        uploadInput.click();
    });

    confirmButton.addEventListener('click', function() {
        document.querySelector("#confirmButton").classList.remove("activeUpload");
        submitInput.click();
    });

</script>
<script src="scripts/bootstrap.bundle.min.js?ver=1.2.0"></script>
    
</body>
</html>