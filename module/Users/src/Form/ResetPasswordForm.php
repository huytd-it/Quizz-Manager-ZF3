<?php

namespace Users\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;


class ResetPasswordForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setAttributes([
            'name' => 'reset-form',
            'class' => 'form-horizontal',
        ]);
        $this->addElements();
        $this->setValidator();
    }
    public function addElements()
    {

        //confirm new pw
        $this->add([
            'type' => 'email',
            'name' => 'email',
            'options' => [
                'label' => 'Nhập email:',
                'label_attributes' => [
                    'class' => 'col-md-3'
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập email',
            ]
        ]);
        //csrf
        $this->add([
            'type' => Element\Csrf::class,
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600,
                ]

            ]
        ]);
        $this->add([
            'type' => Element\Captcha::class,
            'name' => 'captcha_image',
            'style' => 'display:block',
            'options' => [
                'label' => 'Nhập chuổi bên dưới',
                'label_attributes' => [
                    'class' => 'col-md-3'  
                ],
                'captcha' => [
                    'class' => 'Image',
                    'imgDir' => 'public/img/captcha',//Đường dẫn chính xác lưu đường dẫn
                    'suffix' => '.png',
                    'imgUrl' =>  RESOURCE_LINK.'/img/captcha',
                    'font' => APPLICATION_PATH . '/data/font/Anton-Regular.ttf',
                    'fsize' => 50,
                    'width' => 400,
                    'height' => 150,
                    'dotNoiseLevel' => 300,
                    'lineNoiseLevel' => 5,
                    'expiration' => 600,
                    'messages' => [
                        \Laminas\Captcha\Image::BAD_CAPTCHA => 'Giá trị biểu mẫu không đúng',
                    ]
                ]
            ]
        ]);
        //btnSubmit
        $this->add([
            'type' => 'submit',
            'name' => 'btnSubmit',
            'attributes' => [
                'class' => 'btn btn-primary',
                'value' => 'Thay đổi'
            ]
        ]);
    }
    public function setValidator()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
       
        //email
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StringToLower'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines']

            ],
            'validators' => [

                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'break_chain_on_failure' => true,
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Email không được để trống'
                        ]
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'break_chain_on_failure' => true,
                        'max' => 50,
                        'min' => 10,
                        'messages' => [
                            StringLength::TOO_LONG => 'Email nhiều nhất là %max% kí tự',
                            StringLength::TOO_SHORT => 'Email ít nhất là %min% kí tự',
                        ]
                    ]
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'messages' => [
                            EmailAddress::INVALID_FORMAT => 'Email không đúng định dạng',
                            EmailAddress::INVALID_HOSTNAME => 'Hostname không được hổ trợ',
                        ]
                    ]
                ],

            ]
        ]);
        //confirm_pw

    }
}
