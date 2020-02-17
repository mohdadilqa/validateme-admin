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
            'id_helper'         => '',
            's_no'              => 'S.No',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
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
            'id_helper'          => '',
            's_no'               => 'S.No',
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
            'id_helper'                => '',
            's_no'                     => 'S.No',
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
            'organization'             => 'Organization',
            'organization_helper'      => '',
            'organization_domain'      => 'Organization Domain',
            'organization_domain_helper'=> '',
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
    'docTypeManagement'    => [
        'title'          => 'Doc Management',
        'title_singular' => 'Doc Management',
    ],
    'refdata'              => [
        'title'          => 'Reference Data',
        'title_singular' => 'Reference Data',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            's_no'                     => 'S.No',
            'title'                    => 'Title',
            'title_helper'             => '',
            'RDT_key'                  => 'Reference Data Type Key',
            'RDT_key_helper'           => '',
            'code'                     => 'Code',
            'code_helper'              => '',
            'created_date'             => 'Created Date',
            'created_date_helper'      => '',
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
            'id_helper'                => '',
            's_no'                     => 'S.No',
            'code'                     => 'Code',
            'code_helper'              => '',
            'title'                    => 'Title',
            'title_helper'             => '',
            'RDT_key'                  => 'Reference Data Type Key',
            'RDT_key_helper'           => '',
            'field_type'               => 'Field Type',
            'field_type_helper'        => '',
            'created_date'             => 'Created Date',
            'created_date_helper'      => '',
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
];
