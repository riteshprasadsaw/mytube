<?php

namespace App\Http\Controllers;


use App\API\ApiHelper;
use App\Repos\Repository;
use App\Plan;
use Illuminate\Http\Request;


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
        //Validate request
        // $this->validate( $request, [ 'stripeToken' => 'required', 'plan' => 'required'] );

        // User chosen plan
        $pickedPlan = $request->get('plan');

        // Current logged in user
        $me = $request->user();

        \Log::info($me);

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

        // return return "Success";

    }

    public function show($id)
    {
        // get the plan by id from cache
        $plan = $this->getPlanByIdOrFail($id);

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

    

   

}
