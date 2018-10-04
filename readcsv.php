<?php
  include ('db.php');

class Vehicle { 
    public $queryCreateTable = "CREATE TABLE IF NOT EXISTS `VEHICLES` (
            `VehicleID` int(11) unsigned NOT NULL,
            `InhouseSellerID` int(10) NULL,
            `BuyerID` int(10) NULL,
            `ModelID` int(10) NULL,
            `SaleDate` date NULL,
            `BuyDate` date NULL,
             PRIMARY KEY  (`VehicleID`)
             )";
    
    function readCSV() {
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
        return $array;
    }
    
    function insertVehiclesData($array, $conn) {
          for ($i = 3; $i <= count($array)-2; $i++) {  
                $query ="INSERT INTO VEHICLES (VehicleID, InhouseSellerID, BuyerID, ModelID, SaleDate, BuyDate) VALUES ( '".preg_replace('/\D/', '', $array[$i][0])."','".$array[$i][1]."','".$array[$i][2]."', '". $array[$i][3]."','".$array[$i][4]."','".$array[$i][5]."' )";
                mysqli_query($conn, $query); 
          }
    }   
} 

class Buyer {
   public $queryCreateTable = "CREATE TABLE IF NOT EXISTS `BUYERS` (
            `BuyerID` int(11) NOT NULL AUTO_INCREMENT,
            `Name` char(10) NULL,
            `Surname` char(10) NULL,
            PRIMARY KEY  (`BuyerID`) 
            )";
    public $names = array('Marija','Ana','Maja','Marko','Andrej','Nina','David','Marjan','Mojca','Jasmina');
    public $surnames = array('Novak','Horvat','Krajnc','Koren','Mlakar','Kos','Vidmar','Knez','Bogataj');         
    public $sql = "SELECT DISTINCT BuyerID FROM vehicles"; // gets distinct buyerID from vehicles table
    
    function insertBuyersData($conn)
    {
        $result = $conn->query($this->sql);
        // insert data in table buyers
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {      
                $random_name = $this->names[mt_rand(0, sizeof($this->names) - 1)]; // generate a random forename. 
                $random_surname = $this->surnames[mt_rand(0, sizeof($this->surnames) - 1)]; // generate a random surname.
                $query ="INSERT INTO BUYERS (BuyerID, Name, Surname) VALUES ( '".$row["BuyerID"]."','".$random_name."','".$random_surname."' )";
                mysqli_query($conn, $query);
            }
        } 
    }
}
    $database = new DataBase;
    $vehicle = new Vehicle;
    $buyer = new Buyer;
    $conn = $database->dbConnect();
    //creating database tables for vehicles and buyers if it doesn't exists
    $queryCreateVehicleTable = $vehicle->{'queryCreateTable'}; 
    $queryCreateBuyersTable = $buyer->{'queryCreateTable'}; 

    if(!$conn->query($queryCreateVehicleTable) or !$conn->query($queryCreateBuyersTable)){
        echo "Table creation failed: (" . $dbConnection->errno . ") " . $dbConnection->error;
    }

    try {
        $array = $vehicle->readCSV();
        $vehicle->insertVehiclesData($array, $conn);
        $buyer->insertBuyersData($conn);
        echo 'Datatables created successfully!';
    } 
    catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>