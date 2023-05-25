<?php

Auth::routes();

Route::get('/signin', function () {
        return view('signin');
        })->middleware('guest');

Route::post('/signin', 'SecurityController@login')->name('login');

Route::get('/signup', 'SecurityController@signup')->name('signup');

Route::post('/saveUser','UserController@saveUser')->name('saveUser');



Route::group(['middleware' => 'auth', 'prefix' => ''], function () {

      Route::post('/getFutureDateStartTime', 'OrderController@getFutureDateStartTime')->name('getFutureDateStartTime');
      
//Payment
Route::get('payment', 'PayPalController@advancePayment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');

Route::get('balancePayment', 'PayPalController@balancePayment')->name('balancePayment');
Route::get('cancel/balance', 'PayPalController@cancelBalance')->name('balance.cancel');
Route::get('balance/success', 'PayPalController@successBalance')->name('balance.success');

//Dashboard
Route::get('/', 'HomeController@index')->name('/'); 
Route::post('/incomeChart', 'HomeController@incomeChart')->name('incomeChart');

      //   Route::get('/', function () {
      //           return view('index', ['title' => 'Dashboard']);
      //   });

        Route::get('/logout', 'SecurityController@logout')->name('logout');

    Route::group(['middleware' => 'masterfiles', 'prefix' => ''], function () {
        //Item
        Route::get('/item', 'ItemController@itemIndex')->name('item');
        Route::post('/saveItem', 'ItemController@save')->name('saveItem');
        Route::post('/updateItem', 'ItemController@update')->name('updateItem');
        Route::post('/getByItemId', 'ItemController@getById')->name('getByItemId');
        Route::post('/deleteItem', 'ItemController@delete')->name('deleteItem');
        Route::post('/viewItem', 'ItemController@viewItem')->name('viewItem');
        
        //Task
        Route::get('/task', 'TaskController@taskIndex')->name('task');
        Route::post('/saveTask', 'TaskController@save')->name('saveTask');
        Route::post('/updateTask', 'TaskController@update')->name('updateTask');
        Route::post('/getByTaskId', 'TaskController@getByTaskId')->name('getByTaskId');
        Route::post('/deleteMasterTask', 'TaskController@delete')->name('deleteMasterTask');
        Route::post('/viewTask', 'TaskController@view')->name('viewTask');

        //Customer
        Route::get('/customer', 'CustomerController@customerIndex')->name('Customer');
        Route::post('/saveCustomer','CustomerController@saveCustomer')->name('saveCustomer');
        Route::post('/updateCustomer', 'CustomerController@updateCustomer')->name('updateCustomer');
        Route::post('/getByCustomerId', 'CustomerController@getByCustomerId')->name('getByCustomerId');
        Route::post('/deleteCustomer', 'CustomerController@deleteCustomer')->name('deleteCustomer');
        Route::post('/viewCustomer', 'CustomerController@viewCustomer')->name('viewCustomer');
        //User
        Route::get('/user', 'UserController@userIndex')->name('User');
        Route::post('/createUser', 'UserController@createUser')->name('createUser');
        Route::post('/deleteUser', 'UserController@deleteUser')->name('deleteUser');
        Route::post('/updateUser', 'UserController@updateUser')->name('updateUser');
        Route::post('/getByUserId', 'UserController@getByUserId')->name('getByUserId');
    });

    Route::group(['middleware' => 'vehicle', 'prefix' => ''], function () {
      //Vehicle
      Route::get('/vehicle', 'VehicleController@vehicleIndex')->name('vehicle');
      Route::post('/saveVehicle', 'VehicleController@save')->name('saveVehicle');
      Route::post('/updateVehicle', 'VehicleController@update')->name('updateVehicle');
      Route::post('/getByVehicleId', 'VehicleController@getByVehicleId')->name('getByVehicleId');
      Route::post('/viewVehicle', 'VehicleController@viewVehicle')->name('viewVehicle');
      Route::post('/deleteVehicle', 'VehicleController@delete')->name('deleteVehicle');
      Route::post('/viewCustomerName', 'VehicleController@viewCustomerName')->name('viewCustomerName');
    });


        
  Route::group(['middleware' => 'order', 'prefix' => ''], function () {
        //Order
        Route::get('/order', 'OrderController@orderIndex')->name('order');
        Route::post('/viewTableData', 'OrderController@viewTableData')->name('viewTableData');
        Route::post('/getTaskByID', 'OrderController@getTaskByID')->name('getTaskByID');
        Route::post('/addTask', 'OrderController@addTask')->name('addTask');
        Route::post('/deleteTask', 'OrderController@deleteTask')->name('deleteTask');
        Route::post('/viewTaskById', 'OrderController@viewTaskById')->name('viewTaskById');
        Route::post('/getItemByID', 'OrderController@getItemByID')->name('getItemByID');
        Route::post('/addItem', 'OrderController@addItem')->name('addItem');
        Route::post('/viewItemById', 'OrderController@viewItemById')->name('viewItemById');
        Route::post('/deleteOrderItem', 'OrderController@deleteOrderItem')->name('deleteOrderItem');
        Route::post('/getCusDetail', 'OrderController@getCusDetail')->name('getCusDetail');
        Route::post('/saveBooking', 'OrderController@store')->name('saveBooking');
        Route::post('/saveOrder', 'OrderController@save')->name('saveOrder');
        Route::post('/requireRefundAmount', 'OrderController@requireRefundAmount')->name('requireRefundAmount');
                 
  });

   Route::group(['middleware' => 'jobcard', 'prefix' => ''], function () {
        //job card
        Route::get('/job-card', 'JobCardController@jobCardIndex')->name('job-card');
        Route::post('/viewJobTableData', 'JobCardController@viewJobTableData')->name('viewJobTableData');
        Route::post('/loadTempData', 'JobCardController@loadTempData')->name('loadTempData');      
        Route::post('/addJobTask', 'JobCardController@addTask')->name('addJobTask');
        Route::post('/deleteJobTask', 'JobCardController@deleteTask')->name('deleteJobTask');
        Route::post('/viewJobTaskById', 'JobCardController@viewTaskById')->name('viewJobTaskById');
        Route::post('/getCurrentTime', 'JobCardController@getCurrentTime')->name('getCurrentTime');
        Route::post('/addJobItem', 'JobCardController@addItem')->name('addJobItem');
        Route::post('/viewJobItemById', 'JobCardController@viewItemById')->name('viewJobItemById');
        Route::post('/deleteJobOrderItem', 'JobCardController@deleteOrderItem')->name('deleteJobOrderItem');
        Route::post('/jobStart', 'JobCardController@jobStart')->name('jobStart');
        Route::post('/savejob', 'JobCardController@store')->name('savejob');
        Route::post('/deleteJobData', 'JobCardController@deleteJobData')->name('deleteJobData');
  });     

        //Active-Inactive
        Route::post('/activateDeactivate', 'API\CommonController@activateDeactivate')->name('activateDeactivate');

    Route::group(['middleware' => 'settlement', 'prefix' => ''], function () {
        //Payment
        Route::get('/job-payment', 'PaymentController@Index')->name('job-payment');
  }); 

        //Payment gateway integration
        //Route::get('payment-view', 'PaymentGatway@stripe');
        //Route::post('stripe', 'PaymentGatway@stripePost')->name('stripe.post');
   
  Route::group(['middleware' => 'reports', 'prefix' => ''], function () {
         //Reports
        
        Route::get('/serviceHistory', 'ReportsController@serviceHistory')->name('serviceHistory');
        Route::post('/seviceHostory_viewCustomerName', 'ReportsController@viewCustomerName')->name('viewCustomerName');
        Route::get('/completedJobs', 'ReportsController@completedJobs')->name('completedJobs');
        Route::get('/jobEfficiency', 'ReportsController@jobEfficiency')->name('jobEfficiency');
        Route::get('/revenue', 'ReportsController@revenue')->name('revenue');
        //Route::get('/inventoryConsumed', 'ReportsController@inventoryConsumed')->name('inventoryConsumed');
        Route::get('/vehicleList', 'ReportsController@vehicleList')->name('vehicleList');
  });

  Route::group(['middleware' => 'masterfiles', 'prefix' => ''], function () {
        //Settings
          //Refund
        Route::get('/refund', 'RefundController@refund')->name('refund');
        Route::post('/saveRefund', 'RefundController@save')->name('save');
        Route::post('/deleteRefund', 'RefundController@delete')->name('delete');
        
          //Advance
        Route::get('/advance', 'AdvanceController@advance')->name('advance');
        Route::post('/saveAdvance', 'AdvanceController@save')->name('save');
        Route::post('/deleteAdvance', 'AdvanceController@delete')->name('delete');

          //UOM
        Route::get('/uom', 'UomController@uomIndex')->name('uom');
        Route::post('/saveUom', 'UomController@save')->name('saveUom');
        Route::post('/viewUom', 'UomController@view')->name('viewUom');
        Route::post('/updateUom', 'UomController@update')->name('updateUom');
        Route::post('/getByUomId', 'UomController@getById')->name('getByUomId');
        Route::post('/deleteUom', 'UomController@delete')->name('deleteUom');

        //category
        Route::get('/category', 'CategoryController@categoriesIndex')->name('category');
        Route::post('/saveCategory', 'CategoryController@save')->name('saveCategory');
        Route::post('/viewCategory', 'CategoryController@view')->name('viewCategory');
        Route::post('/updateCategory', 'CategoryController@update')->name('updateCategory');
        Route::post('/getByCategoryId', 'CategoryController@getById')->name('getByCategoryId');
        Route::post('/deleteCategory', 'CategoryController@delete')->name('deleteCategory');
   });
  

        
        
        
        
        
        

});
