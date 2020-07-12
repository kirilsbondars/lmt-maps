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
        <div class="btn-group" role="group">
            <button class="btn btn-secondary actions edit" data-toggle="modal" data-target="#editModal" data-id="<?php echo $id?>" title="Edit layer"><i class="fa fa-edit" aria-hidden="true"></i></button>
            <a href="./layers/download_file.php?id=<?php echo $id?>" class="btn btn-secondary actions download" title="Download layer" role="button" aria-pressed="true"><i class="fa fa-download" aria-hidden="true"></i></a>
            <button class="btn btn-secondary actions delete" data-id="<?php echo $id?>" data-name="<?php echo $name?>" title="Delete layer"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
    </td>
</tr>