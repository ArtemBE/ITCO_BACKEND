<?php
function get() {
    global $host, $port, $dbname, $user, $password;

    $projects = [];

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT project_id, project_name FROM projects";
        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $projects[] = new NotFullProject($row['project_id'], $row['project_name']);
        }
        return $projects;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
       $pdo = null;
    }

   return $projects;
}
?>