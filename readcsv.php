<?php
  include ('db.php');
// creating database table vehicles if it doesn't exists
$queryCreateTable = "CREATE TABLE IF NOT EXISTS `VEHICLES` (
    `VehicleID` int(11) unsigned NOT NULL,
    `InhouseSellerID` int(10) NULL,
    `BuyerID` int(10) NULL,
    `ModelID` int(10) NULL,
    `SaleDate` date NULL,
    `BuyDate` date NULL,
     PRIMARY KEY  (`VehicleID`)
)";
if(!$conn->query($queryCreateTable)){
    echo "Table creation failed: (" . $dbConnection->errno . ") " . $dbConnection->error; }
try {
        // creating database table buyers if it doesn't exists
        $queryCreateBuyersTable = "CREATE TABLE IF NOT EXISTS `BUYERS` (
            `BuyerID` int(11) NOT NULL AUTO_INCREMENT,
            `Name` char(10) NULL,
            `Surname` char(10) NULL,
             PRIMARY KEY  (`BuyerID`)
        )";
        if(!$conn->query($queryCreateBuyersTable)){
            echo "Table creation failed: (" . $dbConnection->errno . ") " . $dbConnection->error; }

        // VEHICLES
        // read CSV file
        $row = 1;
        if (($handle = fopen("csv.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                if($row == 1){ $row++; continue; } // skips the first csv line with column names
                $num = count($data);
                $row++;
                $array;
                for ($c=0; $c < $num; $c++) {
                    $array[$row][$c] = $data[$c];
                }
            }
            fclose($handle);
        }
        //insert data in table vehicles
        for ($i = 3; $i <= $row-2; $i++) {  
                $query ="INSERT INTO VEHICLES (VehicleID, InhouseSellerID, BuyerID, ModelID, SaleDate, BuyDate) VALUES ( '".preg_replace('/\D/', '', $array[$i][0])."','".$array[$i][1]."','".$array[$i][2]."', '". $array[$i][3]."','".$array[$i][4]."','".$array[$i][5]."' )";
                mysqli_query($conn, $query);
         }

        // BUYERS
        // array containing forenames.
        $names = array('Marija','Ana','Maja','Marko','Andrej','Nina','David','Marjan','Mojca','Jasmina');
        // array containing surnames.
        $surnames = array('Novak','Horvat','Krajnc','Koren','Mlakar','Kos','Vidmar','Knez','Bogataj');        
        // gets distinct buyerID from vehicles table
        $sql = "SELECT DISTINCT BuyerID FROM vehicles";
        $result = $conn->query($sql);
        // insert data in table buyers
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {      
                // generate a random forename.
                $random_name = $names[mt_rand(0, sizeof($names) - 1)];
                // generate a random surname.
                $random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];
                $query ="INSERT INTO BUYERS (BuyerID, Name, Surname) VALUES ( '".$row["BuyerID"]."','".$random_name."','".$random_surname."' )";
                mysqli_query($conn, $query);
            }
        } 
    echo 'Datatables created successfully!';
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>