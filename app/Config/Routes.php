<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// API Routes
$routes->group('V1/api', function ($routes) {
    $routes->post('Registration', 'V1\Api::Registration');
    $routes->post('verifyOTP', 'V1\Api::verifyOTP');
    $routes->post('getLogin', 'V1\Api::getLogin');
    $routes->post('forgotPassword', 'V1\Api::forgotPassword');
    $routes->post('detailsSignup', 'V1\Api::detailsSignup');
    $routes->get('FetchData', 'V1\Api::FetchData');
    $routes->post('GetFeatureItems_Sale', 'V1\Api::GetFeatureItems_Sale');
    $routes->post('GetFeatureItems_Rent', 'V1\Api::GetFeatureItems_Rent');
    $routes->post('GetFeatureItems_Construction', 'V1\Api::GetFeatureItems_Construction');
    $routes->post('GetFeatureItems_Search', 'V1\Api::GetFeatureItems_Search');
    $routes->get('getSliders', 'V1\Api::getSliders');
    $routes->get('getCities', 'V1\Api::getCities');
    $routes->get('getBrands', 'V1\Api::getBrands');
    $routes->post('getPropertyDetails', 'V1\Api::getPropertyDetails');
    $routes->post('GetFeatureItems_Search_Lite', 'V1\Api::GetFeatureItems_Search_Lite');
    $routes->post('getPropertyDescription', 'V1\Api::getPropertyDescription');
    $routes->post('getLatestSearch', 'V1\Api::getLatestSearch');
    $routes->post('insertSaleProperty', 'V1\Api::insertSaleProperty');
    $routes->post('insertRentProperty', 'V1\Api::insertRentProperty');
    $routes->post('insertMortgageProfile', 'V1\Api::insertMortgageProfile');
    $routes->post('gds_tds_Calculation', 'V1\Api::gds_tds_Calculation');
    $routes->post('addScheduleTour', 'V1\Api::addScheduleTour');
    $routes->post('getSimillerListing', 'V1\Api::getSimillerListing');
    $routes->get('getFeaturesItems', 'V1\Api::getFeaturesItems');
    $routes->get('getNotifications', 'V1\Api::getNotifications');
    $routes->post('addFavourite', 'V1\Api::addFavourite');
    $routes->get('getFavourites', 'V1\Api::getFavourites');
    $routes->get('getPropertyFilter', 'V1\Api::getPropertyFilter');
    $routes->post('contactUs', 'V1\Api::contactUs');
    $routes->get('getAboutUs', 'V1\Api::getAboutUs');
    $routes->get('getPrivacyPolicy', 'V1\Api::getPrivacyPolicy');
    $routes->get('getTermsCondition', 'V1\Api::getTermsCondition');
    $routes->get('getContactUs', 'V1\Api::getContactUs');
    $routes->get('getProfileData', 'V1\Api::getProfileData');
    $routes->post('updateProfileData', 'V1\Api::updateProfileData');
     // Realtor Api
    $routes->group('realtor', function ($routes) {
        $routes->post('getLogin', 'V1\UserController::getLogin');
        $routes->post('updateProfile', 'V1\UserController::updateProfile');
        $routes->post('forgotPassword', 'V1\UserController::forgotPassword');
        $routes->get('getBirthdays', 'V1\UserController::getBirthdays');
        $routes->get('sendBirthdayNotification', 'V1\UserController::sendBirthdayNotification');
        $routes->post('addTask', 'V1\TaskController::addTask');
        $routes->get('getTasks', 'V1\TaskController::getTasks');
        $routes->post('updateTask', 'V1\TaskController::updateTask');
        // Note Panel
        $routes->post('addNote', 'V1\NoteController::addNote');
        $routes->get('getNotes', 'V1\NoteController::getNotes');
        $routes->post('updateNote', 'V1\NoteController::updateNote');
        $routes->post('deleteNote', 'V1\NoteController::deleteNote');
        // Visit List
        $routes->post('getVisitLists', 'V1\TaskController::getVisitLists');
        $routes->post('getVisitDetails', 'V1\TaskController::getVisitDetails');
        $routes->post('bids', 'V1\TaskController::changeBid');
        $routes->post('updateSchedule', 'V1\TaskController::updateSchedule');
        $routes->post('bid/add', 'V1\TaskController::changeBid');
        // HighLights  &  Earning
        $routes->get('getHighlights', 'V1\DashboardController::getHighlights');

        $routes->get('customerClassification/get', 'V1\DashboardController::getCustomerClassifications');
        $routes->post('customerClassification/update', 'V1\DashboardController::updateRealtorCustomerClassification');
        $routes->get('visit_status', 'V1\DashboardController::getVisitStatus');
        $routes->get('task_status', 'V1\DashboardController::getTaskStatus');
        $routes->get('getCustomerEarning', 'V1\DashboardController::getCustomerEarning');
        $routes->post('changeStatus', 'V1\TaskController::changeStatus');
        $routes->get('earning', 'V1\DashboardController::getRealtorEarning');
        $routes->get('getCustomerProfiles', 'V1\DashboardController::getCustomerProfiles');
        $routes->post('getPropertyList', 'V1\DashboardController::getPropertyList');
        $routes->post('addFavourite', 'V1\DashboardController::addFavourite');

    });
   
    

});
// Profile Routes
$routes->group('profile',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Dashboard::profile',['filter' => 'checkauth']);
    $routes->post('change-password', 'Dashboard::changePassword',['filter' => 'checkauth']);
    $routes->post('update-profile', 'Dashboard::updateProfile',['filter' => 'checkauth']);

});
// Dashboard Route
$routes->get('/', 'Dashboard::index',['filter' => 'checkauth']);
// Login Related Routes
$routes->get('login', 'Dashboard::login');
$routes->post('login-submit', 'Dashboard::loginStore');
// Logout
$routes->get('logout', 'Dashboard::logout',['filter' => 'checkauth']);
// Users Realted Routes
$routes->group('user',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'User::index');
    $routes->post('getAjaxData', 'User::ajaxView');
    $routes->get('add', 'User::add');
    $routes->post('store', 'User::store');
    $routes->post('status/(:any)/(:any)', 'User::ajaxDisable/$1/$2');
    $routes->post('checkEmail', 'User::checkEmail');
    $routes->post('getUsers', 'User::getUsers');
});

