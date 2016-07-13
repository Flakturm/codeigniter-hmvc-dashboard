<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "event";
$route['404_override'] = '';

//Settings
$route['admin/settings'] = 'settings';
$route['admin/settings/ajaxSave'] 	= "settings/ajaxSave";
$route['admin/settings/ajaxSendMail'] 	= "settings/ajaxSendMail";

//Events
$route['admin'] = 'events';
$route['admin/events'] = 'events';
$route['admin/events/add'] = 'events/add';
$route['admin/events/edit/(:any)'] = 'events/edit/$1';
$route['admin/events/preview/(:any)'] = 'events/preview/$1';

//Participants
$route['admin/participants'] = 'participants';
$route['admin/participants/add'] = 'participants/add';
$route['admin/participants/edit/(:any)'] = 'participants/edit/$1';
$route['admin/participants/pay/(:any)'] = 'participants/pay/$1';
$route['admin/participants/paid/(:any)'] = 'participants/paid/$1';
$route['admin/participants/feedback'] = 'participants/feedback';
$route['admin/participants/ajaxSendRequest'] = 'participants/ajaxSendRequest';
$route['admin/participants/ajaxPartUpdate'] = 'participants/ajaxPartUpdate';
$route['admin/participants/ajaxOtherPartUpdate'] = 'participants/ajaxOtherPartUpdate';

//Users
$route['admin/users'] = 'users';
$route['admin/users/add'] = 'users/add';
$route['admin/users/edit/(:any)'] = 'users/edit/$1';
$route['admin/users/account'] = 'users/edit';
$route['admin/users/delete/(:any)'] = 'users/delete/$1';
$route['admin/users/ajaxSave'] = 'users/ajaxSave';
$route['admin/users/ajaxUpdate'] = 'users/ajaxUpdate';

//Enquiries
$route['admin/enquiries'] = 'enquiries';
$route['admin/enquiries/add'] = 'enquiries/add';
$route['admin/enquiries/edit/(:any)'] = 'enquiries/edit/$1';
$route['admin/enquiries/ajaxUpdate'] = 'enquiries/ajaxUpdate';

//Custom routing
$route['admin/signin'] = 'users/signin';
$route['admin/logout'] = 'users/logout';
$route['admin/signin/ajaxSendPassword'] = 'users/ajaxSendPassword';


/* End of file routes.php */
/* Location: ./application/config/routes.php */