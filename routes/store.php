<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\AuthController;
use App\Http\Controllers\Store\EmployeeController;
use App\Http\Controllers\Store\ServiceController;
use App\Http\Controllers\Store\PageController;
use App\Http\Controllers\Store\TeamMemberController;
Route::prefix('store')
    ->name('store.')
    ->middleware('web')
    ->group(function () {
        // Admin Login
        Route::get('login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        
        
        
        
        
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
            
            // Team Members Routes (Complete CRUD)
            Route::prefix('team-members')->name('team-members.')->group(function () {
                Route::get('/', [TeamMemberController::class, 'index'])->name('index');
                Route::get('/create', [TeamMemberController::class, 'create'])->name('create');
                Route::post('/', [TeamMemberController::class, 'store'])->name('store');
                Route::get('/{teamMember}', [TeamMemberController::class, 'show'])->name('show');
                Route::get('/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('edit');
                Route::put('/{teamMember}', [TeamMemberController::class, 'update'])->name('update');
                Route::delete('/{teamMember}', [TeamMemberController::class, 'destroy'])->name('destroy');
                
                // Additional routes for addresses and emergency contacts
                Route::post('/{teamMember}/addresses', [TeamMemberController::class, 'addAddress'])->name('addresses.store');
                Route::post('/{teamMember}/emergency-contacts', [TeamMemberController::class, 'addEmergencyContact'])->name('emergency-contacts.store');
                Route::delete('/{teamMember}/addresses/{address}', [TeamMemberController::class, 'removeAddress'])->name('addresses.destroy');
                Route::delete('/{teamMember}/emergency-contacts/{emergencyContact}', [TeamMemberController::class, 'removeEmergencyContact'])->name('emergency-contacts.destroy');
            });
            
            
            Route::resource('employees', EmployeeController::class);    
            Route::resource('services', ServiceController::class);
            
           
           
            
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