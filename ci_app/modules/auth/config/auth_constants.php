<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('AUTH_UNAUTHENTICATED', -1);

define('AUTH_ROLES_ALL', 'all');

define('AUTH_LEVEL_ADMIN', 1);
define('AUTH_LEVEL_USER', 2);
define('AUTH_LEVEL_GUEST', 3);

define('AUTH_LEVEL_ADMIN_LABEL', 'Quản trị');
define('AUTH_LEVEL_USER_LABEL', 'Người dùng');
define('AUTH_LEVEL_GUEST_LABEL', 'Khách');

define('AUTH_USERS_ADMIN_BASE_URL', '/dashboard/auth');
define('AUTH_USERS_ADMIN_ADD_URL', '/dashboard/auth/add');
define('AUTH_USERS_ADMIN_EDIT_URL', '/dashboard/auth/edit');
define('AUTH_USERS_ADMIN_DELETE_URL', '/dashboard/auth/delete');
define('AUTH_USERS_ADMIN_UP_URL', '/dashboard/auth/up');

define('AUTH_USERS_ADMIN_POST_PER_PAGE', 20);

define('AUTH_ROLES_ADMIN_BASE_URL', '/dashboard/auth/roles');
define('AUTH_ROLES_ADMIN_ADD_URL', '/dashboard/auth/roles/add');
define('AUTH_ROLES_ADMIN_EDIT_URL', '/dashboard/auth/roles/edit');
define('AUTH_ROLES_ADMIN_DELETE_URL', '/dashboard/auth/roles/delete');
define('AUTH_ROLES_ADMIN_UP_URL', '/dashboard/auth/roles/up');

define('AUTH_ROLES_ADMIN_POST_PER_PAGE', 20);

define('AUTH_ROLES_MENUS_ADMIN_BASE_URL', '/dashboard/auth/roles_menus');
define('AUTH_ROLES_MENUS_ADMIN_ADD_URL', '/dashboard/auth/roles_menus/add');
define('AUTH_ROLES_MENUS_ADMIN_EDIT_URL', '/dashboard/auth/roles_menus/edit');
define('AUTH_ROLES_MENUS_ADMIN_DELETE_URL', '/dashboard/auth/roles_menus/delete');
define('AUTH_ROLES_MENUS_ADMIN_UP_URL', '/dashboard/auth/roles_menus/up');

define('AUTH_ROLES_MENUS_ADMIN_POST_PER_PAGE', 20);
