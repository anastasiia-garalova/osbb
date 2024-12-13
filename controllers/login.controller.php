<?php
class LoginController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new usLogin();
    }


    public function index(){
        $this->data['pages']['menu'] = $this->model->getMenu();

        if($_POST && isset($_POST['login']) && isset($_POST['password'])){
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt').$_POST['password']);
            if($user && $user['is_active']){
                if($hash == $user['password']){
                    Session::set('login',$user['login']);
                    Session::set('role',$user['role']);
                }
                Router::redirect('/newses/');
            }else{
                Session::setFlash('Ви ще не пройшли модернізацію!<br> Спробуйте зайти через 10хв.');
            }
        }
    }

    public function restore(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        if($_POST){
            $result = $this->model->save($_POST);
            if ($result){
                Session::setFlash('Страница была сохранена');
            }else{
                Session::setFlash('Ошибка!');
            }
            Router::redirect('/login/');
        }
    }


    public function logout(){
        Session::destroy();
        Router::redirect('/login/');
    }
}