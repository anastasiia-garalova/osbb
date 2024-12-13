<?php

class MyAccountController Extends Controller{

    public  function __construct( $data = array()){
        parent::__construct($data);
        $this->model = new UserAccount();
    }


    public function index(){
        $this->data['contacts'] = $this->model->getList();
        if(isset($_POST['submit'])){

            $result = $this->model->save($_POST);
            if ($result){
                Session::setFlash('Страница была сохранена');
            }else{
                Session::setFlash('Ошибка!');
            }
            //Router::redirect('/admin/mycontacts');
        }
    }
}