<?php
function add(Project $project) {
    global $host, $port, $dbname, $user, $password;

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO projects (project_name, project_description, project_image) VALUES (:project_name, :project_description, :project_image) RETURNING project_id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':project_name', $project->project_name, PDO::PARAM_STR);
        $stmt->bindParam(':project_description', $project->project_description, PDO::PARAM_STR);
        $stmt->bindParam(':project_image', $project->project_image, PDO::PARAM_STR);

        $stmt->execute();

        $addedRows =  $stmt->rowCount();
        
        //echo json_encode("Added $addedRows project.");

        $newUserId = $stmt->fetch(PDO::FETCH_COLUMN);
        return $newUserId;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}
?>