<?php
// already existing file 
$file_name = "D:\\testniagalogistik\\csvreadsavetodb\\script_data.csv";
// connection data
$conn = mysqli_connect('localhost', 'root', '', 'testniagalogistik');

if ($conn) {
    echo "prepare database already ok !<br>";
} else {
    throw new Exception('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Prepare drop table existing 
$sql = "DROP TABLE IF EXISTS ORDERS_DISTRIBUTION";
$exec = mysqli_query($conn, $sql);
if (!$exec) {
    throw new Exception('Failed to execute SQL query: ' . mysqli_error($conn));
}

// Prepare data csv to table
$file = fopen($file_name, 'r');

if ($file != FALSE) { 
    // Preparing header for create table 
    $header = fgetcsv($file);
    
    // Generate SQL to create the table
    $sql = "CREATE TABLE ORDERS_DISTRIBUTION (
        ID INT(11) PRIMARY KEY AUTO_INCREMENT, "
        . $header[0]." TEXT, "
        . $header[1]." TEXT, "
        . $header[2]." TEXT, "
        . $header[3]." TEXT, "
        . $header[4]." TEXT, "
        . $header[5]." DECIMAL(12,2)
    )";   

    // Execute the CREATE TABLE query
    $exec = mysqli_query($conn, $sql);
    if (!$exec) {
        throw new Exception('Failed to execute SQL query: ' . mysqli_error($conn));
    }

    // Generate SQL to insert data
    while (($data = fgetcsv($file)) !== FALSE) {  

        // Escape each value in the data array except the last one
        $escapedValues = array_map(function($value) use ($conn) {
            return mysqli_real_escape_string($conn, $value);
        }, array_slice($data, 0, count($data) - 1));

        // Convert the last value to a float
        $nettAmount = floatval($data[count($data) - 1]);
 
        // Implode the escaped values to form the INSERT INTO query
        $values = "'" . implode("', '", $escapedValues) . "', $nettAmount";

        $insertQuery = "INSERT INTO ORDERS_DISTRIBUTION (" . implode(", ", $header) . ") VALUES ($values)";
  
        $exec = mysqli_query($conn, $insertQuery);

        if (!$exec) {
            throw new Exception('Failed to insert data: ' . mysqli_error($conn));
        }
    } 
    fclose($file);
    echo "Data inserted successfully!";
    // number 1 
    $sql = 
        "select "
        ."count(*) as jumlah_pengiriman, " 
        ."OWNER_NAME, "
        ."POD_POL, "
        ."sum(NETT_AMOUNT) as JUMLAH_NET "
        ."from orders_distribution where pod_pol='MKS' group by owner_name having count(*) > 3";
    // 
    $query = mysqli_query($conn, $sql); 
    // 
    echo "<table border=1>";
    echo  
        "<tr>"
            ."<td>&nbsp;&nbsp;jumlah_pengiriman &nbsp;&nbsp;</td>"
            ."<td>&nbsp;&nbsp;OWNER_NAME &nbsp;&nbsp;</td>"
            ."<td>&nbsp;&nbsp;POD_POL &nbsp;&nbsp;</td>"
            ."<td>&nbsp;&nbsp;JUMLAH_NET &nbsp;&nbsp;</td>" 
        ."</tr>";
    if ($query === false) { 
        echo "Error: " . mysqli_error($conn);
    } else {
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            echo  
                "<tr>"
                    ."<td>&nbsp;&nbsp;".$row['jumlah_pengiriman']."</td>"
                    ."<td>&nbsp;&nbsp;".$row['OWNER_NAME']."</td>"
                    ."<td>&nbsp;&nbsp;".$row['POD_POL']."</td>"
                    ."<td>&nbsp;&nbsp;".$row['JUMLAH_NET']."</td>" 
                ."</tr>";
        } 
    }
    echo "</table>";
} else { 
    echo "Failed to open the file.";
}
?>
