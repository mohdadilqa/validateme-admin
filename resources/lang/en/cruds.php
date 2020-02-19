<?php

return [
    'userManagement'    => [
        'title'          => 'User Management',
        'title_singular' => 'User Management',
    ],
    'permission'        => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            's_no'              => 'S.No',
            'title'             => 'Title',
            'created_at'        => 'Created Date',
            'updated_at'        => 'Updated Date',
            'deleted_at'        => 'Deleted Date',
        ],
        'messages'                      =>[
            'success_add'                   =>'Permission has been added successfully.',
            'success_edit'                  =>'Permission has been updated successfully.',
            'success_delete'                =>'Permission has been deleted successfully.',
            'permission_duplicate'          =>'Permisssion has already created.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View Permission',
            'update'                        =>'Update Permission',
            'delete'                        =>'Delete Permission'
        ]
    ],
    'role'              => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            's_no'               => 'S.No',
            'title'              => 'Title',
            'permissions'        => 'Permissions',
            'created_at'         => 'Created Date',
            'updated_at'         => 'Updated Date',
            'deleted_at'         => 'Deleted Date',
        ],
        'messages'                      =>[
            'success_add'                   =>'Role has been added successfully.',
            'success_edit'                  =>'Role has been updated successfully.',
            'success_delete'                =>'Role has been deleted successfully.',
            'role_duplicate'                =>'Role has already created.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View Role',
            'update'                        =>'Update Role',
            'delete'                        =>'Delete Role'
        ]
    ],
    'user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            's_no'                     => 'S.No',
            'name'                     => 'Name',
            'email'                    => 'Email',
            'email_verified_at'        => 'Email verified at',
            'password'                 => 'Password',
            'roles'                    => 'Roles',
            'remember_token'           => 'Remember Token',
            'created_at'               => 'Created Date',
            'updated_at'               => 'Updated Date',
            'deleted_at'               => 'Deleted Date',
            'organization'             => 'Organization',
            'organization_domain'      => 'Organization Domain',
            'default_company'          => 'Validate Me'
        ],
        'messages'                      =>[
            'success_add'                   =>'User has been added successfully.',
            'success_edit'                  =>'User has been updated successfully.',
            'success_delete'                =>'User has been deleted successfully.',
            'email_duplicate'               =>'User has been already registered with this email. Please try with another email.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View User',
            'update'                        =>'Update User',
            'delete'                        =>'Delete User'
        ]
    ],
    'company_user'              => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            's_no'                     => 'S.No',
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
        'heading'        => 'Welcome To Validate Me Dashboard',
        'heading_text'   => 'Manage your users and check their activity here',
        'fields'         => [ 
        ],
    ],
    'log'              => [
        'title'          => 'Activity Logs',
        'title_singular' => 'Activity Log',
        'fields'         => [
            'date'                       => 'Date',
            'user'                       => 'User',
            'company'                    => 'Company',
            'action'                     => 'Action',
            'effeted_user'                => 'Effected User',
            'effected_user_company'       => "Effected User's Company",
        ],
    ],
    'docTypeManagement'    => [
        'title'          => 'Doc Management',
        'title_singular' => 'Doc Management',
    ],
    'refdata'              => [
        'title'          => 'Reference Data',
        'title_singular' => 'Reference Data',
        'fields'         => [
            'id'                       => 'ID',
            's_no'                     => 'S.No',
            'title'                    => 'Title',
            'RDT_key'                  => 'Reference Data Type Key',
            'code'                     => 'Code',
            'created_date'             => 'Created Date',
            'updated_date'             => 'Updated Date',
            'upload'                   => 'Upload Reference Data',
            'download'                 => 'Download Reference Data'
        ],
        'messages'                      =>[
            'success_add'                   =>'Reference data has been added successfully.',
            'success_edit'                  =>'Reference data has been updated successfully.',
            'success_delete'                =>'Reference data has been deleted successfully.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View Reference Data',
            'update'                        =>'Update Reference Data',
            'delete'                        =>'Delete Reference Data'
        ]
    ],
    'refdatafield'              => [
        'title'          => 'Field Definition',
        'title_singular' => 'Field Definition',
        'fields'         => [
            'id'                       => 'ID',
            's_no'                     => 'S.No',
            'code'                     => 'Code',
            'code_helper'              => '',
            'title'                    => 'Title',
            'RDT_key'                  => 'Reference Data Type Key',
            'field_type'               => 'Field Type',
            'created_date'             => 'Created Date',
            'updated_date'             => 'Updated Date',
            'upload'                   => 'Upload Field Data',
            'download'                 => 'Download Field Data'
        ],
        'messages'                      =>[
            'success_add'                   =>'Reference field has been added successfully.',
            'success_edit'                  =>'Reference field has been updated successfully.',
            'success_delete'                =>'Reference field has been deleted successfully.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View Reference Field',
            'update'                        =>'Update Reference Field',
            'delete'                        =>'Delete Reference Field'
        ]
    ],
    'doctype'              => [
        'title'          => 'Document Definition',
        'title_singular' => 'Document Definition',
        'fields'         => [
            'id'                       => 'ID',
            's_no'                     => 'S.No',
            'name'                     => 'Name',
            'ref_data_field'           => 'Reference Data Field',
            'name_rule'                => 'Name Rule',
            'category'                 => 'Category',
            'created_date'             => 'Created Date',
            'updated_date'             => 'Updated Date',
        ],
        'messages'                      =>[
            'success_add'                   =>'Document has been added successfully.',
            'success_edit'                  =>'Document has been updated successfully.',
            'success_delete'                =>'Document has been deleted successfully.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View Document',
            'update'                        =>'Update Document',
            'delete'                        =>'Delete Document'
        ]
    ],
    'refdatafield'              => [
        'title'          => 'Field Definition',
        'title_singular' => 'Field Definition',
        'fields'         => [
            'id'                       => 'ID',
            's_no'                     => 'S.No',
            'code'                     => 'Code',
            'code_helper'              => '',
            'title'                    => 'Title',
            'RDT_key'                  => 'Reference Data Type Key',
            'field_type'               => 'Field Type',
            'created_date'             => 'Created Date',
            'updated_date'             => 'Updated Date',
            'upload'                   => 'Upload Field Data',
            'download'                 => 'Download Field Data'
        ],
        'messages'                      =>[
            'success_add'                   =>'Reference field has been added successfully.',
            'success_edit'                  =>'Reference field has been updated successfully.',
            'success_delete'                =>'Reference field has been deleted successfully.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ],
        'tooltip'                      =>[
            'view'                          =>'View Reference Field',
            'update'                        =>'Update Reference Field',
            'delete'                        =>'Delete Reference Field'
        ]
    ],
    'forgotpassword'              => [
        'title'          => 'Forgot Password',
        'title_singular' => 'Forgot Password',
        'messages'                      =>[
            'success'                       =>'Reset password link has been sent.',
            'email_empty'                   =>'Email can not be empty.',
            'email_not_found'               =>'Email is not regisetered.',
            'error'                         =>'Error. Please try again.',
            'exception'                     =>'Excetption. Please try again',
        ]
    ],
];
