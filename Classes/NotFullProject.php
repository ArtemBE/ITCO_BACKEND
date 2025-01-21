<?php
class NotFullProject {
    public $project_id;
    public $project_name;

    public function __construct($project_id, $project_name) {
        $this->project_id = $project_id;
        $this->project_name = $project_name;
    }
}
?>