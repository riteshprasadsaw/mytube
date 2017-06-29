<?php

namespace App\Http\Controllers;


use App\API\ApiHelper;
use App\Repos\Repository;
use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Cookie;

class PlanController extends Controller
{
     use ApiHelper;
    

    /**
     * @var Repository
     */
    protected $model;

    /**
     * VideoController constructor.
     *
     * @param Video $video
     */
    public function __construct(Plan $plan)
    {
        $this->model = new Repository( $plan );

        // Protect all except reading
        $this->middleware('auth:api', ['except' => ['index', 'show'] ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $plan=$this->model->all();
        $plan = Plan::getStripePlans();

        return $plan;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       $pickedPlan = $request->get('plan');
        
        // Current logged in user
        $me = $request->user();

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
             \Log::info($e);
        }

           
        return "Success";
        

    }

    /**
     * Handle subscription cancellation request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelSubscription(Request $request)
    {

          // \Log::info($request);
        try {
            $request->user()->subscription('main')->cancel();
        } catch ( \Exception $e) {
            return redirect()->route('home')->with('status', $e->getMessage());
        }

        return redirect()->route('home')->with('status',
            'Your Subscription has been canceled.'
        );
    }

    /**
     * Handle Resume subscription
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resumeSubscription(Request $request)
    {
        try {
            $request->user()->subscription('main')->resume();
        } catch ( \Exception $e) {
            return redirect()->route('home')->with('status', $e->getMessage());
        }

        return redirect()->route('home')->with('status',
            'Glad to see you back. Your Subscription has been resumed.'
        );
    }


    public function show($id)
    {
        // get the plan by id from cache
        $plan[] = $this->getPlanByIdOrFail($id);
        return $plan;
    }

    private function getPlanByIdOrFail($id)
    {
        $plans = Plan::getStripePlans();

        if( ! $plans ) throw new NotFoundHttpException;

        return array_first(array_filter( $plans, function($plan) use ($id) {
            return $id == $plan->id;
        }));
    }

    public function checkSubscription(Request $request)
    {
          $is_subscribed = $request->user()->hasStripeId();
           // var_dump($is_subscribed);
          
           if($is_subscribed){

                 $OnGrace=$request->user()->subscription('main')->onGracePeriod();
                 if($OnGrace){
                    return "OnGracePeriod";
                 }else{
                    $isactive=$request->user()->subscription('main')->active();
                 }
            
            
           }else if($is_subscribed='false'){
             
             $isactive='0';
           
           }


           if($isactive){
            return "Subscribed";
          
          }else{
            return "Not Subscribed";
          }
    }

    public function changepassword(Request $request)
    {
        // Validator::make($request->all(), [
        //     'oldpassword' => 'required',
        //     'newpassword' => 'required|min:6|confirmed',
        // ])->validate();

        // $this->validate($request, [
        //     'oldpassword' => 'required',
        //     'newpassword' => 'required|min:6|confirmed',
        // ]);
          
        $request->user()->password=bcrypt($request->newpassword);
         $request->user()->save();

         // return response()->json([
         //        'data' => $errors,
         //    ]);

           // \Log::info($request->newpassword);
           
    }

    public function deleteAccount(Request $request)
    {
        // $id=$request->user()->id;
        // $request->user()->destroy($id); 

        //  // $request->user()->token()->revoke();

        // $this->guard()->logout();

        // $request->session()->flush();

        // $request->session()->regenerate();

        // return redirect('/');
        //  return redirect()->route('login')
        //     // Delete the passport authentication token
        //     ->withCookie(Cookie::forget(Passport::cookie()));

        Auth::logout();


         

    }



    public function checkoutuser(){
         \Stripe\Stripe::setApiKey ( 'sk_test_5QcSNateIIlu8HRvk9lN8YF9' );
            try {
                \Stripe\Charge::create ( array (
                        "amount" => 300 * 100,
                        "currency" => "usd",
                        "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                        "description" => "Test payment." 
                ) );
                Session::flash ( 'success-message', 'Payment done successfully !' );
                return Redirect::back ();
            } catch ( \Exception $e ) {
                Session::flash ( 'fail-message', "Error! Please Try again." );
                return Redirect::back ();
            }
    }
   
    protected function guard()
    {
        return Auth::guard('api');
    }



}
