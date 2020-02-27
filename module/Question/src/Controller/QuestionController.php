<?php

namespace Question\Controller;

use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Question\Form\QuestionForm;
use Question\Model\Question;
use Question\Model\QuestionTable;
//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

class QuestionController extends AbstractActionController
{

    private $table;

    public function __construct(QuestionTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $data = $this->table->select02();
        return new ViewModel(['question' => $data]);
    }

    public function selectAction()
    {
        $data = $this->table->select02();
        foreach ($data as $row) {
            echo '<pre>';
            print_r($row);
            echo '</pre>';
        }

        return new ViewModel(['question' => $data]);
    }
    public function addAction()
    {
        try {


            $addForm = new QuestionForm();

            $fields = $this->table->getField();

            $listField = [];

            foreach ($fields as $row) {
                $id = $row->id;
                $listField[$id] = $row->ten_linh_vuc;
            }
            $addForm->get('id_linh_vuc')->setValueOptions($listField);

            $request = $this->getRequest();
            if (!$request->isPost()) {
                return new ViewModel(['form' => $addForm]);
            }
            $data = $request->getPost()->toArray();
            $addForm->setData($data);

            if (!$addForm->isValid()) {
                $this->flashMesseger()->addErrorMessage("Vui lòng nhập đủ");
                return new ViewModel(['form' => $addForm]);
            }
            $data = $addForm->getData();

            $data['created_at'] = date('Y-m-d'); //get date 
            $data['trang_thai'] = 1; //define status = 1
            
            $question = new Question();
            $question->exchangeArray($data);
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            $this->table->saveQuestion($question);
            $this->flashMessenger()->addSuccessMessage("Thêm thành công");
            return $this->redirect()
                ->toRoute('question', ['controller' => 'QuestionController', 'action' => 'index']);
        } catch (Exception $e) {
            $e->getMessage();
        }
        // return new ViewModel(['form' => $addForm]);
    }


    public function editAction()
    {
    }
    public function deleteAction()
    {
    }
    public function updateAction()
    {
    }
}
