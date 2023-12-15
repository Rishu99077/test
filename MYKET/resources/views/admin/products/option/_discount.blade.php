<div class="stepOne-form ">
    <div class="instructions">

        <input type="hidden" name="price_discount_id" value="{{ isset($PricingId) ? $PricingId : '' }}">
        <div class="inputfield title_filed availability-block-form">

            <h6>{{ translate('Validity of this season') }}</h6>
            <h6 class="f-14">
                {{ translate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.') }}
            </h6>
            <div class="availability-form-item availability-block-validity">

                <div class="validity-from">
                    <label for="validity-from" class="input-label"> Valid from </label>

                    <input class="form-control input_txt  discount_valid_from datepickr" id="discount_valid_from"
                        name="discount_valid_from" errors=""
                        value="{{ isset($ProductOptionDiscount) ? $ProductOptionDiscount->valid_from : '' }}">
                </div>
                <div class="validity-to"><label for="validity-to" class="input-label"> to </label>
                    <div class="datepicker" id="validity-to" data-test-id="validity-to" name="validityTo">

                        <input class="form-control input_txt discount_valid_to datepickr" id="discount_valid_to"
                            name="discount_valid_to" errors=""
                            value="{{ isset($ProductOptionDiscount) ? $ProductOptionDiscount->valid_to : '' }}">
                    </div>
                </div>

                <input type="text" class="form-control w-50 ml-5 numberonly" name="discount_date_percentage"
                    placeholder="Enter discount percentage"
                    value="{{ isset($ProductOptionDiscount) ? $ProductOptionDiscount->date_percentage : '' }}">
            </div>
            {{-- <input type="hidden" name="group_pricing_id"
                value="{{ isset($ProductOptionPricing) ? $ProductOptionPricing->id : '' }}"> --}}

            <div class="col-form-alert-label">
            </div>
        </div>
        @php
            $weekArr = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
            $timeJson = '';
        @endphp
        <div class="inputfield title_filed ">
            <h6>{{ translate('Weekly starting times') }}</h6>
            <h6 class="f-14">
                {{ translate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.') }}
            </h6>
            @if (isset($ProductOptionDiscount))
                @php
                    $timeJson = json_decode($ProductOptionDiscount->time_json);

                @endphp
            @endif
            @foreach ($weekArr as $WA)
                <ul class="availability-days">
                    <li class="availability-day d-flex">
                        <span class="name-day">{{ Str::ucfirst($WA) }}</span>

                        <input type="text" class="form-control w-25 numberonly"
                            name="discount_day[{{ $WA }}]" placeholder="Enter Discount Percentage"
                            value="{{ @$timeJson->$WA }}">

                    </li>
                </ul>
            @endforeach

        </div>
        <div class="inputfield title_filed ">
            <h6>{{ translate('Single/special dates') }}</h6>
            <h6 class="f-14">
                {{ translate('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.') }}
            </h6>
            <ul class="availability-days AppendAviableDiscountDate">
                @php
                    $dateJson = '';
                    $count = 0;
                @endphp
                @if (isset($ProductOptionDiscount))
                    @php
                        $dateJson = json_decode($ProductOptionDiscount->date_json);

                    @endphp
                    @if ($dateJson != '')
                        @foreach ($dateJson as $DKEY => $DJ)
                            @include('admin.products.option.pricing._discount_date_list')
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    @endif
                @endif
            </ul>
            <button type="button" class="btn btn-primary btn-outline-primary btn-round text-primary add-discount-date">
                {{ translate('Add new date') }}
            </button><!---->
        </div>
    </div>
</div>
