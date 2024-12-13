<?php

class AboutsController Extends Controller{

    public function __construct($data =array ()){
        parent::__construct($data);
        $this->model = new Page();
    }

    public function index(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        //content about us
        //content about us
    }
}