<?php
function add(Project $project) {
    global $host, $port, $dbname, $user, $password;

    try {
        // Строка подключения PDO
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        // Создаем объект PDO
        $pdo = new PDO($dsn, $user, $password);

        // Устанавливаем режим обработки ошибок
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL запрос на добавление данных
        $sql = "INSERT INTO projects (project_name, project_description, project_image) VALUES (:project_name, :project_description, :project_image) RETURNING project_id";

        // Подготавливаем запрос
        $stmt = $pdo->prepare($sql);

        // Привязываем параметры
        $stmt->bindParam(':project_name', $project->project_name, PDO::PARAM_STR);
        $stmt->bindParam(':project_description', $project->project_description, PDO::PARAM_STR);
        $stmt->bindParam(':project_image', $project->project_image, PDO::PARAM_STR);

        // Выполняем запрос
        $stmt->execute();

        // Выводим количество добавленных строк.
        $addedRows =  $stmt->rowCount();
        
        //echo json_encode("Added $addedRows project.");

        $newUserId = $stmt->fetch(PDO::FETCH_COLUMN);
        return $newUserId;

    } catch (PDOException $e) {
        // Обработка ошибок
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}
?>