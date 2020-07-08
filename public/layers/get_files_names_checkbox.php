<?php
require_once("../../src/initialize.php");

$layers = Layer::get_all();

if(empty($layers))
    echo '<p style="text-align: center"><em>No uploaded layers</em></p>';

foreach ($layers as $num => $layer) {
    $id = $layer->id;
    $name = $layer->name;
    ?>
    <tr>
        <td style="width: 25px">
            <input type="checkbox" data-id="<?php echo $id?>"/>
        </td>
        <td style="text-align: left;"><?php echo $name?></td>
        <td style="width: 40px">
            <button class="btn edit" data-id="<?php echo $id?>" data-name="<?php echo $name?>">
                <div class="row">
                    <div class="m-1"><div style="width: 5px; height: 15px; background-color: #0000ff"></div></div>
                    <div class="m-1"><div style="width: 15px; height: 15px; background-color: #8B0000; border-radius: 15px"></div></div>
                </div>
            </button>
        </td>
        <td style="width: 31px">
            <button class="btn btn-danger delete" data-id="<?php echo $id?>" data-name="<?php echo $name?>"><i class="fa fa-times" aria-hidden="true"></i></button>
        </td>
    </tr>
<?php
}
