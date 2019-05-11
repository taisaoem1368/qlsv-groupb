<?php
use LaravelAcl\Authentication\Classes\Menu\SentryMenuFactory;

/**
 *  Comment sidebar
 */
View::composer(['laravel-authentication-acl::admin.comments.*'], function ($view)
{
    $view->with('sidebar_items', [
            "Permissions list" => [
                    'url'  => URL::route('permission.list'),
                    "icon" => '<i class="fa fa-lock"></i>'
            ],
            "Add permission"   => [
                    'url'  => URL::route('permission.edit'),
                    "icon" => '<i class="fa fa-plus-circle"></i>'
            ]
    ]);
});