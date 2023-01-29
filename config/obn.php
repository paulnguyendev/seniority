<?php
return [
    'prefix' => [
        'admin' => 'admin',
        'admin_auth' => 'admin/auth',
        'user' => 'user',
        'auth' => 'user/auth',
        'homepage' => '',
        'code' => 'SM',
    ],
    'mail' => [
        'from' => 'tinidev.com@gmail.com',
        'brand' => 'Seniority',
        'subject' => [
            'register_user' => 'Thông Tin Xác Thực Tài Khoản',
            'verify_user' => 'Account Verification Information',
        ],
    ],
    'brand' => [
        'color_main' => "#04befe",

    ],
    'status' => [
        'setting' => [
            'order' => 'new',
            'user' => 'pending',
            'payment' => 'pending',
        ],
        'template' => [
            'pending' => [
                'name' => 'Pending',
                'class' => 'badge-soft-warning',
            ],
            'active' => [
                'name' => 'Activated',
                'class' => 'badge-soft-success',
            ],
            'new' => [
                'name' => 'Đơn hàng mới',
                'class' => 'badge-soft-warning',
            ],
            'shipping' => [
                'name' => 'Đang vận chuyển',
                'class' => 'badge-soft-warning',
            ],
            'confirm' => [
                'name' => 'Đã xác nhận',
                'class' => 'badge-soft-info',
            ],
            'complete' => [
                'name' => 'Complete',
                'class' => 'badge-soft-success',
            ],
            'cancel' => [
                'name' => 'Cancel',
                'class' => 'badge-soft-danger',
            ],
            'default' => [
                'name' => 'Undefined',
                'class' => 'badge-info',
            ],
            'approve_success' => [
                'name' => 'Approved',
                'class' => 'badge-success',
            ],
        ],
    ],
    'ticket' => [
        'status' => [
            'pending' => ['name' => 'Chờ xử lý', 'class' => "bg-warning"],
            'receive' => ['name' => 'Đã tiếp nhận', 'class' => "bg-success"],
            'process' => ['name' => 'Đang xử lý', 'class' => "bg-info"],
            'cancel' => ['name' => 'Đã hủy', 'class' => "bg-danger"],
            'replied'    => ['name' => 'Đã trả lời', 'class' => "bg-info"],
            'complete'    => ['name' => 'Đã xử lý', 'class' => "bg-success"],
            'default' => [
                'name' => 'Chưa xác định',
                'class' => 'badge-info',
            ],
        ],
        'type' => [
            'team' => ['name' => 'Đội nhóm'],
            'product' => ['name' => 'Sản phẩm'],
            'order' => ['name' => 'Đơn hàng'],
            'customer' => ['name' => 'Khách hàng'],
            'income' => ['name' => 'Doanh thu'],
        ],
    ],
];
