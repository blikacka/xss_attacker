<?php

$con = new mysqli("127.0.0.1", "login", "pass", "attacker_demo");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
if (isset($_GET)) {
    $data = htmlspecialchars($_GET['data'] ?? null);
    if ($data !== null && $data !== '') {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        $sql_statement="INSERT INTO `data` (`data`, `ip`) VALUES ('$data', '$ipAddress')";
        $con->query($sql_statement);
    }
}

$query = $con->query('SELECT * FROM `data` ORDER BY id DESC ');
echo '<table border="1">';
echo '<tr><td>ID</td><td>DATA</td><td>IP</td></tr>';
while ($result = mysqli_fetch_array($query)) {
    echo '<tr>';
    echo '<td>' . ($result['id'] ?? '-') . '</td><td>' . ($result['data'] ?? '-') . '</td><td>' . ($result['ip'] ?? '-') . '</td>';
    echo '</tr>';
}
echo '</table>';
$con->close();
