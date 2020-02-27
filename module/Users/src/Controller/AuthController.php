<?php
namespace Users\Controller;

use Laminas\Authentication\Result;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Users\Form\LoginForm;

class AuthController extends AbstractActionController
{
    private $entityManager,$userManager,$authManager,$authService;

    public function __construct($entityManager,$userManager,$authManager,$authService)
    {
                      
        $this->entityManager = $entityManager;
       
        $this->userManager =$userManager;
        
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
                // print_r($data);
                $result = $this->authManager->login($data['ten_dang_nhap'], $data['mat_khau'], $data['ghi_nho']);
                if($result->getCode() == Result::SUCCESS){
                    return $this->redirect()->toRoute('users');
                }else{
                     $message = current($result->getMessages());
                     $this->flashMessenger()->addErrorMessage($message);
                     return $this->redirect()->toRoute('login');
                }
            }

        }
        return new ViewModel(['form' => $form]);
    }
    public function logoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }
}
?>