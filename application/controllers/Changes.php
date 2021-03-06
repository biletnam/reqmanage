<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changes extends MY_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        if(!empty($this->userProjects))
            $this->data['changes'] = $this->change_m->get_in('project_id', $this->userProjects);
        else
            $this->data['changes'] = '';
        
        $this->data['what'] = $this->config->item('hierarchy');

        $this->template->set_title('Последние изменения');
        $this->template->set_breadcrumb(array('Последние изменения'));
        $this->template->load_view('changes', $this->data);
    }

}
