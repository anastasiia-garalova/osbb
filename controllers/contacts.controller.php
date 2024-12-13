<?php

class ContactsController Extends Controller{

    public  function __construct( $data = array()){
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        $this->data['contacts'] =  $this->model->getContacts();
        if( $_POST ){
            if($this->model->save($_POST)){
                Session::setFlash('Thank you! Your message was sent successfully!');
            }
        }
    }

    public function admin_index(){
        $this->data = $this->model->getList();
    }

    public function admin_delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if ($result){
                Session::setFlash('Сообщение было удалино');
            }else{
                Session::setFlash('Ошибка!');
            }
        }
        Router::redirect('/admin/contacts');
    }
}