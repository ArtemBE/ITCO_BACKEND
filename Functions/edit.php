<?php
function edit(Project $project) {

    global $host, $port, $dbname, $user, $password;

    try {
        // Строка подключения PDO
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        // Создаем объект PDO
        $pdo = new PDO($dsn, $user, $password);

        // Устанавливаем режим обработки ошибок
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL запрос с параметрами
        $sql = "UPDATE projects SET project_name = :project_name, project_description = :project_description, project_image = :project_image WHERE project_id = :project_id";
        // Подготавливаем запрос
        $stmt = $pdo->prepare($sql);

        // Привязываем параметры
        $stmt->bindParam(':project_name', $project->project_name, PDO::PARAM_STR);
        $stmt->bindParam(':project_description', $project->project_description, PDO::PARAM_STR);
        $stmt->bindParam(':project_image', $project->project_image, PDO::PARAM_STR);
        $stmt->bindParam(':project_id', $project->project_id, PDO::PARAM_INT);


        // Выполняем запрос
        $stmt->execute();

         // Выводим количество измененных строк.
       $updatedRows =  $stmt->rowCount();
       echo "Updated $updatedRows project.";


    } catch (PDOException $e) {
        // Обработка ошибок
        echo "Error: " . $e->getMessage();
    } finally {
       $pdo = null;
    }
}
?>