<?php
        include ('results.php');

        $res = new Result;
        $result = $res->ShowNextPageResults();
        while($row = mysqli_fetch_array($result)) { ?>
        <tr> 
            <td><?php echo $row['VehicleID'] ?> </td>
            <td><?php echo $row['InhouseSellerID'] ?></td>
            <td><?php echo $row['BuyerID'] ?></td>
            <td><?php echo $row['Name']?></td>        
            <td><?php echo $row['Surname']?></td> 
            <td><?php echo $row['ModelID']?></td> 
            <td><?php echo $row['SaleDate']?></td> 
            <td><?php echo $row['BuyDate']?></td> 
        </tr>
<?php }; ?>
