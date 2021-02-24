<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    public function display($task_id)
    {
        $data['project_id'] = $this->task_model->get_task_project_id($task_id);
        $data['project_name'] = $this->task_model->get_project_name($data['project_id']);
        
        $data['task'] = $this->task_model->get_task($task_id);
        $data['main_view'] = "tasks/display";
        $this->load->view('layouts/main', $data);
    }


    
    
    // your new methods go here
    public function create($project_id)
    {
        // $this->form_validation->set_rules('task_name', 'Task Name', 'trim|required');
        // $this->form_validation->set_rules('task_body', 'Task Description', 'trim|required');
        // $this->form_validation->set_rules('due_date', '','');

        //if ($this->form_validation->run() == false) {
        if ( $this->input->post() == false ) {
            $data['main_view'] = 'tasks/create_task';
            $this->load->view('layouts/main', $data);
        } else {
            
            $data = array(
                //'project_id' => basename($_SERVER['PHP_SELF']),
                'project_id' => $project_id,
                'task_name' => $this->input->post('task_name'),
                'task_body' => $this->input->post('task_body'),
                'due_date' => $this->input->post('due_date')
                );
            
                //flashdata
            if ($this->task_model->create_task($data)) {
                $this->session->set_flashdata('task_created', 'Your task has been created');

                //echo "<script>history.go(-2);</script>";
                //redirect(base_url()."projects/display/".$data['project_id']);
                redirect("projects/display/".$project_id);
            }
        }
    }

    
    // function checkDateFormat($date) {
    //     if (preg_match("/[0-12]{2}/[0-31]{2}/[0-9]{4}/", $date)) {
    //         if(checkdate(substr($date, 0, 2), substr($date, 3, 2), substr($date, 6, 4)))
    //             return true;
    //             else
    //             return false;
    //         } 
    //         else {
    //         return false;
    //         }
    //     }



    public function delete($project_id,$task_id)
    {
        //var_dump($task_id);
        //var_dump($project_id);
        //$this->task_model->delete_task(basename($_SERVER['PHP_SELF']));
        $this->task_model->delete_task($task_id);

        $this->session->set_flashdata('task_deleted', 'Your task has been deleted');

        redirect("projects/display/".$project_id);
    }


    public function edit($task_id)
    {
        if ( $this->input->post() == false ) {
            $data['project_id'] = $this->task_model->get_task_project_id($task_id);
            //$data['project_name'] = $this->task_model->get_project_name($data['project_id']);

            $data['the_task'] = $this->task_model->get_task_project_data($task_id);
            
        //$this->form_validation->set_rules('task_name', 'Task Name', 'trim|required');
        //$this->form_validation->set_rules('task_body', 'Task Description', 'trim|required');
        //$this->form_validation->set_rules('due_date', '','');

        // if ($this->form_validation->run() == false) {
            
        //     $data['the_task'] = $this->task_model->get_task_project_data($task_id);

             $data['main_view'] = 'tasks/edit_task';
 
             $this->load->view('layouts/main', $data);
        } else {
            $project_id = $this->task_model->get_task_project_id($task_id);
            $data = array(

                'project_id' => $project_id,
                'task_name' => $this->input->post('task_name'),
                'task_body' => $this->input->post('task_body'),
                'due_date' => $this->input->post('due_date')
                
                );

            if ($this->task_model->edit_task($task_id, $data)) {
                $this->session->set_flashdata('task_updated', 'Your task has been updated');

                redirect("projects/display/".$project_id);
            }
        }
    }
}
