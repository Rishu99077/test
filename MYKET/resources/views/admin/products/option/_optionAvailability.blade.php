<div class="stepOne-form ">
    <form enctype="multipart/form-data" action="" id="setpAvailabilityForm">
        @csrf
        <div class="title_stepOne">
            <h2>{{ translate('Availability') }}</h2>
        </div>

        <div class="section title ">
            <h6 class="section-question">
                {{ translate('When is your activity available for customers? Add your activity’s dates and times by connecting your booking system or by manually entering the information for your product and options.') }}
            </h6>
            <div class="option_availability ">
                @include('admin.products.option._availability')
            </div>

            <div class="continueBtn availability_div d-none">
                <button type="button" id="" class="next action-button float-left add-new-availability">
                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                    {{ translate('Add new availability') }}
                </button>

            </div>
            <div class="continueBtn">
                <button type="submit" id=""
                    class="next action-button float-left step-availability-btn float-right">
                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                    {{ translate('Save and continue') }}
                </button>
            </div>

        </div>

    </form>
</div>
