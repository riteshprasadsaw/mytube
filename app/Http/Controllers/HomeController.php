<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       \Log::info($request);
        $pickedPlan = $request->get('plan');
       
       


        // Current logged in user
        $me = $request->user();

         // $token=$me->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
         //                'email' => $me->email,
         //                'description' => $me->name
         //            ]);

        try {
            // check already subscribed and if already subscribed with picked plan
            if( $me->subscribed('main') && ! $me->subscribedToPlan($pickedPlan, 'main') ) {

                // swap if different plan attempt
                $me->subscription('main')->swap($pickedPlan);

            } else {
                // Its new subscription

                // if user has a coupon, create new subscription with coupon applied
                if( $coupon = $request->get('coupon') ) {

                    $me->newSubscription( 'main', $pickedPlan)
                        ->withCoupon($coupon)
                        ->create($request->get('stripeToken'), [
                            'email' => $me->email
                        ]);

                } else {

                    // Create subscription
                    $token=$me->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
                        'email' => $me->email,
                        'description' => $me->name
                    ]);

                   
                }

            }
        } catch (\Exception $e) {
            // Catch any error from Stripe API request and show
           // return "Failed";
        }

          return view('welcome'); 
    }

    public function create(Request $request){
        \Log::info($request);
       // $pickedPlan = $request->get('plan');
        $pickedPlan = '56TESGT';
       


        // Current logged in user
        $me = $request->user();

         // $token=$me->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
         //                'email' => $me->email,
         //                'description' => $me->name
         //            ]);

        try {
            // check already subscribed and if already subscribed with picked plan
            if( $me->subscribed('main') && ! $me->subscribedToPlan($pickedPlan, 'main') ) {

                // swap if different plan attempt
                $me->subscription('main')->swap($pickedPlan);

            } else {
                // Its new subscription

                // if user has a coupon, create new subscription with coupon applied
                if( $coupon = $request->get('coupon') ) {

                    $me->newSubscription( 'main', $pickedPlan)
                        ->withCoupon($coupon)
                        ->create($request->get('stripeToken'), [
                            'email' => $me->email
                        ]);

                } else {

                    // Create subscription
                    $token=$me->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
                        'email' => $me->email,
                        'description' => $me->name
                    ]);

                   
                }

            }
        } catch (\Exception $e) {
            // Catch any error from Stripe API request and show
           // return "Failed";
        }

           
        return redirect()->back();
        

    }
  
}
