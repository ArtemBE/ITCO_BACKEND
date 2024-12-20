<?php
// Устанавливаем заголовки для работы с JSON
include('imports.php');

/* file_put_contents('C:\Users\dorne\Desktop\Учеба\Чих пых куку\full', 'jellt'); */

/* $handle = fopen($file, 'w'); // 'w' - режим записи (перезапись) */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: *');
header("Cache-Control: no-cache, must-revalidate");

$host = 'localhost';       // Хост базы данных
$port = 5432;              // Порт PostgreSQL
$dbname = 'DataBasePHP'; // Название базы данных
$user = 'postgres';      // Имя пользователя
$password = '186739403';  // Пароль пользователя

$buildPath = __DIR__ . '/build';
$requestUri = $_SERVER['REQUEST_URI'];



if (strpos($_SERVER['REQUEST_URI'], '/api/image') === 0) {
    // Проверяем, что файл был загружен и ошибок не возникло
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $id = intval(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/')+1));
            $uploadDir = 'image/'; // Папка для сохранения загруженных файлов
            $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . $id . '.' . $fileExtension; // Полный путь к файлу

            // Создаем папку, если её не существует
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Перемещаем файл из временной папки в целевую
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'File uploaded successfully',
                    'file_path' => $uploadFile,
                    'uri' => $_SERVER['REQUEST_URI'],
                    'id' => substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/')+1)
                ]);
            } else {
                http_response_code(500); // Устанавливаем HTTP-код ошибки
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to move uploaded file',
                    'uri' => $_SERVER['REQUEST_URI'],
                    'id' => substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/')+1)
                ]);
            }
        } else {
            http_response_code(400); // Неправильный запрос
            echo json_encode([
                'status' => 'error',
                'message' => 'No file uploaded or upload error occurred',
                'uri' => $_SERVER['REQUEST_URI'],
                'err' => $_FILES['image']
            ]);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $dec = json_decode(file_get_contents('php://input'), true);
        $id = $dec['id'] . '.jpg';
        if (isset($id) && !empty($id)) {
            $filePath = 'image/' . basename($id);
            if (file_exists($filePath)) {
                // Пытаемся удалить файл
                if (unlink($filePath)) {
                    http_response_code(200); // OK
                    echo json_encode(['status' => 'success', 'message' => 'File deleted successfully']);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete the file']);
                }
            } else {
                http_response_code(404); // Not Found
                echo json_encode(['status' => 'error', 'message' => 'File not found', 'id' => $id, 'dec' => $dec]);
            }
        }
    }
    exit;
}



else if (strpos($requestUri, '/api') === 0) {
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
            $project_id = intval(substr($_SERVER['REQUEST_URI'], 5));
            echo json_encode(getOne($project_id));
        }
    }
    exit;
}

//$filePath = $buildPath . $requestUri;
$imagePath = __DIR__ . $requestUri;
if (file_exists($imagePath) && !is_dir($imagePath)) {
    /* if(strpos($requestUri, '/static/css') === 0){
        header("Content-Type: text/css");
    }
    else{
        $mimeType = mime_content_type($filePath);
        header("Content-Type: $mimeType");
    } */
    $mimeType = mime_content_type($imagePath);
    header("Content-Type: $mimeType");
    readfile($imagePath); // Отправляем файл
    exit;
}

/* header('Content-Type: text/html');
readfile($buildPath . '/index.html'); */

?>