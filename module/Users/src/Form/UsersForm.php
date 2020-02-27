<?php

namespace Users\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\Regex;
use Laminas\Validator\StringLength;

class UsersForm extends Form
{
    private $action;

    public function __construct($action = "add")
    {
        parent::__construct();
        $this->setAttributes([
            'name' => 'user-form',
            'class' => 'form-horizontal'

        ]);
        $this->action = $action;
        $this->addElement();
        $this->validators();
    }
    public function addElement()
    {
        //username
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
                    'class' => 'col-md-3 control-label'
                ],

            ]
        ]);
        //highest-point
        $this->add([
            'type' => 'text',
            'name' => 'diem_cao_nhat',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập điểm cao nhất',
                'id' => 'diem_cao_nhat',
            ],
            'options' => [
                'label' => 'Điểm cao nhất ',
                'label_attributes' => [
                    'for' => 'diem_cao_nhat',
                    'class' => 'col-md-3 control-label'
                ],

            ]
        ]);
        //file
        $this->add([
            'type' => 'file',
            'name' => 'hinh_dai_dien',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Hình đại diện',
                'id' => 'hinh_dai_dien',
            ],
            'options' => [
                'label' => 'Hình đại diện ',
                'label_attributes' => [
                    'for' => 'hinh_dai_dien',
                    'class' => 'col-md-3 control-label'
                ],

            ]
        ]);
        //credit
        $this->add([
            'type' => 'text',
            'name' => 'credit',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập số credit',
                'id' => 'credit',
            ],
            'options' => [
                'label' => 'Nhập số credit',
                'label_attributes' => [
                    'for' => 'credit',
                    'class' => 'col-md-3 control-label'
                ],

            ]
        ]);
        //email
        $this->add([
            'type' => 'text',
            'name' => 'email',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập Email',
                'id' => 'email',
            ],
            'options' => [
                'label' => 'Email',
                'label_attributes' => [
                    'for' => 'email',
                    'class' => 'col-md-3 control-label'
                ],

            ]
        ]);
        //khi action == "add"
        if ($this->action == "add") {
            //password
            $this->add([
                'type' => 'text',
                'name' => 'mat_khau',
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập mật khẩu',
                    'id' => 'mat_khau',
                ],
                'options' => [
                    'label' => 'Nhập mật khẩu',
                    'label_attributes' => [
                        'for' => 'mat_khau',
                        'class' => 'col-md-3 control-label'
                    ],

                ]
            ]);
            //confirm_password
            $this->add([
                'type' => 'text',
                'name' => 'confirm_password',
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập lại mật khẩu',
                    'id' => 'confirm_password',
                ],
                'options' => [
                    'label' => 'Nhập mật khẩu',
                    'label_attributes' => [
                        'for' => 'confirm_password',
                        'class' => 'col-md-3 control-label'
                    ],

                ]
            ]);
        }

        //type = select, name=role
        // $this->add([
        //     'type' => 'select',
        //     'name' => 'role',
        //     'attributes' => [
        //         'class' => 'form-control',
        //         'id' => 'role',
        //     ],
        //     'options' => [
        //         'label' => 'Role(s)',
        //         'label_attributes' => [
        //             'for' => 'role',
        //             'class' => 'col-md-3 control-label',
        //         ],
        //         'value_options' => [
        //             'admin' => 'Admin',
        //             'customer' => 'Khách hàng',
        //             'guest' => 'Khách',
        //             'staff' => 'Nhân viên',
        //             'editor' => 'Biên tập',
        //         ],
        //     ],
        // ]);
        //Radio, Name = trang_thai
        $this->add([
            'type' => 'checkbox',
            'name' => 'trang_thai',
            'attributes' => [
                //'class' => 'form-control',
                'id' => 'trang_thai'
            ],
            'options' => [
                'label' => 'Kích hoạt',
                'label_attributes' => [
                    'for' => 'trang_thai',
                    'class' => 'col-md-3 control-label',
                ],

            ]
        ]);

        //Button 
        $this->add([
            'type' => 'submit',
            'name' => 'btnSubmit',
            'attributes' => [
                'class' => 'btn btn-info',
                'value' => 'Save',
            ],
        ]);
        //Radio
        // $this->add([
        //     'type' => 'radio',
        //     'name' => 'gender',
        //     'attributes' => [
        //         'id' => 'gender',
        //         'value' => 'nam',

        //     ],
        //     'options' => [
        //         'label' => 'Giới tính',
        //         'label_attributes' => ['class' => 'form-control'],
        //         'value_options' => [
        //             '0' => 'Nữ',
        //             '1' => 'Nam',
        //             '2' => 'Khác'
        //         ],

        //     ]
        // ]);
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
        if ($this->action == "add") {
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
                                StringLength::TOO_LONG => 'Mật khẩu nhiều nhất %min% kí tự',

                            ]
                        ]
                    ],
                    [
                        'name' => 'Regex',
                        'options' => [
                            'break_chain_on_failure' => true,
                            'pattern' => '/[!@#$%^&]/',
                            'messages' => [
                                Regex::INVALID => 'Pattern %pattern% không chính xác',
                                Regex::NOT_MATCH => 'Mật khẩu phải chứa các kí tự %pattern%',
                                Regex::ERROROUS => 'Có lỗi nội bộ với pattern',
                            ]
                        ]

                    ]
                ]
            ]);
            //cofirm_password
            $inputFilter->add([
                'name' => 'confirm_password',
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
                                NotEmpty::IS_EMPTY => 'Mật khẩu không được để rỗng',

                            ]
                        ]
                    ],
                    [
                        'name' => 'Identical',
                        'options' => [
                            'break_chain_on_failure' => true,
                            'token' => 'mat_khau',
                            'messages' => [
                                Identical::NOT_SAME => 'Mật khẩu phải giống nhau',
                                Identical::MISSING_TOKEN => 'Missing Token',
                            ]
                        ]
                    ]
                ]
            ]);
        }

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
    }
}
