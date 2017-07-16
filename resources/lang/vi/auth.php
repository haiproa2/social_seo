<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    /* Form Login */
    'placeholder_login' => 'Tài khoản hoặc Email',
    'placeholder_password' => 'Mật khẩu',
    'placeholder_password_confirm' => 'Nhắc lại mật khẩu',
    'text_remember' => 'Ghi nhớ đăng nhập',
    'btn_login' => 'Đăng nhập',
    'btn_register' => 'Đăng ký',
    'btn_foget_password' => 'Gửi yêu cầu lấy lại mật khẩu',
    'btn_create_password' => 'Tạo mật khẩu mới',
    'anchor_forgot_pass' => 'Quên mật khẩu?',
    'anchor_register' => 'Đăng ký',
    'anchor_login' => 'Đăng nhập',
    'placeholder_name' => 'Họ và tên',
    'placeholder_username' => 'Tài khoản',
    'placeholder_email' => 'Địa chỉ Email',
    'validate_field_login' => 'Vui lòng nhập tài khoản hoặc Email!',
    'validate_field_password' => 'Không được để trống mật khẩu!',

    'failed' => 'Thông tin đăng nhập không đúng, vui lòng thử lại.',
    'disable' => 'Tài khoản tạm khóa, vui lòng liên hệ <a href="mailto: minhhai.dw@gmail.com?subject=Yêu cầu kích hoạt tài khoản [:login]">minhhai.dw@gmail.com</a>!',
    'throttle' => 'Đặng nhập lỗi quá nhiều lần. Vui lòng thử lại sau :seconds giây.',

    /* Form register */
    'required_name' => 'Vui lòng nhập Họ và Tên.',
    'required_username' => 'Vui lòng nhập tài khoản đăng nhập.',
    'required_password' => 'Vui lòng nhập mật khẩu.',
    'unique_username' => 'Tài khoản đăng nhập đã tồn tại.',
    'required_email' => 'Vui lòng điền Email đăng nhập.',
    'unique_email' => 'Địa chỉ Email đã được sử dụng.',
    'same_password' => 'Mật khẩu và nhắc lại mật khẩu chưa trùng khớp.',
    'register_success' => 'Chúc mừng <b>:name</b>, bạn đã là thành viên của website.<br/>Vui lòng <b><a href=":redirect">bấm vào đây</a></b> nếu sau :second giây trình duyệt không tự động chuyển về trang chính.',

    'checkmail' => 'Địa chỉ Email không đúng.',
    'min' => [
        'numeric' => 'Giá trị cần lớn hơn :min.',
        'file'    => 'File tối thiểu :min kilobytes(Kb).',
        'string'  => 'Trường này cần ít nhất :min ký tự.',
        'array'   => 'Mảng này cần tối thiểu :min phần tử.',
    ],
    'regex' => [
        'password' => 'Mật khẩu cần bao gồm chữ thường, chữ HOA, số và ký tự đặc biệt',
    ],
];
