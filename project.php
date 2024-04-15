<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>

    <form action="project.php" method="post">
        <div class="ft">
            <div class="search">
                search:
                <input type="text" name="sr" placeholder="Search here">
                <div>
                    <button class="action" name="sub">Search</button>
                    <button class="action" name="show">Show all</button>
                </div>
            </div>
            <div class="register">
                name:
                <input type="text" name="us" placeholder="Register here">
                <div>
                    <button class="action" name="add">Register</button>
                    <button class="action" name="clear">Clear</button>
                </div>
            </div>
        </div>
        <div class="res">
            <span>
                <?php
                $arr = [];
                if (isset($_POST['sub']) && !empty($_POST['sr'])) {
                    $sql = "SELECT user, reg FROM us WHERE user = '$_POST[sr]'";
                    $res = mysqli_query($conn, $sql);
                    $row = mysqli_num_rows($res);
                    $name = filter_input(INPUT_POST, "sr", FILTER_SANITIZE_SPECIAL_CHARS);
                    echo "$row Users found with the name $name";
                } elseif (isset($_POST['sub']) && empty($_POST['sr'])) {
                    echo "Please enter something to search.";
                }

                if (isset($_POST['add']) && !empty($_POST['us'])) {
                    $name = filter_input(INPUT_POST, "us", FILTER_SANITIZE_SPECIAL_CHARS);
                    $sql = "INSERT INTO us (user) VALUES ('$name')";
                    $res = mysqli_query($conn, $sql);
                    echo "Inserted \"$name\" successfully.";
                } elseif (isset($_POST['add']) && empty($_POST['us'])) {
                    echo "Please enter something to add.";
                }

                if (isset($_POST['show'])) {
                    $sql = "SELECT * FROM us";
                    $res = mysqli_query($conn, $sql);
                    $row = mysqli_num_rows($res);
                    echo "<strong>Total users: </strong>$row";
                    while ($row_data = mysqli_fetch_assoc($res)) {
                        array_push($arr, $row_data);
                    }
                }

                if (isset($_POST['clear'])) {
                    $sql = "SELECT user FROM us";
                    $res = mysqli_query($conn, $sql);
                    $row = mysqli_num_rows($res);

                    $sql = "TRUNCATE TABLE us";
                    $res = mysqli_query($conn, $sql);
                    echo "$row Users cleared.";
                }

                if (isset($_POST['cnf'])  && !empty($_POST['update'])) {
                    $name = filter_input(INPUT_POST, "update", FILTER_SANITIZE_SPECIAL_CHARS);
                    $sql = "UPDATE us SET user = '$name' WHERE id = $_POST[cnf]";
                    mysqli_query($conn, $sql);
                    echo "Updated successfully";
                }

                if (isset($_POST['del'])) {
                    $sql = "DELETE FROM us WHERE id = $_POST[del];";
                    mysqli_query($conn, $sql);
                    echo "Deleted successfully";
                }
                ?>
            </span>

            <ul>
                <?php
                $index = 0;
                foreach ($arr as $row_data) {
                    echo "<li>
                    <strong>name:</strong> {$row_data['user']} 
                    <strong>registered on</strong> {$row_data['reg']}
                    <button name=\"cnf\" value=\"$row_data[id]\">Update</button> 
                    <button name=\"del\" value=\"$row_data[id]\">Delete</button>
                    <br> </li>";
                    $index++;
                }
                ?>
            </ul>

        </div>
    </form>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        document.addEventListener("keydown", (e) => {
            if (e.key == 'Enter')
                e.preventDefault();
        })
        let inpt = document.querySelectorAll("input");
        let btns = document.querySelectorAll(".action");
        inpt.forEach((e, i) => {
            e.addEventListener("focus", (ev) => {
                document.addEventListener("keydown", (e) => {
                    if (e.key == 'Enter') {
                        if (!i)
                            btns[0].click();
                        else
                            btns[2].click()
                    }
                })
            })
        })
        let upbtn = document.querySelectorAll("li button[name=cnf]");
        let test = 1;
        let prompt = null;
        upbtn.forEach((bt, id) => {
            bt.addEventListener("click", (e) => {
                if (prompt == null || prompt != id) {
                    e.preventDefault();
                }
                if (test) {
                    let inpt = document.createElement("input");
                    inpt.setAttribute("type", "text")
                    inpt.setAttribute("name", `update`)
                    inpt.setAttribute("placeholder", "Enter a new name")
                    bt.parentElement.append(inpt);
                    test = 0;
                    prompt = id;
                }
            })
        })
    </script>
</body>

</html>