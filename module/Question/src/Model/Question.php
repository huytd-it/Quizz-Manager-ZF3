<?php
namespace Question\Model;


class Question {
    //`id`, `noi_dung`, `id_linh_vuc`, `phuong_an_A`, `phuong_an_B`, 
    //`phuong_an_C`, `phuong_an_D`, `dap_an`, `trang_thai`, `deleted_at`, `created_at`, `updated_at

    public $id;
    public $noi_dung;
    public $id_linh_vuc;
    public $phuong_an_A;
    public $phuong_an_B;
    public $phuong_an_C;
    public $phuong_an_D;
    public $dap_an;
    public $trang_thai;
    public $deleted_at;
    public $created_at;
    public $updated_at;

    public function exchangeArray(array $data)
    {
         $this->id =!empty($data['id'])?$data['id']:null;
         $this->noi_dung=!empty($data['noi_dung'])?$data['noi_dung']:null;
         $this->id_linh_vuc=!empty($data['id_linh_vuc'])?$data['id_linh_vuc']:null;
         $this->phuong_an_A=!empty($data['phuong_an_A'])?$data['phuong_an_A']:null;
         $this->phuong_an_B=!empty($data['phuong_an_B'])?$data['phuong_an_B']:null;
         $this->phuong_an_C=!empty($data['phuong_an_C'])?$data['phuong_an_C']:null;
         $this->phuong_an_D=!empty($data['phuong_an_D'])?$data['phuong_an_D']:null;
         $this->dap_an=!empty($data['dap_an'])?$data['dap_an']:null;
         $this->trang_thai=!empty($data['trang_thai'])?$data['trang_thai']:null;
         $this->deleted_at=!empty($data['deleted_at'])?$data['deleted_at']:null;
         $this->created_at=!empty($data['created_at'])?$data['created_at']:null;
         $this->updated_at=!empty($data['updated_at'])?$data['updated_at']:null;

    }



}