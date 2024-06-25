<?php
// Check if the session variable 'loggedIn' is set
if(isset($_SESSION['loggedIn']))
{
    // Get and validate the email of the logged-in user
    $email = validate($_SESSION['loggedInUser']['email']);
    
    // Prepare a SQL query to select the admin record with the specified email
    $query = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
    
    // Execute the SQL query
    $result = mysqli_query($conn, $query);

    // Check if the query returned any rows
    if(mysqli_num_rows($result) == 0)
    {
        // If no rows are returned, log out the user and redirect to the login page with an "ACCESS DENIED" message
        logoutSession();
        redirect('../login.php', 'ACCESS DENIED');
    }
    else
    {
        // Fetch the result row as an associative array
        $row = mysqli_fetch_assoc($result);
        
        // Check if the admin account is banned
        if($row['is_ban'] == 1){
            // If the account is banned, log out the user and redirect to the login page with an "ACCOUNT IS BANNED" message
            logoutSession();
            redirect('../login.php', 'ACCOUNT IS BANNED');
        }
    }
}
else
{
    // If the session variable 'loggedIn' is not set, redirect to the login page with a "PLEASE LOG IN TO CONTINUE" message
    redirect('../login.php', 'PLEASE LOG IN TO CONTINUE');
}
?>
