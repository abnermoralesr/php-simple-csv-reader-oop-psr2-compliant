<?php
require_once(__DIR__."/../controller/Security.php");

use Custom\Security as Security;

$Security = new Security\Tokenizer();
$token = $Security->generateToken();
$checkToken = $Security->checkToken();
if ($checkToken==false) {
    $token = $Security->generateToken();
} else {
    $token = $checkToken;
}
$myUrl = "http://localhost/OOP/";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" 
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" 
        href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">
        <title>CSV File Reader Sample</title>
        <script>
            var myUrl = '<?php echo $myUrl; ?>';
        </script>
    </head>
    <body> 
        <div class="container">
            <h2 class="text-center">CSV File Uploader Sample</h2>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">
                    <form action="upload.php" method="POST" class="csvForm" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Please upload a CSV file</label>
                        <input type="file" id="csvFile" name="upload" value="" />
                        <input type="hidden" id="format" name="format" value="1" />
                        <input type="hidden" id="token" name="token" value="<?php echo $token; ?>" />
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>    
                    <div class="text-center">
                        <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">
                            <button class="btn btn-primary novisible" id="new">Upload New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <br>
            <div id="ajaxContent">
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.9/sweetalert2.all.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>        