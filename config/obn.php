<?php
return [
    'prefix' => [
        'admin' => 'admin',
        'admin_auth' => 'admin/auth',
        'user' => 'user',
        'auth' => 'user/auth',
        'homepage' => '',
        'code' => 'SM',
        'application_code' => 'SMA',
    ],
    'license' => [
        'prefix' => 'ambassador',
        'prefix_group' => 'mortgage',
        'title' => 'MORTGAGE AMBASSADOR',
    ],
    'non_license' => [
        'prefix' => 'ambassador',
        'prefix_group' => 'community',
        'title' => 'COMMNNITY AMBASSADOR',
    ],
    'mail' => [
        'from' => 'anhnnd.hotro@gmail.com',
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
                'class' => 'badge-success',
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
            'open' => [
                'name' => 'Open',
                'class' => 'badge-soft-primary',
            ],
            'complete ' => [
                'name' => 'Complete ',
                'class' => 'badge-soft-success',
            ],
            'incomplete ' => [
                'name' => 'In Complete ',
                'class' => 'badge-soft-warning',
            ],
            'waiting_for_approval' => [
                'name' => 'Waiting For Approval ',
                'class' => 'badge-soft-primary',
            ],
            'deny' => [
                'name' => 'Deny ',
                'class' => 'badge-soft-danger',
            ],
            'approve' => [
                'name' => 'Approve',
                'class' => 'badge-soft-success',
            ],
            'closed' => [
                'name' => 'Closed',
                'class' => 'badge-info',
            ],
            'suspended' => [
                'name' => 'Suspended',
                'class' => 'badge-danger',
            ],
            'trash' => [
                'name' => 'Trash',
                'class' => 'badge-danger',
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
    'agent_type' => [
        'licensed' => [
            'name' => 'Licensed',
            'class' => 'badge-soft-warning',
        ],
        'non-licensed' => [
            'name' => 'Non Licensed',
            'class' => 'badge-soft-primary',
        ],
    ],
    'application' => [
        'open' => [
            'name' => 'Open',
            'class' => 'badge-soft-warning',
        ],
        'complete' => [
            'name' => 'Complete ',
            'class' => 'badge-soft-success',
        ],
        'incomplete' => [
            'name' => 'Incomplete ',
            'class' => 'badge-soft-warning',
        ],
        'waiting_for_approval' => [
            'name' => 'Waiting For Approval ',
            'class' => 'badge-soft-primary',
        ],
        'deny' => [
            'name' => 'Deny ',
            'class' => 'badge-soft-danger',
        ],
        'approve' => [
            'name' => 'Approve',
            'class' => 'badge-soft-success',
        ],
        'closed' => [
            'name' => 'Closed',
            'class' => 'badge-soft-dark',
        ],
    ],
    'lead' => [
        'pending' => [
            'name' => 'Pending',
            'class' => 'badge-soft-warning',
        ],
        'active' => [
            'name' => 'Active',
            'class' => 'badge-soft-success',
        ],
    ],
    'loans' => [
        'complete' => [
            'name' => 'Complete ',
            'class' => 'badge-soft-success',
        ],
        'incomplete' => [
            'name' => 'Incomplete ',
            'class' => 'badge-soft-warning',
        ],
    ],
    'ambassador' => [
        'pending' => [
            'name' => 'Pending',
        ],
        'active' => [
            'name' => 'Active',
        ],
        'suspended' => [
            'name' => 'Suspended',
        ],
        'trash' => [
            'name' => 'Trash',
        ],
        'deleted' => [
            'name' => 'Deleted',
        ],
    ],
];
