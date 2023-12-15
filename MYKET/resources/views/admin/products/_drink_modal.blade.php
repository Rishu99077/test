<div class="inputfield title_filed product_code mt-3">
    <h6 class="font-weight-bold">{{ translate('Tags') }}</h6>
    <select class="select2 drink_tags" name="drink_tags[]" id="drink_tags" multiple="multiple">

        @foreach ($products_drink_tags_desc as $PDT)
            <option value="{{ $PDT['product_food_id'] }}"
                {{ getSelectedInArray($PDT['product_food_id'], $ProductFoodDrink['drink_tags']) }}>{{ $PDT['title'] }}
            </option>
        @endforeach

    </select>
    <div class=" col-form-alert-label">
    </div>
</div>
