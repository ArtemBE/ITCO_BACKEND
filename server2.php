<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: *');

$host = 'localhost';       // Хост базы данных
$port = 5432;              // Порт PostgreSQL
$dbname = 'DataBasePHP'; // Название базы данных
$user = 'postgres';      // Имя пользователя
$password = '186739403';  // Пароль пользователя

class Project {
    // Свойства (данные)
    public $project_id;
    public $project_name;
    public $project_description;
    public $project_image;

    // Конструктор - метод, который выполняется при создании объекта
    public function __construct($project_id, $project_name, $project_description, $project_image) {
        $this->project_id = $project_id;
        $this->project_name = $project_name;
        $this->project_description = $project_description;
        $this->project_image = $project_image;
    }
}

class NotFullProject {
    // Свойства (данные)
    public $project_id;
    public $project_name;

    // Конструктор - метод, который выполняется при создании объекта
    public function __construct($project_id, $project_name) {
        $this->project_id = $project_id;
        $this->project_name = $project_name;
    }
}

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

function getOne($projectId) {
    global $host, $port, $dbname, $user, $password;

    $projects = [];

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT project_id, project_name, project_description, project_image FROM projects WHERE project_id = 2";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindParam(':projectId', $projectId, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $projects[] = new Project($row['project_id'], $row['project_name'], $row['project_description'], $row['project_image']);
        }
        return $projects[0];
    } catch (PDOException $e) {
        // Обработка ошибок
        echo "Error: " . $e->getMessage();
    } finally {
       $pdo = null;
    }
    return $projects[0];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $project_name = $data['project_name'];
    $project_description = $data['project_description'];
    $project_image = $data['project_image'];

    $new_id = add(new Project(-1, $project_name, $project_description, $project_image));

    $aaase = json_encode([
        'status' => 'success',
        'message' => "Hello, Artem!",
        'received_data' => $data,
        'new_id' => $new_id
    ]);
    echo $aaase;
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $project_id = $data['project_id'];
    $project_name = $data['project_name'];
    $project_description = $data['project_description'];
    $project_image = $data['project_image'];

    edit(new Project($project_id, $project_name, $project_description, $project_image));

    $aaase = json_encode([
        'status' => 'success',
        'message' => "Hello, Artem!",
        'received_data' => $data
    ]);
    echo $aaase;
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    $project_id = $data['project_id'];

    delete($project_id);

    $aaase = json_encode([
        'status' => 'success',
        'message' => "Hello, Artem!",
        'received_data' => $data
    ]);
    echo $aaase;
}else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //$data = json_decode(file_get_contents('php://input'), true);
    //$project_id = $data['project_id'];
    if ($_SERVER['REQUEST_URI'] === '/api'){
        echo json_encode(get());
    }
    else{
        $project_id = intval(substr($_SERVER['REQUEST_URI'], 1));
        echo intval(substr($_SERVER['REQUEST_URI'], 5));
    }
}
?>