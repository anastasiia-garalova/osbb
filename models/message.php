<?php

class Message extends Model{

    public function getList(){
        $sql = "SELECT * FROM messages WHERE 1";
        return $this->db->query($sql);
    }

    public function getContacts(){
        $sql = "SELECT * FROM сontacts WHERE id=1";
        return $this->db->query($sql);
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

    public  function save($data, $id = null){
        if(!isset($data['name']) || !isset($data['email'] ) || !isset($data['message'])){
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $message = $this->db->escape($data['message']);

        if( !$id){
            $sql = "
                insert into messages
                  set name = '{$name}',
                      email = '{$email}',
                      message = '{$message}'
            ";
        }else{
            $sql = "
                update messages
                  set name = '{$name}',
                      email = '{$email}',
                      message = '{$message}',
                  where id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }


    public function delete($id){
        $id = (int)$id;
        $sql = "delete FROM messages where id={$id}";
        return $this->db->query($sql);
    }

}