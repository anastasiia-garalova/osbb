<?php

class Thems extends Model{

    public  function  getList($only_published = false){
        $sql = "SELECT t.*,u.login FROM Thems t LEFT JOIN users u ON t.user_id = u.id";
        if($only_published){
            $sql .= "and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public  function  getListComments($id){
        $sql = "SELECT c.*, t.name as them
                FROM comments c
                LEFT JOIN Thems t
                ON c.id_theme = t.id
                WHERE id_theme = $id";
        $comments = $this->db->query($sql);

        return $comments;
    }
    public function getAnswer($id_them){
        $id_them = (int)$id_them;
        $sql = "SELECT * FROM answer a
                JOIN users u
                ON u.id = a.id_user
                WHERE a.id_them = '{$id_them}'
                ORDER BY a.id_comment DESC";

        return $this->db->query($sql);
    }

    public function getIdUser($login){
        $sql = "
                SELECT id
                  FROM users
                  WHERE login = '{$login}'
            ";
        $res = $this->db->query($sql);
        return $res[0]['id'];
    }

    public function getByAlias($alias){
        $id = $this->db->escape($alias);
        $sql = "SELECT c.*, t.name AS thems, u.login
                FROM comments c
                JOIN users u ON c.id_user = u.id
                JOIN Thems t ON c.id_theme = t.id
                where  c.id_theme = '{$id}' ";

        $result =$this->db->query($sql);
        return isset($result) ? $result : null;
    }

    public function getByAliasThem($alias){
        $id = $this->db->escape($alias);
        $sql = "SELECT t.*, t.data AS data_thems, u.login
                FROM Thems t LEFT JOIN users u
                ON t.user_id = u.id
                WHERE  t.id = '{$id}'  LIMIT 1";

        $result =$this->db->query($sql);
        return isset($result) ? $result : null;
    }

    public function getById($id){
        $id = (int)$id;
        $sql = "SELECT * FROM Thems
                WHERE  id = '{$id}' limit 1";
        $result =$this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
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

    public function getAdminMenu(){
        $sql = "SELECT id, title, alias FROM pages WHERE id = id_category_menu";
        $sel = $this->db->query($sql);
        return $sel;
    }

        public function saveComment($data, $id_user, $id_them)
    {
        if (!isset($data['comment']) ){
            return false;
        }

        $comment = $data['comment'];
        $data_comment = date('Y-m-j');

            $sql = "
                INSERT INTO comments
                  SET content = '{$comment}',
                      id_user = '{$id_user}',
                      id_theme = '{$id_them}',
                      comment_date = '{$data_comment}'
            ";

        return $this->db->query($sql);
    }

     public function saveAnswer($data, $id_user, $id_them)
    {
        if (!isset($data['content_answer']) ){
            return false;
        }

        $content_answer = $data['content_answer'];
        $id_comment = $data['id_comments'];
        $data_answer = date('Y-n-j');

        $sql = "
                INSERT INTO answer
                  SET content_answer = '{$content_answer}',
                      id_user = '{$id_user}',
                      id_comment = '{$id_comment}',
                      id_them = '{$id_them}',
                      data = '{$data_answer}'
            ";

        return $this->db->query($sql);
    }

    public function save($data, $id= null){

        if(!isset($data['title']) || !isset($data['data'] )
            || !isset($data['content_thems'])){
            return false;
        }

        $id_thems = $data['id'];
        $title = $this->db->escape($data['title']);
        $data_thems = $this->db->escape($data['data']);
        $content = $this->db->escape($data['content_thems']);
        //$is_published = isset($data['is_published']) ? 1 : 0;

        if(!$id){
            $sql = "
                insert into Thems
                  set
                      `name` = '{$title}',
                      `data` = '{$data_thems}',
                      content_thems = '{$content}'
            ";
        }else{
            $sql = "
                update Thems
                  set id = '{$id_thems}',
                      `name` = '{$title}',
                      `data` = '{$data_thems}',
                      content_thems = '{$content}'
                  where id = '{$id}'
            ";
        }
        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete FROM Thems where id={$id}";
        return $this->db->query($sql);
    }

    public function deletec($id){
        $id = (int)$id;
        $sql = "DELETE FROM comments WHERE id={$id}";
        return $this->db->query($sql);
    }
}