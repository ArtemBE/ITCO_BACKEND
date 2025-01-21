<?php
function delete($projectIds) {
    global $host, $port, $dbname, $user, $password;
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (empty($projectIds)){
          echo "No project IDs provided";
          return;
        }


        $sql = "DELETE FROM projects WHERE project_id IN (" . implode(',', array_fill(0, count($projectIds), '?')) . ")";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($projectIds);

       $deletedRows =  $stmt->rowCount();
       echo "Deleted $deletedRows projects.";


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
          $pdo = null;
    }
}
?>