// City Related Routes
$routes->group('city',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'City::index');
    $routes->post('getAjaxData', 'City::ajaxView');
    $routes->get('add', 'City::add');
    $routes->post('store', 'City::store');
    $routes->get('edit/(:num)', 'City::edit/$1');
    $routes->post('update', 'City::update');
    $routes->post('status/(:any)/(:any)', 'City::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'City::ajaxDelete/$1');
});

// Task Status Related Routes
$routes->group('task_status',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'TaskStatusController::index');
    $routes->post('getAjaxData', 'TaskStatusController::ajaxView');
    $routes->get('add', 'TaskStatusController::add');
    $routes->post('store', 'TaskStatusController::store');
    $routes->get('edit/(:num)', 'TaskStatusController::edit/$1');
    $routes->post('update', 'TaskStatusController::update');
    $routes->post('status/(:any)/(:any)', 'TaskStatusController::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'TaskStatusController::ajaxDelete/$1');
});
// Visit Status Related Routes
$routes->group('visit_status',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'VisitStatusController::index');
    $routes->post('getAjaxData', 'VisitStatusController::ajaxView');
    $routes->get('add', 'VisitStatusController::add');
    $routes->post('store', 'VisitStatusController::store');
    $routes->get('edit/(:num)', 'VisitStatusController::edit/$1');
    $routes->post('update', 'VisitStatusController::update');
    $routes->post('status/(:any)/(:any)', 'VisitStatusController::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'VisitStatusController::ajaxDelete/$1');
});
// Customer Classifications Related Routes
$routes->group('customer_classification',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'CustomerClassificationController::index');
    $routes->post('getAjaxData', 'CustomerClassificationController::ajaxView');
    $routes->get('add', 'CustomerClassificationController::add');
    $routes->post('store', 'CustomerClassificationController::store');
    $routes->get('edit/(:num)', 'CustomerClassificationController::edit/$1');
    $routes->post('update', 'CustomerClassificationController::update');
    $routes->post('status/(:any)/(:any)', 'CustomerClassificationController::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'CustomerClassificationController::ajaxDelete/$1');
});

