<?php

namespace Users\Controller;

use Laminas\Filter\File\Rename;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Users\Entity\Users;
use Users\Form\ChangePasswordForm;
use Users\Form\ResetPasswordForm;
use Users\Form\UsersForm;

class UserController extends AbstractActionController
{

    private $entityManager;
    private $userManager;

    public function __construct($entityManager, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }
    public function indexAction()
    {

        $users = $this->entityManager->getRepository(Users::class)->findAll();
        return new ViewModel(['users' => $users]);
    }
    public function addAction()
    {
        $form = new UsersForm('add');

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $file = $this->getRequest()->getFiles()->toArray();

            $data = array_merge_recursive($data, $file);
            $form->setData($data);

            // echo '<pre>';
            // print_r($file);
            // echo '</pre>';

            if ($form->isValid()) {

                $data = $form->getData();
                $newName = date('Y-m-d-h-i-s') . '-' . $file['hinh_dai_dien']['name'];

                //Đổi tên ảnh + chọn nơi lưu trữ
                $image = new Rename([
                    'target' => IMAGE_PATH . "/" . $newName,
                    'overwrite' => true
                ]);
                //
                $image->filter($file['hinh_dai_dien']);

                $data['hinh_dai_dien'] = $newName;

                $user = $this->userManager->addUser($data);

                $this->flashMessenger()->addSuccessMessage("Thêm thành công");
                return $this->redirect()->toRoute('users', ['controller' => 'UserController', 'action' => 'index']);
            }
        }

        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $idUser = $this->params()->fromRoute('id', 0);
        if ($idUser <= 0) {
            $this->getResponse()->setStatusCode('404');
            return;
        }
        $user = $this->entityManager->getRepository(Users::class)->find($idUser);

        if (!$user) {
            $this->getResponse()->setStatusCode('404');
            return;
        }

        $form = new UsersForm("edit");

        if (!$this->getRequest()->isPost()) {
            $data = [
                'ten_dang_nhap' => $user->getTenDangNhap(),
                'mat_khau' => $user->getMatKhau(),
                'email' => $user->getEmail(),
                'hinh_dai_diem' => $user->getHinhDaiDien(),
                'diem_cao_nhat' => $user->getDiemCaoNhat(),
                'credit' => $user->getCredit(),
                'trang_thai' => $user->getTrangThai(),

            ];
            $form->setData($data);
            return new ViewModel(['form' => $form, 'user' => $user]);
        }

        $data = $this->params()->fromPost();
        $file = $this->getRequest()->getFiles()->toArray();

        $data = array_merge_recursive($data, $file);

        $form->setData($data);
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // die();
        //kiểm tra dữ liệu hợp lệ
        if ($form->isValid()) {

            $data = $form->getData();
            //Kiểm tra đã có chọn ảnh mới ko
            if ($file['hinh_dai_dien']['error'] <= 0) {
                $newName = date('Y-m-d-h-i-s') . '-' . $file['hinh_dai_dien']['name'];
                //
                $image = new Rename([
                    'target' => IMAGE_PATH . "/" . $newName,
                    'overwrite' => true,
                ]);

                $image->filter($file['hinh_dai_dien']);

                $data['hinh_dai_dien'] = $newName;
            } else {
                $data['hinh_dai_dien'] = $user->getHinhDaiDien();
            }



            $this->userManager->updateUser($data, $user);

            $this->flashMessenger()->addSuccessMessage("Cập nhật thành công");
            return $this->redirect()->toRoute('users');


            //admin@123
            //admin@1234
        }
        // return $this->redirect()->toRoute('users',['actions'=>'edit']);
    }
    public function deleteAction()
    {
        $idUser = $this->params()->fromRoute('id', 0);
        if ($idUser <= 0) {
            $this->getResponse()->setStatusCode('404');
            return;
        }
        $user = $this->entityManager->getRepository(Users::class)->find($idUser);
        if (!$user) {
            $this->getResponse()->setStatusCode('404');
            return;
        }
        if ($this->getRequest()->isPost()) {
            $btn = $this->getRequest()->getPost('delete', 'No');
            if ($btn === 'Yes') {
                $this->userManager->removeUser($user);
            }
            return $this->redirect()->toRoute('users');
        }
        return new ViewModel(['user' => $user]);
    }
    public function changePasswordAction()
    {
        $idUser = $this->params()->fromRoute('id', 0);
        if ($idUser <= 0) {
            $this->getResponse()->setStatusCode('404');
            return;
        }
        $user = $this->entityManager->getRepository(Users::class)->find($idUser);
        if (!$user) {
            $this->getResponse()->setStatusCode('404');
            return;
        }
        $form = new ChangePasswordForm();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);

            echo '<pre>';
            print_r($data);
            echo '</pre>';
            if ($form->isValid()) {
                $data = $form->getData();

                $check = $this->userManager->changePassword($user, $data);

                var_dump($check);
                // die();
                if (!$check) {
                    $this->flashMessenger()->addErrorMessage("Mật khẩu cũ chưa đúng , vui lòng nhập lại");
                    return $this->redirect()->toRoute('users', ['action' => 'change-password', 'id' => $user->getId()]);
                } else {
                    $this->flashMessenger()->addSuccessMessage("Mật khẩu đã thay đổi");
                    return $this->redirect()->toRoute('users');
                }
            }
        }
        return new ViewModel(['form' => $form]);
    }
    public function resetPasswordAction()
    {
        $form = new ResetPasswordForm();
        //  echo '<pre>';
        // print_r($form->get('captcha_image'));
        // echo '</pre>';
        // die();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                // print_r($data);
                $user = $this->entityManager->getRepository(Users::class)->findOneByEmail($data['email']);
                if ($user !== null) {
                    $this->userManager->createPasswordToken($user);
                    $this->flashMessenger()->addSuccessMessage('Kiểm tra hộp thư để reset password');
                } else {
                    $this->flashMessenger()->addErrorMessage('Email không tồn tại');
                }
            } else {
                $this->flashMessenger()->addErrorMessage('Nhập không hợp lệ');
            }

            return $this->redirect()->toRoute('resetpassword');
        }
        return new ViewModel(['form' => $form]);
    }
    public function setPasswordAction()
    {
        $token = $this->params()->fromRoute('token', null);

        //var_dump($token);
        //Check hợp lệ của token
        if ($token == null || strlen($token) != 32) {
            throw new \Exception('Token không hợp lệ');
        } else if (!$this->userManager->checkPWToken($token)) {
            throw new \Exception('Token không hợp lệ hoặc hết hạn sữ dụng. Vui lòng nhập lại');
        }
        ///echo "Token hợp lệ";

        $form = new ChangePasswordForm("resetPw");

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            // echo '<pre>';
            // print_r($form);
            // echo '</pre>';
            // die();
            if ($form->isValid()) {
                //Đổi mật khẩu
                if ($this->userManager->setNewPasswordByToken($token, $data['new_pw'])) {
                    $this->flashMessenger()->addSuccessMessage('Đổi mật khẩu thành công');
                    return $this->redirect()->toRoute('users');
                } else {
                    $this->flashMessenger()->addErrorMessage('Email không tồn tại');
                    return $this->redirect()->toRoute('setpassword', ['token' => $token]);
                }
            }
        }
        //$2y$10$D7aqH0/Cj4kMO294VAGP5u.2TW8J/E46/cBQV.I0.hCGxfROkI4HG
        //admin@yukihuy
        //$2y$10$QeERvxi8TFCKIWzxAtMp7.784ex1NLLdzIVXOEkBv.8DOi.qw/p/e
        return new ViewModel(['form' => $form]);
    }
}
