
<?php

class Comit extends Model{

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
        if($data['user_name'] == null ){
                    Session::setFlash("Будь ласка, вкажiть своє iм'я!");
                    return false;
                }
                if($data['user_email'] == null ){
                    Session::setFlash("Будь ласка, вкажiть свiй email!");
                    return false;
                }


                if($data['comit'] == null ){
                    Session::setFlash("Ви не заповнили поле з коментарем!");
                    return false;
                }



        //Включить проверку на логин, есть ли уже такой логин в БД


                if (filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
                    true;
                }else{
                    Session::setFlash("E-mail {$data['user_email']} вказано не вірно!");

                    return false;
                }

                $sql = "
        insert into comits
        set id_tema = '1',
        user_name = '{$data['user_name']}',
        user_email = '{$data['user_email']}',
        comit = '{$data['comit']}'
        ";

        return $this->db->query($sql);
    }
}