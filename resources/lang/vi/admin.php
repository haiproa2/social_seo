<?php

return [
    'required' => 'Trường bắt buộc nhập.',
    'email' => 'Địa chỉ Email không chính xác.',
    'email_unique' => 'Địa chỉ Email đã được sử dụng.',
    'phone_unique' => 'Số điện thoại đã được sử dụng.',
    'max'                  => [
        'numeric' => 'Chỉ nhập số nhỏ hơn :max.',
        'file'    => 'Dung lượng tối đa cho phép :max kilobytes(Kb).',
        'string'  => 'Quá nhiều ký tự cho phép.',
        'array'   => 'Mảng chứa tối đa :max phần tử.',
    ],
    'min'                  => [
        'numeric' => 'Nhập số lớn hơn :min.',
        'file'    => 'Dung lượng tối thiểu cần :min kilobytes(Kb).',
        'string'  => 'Số lượng ký tự quá ngắn.',
        'array'   => 'Mảng cần ít nhất :min phần tử.',
    ],
];
