<?php
class ComitsController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Comit();
    }


    public function index(){
        $this->data['pages']['menu'] = $this->model->getMenu();

        if( $_POST ){
            $this->data['comit'] =  $_POST;
            if($this->model->save($_POST)){
                Session::setFlash('Спасибі, Ви успішно додали свій коментар!');
                //header('Location:../abouts');
            }
        }
    }
}
