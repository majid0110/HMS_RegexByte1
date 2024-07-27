<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'LoginController::show');
$routes->get('/session_expired', 'LoginController::session_expired');
$routes->post("/loginSave", 'LoginController::loginSave');
$routes->get('/dashboard', 'LoginController::dashboard');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/user_form', 'LoginController::user_form');
$routes->get('/business_table', 'LoginController::business_table');
$routes->post('/store', 'LoginController::store');
$routes->get('/role_form', 'LoginController::role_form');
$routes->post('/save_role', 'LoginController::save_role');
$routes->get('/user_form2', 'LoginController::user_form2');
$routes->post('/save_user', 'LoginController::save_user');

// $routes->get('/edit_role', 'LoginController::edit_role');
$routes->post('/update_role/(:num)', 'LoginController::update_role/$1');
$routes->get('/view_role', 'LoginController::view_role');
$routes->get('/edit_role/(:num)', 'LoginController::edit_role/$1');
// $routes->get('/role/edit/(:num)', 'LoginController::edit_role/$1');
$routes->get('/delete_role/(:num)', 'LoginController::delete_role/$1');

// $routes->post('role/update/(:num)', 'LoginController::updateRole/$1');
$routes->get('role/edit/(:num)', 'LoginController::editRole/$1');
$routes->post('/updateRole/(:num)', 'LoginController::updateRole/$1');

$routes->get('/users_table', 'LoginController::users_table');
$routes->get('/edit_user/(:num)', 'LoginController::edit_user/$1');
$routes->post('/update_user/(:num)', 'LoginController::update_user/$1');

$routes->get('/doctors_form', 'DoctorController::doctors_form');
$routes->get('/doctors_table', 'DoctorController::doctors_table');
$routes->get('/user_form1', 'LoginController::user_form1');
$routes->post('/saveDoctorProfile', 'DoctorController::saveDoctorProfile');
$routes->get('/doctors_fee', 'DoctorController::doctors_fee');

$routes->post('/Savedoctorsfee', 'DoctorController::Savedoctorsfee');

// $routes->get('/editDoctor', 'DoctorController::editDoctor');
// $routes->get('/deleteDoctor', 'DoctorController::deleteDoctor');
$routes->get('/editDoctor/(:num)', 'DoctorController::editDoctor/$1');
$routes->get('/deleteDoctor/(:num)', 'DoctorController::deleteDoctor/$1');

$routes->get('/appointments_form', 'DoctorController::appointments_form');
//-----------------------------------------------------------------clients Routes
$routes->post('ClientController/saveClientProfile', 'ClientController::saveClientProfile');

$routes->get('/clients_form', 'ClientController::clients_form');

$routes->get('/clients_table', 'ClientController::clients_table');
$routes->post('/saveClientProfile', 'ClientController::saveClientProfile');
$routes->get('/deleteClient/(:num)', 'ClientController::deleteClient/$1');
// $routes->get('/editClient/(:num)', 'ClientController::editClient/$1');
$routes->post('/Savedoctorsfee', 'DoctorController::Savedoctorsfee');
// $routes->get('ClientController/editClient/(:num)', 'ClientController::editClient/$1');
// $routes->get('ClientController/editClient/(:num)', 'ClientController::editClient/$1');
$routes->get('/editClient/(:num)', 'ClientController::editClient/$1');
$routes->post('/updateClient/(:num)', 'ClientController::updateClient/$1');
$routes->post('/updateClient/(:num)', 'ClientController::updateClient/$1');


//-------------------------------------------------------------------Appointments Routes
$routes->get('/appointments_form', 'ClientController::appointments_form');
// $routes->post('/saveAppointment', 'AppointmentController::saveAppointment');
$routes->get('/appointments_table', 'AppointmentController::appointments_table');
$routes->get('/deleteAppointment/(:num)', 'AppointmentController::deleteAppointment/$1');
$routes->post('/saveClient', 'AppointmentController::saveClientProfile');
$routes->post('AppointmentController/saveAppointment', 'AppointmentController::saveAppointment');
$routes->post('AppointmentController/saveOpdAppointment', 'AppointmentController::saveOpdAppointment');


$routes->post('AppointmentController/printToken', 'AppointmentController::printToken');

$routes->group('appointment', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('fetchDoctorFee/(:num)/(:num)', 'AppointmentController::fetchDoctorFee/$1/$2');
});


