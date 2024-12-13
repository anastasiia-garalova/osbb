<?php

class UserAccount extends Model{

    public function getByLogin($login){
        $login = $this->db->escape($login);
        $sql = "SELECT * FROM users WHERE login = '{$login}' limit 1";
        $result = $this->db->query($sql);

        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public function getList(){
        $sql = "SELECT * FROM users";
        return $this->db->query($sql);
    }

    public function save($data){
        $sel = "SELECT id FROM users";
        $users_id = $this->db->query($sel);

        foreach($users_id as $arr_id){
            foreach($arr_id as $id){
                if (isset($data['is_active'][$id]) || $data['is_active'][$id] == 1) {
                    $val = 1;
                    $sql = "
                     UPDATE users
                      SET is_active = '{$val}',
                        role = '{$data['role'][$id]}'
                      WHERE id = '{$id}'
                   ";
                    $this->db->query($sql);
                }else{
                    $val = 0;
                    $sql = "
                     UPDATE users
                      SET is_active = '{$val}'
                      WHERE id = '{$id}'
                   ";
                    $this->db->query($sql);
                }
            }
        }
        return true;
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete FROM users where id={$id}";
        return $this->db->query($sql);
    }
}