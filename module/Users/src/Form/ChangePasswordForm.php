<?php

namespace Users\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Identical;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\Regex;
use Laminas\Validator\StringLength;


class ChangePasswordForm extends Form
{
    private $action;
    public function __construct($action = 'changePw')
    {
        $this->action = $action;
        parent::__construct();
        $this->setAttributes([
            'name' => 'change-form',
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ]);
        $this->addElements();
        $this->setValidator();
    }
    public function addElements()
    {
        if ($this->action == 'changePw') {
            //old pw
            $this->add([
                'type' => 'password',
                'name' => 'old_pw',
                'options' => [
                    'label' => 'Mật khẩu cũ',
                    'label_attributes' => [
                        'class' => 'col-md-3'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập mật khẩu cũ',
                ]
            ]);
        }

        //new pw
        $this->add([
            'type' => 'password',
            'name' => 'new_pw',
            'options' => [
                'label' => 'Mật khẩu mới',
                'label_attributes' => [
                    'class' => 'col-md-3'
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập mật khẩu mới',
            ]
        ]);

        //confirm new pw
        $this->add([
            'type' => 'password',
            'name' => 'confirm_new_pw',
            'options' => [
                'label' => 'Nhập lại mật khẩu mới',
                'label_attributes' => [
                    'class' => 'col-md-3'
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Nhập lại mật khẩu mới',
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
        if ($this->action == 'changePw') {
            //password
            $inputFilter->add([
                'name' => 'old_pw',
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
        }

        $inputFilter->add([
            'name' => 'new_pw',
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
            'name' => 'confirm_new_pw',
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
                        'token' => 'new_pw',
                        'messages' => [
                            Identical::NOT_SAME => 'Mật khẩu phải giống nhau',
                            Identical::MISSING_TOKEN => 'Missing Token',
                        ]
                    ]
                ]
            ]
        ]);
        //confirm_pw

    }
}