$routes->get('/editDoctor/(:num)', 'DoctorController::editDoctor/$1');
$routes->get('/deleteDoctor/(:num)', 'DoctorController::deleteDoctor/$1');
$routes->get('viewAppointmentDetails/(:num)', 'AppointmentController::viewAppointmentDetails/$1');

$routes->get('/edit_fee/(:num)', 'DoctorController::editDoctorFee/$1');
$routes->get('/edit_fee/(:num)', 'DoctorController::editDoctorFee/$1');
$routes->post('/updateDoctorFee/(:num)', 'DoctorController::updateDoctorFee/$1');

$routes->get('/GenearalOPD', 'AppointmentController::GenearalOpd_form');

//----------------------------------------------------------------------------------Doctor
$routes->post('updateDoctor', 'DoctorController::updateDoctor');
// $routes->get('DoctorController/editDoctor/(:num)', 'DoctorController::editDoctor/$1');
$routes->get('/editDoctor/(:num)', 'DoctorController::editDoctor/$1');
$routes->post('doctor-controller/get-doctors', 'DoctorController::getDoctors', ['as' => 'get-doctors']);
$routes->post('DoctorController/getDoctors', 'DoctorController::getDoctors');
$routes->post('DoctorController/fetchDoctorFee', 'DoctorController::fetchDoctorFee');

//----------------------------------------------------------------------------------Doctor Specilization
$routes->get('/specilization_table', 'itemsController::specilization_table');
$routes->get('/specilization_form', 'itemsController::specilization_form');
$routes->post('/saveSpecialization', 'itemsController::saveSpecialization');
//-------------------------------------------------------------------------------------------------------------------------
//                                                 Lab Services
//-------------------------------------------------------------------------------------------------------------------------
$routes->get('/labServices_form', 'LabController::labServices_form');
$routes->post('/saveLabService', 'LabController::saveLabService');
$routes->get('/labtest_form', 'LabController::labtest_form');
$routes->post('/addTest', 'LabController::addTest');

$routes->get('LabController/getTestTypePrice/(:num)', 'LabController::getTestTypePrice/$1');
//$routes->post('submitTests', 'LabController::submitTests');
$routes->post('LabController/submitTests', 'LabController::submitTests');
$routes->post('/submitTests', 'LabController::submitTests');

$routes->post('LabController/getAppointmentsForClient', 'LabController::getAppointmentsForClient');
$routes->post('LabController/getTestTypeId', 'LabController::getTestTypeId');
$routes->post('LabController/getTestTypeId', 'LabController::getTestTypeId');
$routes->post('LabController/getAppointmentTypeName/(:num)', 'LabController::getAppointmentTypeName/$1');
$routes->get('/labtest_table', 'LabController::labtest_table');
$routes->get('viewTestDetails/(:num)', 'LabController::viewTestDetails/$1');
$routes->get('labServices_form', 'LabController::labServices_form');
$routes->get('editTestForm/(:num)', 'LabController::editTestForm/$1');
$routes->post('updateTest/(:num)', 'LabController::updateTest/$1');
$routes->get('edit_test/(:num)', 'LabController::editTestForm/$1');
$routes->get('deleteTest/(:num)', 'LabController::deleteTest/$1');
$routes->get('/lab_test_form', 'LabController::lab_test_form');

$routes->get('/generateExcelLabReport', 'ReportsController::generateExcelLabReport');
$routes->post('generateExcelLabReport', 'ReportsController::generateExcelLabReport');

$routes->get('/generateExcelLabDetailReport', 'ReportsController::generateExcelLabDetailReport');
$routes->post('generateExcelLabDetailReport', 'ReportsController::generateExcelLabDetailReport');
//routes for generating pdf

$routes->get('/generate_pdf', 'AppointmentController::generatePdf');

$routes->post('PdfController/getDynamicDataForPdf', 'PdfController::getDynamicDataForPdf');
$routes->get('PdfController/generatePdf', 'PdfController::generatePdf');

$routes->get('/generate_testPdf', 'LabController::generatePdf');


//-------------------------------------------------------------------------------------------------------------------------
//                                                 Services Routes
//-------------------------------------------------------------------------------------------------------------------------
$routes->get('/Services_form', 'ServiceController::Services_form');
$routes->post('/saveArtMenu', 'ServiceController::saveArtMenu');
$routes->get('/Services_table', 'ServiceController::Services_table');
$routes->get('/deleteService/(:num)', 'ServiceController::deleteService/$1');
$routes->get('editService/(:num)', 'ServiceController::editService/$1');
$routes->post('updateService/(:num)', 'ServiceController::updateService/$1');
$routes->post('updateService', 'ServiceController::updateService');
// $routes->get('/Services_form1', 'ServiceController::Services_form1');
// $routes->get('ServicesForm', 'ServiceController::ServicesForm');
$routes->get('ServicesForm', 'ServiceController::ServicesForm');
$routes->get('getItems', 'ServiceController::getItems');
$routes->get('getItemsForEditService', 'ServiceController::getItemsForEditService');
$routes->get('getItemsForEditService/(:num)', 'ServiceController::getItemsForEditService/$1');


