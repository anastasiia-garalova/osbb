<?php

class Registration extends Model{

    public function getByLogin($login){
        $login = $this->db->escape($login);
        $sql = "select * FROM users where login = '{$login}' limit 1";
        $result = $this->db->query($sql);

        if(isset($result[0])){
            return $result[0];
        }
        return false;
    }

    public function getMenu(){
        $sql = "SELECT id, title, id_category_menu, alias FROM pages ";
        $sel = $this->db->query($sql);
        foreach($sel as $arr){
            if($arr['id'] == $arr['id_category_menu']){
                $menu[] = $this->arrMenu($arr['id'],$sel);
            }
        }
        return $menu;
    }

    public function arrMenu($id, $arr){
        foreach($arr as $val){
            if($id == $val['id_category_menu']){
                $menu[$id][$val['alias']] = $val['title'];
            }
        }
        return $menu[$id];
    }

    public  function save($data){
        if($data['user_name'] == null || $data['login'] == null || $data['email'] == null
            || $data['number_room'] == null
            || $data['password'] == null || $data['r_password'] == null){
            Session::setFlash("Будь ласка, заповніть всі поля форми!");
            return false;
        }

        $login = $data['login'];
        $sel = "SELECT * FROM users WHERE login = '$login'";
        $res = $this->db->query($sel);
        if($res) {
            Session::setFlash("Користувач із логіном <b>{$login}</b> вже існує !");
            return false;
        }

        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            true;
        }else{
            Session::setFlash("E-mail {$data['email']} указан не верно!");
            return false;
        }

        if (strlen($data['password'])<5){
            Session::setFlash('Пароль дуже короткий, введіть не менше 5 символів!');
            return false;
        }

        if ($data['password'] == $data['r_password']) {
            $data['password'] = md5(Config::get('salt').$_POST['password']);
        }else{
            Session::setFlash('Паролі не збігаються!');
            return false;
        }

        $title = substr(htmlspecialchars('Новый пользователь сайта!'), 0, 1000);
        $mess =  substr(htmlspecialchars("Пользователь ".trim($data['user_name']).
                " пытается зарегистрироваться.</br> тел:".$data['number_tel'].
            "</br> login:".$data['login'].
            "</br> email:".$data['email'].
            "</br> Номер квартиры:".$data['number_room']
                    ), 0, 1000000);
        $to = 'mma7@i.ua';
        $from = $data['email'];

        mail($to, $title, $mess, 'From:'.$from);

        $sql = "
               insert into users
                set login = '{$data['login']}',
                    email = '{$data['email']}',
                    number_tel = '{$data['number_tel']}',
                    number_room = '{$data['number_room']}',
                    password = '{$data['password']}',
                    user_name = '{$data['user_name']}'
            ";

        return $this->db->query($sql);
    }
}