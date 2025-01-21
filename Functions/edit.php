<?php
function edit(Project $project) {

    global $host, $port, $dbname, $user, $password;

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        $pdo = new PDO($dsn, $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE projects SET project_name = :project_name, project_description = :project_description, project_image = :project_image WHERE project_id = :project_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':project_name', $project->project_name, PDO::PARAM_STR);
        $stmt->bindParam(':project_description', $project->project_description, PDO::PARAM_STR);
        $stmt->bindParam(':project_image', $project->project_image, PDO::PARAM_STR);
        $stmt->bindParam(':project_id', $project->project_id, PDO::PARAM_INT);

        $stmt->execute();

       $updatedRows =  $stmt->rowCount();
       echo "Updated $updatedRows project.";


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
       $pdo = null;
    }
}
?>