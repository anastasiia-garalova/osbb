<?php

class RegistrationsController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Registration();
    }


    public function index(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        if( $_POST ){
            $this->data['user'] =  $_POST;
            if($this->model->save($_POST)){

                Session::setFlash('Спасибі, Ви успішно пройшли реєстрацію! Чекайте листа з підтвердженням!');
                header('Location:/login/');
            }
        }
    }

}