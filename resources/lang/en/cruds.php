<?php

return [
    'userManagement'    => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'        => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'              => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'organization'               => 'Organization',
            'organization_helper'        => '',
            'organization_domain'               => 'Organization Domain',
            'organization_domain_helper'        => '',
        ],
    ],
    'company_user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'joining_date'             => 'Joining Date',
            'joining_date_at_helper'   => '',
            'status'                   => 'Status',
            'status_helper'          => '',
        ],
    ],
    'dashboard'              => [
        'title'          => 'Dashboard',
        'title_singular' => 'Dashboard',
        'fields'         => [
            
        ],
    ],
    'log'              => [
        'title'          => 'Logs',
        'title_singular' => 'Log',
        'fields'         => [
            'date'                       => 'Date',
            'date_helper'                => '',

            'user'                       => 'User',
            'user_helper'                => '',

            'company'                    => 'Company',
            'company_helper'             => '',

            'action'                     => 'Action',
            'action_helper'              => '',

            'effeted_user'                => 'Effected User',
            'effeted_user_helper'         => '',

            'effected_user_company'       => "Effected User's Company",
            'effected_user_company_helper'=> '',
        ],
    ],
];
