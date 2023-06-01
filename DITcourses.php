<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
</head>
<body>
    <fieldset>
        <?php
        if (array_key_exists("courseSubmit", $_POST))
        {
            $courseCode = $_POST["courseCode"] ?? null;
            $courseName = $_POST["courseName"] ?? null;
            $creditSelect = $_POST["creditSelect"] ?? null;
            $semSelect = $_POST["semSelect"] ?? null;

            $errors = [];
            if ($courseCode === "")
            {
                $errors[] = "You forgot to enter COURSE CODE.";
            }
            if ($courseName === "")
            {
                $errors[] = "You forgot to enter COURSE NAME.";
            }
            if(!empty($errors))
            {
                echo "<h1>Error!</h1>";
                echo "<ul>";
                foreach ($errors as $error) echo "<li>{$error}</li>";
                echo "</ul>";
            }
            else
            {
                $mysqli = new mysqli("localhost", "root", "", "diploma_course");

                //PHP 8.1 and below
                $statement = $mysqli->prepare('SELECT * FROM courses WHERE code = ?;');
                $statement->bind_param('s', $courseCode);
                $statement->execute();
                $row = $statement->get_result();

                //PHP 8.2
                // $row = $mysqli -> execute_query('SELECT * FROM courses WHERE code = ?;', [$courseCode]);

                if ($row->num_rows !== 0)
                {
                    echo "<font color='red'>DUPLICATE This course ALREADY EXISTS in database</font>";
                }
                else
                {
                    //PHP 8.1 and below
                    $statement = $mysqli->prepare('INSERT INTO courses (code, name, credit, semoffer) VALUES (?, ?, ?, ?);');
                    $statement->bind_param('ssss', $courseCode, $courseName, $creditSelect, $semSelect);
                    $statement->execute();

                    //PHP 8.2
                    // $mysqli -> execute_query('INSERT INTO courses (code, name, credit, semoffer) VALUES (?, ?, ?, ?);', [$courseCode, $courseName, $creditSelect, $semSelect]);

                    echo "<font color='blue'>{$courseCode}: {$courseName} (credit: {$creditSelect}, sem: {$semSelect}) is STORED in database</font>";
                    echo "</fieldset></body></html>";
                    $mysqli->close();
                    unset($mysqli);
                    exit();
                }
                $mysqli->close();
                unset($mysqli);
            }
        }
        ?>
        <h2>DIT Courses</h2>
        <form action="" method="post">
            <p>
                <label>Course Code:</label>
                <input type="text" name="courseCode" id="courseCode">
            </p>
            <p>
                <label>Course Name:</label>
                <input type="text" name="courseName" id="courseName">
            </p>
            <p>
                <label>Credits:</label>
                <select name="creditSelect" id="creditSelect">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </p>
            <p>
                <label>Offer in semester:</label>
                <select name="semSelect" id="semSelect">
                    <option value="1">Sem 1</option>
                    <option value="2">Sem 2</option>
                    <option value="3">Sem 3</option>
                    <option value="4">Sem 4</option>
                    <option value="5">Sem 5</option>
                </select>
            </p>
            <input type="submit" value="INSERT NEW COURSE" name="courseSubmit" id="courseSubmit">
        </form>
    </fieldset>
</body>
</html>