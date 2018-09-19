<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="jquery.simplePagination.js"></script>     
</head>
<body> 
<div class="container" style="padding-top:20px;">
    <form action="search.php" method="GET">
        <input type="text" name="query" />
        <input  id="button" type="submit" value="Search" />
    </form>
    <?php

        //include('readcsv.php');
        include ('db.php');
        $results_per_page = 20;
        // find out the number of results stored in database
        $sql=   "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
                FROM vehicles
                INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID;";
        $result = mysqli_query($conn, $sql);
        $number_of_results = mysqli_num_rows($result);
        // determine number of total pages available
        $number_of_pages = ceil($number_of_results/$results_per_page);
        // determine which page number visitor is currently on
        if (!isset($_GET['page'])) {
          $page = 1;
        } else {
          $page = $_GET['page'];
        }
        // determine the sql LIMIT starting number for the results on the displaying page
        $this_page_first_result = ($page-1)*$results_per_page;
        // retrieve selected results from database and display them on page
        $sql=  "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
                FROM vehicles
                INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID LIMIT " . $this_page_first_result . ',' .  $results_per_page;
        $result = mysqli_query($conn, $sql); ?>
   
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
   
    <nav><ul class="pagination">
    <?php if(!empty($total_pages)):for($i=1; $i<=$total_pages; $i++):  
                if($i == 1):?>
                <li class='active'  id="<?php echo $i;?>"><a href='pagination.php?page=<?php echo $i;?>'><?php echo $i;?></a></li> 
                <?php else:?>
                <li id="<?php echo $i;?>"><a href='pagination.php?page=<?php echo $i;?>'><?php echo $i;?></a></li>
            <?php endif;?>          
    <?php endfor;endif;?>
    </ul>
    </nav>
         </div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('.pagination').pagination({
            items: <?php echo $number_of_results;?>,
            itemsOnPage: <?php echo $results_per_page;?>,
            cssStyle: 'light-theme',
            currentPage : 1,
            onPageClick : function(pageNumber) {
                jQuery("#target-content").html('loading...');
                jQuery("#target-content").load("pagination.php?page=" + pageNumber);
            }
        });
    });
</script>

