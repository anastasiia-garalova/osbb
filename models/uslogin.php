<?php

class usLogin extends Model{

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

    public function save($data){
        if(!isset($data['login']) || !isset($data['email'] )){
            return false;
        }
        //$alias = $this->db->escape($data['alias']);
        //$title = $this->db->escape($data['title']);
        $login = $data['login'];
        $email = $data['email'];
        $pass = "";
        $sel = "SELECT * FROM users WHERE login = '$login' AND email= '$email' ";
        $res = $this->db->query($sel);
        if(!$res) {
            Session::setFlash("Ви ввели не коректний логін <b>{$login}</b> або email <b>{$email}</b>!");
            return false;
        }else {
            $all = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

            $cnt = strlen($all) - 1;
            srand((double)microtime()*1000000);
            for($i=0; $i<6; $i++) $pass .= $all[rand(0, $cnt)];
            $num = rand(12,99);
            $pass = $num.$pass;

            $title = substr(htmlspecialchars('Новый пароль на сайте osbb!'), 0, 1000);
            $mess =  substr(htmlspecialchars("Ваш логин: ".trim($login).
                " и новый пароль: ".trim($pass)), 0, 1000000);
            $to = $email;
            $from = 'mma7@i.ua';

            mail($to, $title, $mess, 'From:'.$from);
           // echo $pass;
            $pass = md5(Config::get('salt').$pass);
            $sql = "
                update users
                      set password = '{$pass}'
                  where login = '{$login}'
            ";
        }

       return $this->db->query($sql);
    }

}