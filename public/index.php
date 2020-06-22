<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LMT map</title>
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- OpenLayers -->
    <link rel="stylesheet" href="assets/ol/ol.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>

<!-- Container -->
<div class="container-fluid">
    <div id="row" class="row">

        <!-- Layers chooser -->
        <div id="layers" class="col-md-3">
            <h5>Choose files to display:</h5>
            <form id="choice_layers">
            </form>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLayerModal">Manage layers</button>
        </div>

        <!-- Map -->
        <div id="map" class="map col-md"></div>
    </div>
</div>

<!-- Layers manager -->
<div class="modal fade" id="addLayerModal" tabindex="-1" role="dialog" aria-labelledby="addLayerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addLayerModalLabel">Add layer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="successful_upload" class="alert alert-success" role="alert">
                    File successfully been uploaded.
                </div>
                <div id="unsuccessful_upload" class="alert alert-danger" role="alert"></div>

                <form id="addLayerForm" action="files/upload_file.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".geojson, .kml" required>
                    <input type="submit" class="btn btn-success" value="Upload Image" name="submit">
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<!--                <button type="submit" class="btn btn-primary" form="">Save changes</button>-->
            </div>
            
        </div>
    </div>
</div>

<!-- OpenLayers -->
<script src="assets/ol/ol.js"></script>
<!-- jQuery-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap and others -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!-- My JS -->
<script src="assets/script.js"></script>
</body>
</html>