<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Support\Str;

class DashboardHelper
{
    static public function getMenuItems() : array
    {
        $_menuitems = [];
        $_menuitems = [
            [
                'label' => __('Home'),
                'prefixIcon' => 'bx bxs-home',
                'route' => route('Admin.home'),
                'active' => request()->routeIs('Admin.home'),
                'can'   =>  'dashboard_access'
            ],
            [
                'label' => __('Users'),
                'prefixIcon' => 'bi bi-people',
                'route' => route('users.index'),
                'active' => request()->routeIs('users.*'),
                'can'   => 'user_access',
            ],
            [
                'label' => __('Audit Logs'),
                'prefixIcon' => 'bi bi-people',
                'route' => route('audit-logs.index'),
                'active' => request()->routeIs('audit-logs.index.*'),
                'can'   => 'user_access',
            ],
            
        ];
        return $_menuitems;
    }
}
?>