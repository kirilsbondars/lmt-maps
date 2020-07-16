//Override defaults for alertifyjs
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

// html
function getPanelTableRow(layer) {
    let id = layer["id"];
    let name = layer["name"];
    let style = JSON.parse(layer["style"]);
    let length = layer["length"];

    let row = '<tr>';
    row += '<td class="first">';
    row += '<input type="checkbox" data-id="' + id +'" data-length="' + length + '" title="Check to display layer"/>';
    row += '</td>';
    row += '<td class="second" title="' + name +'">' + name + '</td>';
    row += '<td class="third">';
    row += '<div style="display: table; border-spacing: 3px; border-collapse: separate;">';
    row += '<div class="stroke" style="width: 7px; height: 18px; background-color: ' +  +'; display: table-cell; cursor: pointer" title="Color of stroke"></div>';
    row += '<div class="circle" style="width: 18px; height: 18px; background-color: <?php echo $circleColor?>; border-radius: 18px; display: table-cell; cursor: pointer" title="Color of point"></div>';
    row += '</div>';
    row += '</td>';
    row +='<td class="forth">';
    row += '<div class="btn-group" role="group">';
    row += '<button class="btn btn-secondary actions edit" data-toggle="modal" data-target="#editModal" data-id="<?php echo $id?>" title="Edit layer"><i class="fa fa-edit" aria-hidden="true"></i></button>';
    row += '<a href="files/download_files.php?ids=[<?php echo $id?>]" class="btn btn-secondary actions download" title="Download layer" role="button" aria-pressed="true"><i class="fa fa-download" aria-hidden="true"></i></a>';
    row += '<button class="btn btn-secondary actions delete" data-id="<?php echo $id?>" data-name="<?php echo $name?>" title="Delete layer"><i class="fa fa-times" aria-hidden="true"></i></button>';
    row += '</div>';
    row +='</td>';
    row += '</tr>';
}

function getPanelTable() {

}

// functions
$(window).on('load', function() {
    $.post("test/layer/get_all.php", function (json) {
        let data = JSON.parse(json);
        console.log(data);
    })
});