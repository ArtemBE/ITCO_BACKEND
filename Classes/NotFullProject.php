<?php
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
?>