<?php
class BalanceController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new BalanceAccount();
    }


    public function index(){

        $this->data['balance'] =  $this->model->getList();
    }

    public function admin_index(){
        $this->data['balance'] = $this->model->getList();

    }

    public function admin_add(){
        if($_POST){
            $result = $this->model->save($_POST, $_FILES);
            if ($result){
                Session::setFlash('Страница была сохранена');
            }else{
                Session::setFlash('Ошибка!');
            }
            Router::redirect('/admin/balance/');
        }
    }

    public function admin_edit(){
        if(!$_FILES){
            Session::setFlash('Вы не загрузили файл!');
        }
        if($_POST){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST,$_FILES, $id);
            if ($result){

                Session::setFlash('Страница была сохранена');
            }else{
                Session::setFlash('Ошибка!');
            }
            Router::redirect('/admin/balance/');
        }


        if(isset($this->params[0])){
            $this->data['balance'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/balance/');
        }
    }

    public function admin_delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if ($result){
                Session::setFlash('Страница была удалина');
            }else{
                Session::setFlash('Ошибка!');
            }
        }
        Router::redirect('/admin/balance/');
    }
}