$routes->get('transferServices', 'ServiceController::transferServices');
$routes->post('transferServices', 'ServiceController::transferServices');

//-------------------------------------------------------------------------------------------------------------------------
//                                                 Sales Routes
//-------------------------------------------------------------------------------------------------------------------------
$routes->get('/sales_form', 'SalesController::sales_form');
$routes->post('SalesController/submitServices', 'SalesController::submitServices');
$routes->post('SalesController/submitInvoice', 'SalesController::submitInvoice');

$routes->get('/PayInvoice', 'SalesController::PayInvoice');
$routes->get('/PayInvoice/(:num)', 'SalesController::PayInvoice/$1');

$routes->post('/Payment', 'SalesController::Payment');
$routes->post('SalesController/submitServices', 'SalesController::submitServices');
$routes->post('submitServices', 'SalesController::submitServices');
$routes->post('submitInvoice', 'SalesController::submitInvoice');
$routes->get('/Sales_table', 'SalesController::Sales_table');
$routes->get('/deleteSales/(:num)', 'SalesController::deleteSales/$1');
$routes->get('viewServiceDetails/(:num)', 'SalesController::viewServiceDetails/$1');
$routes->get('sales/deleteService/(:num)', 'SalesController::deleteService/$1');
$routes->post('sales/deleteService/(:num)', ' ::deleteService/$1');
$routes->post('SalesController/filterServices', 'SalesController::filterServices');
$routes->post('SalesController/getAllServices', 'SalesController::getAllServices');
//$routes->match(['get', 'post'], 'SalesController/getAllServices', 'SalesController::getAllServices');

// $routes->get('deleteSales/(:num)', 'SalesController::deleteSales/$1');

$routes->get('/services_details', 'ReportsController::services_details');
$routes->post('/services_details', 'ReportsController::services_details');

$routes->get('/generateExcelServiceDetailReport', 'ReportsController::generateExcelServiceDetailReport');
$routes->post('generateExcelServiceDetailReport', 'ReportsController::generateExcelServiceDetailReport');

$routes->get('SalesController/downloadPDF/(:num)', 'SalesController::downloadPDF/$1');
$routes->get('SalesController/cancelInvoice/(:num)', 'SalesController::cancelInvoice/$1');


$routes->get('/correctInvoice/(:num)', 'SalesController::correctInvoice/$1');
// $routes->get('/edititem/(:num)', 'itemsController::edititem/$1');
$routes->post('SalesController/UpdateInvoice/(:num)', 'SalesController::UpdateInvoice/$1');
$routes->post('SalesController/UpdateInvoice', 'SalesController::UpdateInvoice');

$routes->post('/saveClientfromSales', 'SalesController::saveClientProfile');

//-------------------------------------------------------------------------------------------------------------------------
//                                                 Reports Routes
//-------------------------------------------------------------------------------------------------------------------------
$routes->get('/reports_form', 'ReportsController::reports_form');
$routes->get('/appointment_report', 'ReportsController::appointment_report');
$routes->post('appointment_report', 'ReportsController::appointment_report');

$routes->get('/lab_details', 'ReportsController::lab_details');
$routes->post('/lab_details', 'ReportsController::lab_details');

$routes->get('/generateExcelAppointments', 'ReportsController::generateExcelAppointments');
$routes->post('generateExcelAppointments', 'ReportsController::generateExcelAppointments');
//----------------------------------------------
$routes->get('/lab_report', 'ReportsController::lab_report');
$routes->post('lab_report', 'ReportsController::lab_report');


$routes->get('/services_report', 'ReportsController::services_report');
$routes->post('services_report', 'ReportsController::services_report');

$routes->get('/generateExcelServiceReport', 'ReportsController::generateExcelServiceReport');
$routes->post('generateExcelServiceReport', 'ReportsController::generateExcelServiceReport');

