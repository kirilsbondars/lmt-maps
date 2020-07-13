<tr>
    <td class="first">
        <input type="checkbox" data-id="<?php echo $id?>" class="checkboxLayer" title="Check to display layer"/>
    </td>
    <td class="second"><?php echo $name?></td>
    <td class="third">
        <div style="display: table; border-spacing: 3px; border-collapse: separate;">
            <div class="stroke" style="width: 7px; height: 18px; background-color: <?php echo $strokeColor?>; display: table-cell; cursor: pointer" title="Color of stroke"></div>
            <div class="circle" style="width: 18px; height: 18px; background-color: <?php echo $circleColor?>; border-radius: 18px; display: table-cell; cursor: pointer" title="Color of point"></div>
        </div>
    </td>
</tr>