<?php
class Attribute_m extends MY_Model
{
    protected $_primary_key = 'id';
    protected $_table_name = 'attributes';
    protected $_order_by = 'id asc, order desc';

    public $rules = array(
        'title' => array(
            'field' => 'title', 
            'label' => 'Title', 
            'rules' => 'trim|required|max_length[128]'
        ),
        'body' => array(
            'field' => 'body', 
            'label' => 'Body', 
            'rules' => 'trim|required|max_length[128]'
        )
    );

    public function get_new()
    {
        $model = new stdClass();
        $model->title = '';
        $model->body = NULL;
        return $model;
    }
    
    public function delete($id)
    {
        // удаляем атрибут
        parent::delete($id);
    }

    public function save_for_all($data)
    {
        $section = $this->db->select('section_id')->from('requirements')->where('id', $data['req_id'])->get()->row();

        $requirements = $this->db->select('id')->from('requirements')->where('section_id', $section->section_id)->get()->result();
        foreach ($requirements as $r) {
            if($r->id == $data['req_id']) {
                $this->db->set($data);
                $this->db->insert($this->_table_name);
            }
            else {
                $info = array('req_id' => $r->id, 'title' => $data['title'], 'body' => NULL);
                $this->db->set($info);
                $this->db->insert($this->_table_name);
            }
        }

        return $this->db->insert_id();
    }

    public function get_by_reqid_and_title($req_id, $title)
    {
        $this->db->select('id')->from($this->_table_name)->where('req_id', $req_id)->where('title', $title);

        return $this->db->get()->row();
    }
}