// System Option Routes
$routes->group('system_option',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Dashboard::system_option');
    $routes->post('update', 'Dashboard::system_option_update');
    });
// Slider Routes
$routes->group('slider',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Slider::index');
    $routes->post('getAjaxData', 'Slider::ajaxView');
    $routes->get('add', 'Slider::add');
    $routes->post('store', 'Slider::store');
    $routes->post('status/(:any)/(:any)', 'Slider::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'Slider::ajaxDelete/$1');
});
// Property Routes
$routes->group('property',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Property::index');
    $routes->post('getAjaxData', 'Property::ajaxView');
    $routes->post('status/(:any)/(:any)', 'Property::ajaxDisable/$1/$2');
    $routes->post('feature/(:any)/(:any)', 'Property::ajaxFeature/$1/$2');
    $routes->get('construction-property', 'Property::getPreconstruction_Property');
    $routes->get('add-preconstruction-property', 'Property::add_preconstruction_property');
    $routes->post('preconstruction_store', 'Property::preconstruction_store');
    $routes->post('getPreconstructionAjaxData', 'Property::getPreconstructionAjaxView');
    // Rent Property
    $routes->get('rent-property', 'Property::getRent_Property');
    $routes->post('getRentPropertyAjaxData', 'Property::getRentPropertyAjaxView');
    // Sale Property
    $routes->get('sale-property', 'Property::getSale_Property');
    $routes->post('getSalePropertyAjaxData', 'Property::getSalePropertyAjaxView');
});
// Brand Related Routes
$routes->group('brand',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Brand::index');
    $routes->post('getAjaxData', 'Brand::ajaxView');
    $routes->get('add', 'Brand::add');
    $routes->post('store', 'Brand::store');
    $routes->post('status/(:any)/(:any)', 'Brand::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'Brand::ajaxDelete/$1');
});
// Schedule Tour Related Routes
$routes->group('tour',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Tour::index');
    $routes->post('getAjaxData', 'Tour::ajaxView');
    $routes->post('assign_realtor/(:any)/(:any)', 'Tour::assignRealtor/$1/$2');
    $routes->post('confirmRequest/(:any)/(:any)', 'Tour::confirmRequest/$1/$2');
});
$routes->get('callback', 'Realtor::callback');
$routes->get('getAccessToken', 'Realtor::getAccessToken');
// Realtors Routes
$routes->group('realtor',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Realtor::index');
    $routes->post('getAjaxData', 'Realtor::AjaxView');
    $routes->get('add', 'Realtor::add');

    $routes->post('store', 'Realtor::store');
    $routes->post('checkEmail', 'Realtor::checkEmail');
    $routes->post('checkUsername', 'Realtor::checkUsername');
    $routes->get('edit/(:num)', 'Realtor::edit/$1');
    $routes->post('update', 'Realtor::update');
    $routes->post('status/(:any)/(:any)', 'Realtor::ajaxDisable/$1/$2');
    $routes->post('delete/(:num)', 'Realtor::ajaxDelete/$1');
    $routes->post('details/(:num)', 'Realtor::ajaxDetails/$1');
    $routes->post('getRealtors', 'Realtor::getRealtors');
});
// Realtors Routes
$routes->group('brokerage',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Brokerage::index');
    $routes->post('getAjaxData', 'Brokerage::AjaxView');
    $routes->get('add', 'Brokerage::add');
    $routes->post('store', 'Brokerage::store');
    $routes->post('checkEmail', 'Brokerage::checkEmail');

});
// Schedule Tour Related Routes
$routes->group('notification',['filter' => 'checkauth'], function ($routes) {
    $routes->get('/', 'Notification::index');
    $routes->post('getAjaxData', 'Notification::ajaxView');
    $routes->get('add', 'Notification::add');
    $routes->post('store', 'Notification::store');
    $routes->post('delete/(:num)', 'Notification::ajaxDelete/$1');
    $routes->get('edit/(:num)', 'Notification::edit/$1');
    $routes->post('update', 'Notification::update');
});

$routes->add('enqueue-tasks', 'EnqueueTasks::run');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * 
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
