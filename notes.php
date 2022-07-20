<table>
        <thead>
            <tr>
                <th> Name </th>
                <th> Description </th>
                <th> Price </th>
                <th> Image link </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($row))
            foreach($row as $rows)
            {
                ?>
                <tr>
                    <td><?php echo $rows['name']; ?></td>
                    <td><?php echo $rows['description']; ?></td>
                    <td><?php echo $rows['price']; ?></td>
                    <td><img src="<?php echo $rows['img']; ?>" width="300" height="auto" /></td>
                </tr>
                <?php } ?>
        </tbody>        
    </table>