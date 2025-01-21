<?php
class Project {
    public $project_id;
    public $project_name;
    public $project_description;
    public $project_image;

    public function __construct($project_id, $project_name, $project_description, $project_image) {
        $this->project_id = $project_id;
        $this->project_name = $project_name;
        $this->project_description = $project_description;
        $this->project_image = $project_image;
    }
}
?>