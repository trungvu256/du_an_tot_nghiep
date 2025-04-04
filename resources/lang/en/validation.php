<?php

return [
    'accepted' => ':attribute phải được chấp nhận.',
    'accepted_if' => ':attribute phải được chấp nhận khi :other là :value.',
    'active_url' => ':attribute không phải là một URL hợp lệ.',
    'after' => ':attribute phải là một ngày sau :date.',
    'after_or_equal' => ':attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ được chứa chữ cái.',
    'alpha_dash' => ':attribute chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => ':attribute chỉ được chứa chữ cái và số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là một ngày trước :date.',
    'before_or_equal' => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ':attribute phải nằm giữa :min và :max.',
        'file' => ':attribute phải có dung lượng từ :min đến :max kilobytes.',
        'string' => ':attribute phải có từ :min đến :max ký tự.',
        'array' => ':attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean' => ':attribute phải là true hoặc false.',
    'confirmed' => ':attribute xác nhận không khớp.',
    'current_password' => 'Mật khẩu không chính xác.',
    'date' => ':attribute không phải là ngày hợp lệ.',
    'date_equals' => ':attribute phải là ngày bằng :date.',
    'date_format' => ':attribute không đúng định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải có :digits chữ số.',
    'digits_between' => ':attribute phải có từ :min đến :max chữ số.',
    'email' => ':attribute phải là một địa chỉ email hợp lệ.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là một tệp tin.',
    'image' => ':attribute phải là một hình ảnh.',
    'in' => ':attribute không hợp lệ.',
    'integer' => ':attribute phải là một số nguyên.',
    'max' => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file' => ':attribute không được lớn hơn :max kilobytes.',
        'string' => ':attribute không được dài hơn :max ký tự.',
        'array' => ':attribute không được có nhiều hơn :max phần tử.',
    ],
    'min' => [
        'numeric' => ':attribute phải tối thiểu là :min.',
        'file' => ':attribute phải có tối thiểu :min kilobytes.',
        'string' => ':attribute phải có tối thiểu :min ký tự.',
        'array' => ':attribute phải có tối thiểu :min phần tử.',
    ],
    'numeric' => ':attribute phải là một số.',
    'regex' => ':attribute có định dạng không hợp lệ.',
    'required' => ':attribute không được để trống.',
    'string' => ':attribute phải là một chuỗi.',
    'unique' => ':attribute đã tồn tại.',
    'url' => ':attribute phải là một URL hợp lệ.',
    'uuid' => ':attribute phải là UUID hợp lệ.',

    'custom' => [
        'password' => [
            'min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ],
        'email' => [
            'unique' => 'Email này đã được sử dụng.',
        ],
    ],

    'attributes' => [
    ],
];
