<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>     
</head>
<body> 
<div class="container" style="padding-top:20px;">
<?php
    include('db.php');
    $query = $_GET['query']; 
    // Minimum length of the search query
    $min_length = 3;
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then  
        $sql=  "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
                FROM vehicles
                INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID
                WHERE Name LIKE '".$query."' OR Surname LIKE '".$query."' OR SaleDate LIKE '".$query."'";
        $result = mysqli_query($conn, $sql);      
        if($row = mysqli_fetch_array($result) ==0){   
            echo "No matches found for " . $query . ". Please try again with a different query.";
        } else {
?> 
            <table class="table table-bordered table-striped" >
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Seller ID</th>
                        <th>Buyer ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Model ID</th>
                        <th>Sale date</th>
                        <th>Buy date</th>
                    </tr>
                </thead>
                <tbody id="target-content">
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
                </tbody>
            </table>
<?php
        } 
    }
    else { // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }
?>
</div>
</body> 
</html>



