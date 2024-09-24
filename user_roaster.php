<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = mysqli_connect("localhost", "root", "root", "accounting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all users from UserTable
$sql = "SELECT * FROM Table1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information Table</title>
    <link rel="stylesheet" href="./user_roaster_stylesheet.css">
</head>
<body>
    <nav>
        <div class="welcome">
            <img src="profile.png" alt="Picture" class="picture">
            <h1>Ledger Ledgend Administrator</h1>
        </div>
        <div class="user-profile">
            <img src="pfp.png" alt="User Picture" class="profile-pic">
            <span class="username">Jtrejo0924</span>
            <a href="./logout.html" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="main-bar">
        <a href="./administrator_home.html" class="nav-link">Home</a>
        <a href="./it_ticket.html" class="nav-link">IT Ticket</a>
        <div class="dropdown">
            <button class="dropbtn">User Management</button>
            <div class="dropdown-content">
                <a href="./create_new_user_admin.html">Create User</a>
                <a href="./user_roaster.php">View Users</a>
                <a href="./Manage_Users.html">Account Approval</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Reports</button>
            <div class="dropdown-content">
                <a href="#">User Report</a>
                <a href="./Expired_Passwords_Log.html">Expired Passwords Report</a>
                <a href="#">Login Attempts Report</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Notifications</button>
            <div class="dropdown-content">
                <a href="#">Password Expiration Alerts</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Email Management</button>
            <div class="dropdown-content">
                <a href="#">Send Email</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn">Settings</button>
            <div class="dropdown-content">
                <a href="#">System Settings</a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Type ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email Address</th>
                    <th>Date of Birth</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Failed Attempts</th>
                    <th>Lockout Until</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <td>' . $row['Id'] . '</td>
                                <td>' . $row['UserTypeId'] . '</td>
                                <td>' . $row['Username'] . '</td>
                                <td>' . $row['Password'] . '</td>
                                <td>' . $row['EmailAddress'] . '</td>
                                <td>' . $row['DateOfBirth'] . '</td>
                                <td>' . $row['FirstName'] . '</td>
                                <td>' . $row['LastName'] . '</td>
                                <td>' . $row['FailedAttempts'] . '</td>
                                <td>' . $row['LockoutUntil'] . '</td>
                                <td><button class="update-button" onclick="window.location.href=\'update_user.php?id=' . $row['Id'] . '\'">Update</button></td>
                            </tr>';
                    }
                } else {
                    echo '<tr><td colspan="11">No users found</td></tr>';
                }
                // Close the connection
                $conn->close();
                ?>
            </tbody>
        </table>    
    </div>
</body>
</html>
