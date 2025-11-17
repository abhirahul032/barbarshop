<?php


namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;

use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index(Request $request){
        
    }
    public function calender(Request $request){
        return view('store.page.calender');
    }
   
     //  Salesmenu start    
    public function dailySales(Request $request){
        return view('store.sale.dailysales');
    }
    
    public function appointmentsList(Request $request){
        return view('store.sale.appointments-list');
    }
    
    public function salesList(Request $request){
        return view('store.sale.sales-list');
    }
    
    public function paymentTransactions(Request $request){
        return view('store.sale.payment-transactions');
    }
    
    public function giftCards(Request $request){
        return view('store.sale.gift-cards');
    }
    
    public function paidPlans(Request $request){
        return view('store.sale.paid-plans');
    }
    //  Salesmenu end 
    
    
    //  Clientmenu start    
    public function clientList(Request $request){
        return view('store.client.client-list');
    }
    public function clientLoyalty(Request $request){
        return view('store.client.client-loyalty');
    }    
    //  Clientmenu start    
    
    
     //  catalog start    
    public function catalogueServices(Request $request){
        return view('store.catalogue.services');
    }
    public function catalogueMemberships(Request $request){
        return view('store.catalogue.memberships');
    }
    public function catalogueProducts(Request $request){
        return view('store.catalogue.products');
    }
    
    public function catalogueStocktakes(Request $request){
        return view('store.catalogue.stocktakes');
    }
    public function catalogueOrders(Request $request){
        return view('store.catalogue.orders');
    }
    public function catalogueSuppliers(Request $request){
        return view('store.catalogue.suppliers');
    }
     //  catalog end    
    
    
    
     //  online  start    
    public function onlinebookingLocations(Request $request){
        return view('store.online-booking.locations');
    }
    public function onlinebookingButtonsAndLinks(Request $request){
        return view('store.online-booking.buttonsandlinks');
    }
     //  online start    
    
    
    
    //marketing start 
    
    public function blastCampaigns(Request $request){
        return view('store.marketing.blast-campaigns');
    }
    public function automatedMessages(Request $request){
        return view('store.marketing.automated-messages');
    }
    public function notifications(Request $request){
        return view('store.marketing.notifications');
    }
    
    public function deals(Request $request){
        return view('store.marketing.deals');
    }
    public function peakPricing(Request $request){
        return view('store.marketing.peak-pricing');
    }    
    public function reviews(Request $request){
        return view('store.marketing.reviews');
    }
    //marketing end 
    
    
    //team start 
    public function scheduledShifts(Request $request){
        return view('store.team.scheduled-shifts');
    }
    public function timesheets(Request $request){
        return view('store.team.timesheets');
    }
    public function payrun(Request $request){
        return view('store.team.payrun');
    }
    //team end 
    
     //report start 
     public function reportGroup(Request $request){
        return view('store.report.report-group');
    }
    
    
    //report end 
    
    public function addOn(Request $request){
        return view('store.setting.add-on');
    }
    public function setting(Request $request){
        return view('store.setting.setting');
    }
    
    
}