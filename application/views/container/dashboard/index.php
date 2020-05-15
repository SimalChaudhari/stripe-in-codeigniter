<?php $plan = array(
    'silver' => 37,
    'gold' => 67,
    'platinum' => 137,
);
?>

<div class="col-lg-10 col-md-12 col-12 p-0 m-0 overflow-hidden">
    <div class="right_coliv">

      <section class="g-mb-100">
        <div class="container">
          <div class="row">
              <!-- Profle Content -->
              <div class="col-lg-8 offset-lg-2">
                  <!-- Tab panes -->
                  <div id="tab-pane">

                    <!-- Payment Options -->
                    <div id="nav-1-1-default-hor-left-underline--3">
                        <h2 class="h4 g-font-weight-300">Upgrade your Subscription</h2>
                        <p class="g-mb-25">Below are the payment options for your account.</p>


                        <form class="g-py-15" action="" method="POST" id="payment-form">
                            <input type="hidden" name="email" value="sm@gmail.com">
                            <div class="mb-4">
                                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Choose your Plan:</label>
                                <div class="btn-group justified-content form-group">
                                    <label class="u-check">
                                        <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0 plan-radio" name="Plan" type="radio" checked="" value="silver" data-price="<?php echo $plan['silver']; ?>">
                                        <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0">Silver ($<?php echo $plan['silver']; ?>/month)</span>
                                    </label>
                                    <label class="u-check">
                                        <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0 plan-radio" name="Plan" type="radio" value="gold" data-price="<?php echo $plan['gold']; ?>">
                                        <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">Gold ($<?php echo $plan['gold']; ?>/month)</span>
                                    </label>
                                    <label class="u-check">
                                        <input class="hidden-xs-up g-pos-abs g-top-0 g-left-0 plan-radio" name="Plan" type="radio" value="platinum" data-price="<?php echo $plan['platinum']; ?>">
                                        <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">Platinum ($<?php echo $plan['platinum']; ?>/month)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-4 form-group">
                                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Name On Card:</label>
                                <input name="cardholder-name" class="form-control g-color-black  g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 validate" placeholder="Jane Doe" />
                                <small class="form-control-feedback d-block g-bg-red g-color-white g-font-size-12 g-px-14 g-py-3 mt-0">This is a required field.</small>
                            </div>

                            <div class="mb-4">
                                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Card Details:</label>
                                <div id="card-element" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded" style="padding:0 .75rem;"></div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 mb-4">
                                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Phone:</label>
                                    <input name="phone" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 field" type="tel" placeholder="(123) 456-7890">
                                </div>

                                <div class="col-xs-12 col-sm-6 mb-4 form-group">
                                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">ZIP code:</label>
                                    <input name="address-zip" class="form-control g-color-black g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 validate" placeholder="94110" />
                                    <small class="form-control-feedback d-block g-bg-red g-color-white g-font-size-12 g-px-14 g-py-3 mt-0">This is a required field.</small>
                                </div>
                            </div>

                          
                          
                            <div class="text-sm-right">
                                <a class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10" href="#">Cancel</a>
                                <button class="btn u-btn-primary pay-btn rounded-0 g-py-12 g-px-25" type="submit">Pay</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Payment Options -->
                  </div>
                  <!-- End Tab panes -->
              </div>
              <!-- End Profle Content -->
          </div>
        </div>
      </section>
    </main>
    </div>
</div>
        