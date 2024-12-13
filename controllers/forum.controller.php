<?php

class ForumController extends Controller{

    public function __construct($data =array ()){
        parent::__construct($data);
        $this->model = new Thems();
    }

    public function index(){
        $this->data['forum'] =  $this->model->getList();
        $this->data['pages']['menu'] = $this->model->getMenu();

    }

    public function view(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        $params = App::getRouter()->getParams();

        if(isset($params[0])){

            $alias = strtolower($params[0]);
            $this->data['them']= $this->model->getByAliasThem($alias);
            $this->data['them']['comments']= $this->model->getByAlias($alias);
            $this->data['them']['answer']= $this->model->getAnswer($alias);

            if($_POST['save']){
                if($_POST){
                    $login = Session::get('login');
                    $id_user = $this->model->getIdUser($login);

                    $result = $this->model->saveComment($_POST, $id_user, $alias);
                    if ($result){
                        Session::setFlash('Страница была сохранена');
                    }else{
                        Session::setFlash('Ошибка!');
                    }
                    Router::redirect($id);
                }
            }elseif($_POST['cancel']){
                Router::redirect($id);
            }

            if($_POST['answer']){
                if($_POST){
                    $login = Session::get('login');
                    $id_user = $this->model->getIdUser($login);

                    $result = $this->model->saveAnswer($_POST,$id_user, $alias);
                    if ($result){
                        Session::setFlash('Страница была сохранена');
                    }else{
                        Session::setFlash('Ошибка!');
                    }
                    Router::redirect($id);
                }
            }elseif($_POST['cancel']){
                Router::redirect($id);
            }

        }

        /*
        if(isset($params[0])){
            $alias = strtolower($params[0]);
            $this->data['coments']= $this->model->getByAlias($alias);
            $this->data['them']= $this->model->getByAliasThem($alias);
        }

        if($_POST['save_comment']){
            if($_POST){
                $result = $this->model->save_comment($_POST, $alias);
                if ($result){
                    Session::setFlash('Ваш відгук успішно добавлен!');
                    $params = App::getRouter()->getParams();
                    if(isset($params[0])){
                        $alias = strtolower($params[0]);
                        $this->data['them']= $this->model->getByAlias($alias);
                    }
                }else{
                    Session::setFlash('Ошибка!');
                }
              // Router::redirect('/forum/');
            }
        }elseif($_POST['cancel']){
            Router::redirect('/forum/');
        }
        */

    }

    public function admin_index(){
        $this->data['forum'] = $this->model->getList();

    }

    public function admin_add(){
        if($_POST['save']){
            if($_POST){
                $result = $this->model->save($_POST);
                if ($result){
                    Session::setFlash('Страница была сохранена');
                }else{
                    Session::setFlash('Ошибка!');
                }
                Router::redirect('/admin/forum');
            }
        }elseif($_POST['cancel']){
            Router::redirect('/admin/forum');
        }
    }

    public function admin_edit(){
        if(isset($this->params[0])){
            $this->data['them'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/forum/');
        }
        if($_POST['save']){
            if($_POST){
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                $result = $this->model->save($_POST,$id);

                if ($result){
                    Session::setFlash('Страница была сохранена');
                }else{
                    Session::setFlash('Ошибка!');
                }
                Router::redirect('/admin/forum');
            }

        }elseif($_POST['cancel']){
            Router::redirect('/admin/forum/');
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
        Router::redirect('/admin/forum');
    }

    public function admin_editc(){
        $this->data['pages']['menu'] = $this->model->getMenu();
        if(isset($this->params[0])){
            $this->data['comments'] = $this->model->getListComments($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/forum/');
        }

    }

    public function admin_deletec(){
        if(isset($this->params[0])){
            $result = $this->model->deletec($this->params[0]);
            if ($result){
                Session::setFlash('Страница была удалина');
            }else{
                Session::setFlash('Ошибка!');
            }
        }
        Router::redirect('/admin/forum/editc/');
    }

}