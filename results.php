<?php 
    include_once ('db.php');

class Result
{
    public $results_per_page = 20;
    
    function ShowNextPageResults()
    {
        $database = new DataBase;
        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
        $this_page_first_result = ($page-1)*$this->results_per_page;
        $sql=  "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
                FROM vehicles
                INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID LIMIT " . $this_page_first_result . ',' .  $this->results_per_page;
        $result = mysqli_query($database->dbConnect(), $sql); 
        
        return $result;
    }

    function returnResultsNum()
    {
        $database = new DataBase;
        // find out the number of results stored in database
        $sql=   "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
                FROM vehicles
                INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID;";
        $result = mysqli_query($database->dbConnect(), $sql);
        $number_of_results = mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results/$this->results_per_page);  // determine number of total pages available
        
        return $number_of_results;
        
    }
    
    function showResults()
    {
        $database = new DataBase;
        // determine which page number visitor is currently on
        if (!isset($_GET['page'])) {
          $page = 1;
        } else {
          $page = $_GET['page'];
        }
        $this_page_first_result = ($page-1)* $this->results_per_page;    // determine the sql LIMIT starting number for the results on the displaying page
        // retrieve selected results from database and display them on page
        $sql=  "SELECT vehicles.VehicleID, vehicles.InhouseSellerID, vehicles.BuyerID, buyers.Name, buyers.Surname, vehicles.ModelID, vehicles.SaleDate, vehicles.BuyDate
                FROM vehicles
                INNER JOIN buyers ON vehicles.BuyerID=buyers.BuyerID LIMIT " . $this_page_first_result . ',' .  $this->results_per_page;
        $result = mysqli_query($database->dbConnect(), $sql); 
        
        return $result;      
    }
        
}
?>

