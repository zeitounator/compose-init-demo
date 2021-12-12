<html>
    <head>
        <title>compose init demo</title>
    </head>
    <body>
        <h1>A bit of explanation</h1>
        <p>This page only displays the entries create in test db/table during init phase.entries.entries.</p>
        <p>The app container running this page will not start until the init container has done its work and exits</p>
        <h1>List of entries in my_app.test table</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Myval</th>
            </tr>
            <?php
                $pass = getenv('MYSQL_ROOT_PASSWORD');
                $con = new MySQLi('db', 'root', getenv('MYSQL_ROOT_PASSWORD'), 'my_app');
                $entries = $con->query('select * from test');
                while ($row = $entries->fetch_array()) {
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['myval'] . "</td></tr>";
                }
            ?>
        </table>
    </body>
</html>