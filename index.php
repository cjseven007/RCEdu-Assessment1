<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lim Jia Chyuen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ededed;
        }

        header {
            text-align: center;
            padding: 20px;
            padding-top: 50px;
        }

        header img {
            border-radius: 50%;
            width: 200px;
            height: 200px;
            object-fit: cover;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        header p {
            max-width: 500px;
            margin: 0 auto;
        }

        .main-section {
            display: flex;
            justify-content: space-around;
            align-items: start;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        #lessons {
            max-width: 800px;
            margin: 10px auto;
            margin-right: 30px;
        }

        .lesson {
            background-color: white;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            padding: 10px;
            padding-left: 20px;
            border-radius: 15px;
        }

        #add-name {
            max-width: 400px;
            margin: 10px auto;
        }

        #names {
            text-align: center;
            margin: 20px auto;
            background-color: white;
            padding: 10px;
            border-radius: 15px;
            align-items: center;
        }

        #names p {
            margin: 0;
        }

        .individual-name {
            margin: 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            box-sizing: border-box;
            width: 300px;
        }

        .individual-name input {
            width: 70px;
            padding: 5px;
            box-sizing: border-box;
            margin-right: 5px;
            border-radius: 10px;
        }

        .delete-btn {
            background-color: #ff6666;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
        }

        footer a {
            color: white;
        }
    </style>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "my_app_user";
    $password = "cjseven123";
    $dbname = "my_app";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Process form submission for adding a name
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
        $name = mysqli_real_escape_string($conn, $_POST["name"]); // Sanitize input

        // Insert the name into the database
        $sql = "INSERT INTO names (name) VALUES ('$name')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Process form submission for deleting a name
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
        $delete_id = mysqli_real_escape_string($conn, $_POST["delete_id"]); // Sanitize input

        // Delete the name from the database
        $sql = "DELETE FROM names WHERE id = '$delete_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Process form submission for updating a name
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_id"]) && isset($_POST["updated_name"])) {
        $update_id = mysqli_real_escape_string($conn, $_POST["update_id"]);
        $updated_name = mysqli_real_escape_string($conn, $_POST["updated_name"]);

        // Update the name in the database
        $sql = "UPDATE names SET name = '$updated_name' WHERE id = '$update_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


    // Fetch and display names from the database
    $sql = "SELECT id, name FROM names";
    $result = $conn->query($sql);
    ?>

    <header>
        <img src="profilepic.jpg" alt="Profile Picture">
        <h1>Hi, I'm Lim Jia Chyuen</h1>
        <p>This is my PHP Application for Assessment 1. <br />It is deployed with LAMP Stack (Linux, Apache, MySQL, PHP). It is also equiped with CRUD operation to create, read, update and delete names to the MySQL database.</p>
    </header>
    <div class="main-section">
        <section id="lessons">
            <h2>Key Things I Learnt</h2>

            <?php
            $lessons = [
                ['title' => 'Fundamentals of Cloud Computing', 'description' => 'Defining Cloud Computing, identify its benefits, types of deployment model and many more.'],
                ['title' => 'AWS EC2', 'description' => 'Launching an instance of Amazon Elastic Cloud Compute, managing and configuring the server.'],
                ['title' => 'LAMP Stack', 'description' => 'Linux (OS), Apache (Web Server), MySQL (Database Server), PHP (Programming Language).'],
                ['title' => 'Exposure to Latest Tools', 'description' => 'Experience using cutting edge technology in cloud computing such as Digital Ocean and RunCloud.'],
            ];

            // Loop through lessons and display them
            foreach ($lessons as $lesson) {
                echo '<div class="lesson">';
                echo '<h3>' . $lesson['title'] . '</h3>';
                echo '<p>' . $lesson['description'] . '</p>';
                echo '</div>';
            }
            ?>
        </section>

        <section id="add-name">
            <h2>Add a Name</h2>
            <form action="index.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" autocomplete="name" required>
                <input type="submit" value="Add Name">
            </form>
            <div id="names">
                <h3>Name List</h3>
                <p>You can perform CRUD operation here!</p>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="individual-name">';
                        echo '<p>';
                        echo $row['name'];
                        echo '<form action="index.php" method="post" style="display: inline;">';
                        echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="delete-btn">Delete</button>';
                        echo '</form>';

                        // Update form
                        echo '<form action="index.php" method="post" style="display: inline;">';
                        echo '<input type="hidden" name="update_id" value="' . $row['id'] . '">';
                        echo '<input type="text" name="updated_name" value="' . $row['name'] . '" autocomplete="off" required>';
                        echo '<button type="submit" class="update-btn">Update</button>';
                        echo '</form>';

                        echo '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No names added yet.</p>";
                }
                ?>
            </div>
        </section>


    </div>
    <footer>
        <p>Email: limjiachyuen04@gmail.com</p>
        <p>LinkedIn: <a href="https://www.linkedin.com/in/limjiachyuen/">linkedin.com/in/limjiachyuen/</a> </p>
    </footer>
</body>

</html>