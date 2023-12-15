<div class="stepOne-form ">
    <form enctype="multipart/form-data" action="" id="setpDiscountForm">
        @csrf
        <div class="title_stepOne">
            <h2>{{ translate('Discount') }}</h2>
        </div>

        <div class="section title ">
            <h6 class="section-question">
                {{ translate('When is your activity available for customers? Add your activity’s dates and times by connecting your booking system or by manually entering the information for your product and options.') }}
            </h6>
            <div class="option_discount">
                @include('admin.products.option._discount')
            </div>

            {{-- <div class="continueBtn discount_div d-none">
                <button type="button" id="" class="next action-button float-left add-new-discount">
                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                    Add new discount
                </button>

            </div> --}}
            <div class="continueBtn">
                <button type="submit" id=""
                    class="next action-button float-left step-discount-btn float-right">
                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                    {{ translate('Save and continue') }}
                </button>
            </div>

        </div>

    </form>
</div>
