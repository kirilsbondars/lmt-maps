<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vector Layer</title>
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL"></script>
    <!-- My CSS -->
    <link rel="stylesheet" href="assets/styles.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- OpenLayers -->
    <link rel="stylesheet" href="assets/v6.3.1-dist/ol.css">
</head>
<body>
<div class="container-fluid">
    <div id="row" class="row">
        <div id="layers" class="col-md-3">
            Choose files to display:
            <form id="choice_layers">
                <?php require_once("get_files_names.php"); ?>
            </form>
            <button type="button" id="layers" class="btn btn-primary btn-lg btn-block">Manage layers</button>
        </div>
        <div id="map" class="map col-md"></div>
    </div>
</div>

<!-- OpenLayers -->
<script src="assets/v6.3.1-dist/ol.js"></script>
<!-- Bootstrap and others -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!-- My JS -->
<script src="assets/script.js"></script>
</body>
</html>