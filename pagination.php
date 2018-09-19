<?php
include('db.php');
    $results_per_page = 20;
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
    $this_page_first_result = ($page-1)*$results_per_page;
    $sql=  "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
            FROM vehicles
            INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID LIMIT " . $this_page_first_result . ',' .  $results_per_page;
    $result = mysqli_query($conn, $sql); ?>
?>

 <?php while($row = mysqli_fetch_array($result)) { ?>
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
