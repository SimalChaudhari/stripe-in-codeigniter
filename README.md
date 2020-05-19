# Stripe Integration for Plans

So there are many payment integration but Strip payment gateway is one of the easiest and powerful solution.

Before stripe implement you must have stripe account and when you login with that account then stripe will provide API Keys as bellow.

###### 1. Test API Keys
###### 2. Live API Keys


#### 1. Test API Keys

Test API Keys use for developing purpose so before go to live it will help to test.

Let's get start with steps as bellow.

**Step 1 :** Create a Stripe account (https://stripe.com/) and login to the dashboard.

**Step 2 : **Navigate to the **Developers ->API** keys page https://prnt.sc/shcfoa. 
Here is two type of standard API keys named secret key and publishable key. To show the Secret key, click on Reveal test key token button.

**Step 3 : **go to constant file and set `API keys` https://prnt.sc/shchpq

**Step 4 :** Create Product from Stripe navigation menus https://prnt.sc/shcil1. https://prnt.sc/shcjp1

**Step 5 :** Now go to particular product and create plan for that product https://prnt.sc/shcl4o

**Step 6 :** Now you can see `ID` of plan  https://prnt.sc/shcm2j and use in subscription.

**Step 7 : **Include `<script src="https://js.stripe.com/v3/"></script>` in your page from https://stripe.com/docs/stripe-js. and setup code https://prnt.sc/shcojx

**Step 8 :** Downoad Stripe page with composer or direct folder from this current repo (application/third_party/stripe/).

**Step 9 :** include Stripe PHP library in controller. and set `secret key`.
 `require_once APPPATH."third_party/stripe/init.php"`;

```sh
            \Stripe\Stripe::setApiKey(SECRET_KEY);
                'email' => trim($this->input->post('email')),
                        'source' => $this->input->post('stripeToken')
                    ));

                    // Get selected plan id 
                    $selected_plan = null;
                    $plans = \Stripe\Plan::all();
                    foreach ($plans->data as $p) {
                        if($p['nickname'] == strtolower(trim($this->input->post('plan')))) {
                            $selected_plan = $p;
                        break;
                        }
                    }

                    $subscription = \Stripe\Subscription::create(array(
                        'customer' => $customer->id,
                        "items" => array(
                            array(
                                "plan" => $selected_plan['id'],
                            ),
                        ),
                        'trial_period_days' => 14,
                    ));
                return $subscription;

```
**Step 10 :** Go to stripe account and check the `customer & subscription` menu from navigation bar  https://prnt.sc/shctvy, https://prnt.sc/shcuc1

This is stripe API documentation https://stripe.com/docs/api where you can check the code and parameter for particular API 

If you want to implement in any technology then you must need to folow above steps. 


#### 2. Live API Keys

Go to stripe account and make test mode `off` https://prnt.sc/shcb6c so you will get live Keys and implement that keys.

Live key will use for original transaction so be carefull for testing time.

**Note :** You must create plan from stripe from Billing->Products https://prnt.sc/shc4t0
