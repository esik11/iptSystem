<?php
session_start(); // Start the session
require 'db-conn.php'; // Include the database connection file

// Input validation function
function validate($inputData, $required = true)
{
    global $conn;

    // Check if the input is required and not empty
    if ($required && empty($inputData)) {
        return false;
    }

    // Sanitize the input to prevent SQL injection
    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}

// Function to redirect to another page with a status message
function redirect($url, $status)
{
    $_SESSION['status'] = $status; // Set the session status message
    header('Location:'. $url); // Redirect to the specified URL
    exit(0); // Exit the script
}

// Function to display alert messages or status after any process
function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
               <h6>' . $_SESSION['status'] . '</h6>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION['status']); // Clear the session status message
    }
}

// Function to insert records into a table
function insert($tableName, $data)
{
    global $conn;
    $table = validate($tableName); // Validate the table name
    
    // Prepare the columns and values for the SQL query
    $columns = array_keys($data);
    $values = array_values($data);
    $finalColumn = implode(',', $columns);
    $finalValues = "'" . implode("', '", $values) . "'";
    
    // Construct and execute the SQL query
    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result; // Return the result of the query
}

// Function to update records in a table
function update($tableName, $id, $data)
{
    global $conn;
    $table = validate($tableName); // Validate the table name
    $id = validate($id); // Validate the ID

    // Prepare the update data string for the SQL query
    $updateDataString = "";
    foreach ($data as $column => $value) {
        $updateDataString .= $column . '=' . "'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    // Construct and execute the SQL query
    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return $result; // Return the result of the query
}

// Function to get all records from a table
function getAll($tableName, $status = NULL)
{
    global $conn;
    $table = validate($tableName); // Validate the table name
    $status = validate($status); // Validate the status

    // Construct and execute the SQL query based on the status
    if ($status == 'status') {
        $query = "SELECT * FROM $table WHERE status= '0'";
    } else {
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query); // Return the result of the query
}

// Function to get a record by ID
function getById($tableName, $id)
{
    global $conn;
    $table = validate($tableName); // Validate the table name
    $id = validate($id); // Validate the ID

    // Construct and execute the SQL query
    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Check the result and prepare the response
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'RECORD FOUND!'
            ];
            return $response; // Return the response
        }
    } else {
        $response = [
            'status' => 404,
            'message' => 'NO DATA HAS BEEN FOUND!'
        ];
        return $response; // Return the response
    }
}

// Function to delete a record by ID
function delete($tableName, $id)
{
    global $conn;
    $table = validate($tableName); // Validate the table name
    $id = validate($id); // Validate the ID

    // Construct and execute the SQL query
    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result; // Return the result of the query
}

// Function to check if a parameter ID is set and return it
function checkParamId($type)
{
    if (isset($_GET[$type])) {
        if ($_GET[$type] != '') {
            return $_GET[$type]; // Return the parameter value
        } else {
            return '<h5>NO ID FOUND</h5>'; // Return an error message
        }
    } else {
        return '<h5>NO ID GIVEN</h5>'; // Return an error message
    }
}

// Function to log out the current session
function logoutSession()
{
    unset($_SESSION['loggedIn']); // Unset the loggedIn session variable
    unset($_SESSION['loggedInUser']); // Unset the loggedInUser session variable
}

// Function to send a JSON response
function jsonResponse($status, $status_type, $message)
{
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response); // Encode and return the response as JSON
    return;
}
?>
