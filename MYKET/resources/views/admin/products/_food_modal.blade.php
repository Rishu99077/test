<div class="inputfield title_filed product_code">
    <h6 class="font-weight-bold">{{ translate('Type of meal') }}</h6>
    <select name="type_of_meal" id="type_of_meal" class="form-control select2">
        <option value="" selected disabled> {{ translate('Select') }}</option>

        @foreach ($products_food_desc as $PFD)
            <option value="{{ $PFD['product_food_id'] }}"
                {{ getSelected($PFD['product_food_id'], $ProductFoodDrink['type_of_meal']) }}>{{ $PFD['title'] }}
            </option>
        @endforeach
    </select>
    <div class=" col-form-alert-label">
    </div>
</div>

<div class="inputfield title_filed product_code mt-3">
    <h6 class="font-weight-bold">{{ translate('Time of day') }}</h6>
    <select name="time_of_day" id="time_of_day" class="form-control select2">
        <option value="" selected disabled> {{ translate('Select') }}</option>

        @foreach ($products_time_desc as $PTD)
            <option value="{{ $PTD['product_food_id'] }}"
                {{ getSelected($PTD['product_food_id'], $ProductFoodDrink['time_of_day']) }}>{{ $PTD['title'] }}
            </option>
        @endforeach
    </select>
    <div class=" col-form-alert-label">
    </div>
</div>
<div class="inputfield title_filed product_code mt-3">
    <h6 class="font-weight-bold">{{ translate('Tags') }}</h6>
    <select class="select2 food_tags" name="food_tags[]" id="food_tags" multiple="multiple">
        @foreach ($products_food_tags_desc as $PFT)
            <option value="{{ $PFT['product_food_id'] }}"
                {{ getSelectedInArray($PFT['product_food_id'], $ProductFoodDrink['food_tags']) }}>{{ $PFT['title'] }}
            </option>
        @endforeach

    </select>
    <div class=" col-form-alert-label">
    </div>
</div>