//-------------------------------------------------------------------------------------------------------------------------
//                                                 items Routes
//-------------------------------------------------------------------------------------------------------------------------
$routes->get('/items_form', 'itemsController::items_form');
$routes->post('/saveitems', 'itemsController::saveitems');
$routes->get('/items_table', 'itemsController::items_table');
$routes->get('/Managment_form', 'itemsController::Managment_form');
$routes->get('items', 'itemsController::items_table');
$routes->get('/additem', 'itemsController::additem');
$routes->get('/deleteitem/(:num)', 'itemsController::deleteitem/$1');
$routes->get('/edititem/(:num)', 'itemsController::edititem/$1');
$routes->post('updateitem/(:num)', 'itemsController::updateitem/$1');
$routes->post('updateExpiry/(:num)', 'itemsController::updateExpiry/$1');

$routes->get('transferItems', 'itemsController::transferItems');
$routes->post('transferItems', 'itemsController::transferItems');
$routes->get('progressStatus', 'itemsController::progressStatus');

//-------------------------------------------------------------------------------------------------------------------------
//                                                 items Routes
//-------------------------------------------------------------------------------------------------------------------------

$routes->get('/category_table', 'itemsController::category_table');
$routes->post('/saveCatart', 'itemsController::saveCatart');
$routes->post('/saveCatart_fromDialog', 'itemsController::saveCatart_fromDialog');
$routes->post('/saveCatart_fromitemsDialog', 'itemsController::saveCatart_fromitemsDialog');

$routes->get('/addcat', 'itemsController::addcat');
$routes->get('/cat_form_dialog', 'itemsController::cat_form_dialog');

$routes->get('/deletecat/(:num)', 'itemsController::deletecat/$1');
$routes->get('/editcat/(:num)', 'itemsController::editcat/$1');
$routes->post('/updatecat/(:num)', 'itemsController::updatecat/$1');
//-------------------------------------------------------------------------------------------------------------------------
//                                                 Sector Routes
//-------------------------------------------------------------------------------------------------------------------------

$routes->get('/sectors_table', 'itemsController::sectors_table');
$routes->get('/sectors_form', 'itemsController::sectors_form');
$routes->post('/saveSector', 'itemsController::saveSector');
$routes->get('/deletesector/(:num)', 'itemsController::deletesector/$1');
$routes->get('editsector/(:num)', 'itemsController::editsector/$1');
$routes->post('/updateSector/(:num)', 'itemsController::updateSector/$1');

$routes->post('ServiceController/transferItemsToServices', 'ServiceController::transferItemsToServices');
$routes->get('/transferItemsToServices', 'ServiceController::transferItemsToServices');
$routes->post('/transferItemsToServices', 'ServiceController::transferItemsToServices');

//----------------------------------------------------------------------------------------------------------------
//                                              Expenses Routes
//----------------------------------------------------------------------------------------------------------------
$routes->get('/expenses_form', 'ExpenseController::expenses_form');
$routes->post('/save_expense', 'ExpenseController::save_expense');
$routes->get('/expenses_table', 'ExpenseController::expenses_table');
$routes->get('deleteExpense/(:num)', 'ExpenseController::deleteExpense/$1');
$routes->get('/editExpense/(:num)', 'ExpenseController::editExpense/$1');
$routes->get('/expenseCategory_table', 'ExpenseController::expenseCategory_table');
$routes->post('/addExpenseCategory', 'ExpenseController::addExpenseCategory');
$routes->get('deleteExpenseCat/(:num)', 'ExpenseController::deleteExpenseCat/$1');
$routes->post('/updateExpenseCategory', 'ExpenseController::updateExpenseCategory');
$routes->get('/expenses_form1', 'ExpenseController::expenses_form1');
$routes->post('export_expenses', 'ExpenseController::exportExpenses');

//----------------------------------------------------------------------------------------------------------------
//                                              Configuration Routes
//----------------------------------------------------------------------------------------------------------------
$routes->get('/configure', 'ConfigureController::configure');
$routes->get('/config_settings', 'ConfigureController::config_settings');
$routes->get('/config_form/(:num)', 'ConfigureController::config_form/$1');
$routes->post('/update/(:num)', 'ConfigureController::update/$1');
$routes->post('updateConfig', 'ConfigureController::updateConfig');
$routes->post('createTables', 'ConfigureController::createTables');


//----------------------------------------------------------------------------------------------------------------
//                                              New-Sales Routes
//----------------------------------------------------------------------------------------------------------------
$routes->get('/New_SalesFrom', 'newSalesController::New_SalesFrom');
$routes->post('newSalesController/filterServices', 'newSalesController::filterServices');