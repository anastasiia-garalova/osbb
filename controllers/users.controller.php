<?php
class UsersController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new User();
    }

    public function admin_index(){
        $this->data = $this->model->getList();
        if($_POST){
            $result = $this->model->save($_POST);
            if ($result){
                Session::setFlash('Страница была сохранена');
            }else{
                Session::setFlash('Ошибка!');
            }
            Router::redirect('/admin/users/');
        }
    }

    public function admin_login(){
        if($_POST && isset($_POST['login']) && isset($_POST['password'])){
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt').$_POST['password']);

            if($user && $user['is_active'] && $hash == $user['password']){
                Session::set('login',$user['login']);
                Session::set('role',$user['role']);
            }
            Router::redirect('/admin/');
        }
    }

    public function admin_logout(){
        Session::destroy();
        Router::redirect('/admin/');
    }

    public function admin_edit(){
        $this->data = $this->model->getList();
        if($_POST['save']){
            if($_POST){
                $result = $this->model->save($_POST);
                if ($result){
                    Session::setFlash('Страница была сохранена');

                }else{
                    Session::setFlash('Ошибка!');
                }
                Router::redirect('/admin/users');
            }

        }elseif($_POST['cancel']){
            Router::redirect('/admin/users');
        }
    }

    public function admin_delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if ($result){
                Session::setFlash('Пользователь был удален');
            }else{
                Session::setFlash('Ошибка!');
            }
        }
        Router::redirect('/admin/users');
    }
}