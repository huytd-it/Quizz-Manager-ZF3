<?php

namespace Users\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\Regex;
use Laminas\Validator\StringLength;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setAttributes([
            'name' => 'user-form',
            'class' => 'form-horizontal'

        ]);
        
        $this->addElement();
        $this->validators();
    }
    public function addElement()
    {
        //ten_dang_nhap
        $this->add([
            'type' => 'text',
            'name' => 'ten_dang_nhap',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập tên người chơi',
                'id' => 'ten_dang_nhap',
            ],
            'options' => [
                'label' => 'Tên người chơi',
                'label_attributes' => [
                    'for' => 'ten_dang_nhap',
                    'class' => 'col-md-12 control-label'
                ],

            ]
        ]);
        //mat_khau
        $this->add([
            'type' => 'text',
            'name' => 'mat_khau',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập mật khẩu',
                'id' => 'ten_dang_nhap',
            ],
            'options' => [
                'label' => 'Mật khẩu',
                'label_attributes' => [
                    'for' => 'ten_dang_nhap',
                    'class' => 'col-md-12 control-label'
                ],

            ]
        ]);
        //ghi nhớ
        $this->add([
            'type' => Element\Checkbox::class,
            'name' => 'ghi_nho',
            'attributes' => [
                'id' => 'ghi_nho'
            ],
            'options' => [
                'label' => 'Remember me',
                'label_attributes' => [
                    'for' => 'ghi_nho',
                    'class' => 'col-md-12 control-label',
                ]
            ]
        ]);
        //Button 
        $this->add([
            'type' => 'submit',
            'name' => 'btnSubmit',
            'attributes' => [
                'class' => 'btn btn btn-outline-success',
                'value' => 'Đăng nhập',
            ],
        ]);
    }
    public function validators()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
        //username
        $inputFilter->add([
            'name' => 'ten_dang_nhap',
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
                            NotEmpty::IS_EMPTY => 'Username không được để rỗng',

                        ],
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'break_chain_on_failure' => true,
                        'min' => 8,
                        'max' => 50,
                        'messages' => [
                            StringLength::TOO_SHORT => 'Tên đăng nhập ít nhất %min% kí tự',
                            StringLength::TOO_LONG => 'Tên đăng nhập nhiều nhất %min% kí tự',

                        ]
                    ]
                ]
            ]
        ]);
        //password & confirm password

        //password
        $inputFilter->add([
            'name' => 'mat_khau',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines']

            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'break_chain_on_failure' => true,
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Password không được để rỗng',

                        ],
                    ]
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'break_chain_on_failure' => true,
                        'min' => 8,
                        'max' => 20,
                        'messages' => [
                            StringLength::TOO_SHORT => 'Mật khẩu ít nhất %min% kí tự',
                            StringLength::TOO_LONG => 'Mật khẩu nhiều nhất %max% kí tự',

                        ]
                    ]
                ],

            ]
        ]);
        $inputFilter->add([
            'name' => 'ghi_nho',
            'require' => 'false',
            'validators' => [
                [
                    'name' => 'InArray',
                    'options' => [
                        'haystack' => [0, 1],
                        'messages' => [
                            InArray::NOT_IN_ARRAY => 'Dữ liệu không hợp lệ',
                        ]
                    ]
                ]
            ]
        ]);
    }
}
