<?php

class Page extends Model{

    public  function  getList($only_published = false){
        $sql = "select p.id,
                    p.title,
                    p.alias,
                    p2.title AS title_category_menu,
                    p.content,
                    p.content1,
                    p.is_published,
                    p.img_name,
                    p.id_category_menu,
                    p.hide_content
                    FROM pages p
                    left JOIN pages p2 ON  p.id_category_menu = p2.id";

        if($only_published){
            $sql .= "and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public function getByAlias($alias){
        $alias = $this->db->escape($alias);
        $sql = "select p.id,
                    p.title,
                    p.alias,
                    p2.title AS title_category_menu,
                    p.content,
                    p.content1,
                    p.is_published,
                    p.img_name,
                    p.id_category_menu,
                    p.hide_content
                    FROM pages p
                    JOIN pages p2 ON  p.id_category_menu = p2.id where  p.alias = '{$alias}' limit 1";
        $result =$this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getById($id){
        $id = (int)$id;
        $sql = "select p.id,
                    p.title,
                    p.alias,
                    p2.title AS title_category_menu,
                    p.content,
                    p.content1,
                    p.is_published,
                    p.img_name,
                    p.id_category_menu,
                    p.hide_content
                    FROM pages p
                    LEFT JOIN pages p2 ON  p.id_category_menu = p2.id where  p.id = '{$id}' limit 1";
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

    public function save($data, $id = null, $files = false){
        if(!isset($data['alias']) || !isset($data['title'] ) || !isset($data['content'])){
            return false;
        }

        if(!empty($files)){
            $name = $files['img_name']['name'];
            $tmp_name = $files['img_name']['tmp_name'];
            $uploads_dir = '../webroot/uploads';
            if( !move_uploaded_file($tmp_name,"$uploads_dir/$name")){
                //echo "Произошла ошибка загрузки файла!";
            }
        }

        $id = (int)$id;
        $alias = $this->db->escape($data['alias']);
        $title = $this->db->escape($data['title']);
        $id_category_menu = $this->db->escape($data['id_category_menu']);
        $content1 = $this->db->escape($data['content1']);
        $content = $this->db->escape($data['content']);
        $hide_content = $this->db->escape($data['hide_content']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if( !$id){
            $sql = "
                insert into pages
                  set alias = '{$alias}',
                      title = '{$title}',
                      id_category_menu = '{$id_category_menu}',
                      content = '{$content}',
                      content1 = '{$content1}',
                      hide_content = '{$hide_content}',
                      img_name = '{$name}',
                      is_published = '{$is_published}'
            ";
        }else{
            $sql = "
                update pages
                  set
                      title = '{$title}',
                      id_category_menu = '{$id_category_menu}',
                      content = '{$content}',
                      content1 = '{$content1}',
                      hide_content = '{$hide_content}',
                      img_name = '{$name}',
                      is_published = '{$is_published}'
                  where id = '{$id}'
            ";
        }

        return $this->db->query($sql);
    }

    public function delete($id){
        $id = (int)$id;
        $sql = "delete FROM pages where id={$id}";
        return $this->db->query($sql);
    }
}