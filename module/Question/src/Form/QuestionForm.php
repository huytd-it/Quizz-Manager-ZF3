<?php 
namespace Question\Form;

// use Zend\Form\Element;
// use Zend\Form\Form;
use Laminas\Form\Form;
use Laminas\Form\Element;


class QuestionForm extends Form{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->getAttributes([
            'class' => 'form-horizonal',
            'id' => 'question-form',
            'enctype' => 'multipart/form-data'
        ]);

        $this->setElements();

    }
    private function setElements()
    {
        //id
        $id = new Element\Text('id');
        $id->setAttributes([
            'type' => 'hidden',
            'value' => 'Zend 3'

        ]);
        $this->add($id);
        //field
        $field = new Element\Select('id_linh_vuc');
        $field->setLabel('Chọn lĩnh vực');
        $field->setLabelAttributes([
            'class' => 'col-sm-9 col-form-label'           
            ]);
        $field->setAttributes([
            'class'=>'form-control',
        ]);
        $field->setValueOptions([
            '0' => 'Zend Framework',
            '1' => 'Question',
            '2' => 'Love',
        ]);
        
        //Text
        $content = new Element\Text('noi_dung');
        $content->setLabel('Nội dung');
        $content->setLabelAttributes(['class' => 'col-sm-9 col-form-label']);
        $content->setAttributes(['class' => 'form-control']);
        $this->add($content);
        //A
        $content = new Element\Text('phuong_an_A');
        $content->setLabel('Phương án A');
        $content->setLabelAttributes(['class' => 'col-sm-9 col-form-label']);
        $content->setAttributes(['class' => 'form-control']);
        $this->add($content);
        //B
        $content = new Element\Text('phuong_an_B');
        $content->setLabel('Phương án B');
        $content->setLabelAttributes(['class' => 'col-sm-9 col-form-label']);
        $content->setAttributes(['class' => 'form-control']);
        $this->add($content);
        //C
        $content = new Element\Text('phuong_an_C');
        $content->setLabel('Phương án C');
        $content->setLabelAttributes(['class' => 'col-sm-9 col-form-label']);
        $content->setAttributes(['class' => 'form-control']);
        $this->add($content);
        //D
        $content = new Element\Text('phuong_an_D');
        $content->setLabel('Phương án D');
        $content->setLabelAttributes(['class' => 'col-sm-9 col-form-label']);
        $content->setAttributes(['class' => 'form-control']);
        $this->add($content);
        //Answer
        $content = new Element\Text('dap_an');
        $content->setLabel('Đáp án');
        $content->setLabelAttributes(['class' => 'col-sm-9 col-form-label']);
        $content->setAttributes(['class' => 'form-control']);
        $this->add($content);


        //Button
        $saveButton = new Element\Submit('save');
        $saveButton->setValue('Add');
        $saveButton->setAttributes([
            'class'=>'form-control btn-info',
        ]);
        $this->add($saveButton);
        //File
        $file = new Element\File('image');
        $file->setLabel('Ảnh câu hỏi');
       //  $file->setValue('Chọn ảnh');
        $file->setLabelAttributes(['class' => 'col-sm-6 col-form-label']);
        $file->setAttributes([
            'class' => 'form-control-file',
           
        ]);
       
        $this->add($file);


        //echo $this->formSelect($field);

        //Redirect route
        // return $this->redirect()->toRoute('album', ['action' => 'index']);

        $this->add($field);
        //define 

    }
}