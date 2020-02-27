<?php

namespace Users\Service;

use DateTime;
use Laminas\Crypt\Password\Bcrypt;
use Users\Entity\Users;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Math\Rand;

class UserManager
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function checkUsernameExists($username)
    {
        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['ten_dang_nhap' => $username]);
        return $user != null;
    }
    public function checkEmailExists($email)
    {
        $email = $this->entityManager->getRepository(Users::class)->findOneByEmail($email);
        return $email != null;
    }

    /**
     * @Thêm user
     * @param data []
     */
    public function addUser($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if ($this->checkEmailExists($data['email'])) {
            throw new \Exception("Email " . $data['email'] . "Đã có người sữ dụng");
        }
        if ($this->checkUsernameExists($data['ten_dang_nhap'])) {
            throw new \Exception("Tên đăng nhập [" . $data['ten_dang_nhap'] . "] Đã có người sữ dụng");
        }
        $user = new Users();
        //ten_dang_nhap
        $user->setTenDangNhap($data['ten_dang_nhap']);
        //email
        $user->setEmail($data['email']);
        //hinh_dai_diem
        $user->setHinhDaiDien($data['hinh_dai_dien']);
        //diem_cao_nhat
        $user->setDiemCaoNhat($data['diem_cao_nhat']);
        //credit
        $user->setCredit($data['credit']);
        //trang_thai
        $user->setTrangThai($data['trang_thai']);
        //deleted_at
        // $user->setDeletedAt($data['deleted_at']);
        // //created_at
        $user->setCreatedAt(new DateTime('NOW'));
        // //updated_at
        // $user->setUpdatedAt($data['updated_at']);
        $bcrypt = new Bcrypt();
        $securePass = $bcrypt->create($data['mat_khau']);
        //$user->mat_khau
        $user->setMatKhau($securePass);
        //Tạo mới
        $this->entityManager->persist($user);
        //Thêm vào
        $this->entityManager->flush();

        echo '<pre>';
        print_r($user);
        echo '</pre>';

        return $user;
    }
    public function updateUser($data, $user)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        $sql = "SELECT u from Users\Entity\Users u WHERE u.email = '" . $data['email'] . "' AND u.ten_dang_nhap <> '" . $data['ten_dang_nhap'] . "'";

        $query = $this->entityManager->createQuery($sql);
        $users = $query->getResult();


        echo '<pre>';
        print_r($users);
        echo '</pre>';


        if (!empty($users)) {
            throw new \Exception("Email " . $data['email'] . " đã có người sữ dụng.");
        }


        //ten_dang_nhap
        $user->setTenDangNhap($data['ten_dang_nhap']);
        //email
        $user->setEmail($data['email']);
        //hinh_dai_diem
        $user->setHinhDaiDien($data['hinh_dai_dien']);
        //diem_cao_nhat
        $user->setDiemCaoNhat($data['diem_cao_nhat']);
        //credit
        $user->setCredit($data['credit']);
        //trang_thai
        $user->setTrangThai($data['trang_thai']);
        //updated_at
        $update_at = new DateTime('NOW');
        $user->setUpdatedAt($update_at);

        // $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }


    public function removeUser($user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
    public function verifyPassword($securePass, $password)
    {
        $bcrypt = new Bcrypt();
        if ($bcrypt->verify($password, $securePass)) {
            return true;
        }
        return false;
    }
    public function changePassword($user, $data)
    {
        $securePass = $user->getMatKhau();
        var_dump($securePass);
        $password = $data['old_pw'];
        var_dump($password);
        //Xác minh mật khẩu
        if (!$this->verifyPassword($securePass, $password))
            return false;
        //Mã hóa mật khẩu mới và thêm vào db
        $newPassword = $data['new_pw'];
        $bcrypt = new Bcrypt();
        $securePass = $bcrypt->create($newPassword);
        $user->setMatKhau($securePass);
        $this->entityManager->flush();

        return true;
    }
    //
    public function createPasswordToken($user)
    {

        $token = Rand::getString(32, '0123456789qwertyuiopasdfghjklzxcvbnm', true); //hàm random

        $user->setPWResetToken($token);
        $time = new DateTime('now'); //Hàm lấy thời gian hiện tại
        $user->setPWResetAt($time);
        //Thêm data vào row sẵn có
        $this->entityManager->flush();

        $http = isset($_SERVER['HTTP']) ? "https://" : "http://"; //Kiểm tra giao thức http
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost:8000'; //kiểm tra host

        $url = $http . $host . "/skeleton-application/public/set-password/" . $token;

        $bodyMessage  = "Chào bạn, " . $user->getTenDangNhap() .
            " Bạn vui lòng chọn vào đường link bên dưới để reset lại mật khẩu: "
            . $url .
            " Nếu bạn không yêu cầu reset lại mật khẩu vui lòng bỏ qua thông báo này";
        //Cấu trúc của mail
        $message = new Message();
        $message->addFrom("yukihuy99yuki@gmail.com");
        $message->addTo($user->getEmail());
        $message->setSubject('Reset Password');
        $message->setBody($bodyMessage);
        //Thiết lập giao thức Smtp
        $transport = new SmtpTransport();
        $options = new SmtpOptions([
            'name'              => 'smtp.gmail.com',
            'host'              => 'smtp.gmail.com',
            'port'              => 465,
            'connection_class'  => 'login',
            'connection_config' => [
                'username' => 'yukihuy99yuki@gmail.com', //gmail
                'password' => '01689320842', //mật khẩu của gmail phía trên
                'ssl'      => 'ssl'
            ],
        ]);

        $transport->setOptions($options);
        $transport->send($message);
    }

    public function checkPWToken($token)
    {
        // dd($token);
        $user = $this->entityManager->getRepository(Users::class)
            ->findOneBy(['pw_reset_token' => $token]);
        // dd($user);
        // echo '<pre>';print_r($user);echo '</pre>';die();
        if (!$user)
            return false;
     

        $userTokenAt = $user->getPWResetAt()->getTimestamp();
        $time_now = new Datetime('now');
        $time_now = $time_now->getTimestamp();

        if (($time_now - $userTokenAt) > 86400) {
            //24*60*60 => 24h
            var_dump($time_now - $userTokenAt);
            return false;
        }

        return true;
    }
    /**
     * @param $token string
     * @param $newPassword string
     */
    public function setNewPasswordByToken($token, $newPassword)
    {
        if (!$this->checkPWToken($token)) {
            return false;
        }
        $user = $this->entityManager->getRepository(Users::class)
            ->findOneBy(['pw_reset_token' => $token]);
        if (!$user)
            return false;
        else {
            $bcrypt = new Bcrypt();
            $passwordHash = $bcrypt->create($newPassword);
            $user->setMatKhau($passwordHash);
            //reset
            $user->setPWResetAt(null);
            $user->setPWResetToken(null);
            //lưu
            $this->entityManager->flush();
            return true;
        }
    }
}
