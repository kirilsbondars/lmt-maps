<?php require_once("../src/initialize.php"); ?>
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
    <link rel="stylesheet" href="assets/ol/ol.css">
</head>
<body>
<div class="container-fluid">
    <div id="row" class="row">
        <div id="layers" class="col-md-3">
            Choose files to display:
            <form id="choice_layers">
            </form>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Manage layers</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Manage layers</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
<!--                            <table class="table">-->
<!--                                <thead class="thead-dark">-->
<!--                                <tr>-->
<!--                                    <th scope="col">#</th>-->
<!--                                    <th scope="col">First</th>-->
<!--                                    <th scope="col">Last</th>-->
<!--                                    <th scope="col">Handle</th>-->
<!--                                </tr>-->
<!--                                </thead>-->
<!--                                <tbody>-->
<!--                                <tr>-->
<!--                                    <th scope="row">1</th>-->
<!--                                    <td>Mark</td>-->
<!--                                    <td>Otto</td>-->
<!--                                    <td>@mdo</td>-->
<!--                                </tr>-->
<!--                                </tbody>-->
<!--                            </table>-->
                            <form id="add_layers" enctype="multipart/form-data">
                                Select file to upload:
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <input type="submit" value="Upload Image" name="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="map" class="map col-md"></div>
    </div>
</div>

<!-- OpenLayers -->
<script src="assets/ol/ol.js"></script>
<!-- Bootstrap and others -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!-- My JS -->
<script src="assets/script.js"></script>
</body>
</html>