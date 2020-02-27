<?php

namespace Users\Entity;

use Doctrine\ORM\Mapping as Mapping;


/**
 * 
 
 */


/**
 *@param ten_dang_nhap string
 *@param mat_khau string
 *@param email string
 *@param hinh_dai_diem string
 *@param diem_cao_nhat integer
 *@param credit integer
 *@param trang_thai boolean
 *@param deleted_at datetime
 *@param created_at datetime
 *@param updated_at datetime
 * 
 * 
 * @Mapping\Entity
 * @Mapping\Table(name="nguoi_chois")
 * 
 */

class Users
{
    /**
     * @Mapping\Id
     * @Mapping\Column(type="integer")
     * @Mapping\GeneratedValue
     */
    private $id;
    /** @Mapping\Column(type="string") */
    private $ten_dang_nhap;
    /** @Mapping\Column(type="string") */
    private $mat_khau;
    /** @Mapping\Column(type="string") */
    private $email;
    /** @Mapping\Column(type="string") */
    private $hinh_dai_dien;
    /** @Mapping\Column(type="integer") */
    private $diem_cao_nhat;
    /** @Mapping\Column(type="integer") */
    private $credit;
    /** @Mapping\Column(type="integer") */
    private $trang_thai;
    /** @Mapping\Column(type="datetime") */
    private $deleted_at;
    /** @Mapping\Column(type="datetime") */
    private $created_at;
    /** @Mapping\Column(type="datetime") */
    private $updated_at;
     /** @Mapping\Column(type="string",name="pw_reset_token") */
     private $pw_reset_token;
     /** @Mapping\Column(type="datetime",name="pw_reset_at") */
     private $pw_reset_at;



        
    /** pw_reset_token
     * @return
     */
    public function getPWResetToken()
    {
        return $this->pw_reset_token;
    }
    /**
     * @param
     */
    public function setPWResetToken($pw_reset_token)
    {
        $this->pw_reset_token = $pw_reset_token;
    }

   /** pw_reset_at
     * @return
     */
    public function getPWResetAt()
    {
        return $this->pw_reset_at;
    }
    /**
     * @param
     */
    public function setPWResetAt($pw_reset_at)
    {
        $this->pw_reset_at = $pw_reset_at;
    }

    //id
    /**
     * @return
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    //ten_dang_nhap
    /**
     * @return
     */
    public function getTenDangNhap()
    {
        return $this->ten_dang_nhap;
    }
    /**
     * @param
     */
    public function setTenDangNhap($ten_dang_nhap)
    {
        $this->ten_dang_nhap = $ten_dang_nhap;
    }
    //mat_khau
    /**
     * @return
     */
    public function getMatKhau()
    {
        return $this->mat_khau;
    }
    /**
     * @param
     */
    public function setMatKhau($mat_khau)
    {
        $this->mat_khau = $mat_khau;
    }
    //email
    /**
     * @return
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    //hinh_dai_diem
    /**
     * @return
     */
    public function getHinhDaiDien()
    {
        return $this->hinh_dai_dien;
    }
    /**
     * @param
     */
    public function setHinhDaiDien($hinh_dai_dien)
    {
        $this->hinh_dai_dien = $hinh_dai_dien;
    }
    //diem_cao_nhat
    /**
     * @return
     */
    public function getDiemCaoNhat()
    {
        return $this->diem_cao_nhat;
    }
    /**
     * @param
     */
    public function setDiemCaoNhat($diem_cao_nhat)
    {
        $this->diem_cao_nhat = $diem_cao_nhat;
    }
    //credit
    /**
     * @return
     */
    public function getCredit()
    {
        return $this->credit;
    }
    /**
     * @param
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
    //trang_thai
    /**
     * @return
     */
    public function getTrangThai()
    {
        return $this->trang_thai;
    }
    /**
     * @param
     */
    public function setTrangThai($trang_thai)
    {
        $this->trang_thai = $trang_thai;
    }
    //deleted_at
    /**
     * @return
     */
    public function getDeleted()
    {
        return $this->deleted_at;
    }
    /**
     * @param
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }
    //created_at
    /**
     * @return
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    /**
     * @param
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    //updated_at
    /**
     * @return
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    /**
     * @param
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
//id
//ten_dang_nhap
//mat_khau
//email
//hinh_dai_diem
//diem_cao_nhat
//credit
//trang_thai
//deleted_at
//created_at
//updated_at
