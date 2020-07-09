<?php
require_once("../../src/initialize.php");

$layers = Layer::get_all();

if(empty($layers))
    echo '<p style="text-align: center"><em>No uploaded layers</em></p>';

foreach ($layers as $num => $layer) {
    $id = $layer->id;
    $name = $layer->name;
    $style = json_decode($layer->style, true);
    $strokeColor = $style["stroke"]["color"];
    $circleColor = $style["circle"]["fill"]["color"];
    ?>
    <tr>
        <td class="first">
            <input type="checkbox" data-id="<?php echo $id?>" class="checkboxLayer" title="Check to display layer"/>
        </td>
        <td class="second"><?php echo $name?></td>
        <td class="third">
            <div style="display: table; border-spacing: 3px; border-collapse: separate;">
                <div style="width: 7px; height: 18px; background-color: <?php echo $strokeColor?>; display: table-cell; cursor: pointer" title="Color of stroke"></div>
                <div style="width: 18px; height: 18px; background-color: <?php echo $circleColor?>; border-radius: 18px; display: table-cell; cursor: pointer" title="Color of point"></div>
            </div>
        </td>
        <td class="forth">
            <div class="btn-group editDelete" role="group">
                <button class="btn btn-secondary edit" data-toggle="modal" data-target="#editModal" data-id="<?php echo $id?>" data-name="<?php echo $name?>" title="Edit layer"><i class="fa fa-edit" aria-hidden="true"></i></button>
                <button class="btn btn-secondary delete" data-id="<?php echo $id?>" data-name="<?php echo $name?>" title="Delete layer"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
        </td>
    </tr>
<?php
}