<?php
namespace Users\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Users\Form\LoginForm;

class AuthController extends AbstractActionController
{
    private $entityManager,$userManager,$authManager,$authService;

    public function __construct($entityManager,$userManager,$authManager,$authService)
    {
                      
        $this->entityManager = $entityManager;
       
        $this->userManager =$authService;
        
        $this->authManager =$authManager;
      
        $this->authService =$authService;
    }
    public function loginAction()
    {
        $form = new LoginForm();
        if($this->getRequest()->isPost()){
            $data = $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid()){
                $data = $form->getData();
                print_r($data);
            }
        }
        return new ViewModel(['form' => $form]);
    }
}
?>