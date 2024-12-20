<?php
function delete($projectIds) {
    global $host, $port, $dbname, $user, $password;
    try {
        // Строка подключения PDO
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
         // Создаем объект PDO
        $pdo = new PDO($dsn, $user, $password);
        // Устанавливаем режим обработки ошибок
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Проверяем, что массив не пустой
        if (empty($projectIds)){
          echo "No project IDs provided";
          return;
        }


        // Подготавливаем SQL-запрос
        $sql = "DELETE FROM projects WHERE project_id IN (" . implode(',', array_fill(0, count($projectIds), '?')) . ")";

        $stmt = $pdo->prepare($sql);


        // Выполняем запрос с передачей массива ID
        $stmt->execute($projectIds);

      // Выводим количество удаленных записей
       $deletedRows =  $stmt->rowCount();
       echo "Deleted $deletedRows projects.";


    } catch (PDOException $e) {
        // Обработка ошибок
        echo "Error: " . $e->getMessage();
    } finally {
          $pdo = null;
    }
}
?>