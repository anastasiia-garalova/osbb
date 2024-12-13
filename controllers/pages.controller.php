<?php

class PagesController extends Controller{

    public function __construct($data =array ()){
        parent::__construct($data);
        $this->model = new Page();
    }

    public function index(){
        $this->data['pages'] =  $this->model->getList();
        $this->data['pages']['menu'] = $this->model->getMenu();
    }

    public function view(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        $params = App::getRouter()->getParams();
        if(isset($params[0])){
            $alias = strtolower($params[0]);
            $this->data['page'] = $this->model->getByAlias($alias);
        }
    }

    public function admin_index(){
        $this->data['pages'] = $this->model->getList();

    }

    public function admin_add(){
        $this->data['menu'] = $this->model->getAdminMenu();
        if($_POST['save']){
            if(!empty($_FILES)){
                if($_POST){
                    $result = $this->model->save($_POST,'null',$_FILES);
                    if ($result){
                        Session::setFlash('Страница была сохранена');
                    }else{
                        Session::setFlash('Ошибка!');
                    }
                    Router::redirect('/admin/pages/');
                }
            }else{
                if($_POST){
                    $result = $this->model->save($_POST);
                    if ($result){
                        Session::setFlash('Страница была сохранена');
                    }else{
                        Session::setFlash('Ошибка!');
                    }
                    Router::redirect('/admin/pages/');
                }
            }
        }elseif($_POST['cancel']){
            Router::redirect('/admin/pages/');
        }
    }

    public function admin_edit(){
        $this->data['menu'] = $this->model->getAdminMenu();
        if($_POST['save']){
            if(!empty($_FILES)){
                if($_POST){
                    $id = isset($_POST['id']) ? $_POST['id'] : null;
                    $result = $this->model->save($_POST, $id, $_FILES);
                    if ($result){
                        Session::setFlash('Страница была сохранена');
                    }else{
                        Session::setFlash('Ошибка!');
                    }
                    Router::redirect('/admin/pages/');
                }
            }else{
                if($_POST){
                    $id = isset($_POST['id']) ? $_POST['id'] : null;
                    $result = $this->model->save($_POST, $id);
                    if ($result){
                        Session::setFlash('Страница была сохранена');
                    }else{
                        Session::setFlash('Ошибка!');
                    }
                    Router::redirect('/admin/pages/');
                }
            }
        }elseif($_POST['cancel']){
            Router::redirect('/admin/pages/');
        }

        if(isset($this->params[0])){
            $this->data['page'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/pages/');
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
        Router::redirect('/admin/pages/');
    }
}