<?php

class Imageupload extends \CI_Controller
{
    function __construct()
    {
        parent::__construct();
         $this->load->library('image_lib');
        $this->load->helper(array('form', 'url'));
    }
    function index()
    {
        $this->load->view('imageupload_view', array('error' => ' '));
    }
    function doupload()
    {
        $name_array = array();
        $count = count($_FILES['userfile']['size']);
        foreach ($_FILES as $key => $value) {
            for ($s = 0; $s <= $count - 1; $s++) {
                $_FILES['userfile']['name'] = $value['name'][$s];
                $_FILES['userfile']['type'] = $value['type'][$s];
                $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
                $_FILES['userfile']['error'] = $value['error'][$s];
                $_FILES['userfile']['size'] = $value['size'][$s];
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '100';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $data = $this->upload->data();
                $name_array[] = $data['file_name'];
                $this->textWatermark($data['full_path']);
            }
        }
        $names = implode(',', $name_array);
        /*            $this->load->database();
                    $db_data = array('id'=> NULL,'name'=> $names);
                    $this->db->insert('testtable',$db_data);
        */
        print_r($names);
    }

    public function textWatermark($source_image)
    {
        $config['source_image'] = $source_image;
        //The image path,which you would like to watermarking
        $config['wm_text'] = 'arjunphp.com';
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = './fonts/atlassol.ttf';
        $config['wm_font_size'] = 16;
        $config['wm_font_color'] = 'ffffff';
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'right';
        $config['wm_padding'] = '20';
        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
            return $this->image_lib->display_errors();
        }
    }
    public function overlayWatermark($source_image)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['wm_type'] = 'overlay';
        $config['wm_overlay_path'] = './uploads/logo.png';
        //the overlay image
        $config['wm_opacity'] = 50;
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'right';
        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
            echo $this->image_lib->display_errors();
        }
    }
}