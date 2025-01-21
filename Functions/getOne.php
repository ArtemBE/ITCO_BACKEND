<?php
function getOne($projectId) {
    global $host, $port, $dbname, $user, $password;

    $projects = [];

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT project_id, project_name, project_description, project_image FROM projects WHERE project_id = :projectId";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':projectId', $projectId, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $projects[] = new Project($row['project_id'], $row['project_name'], $row['project_description'], $row['project_image']);
        }
        return $projects[0];


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
       $pdo = null;
    }

   return $projects;
}
?>