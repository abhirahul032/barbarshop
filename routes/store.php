<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\AuthController;
use App\Http\Controllers\Store\EmployeeController;
use App\Http\Controllers\Store\ServiceController;
use App\Http\Controllers\Store\PageController;
use App\Http\Controllers\Store\TeamMemberController;
use App\Http\Controllers\Store\ScheduledShiftController;
use App\Http\Controllers\Store\AppointmentController; // Add this line
use App\Http\Controllers\Store\ApiController; // Add this line
use App\Http\Controllers\Store\MembershipController; // Add this line
use App\Http\Controllers\Store\SupplierController; // Add this line
use App\Http\Controllers\Store\ProductController; // Add this line
use App\Http\Controllers\Store\ClientController; // Add this line
use App\Http\Controllers\Store\ClientMembershipController;


Route::prefix('store')
    ->name('store.')
    ->middleware('web')
    ->group(function () {
        // Admin Login
        Route::get('login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        
        
        
        Route::get('appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.available-slots');
        
        // Store Index Route
        Route::get('/', function () {
            return auth()->guard('store')->check() 
                ? redirect()->route('store.dashboard')
                : redirect()->route('store.login');
        })->name('index');

        // Protected Admin Routes - USING CUSTOM MIDDLEWARE
        Route::middleware('store.auth')->group(function () {
            Route::get('dashboard', function () {
                return view('store.dashboard');
            })->name('dashboard');
            
               // ============ CLIENT ROUTES ============
            Route::prefix('clients')->name('clients.')->group(function () {
                Route::get('/', [ClientController::class, 'index'])->name('index');
                Route::get('/create', [ClientController::class, 'create'])->name('create');
                Route::post('/', [ClientController::class, 'store'])->name('store');
                Route::get('/{client}', [ClientController::class, 'show'])->name('show');
                Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit');
                Route::put('/{client}', [ClientController::class, 'update'])->name('update');
                Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
                
                // Additional routes for addresses and emergency contacts
                Route::post('/{client}/addresses', [ClientController::class, 'storeAddress'])->name('addresses.store');
                Route::post('/{client}/emergency-contacts', [ClientController::class, 'storeEmergencyContact'])->name('emergency-contacts.store');
                Route::delete('/{client}/addresses/{address}', [ClientController::class, 'destroyAddress'])->name('addresses.destroy');
                Route::delete('/{client}/emergency-contacts/{emergencyContact}', [ClientController::class, 'destroyEmergencyContact'])->name('emergency-contacts.destroy');
            });
            
            Route::prefix('clients/{client}/memberships')->name('clients.memberships.')->group(function () {
                Route::get('/', [ClientMembershipController::class, 'index'])->name('index');
                Route::post('/', [ClientMembershipController::class, 'store'])->name('store');
                Route::put('/{clientMembership}', [ClientMembershipController::class, 'update'])->name('update');
                Route::delete('/{clientMembership}', [ClientMembershipController::class, 'destroy'])->name('destroy');
                Route::post('/{clientMembership}/redeem', [ClientMembershipController::class, 'redeem'])->name('redeem');
            });
            
            // Add this to your store routes after the other catalogue routes
            Route::prefix('suppliers')->name('suppliers.')->group(function () {
                Route::get('/', [SupplierController::class, 'index'])->name('index');
                Route::get('/create', [SupplierController::class, 'create'])->name('create');
                Route::post('/', [SupplierController::class, 'store'])->name('store');
                Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
                Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
                Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
                Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
            });
            // Also update the catalogue suppliers route to point to the new controller
           
            
            // Membership Routes
            Route::prefix('memberships')->name('memberships.')->group(function () {
                Route::get('/', [MembershipController::class, 'index'])->name('index');
                Route::get('/create', [MembershipController::class, 'create'])->name('create');
                Route::post('/', [MembershipController::class, 'store'])->name('store');
                Route::get('/{membership}', [MembershipController::class, 'show'])->name('show');
                Route::get('/{membership}/edit', [MembershipController::class, 'edit'])->name('edit');
                Route::put('/{membership}', [MembershipController::class, 'update'])->name('update');
                Route::delete('/{membership}', [MembershipController::class, 'destroy'])->name('destroy');
                Route::put('/{membership}/toggle-status', [MembershipController::class, 'toggleStatus'])->name('toggle-status');
                Route::get('/services/by-category', [MembershipController::class, 'getServicesByCategory'])->name('services.by-category');
            });
            // Tax Rate Routes
            Route::prefix('tax-rates')->name('tax-rates.')->group(function () {
                Route::get('/', [TaxRateController::class, 'index'])->name('index');
                Route::post('/', [TaxRateController::class, 'store'])->name('store');
                Route::put('/{taxRate}', [TaxRateController::class, 'update'])->name('update');
                Route::delete('/{taxRate}', [TaxRateController::class, 'destroy'])->name('destroy');
            });

            
            // ============ APPOINTMENT ROUTES ============
            Route::prefix('appointments')->name('appointments.')->group(function () {
                Route::get('/', [AppointmentController::class, 'index'])->name('index');
                Route::get('/create', [AppointmentController::class, 'create'])->name('create');
                Route::post('/', [AppointmentController::class, 'store'])->name('store');
                Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
                Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
                Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
                Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('destroy');
                
                // Additional appointment routes
                Route::get('/calendar/view', [AppointmentController::class, 'calendar'])->name('calendar');
                Route::get('/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('available-slots');
            });

            // ============ API ROUTES FOR CALENDAR ============
            Route::prefix('api')->name('api.')->group(function () {
                Route::get('/calendar-events', [ApiController::class, 'calendarEvents'])->name('calendar-events');
                Route::get('/team-member/{teamMember}/schedule', [ApiController::class, 'teamMemberSchedule'])->name('team-member-schedule');
            });
            
            
            
            // Scheduled Shifts Routes
            // In your scheduled-shifts route group, add these routes:
            Route::prefix('scheduled-shifts')->name('scheduled-shifts.')->group(function () {
                Route::get('/', [ScheduledShiftController::class, 'index'])->name('index');
                Route::post('/', [ScheduledShiftController::class, 'store'])->name('store');
                Route::post('/bulk', [ScheduledShiftController::class, 'bulkStore'])->name('bulk.store');

                // Add these missing routes:
                Route::get('/{scheduledShift}/edit', [ScheduledShiftController::class, 'edit'])->name('edit');
                Route::put('/{scheduledShift}', [ScheduledShiftController::class, 'update'])->name('update');
                Route::delete('/{scheduledShift}', [ScheduledShiftController::class, 'destroy'])->name('destroy');
            });
            
            // Team Members Routes (Complete CRUD)
            Route::prefix('team-members')->name('team-members.')->group(function () {
                Route::get('/', [TeamMemberController::class, 'index'])->name('index');
                Route::get('/create', [TeamMemberController::class, 'create'])->name('create');
                Route::post('/', [TeamMemberController::class, 'store'])->name('store');
                Route::get('/{teamMember}', [TeamMemberController::class, 'show'])->name('show');
                Route::get('/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('edit');
                Route::put('/{teamMember}', [TeamMemberController::class, 'update'])->name('update');
                Route::put('/{teamMember}/services', [TeamMemberController::class, 'updateservices'])->name('updateservices');
                Route::put('/{teamMember}/settings', [TeamMemberController::class, 'updateSettings'])->name('update-settings');
                
                
                
                
                Route::post('/{teamMember}/wages', [TeamMemberController::class, 'storewage'])->name('wages.store'); 
                Route::post('/{teamMember}/commission', [TeamMemberController::class, 'storeCommission'])->name('commission.store');
                Route::post('/{teamMember}/payrun', [TeamMemberController::class, 'storePayRun'])->name('payrun.store');
                Route::post('/{teamMember}/generate-payrun', [TeamMemberController::class, 'generatePayRun'])->name('payrun.generate');
                         
                
                Route::delete('/{teamMember}', [TeamMemberController::class, 'destroy'])->name('destroy');
                
                // Additional routes for addresses and emergency contacts
                Route::post('/{teamMember}/addresses', [TeamMemberController::class, 'addAddress'])->name('addresses.store');
                Route::post('/{teamMember}/emergency-contacts', [TeamMemberController::class, 'addEmergencyContact'])->name('emergency-contacts.store');
                Route::delete('/{teamMember}/addresses/{address}', [TeamMemberController::class, 'removeAddress'])->name('addresses.destroy');
                   // Set primary address route - FIXED NAME
                Route::post('/{teamMember}/addresses/{address}/set-primary', [TeamMemberController::class, 'setPrimaryAddress'])
                    ->name('addresses.set-primary'); 
                
               

                Route::delete('/{teamMember}/emergency-contacts/{emergencyContact}', [TeamMemberController::class, 'removeEmergencyContact'])->name('emergency-contacts.destroy');
            });
            
            Route::resource('team-members', TeamMemberController::class);
            Route::resource('employees', EmployeeController::class);    
            Route::resource('services', ServiceController::class);   
            
//            Route::resource('products', ProductController::class);
//            Route::post('/products/brand', [ProductController::class, 'storeBrand'])->name('store.products.brand.store');
//            Route::post('/products/category', [ProductController::class, 'storeCategory'])->name('store.products.category.store');
           
             // PRODUCT ROUTES - FIXED ORDER
            Route::prefix('products')->name('products.')->group(function () {
                // AJAX routes for brand and category creation - MUST COME BEFORE RESOURCE
                Route::post('/brand', [ProductController::class, 'storeBrand'])->name('brand.store');
                Route::post('/category', [ProductController::class, 'storeCategory'])->name('category.store');
                
                // Resource routes
                Route::get('/', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/', [ProductController::class, 'store'])->name('store');
                Route::get('/{product}', [ProductController::class, 'show'])->name('show');
                Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
                Route::put('/{product}', [ProductController::class, 'update'])->name('update');
                Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            });
            
            
            Route::get('page/calender', [PageController::class, 'calender'])->name('page.calender');
         // --- Sales Menu ---
            Route::get('daily-sales', [PageController::class, 'dailySales'])->name('page.daily.sales');
            Route::get('appointments-list', [PageController::class, 'appointmentsList'])->name('page.appointments.list');
            Route::get('sales-list', [PageController::class, 'salesList'])->name('page.sales.list');
            Route::get('payment-transactions', [PageController::class, 'paymentTransactions'])->name('page.payment.transactions');
            Route::get('gift-cards', [PageController::class, 'giftCards'])->name('page.gift.cards');
            Route::get('paid-plans', [PageController::class, 'paidPlans'])->name('page.paid.plans');

            // --- Client Menu ---
            Route::get('client-list', [PageController::class, 'clientList'])->name('page.client.list');
            Route::get('client-loyalty', [PageController::class, 'clientLoyalty'])->name('page.client.loyalty');
                // --- Catalog Menu ---
            Route::get('catalogue/services', [PageController::class, 'catalogueServices'])->name('page.catalogue.services');
            Route::get('catalogue/memberships', [PageController::class, 'catalogueMemberships'])->name('page.catalogue.memberships');
            Route::get('catalogue/products', [PageController::class, 'catalogueProducts'])->name('page.catalogue.products');
            Route::get('catalogue/stocktakes', [PageController::class, 'catalogueStocktakes'])->name('page.catalogue.stocktakes');
            Route::get('catalogue/orders', [PageController::class, 'catalogueOrders'])->name('page.catalogue.orders');
            Route::get('catalogue/suppliers', [PageController::class, 'catalogueSuppliers'])->name('page.catalogue.suppliers');
            
            
            // --- Online Booking ---
            Route::get('online-booking/locations', [PageController::class, 'onlinebookingLocations'])
                ->name('page.onlinebooking.locations');

            Route::get('online-booking/buttons-and-links', [PageController::class, 'onlinebookingButtonsAndLinks'])
                ->name('page.onlinebooking.buttons.links');

            
            
             // --- Marketing Menu ---
            Route::get('marketing/blast-campaigns', [PageController::class, 'blastCampaigns'])
                ->name('page.marketing.blast.campaigns');

            Route::get('marketing/automated-messages', [PageController::class, 'automatedMessages'])
                ->name('page.marketing.automated.messages');

            Route::get('marketing/notifications', [PageController::class, 'notifications'])
                ->name('page.marketing.notifications');

            Route::get('marketing/deals', [PageController::class, 'deals'])
                ->name('page.marketing.deals');

            Route::get('marketing/peak-pricing', [PageController::class, 'peakPricing'])
                ->name('page.marketing.peak.pricing');

            Route::get('marketing/reviews', [PageController::class, 'reviews'])
                ->name('page.marketing.reviews');
            
            
              // --- Team Menu ---
            Route::get('team/scheduled-shifts', [PageController::class, 'scheduledShifts'])
                ->name('page.team.scheduled.shifts');

            Route::get('team/timesheets', [PageController::class, 'timesheets'])
                ->name('page.team.timesheets');

            Route::get('team/payrun', [PageController::class, 'payrun'])
                ->name('page.team.payrun');
            
            
               // --- Report Menu ---
            Route::get('report/report-group', [PageController::class, 'reportGroup'])
                ->name('page.report.group');
            
              // --- Settings Menu ---
            Route::get('setting/add-on', [PageController::class, 'addOn'])
                ->name('page.setting.addon');

            Route::get('setting', [PageController::class, 'setting'])
                ->name('page.setting');
            
            
           // Route::get('/page/calender', [PageController::class, 'calender'])->name('calender');
            // Logout
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });