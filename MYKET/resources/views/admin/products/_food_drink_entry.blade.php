@if ($is_edit > 0)
    <h6 class="font-weight-bold">
        {{ $ProductFoodDrink->food == 'yes' ? ($type_of_meal_description ? $type_of_meal_description->title . '+' : '') : '' }}
        {{ $ProductFoodDrink->drink == 'yes' ? 'drinks' : '' }}

        <span class="float-right text-danger edit_food_drink">{{ translate('Edit') }}</span>
        <input type="hidden" value="{{ $ProductFoodDrink->id }}">
    </h6>
    <span>
        {{ $time_of_day_description ? $time_of_day_description->title . ':' . $foodTagArr : '' }} </span>
    <span class="d-block">
        {{ $ProductFoodDrink->drink == 'yes' ? 'Drinks:' . $drinkTagArr : '' }}
    </span>

    <span class="icofont icofont-ui-delete text-danger float-right pointer remove_food_drink"
        id="{{ $ProductFoodDrink->id }}"></span>
    </span>
@else
    <div class="counter-card-1 food-drink-counter mb-2" id="food_drink_counter_{{ $ProductFoodDrink->id }}">
        <h6 class="font-weight-bold">
            @php
                $plus = '';
                if ($ProductFoodDrink->food == 'yes' && $ProductFoodDrink->drink == 'yes') {
                    $plus = '+';
                }
            @endphp
            {{ $ProductFoodDrink->food == 'yes' ? ($type_of_meal_description ? $type_of_meal_description->title : '') : '' }}
            {{ $plus }}
            {{ $ProductFoodDrink->drink == 'yes' ? 'drinks' : '' }}

            <span class="float-right text-danger edit_food_drink">{{ translate('Edit') }}</span>
            <input type="hidden" value="{{ $ProductFoodDrink->id }}">
        </h6>
        <span>
            {{ $time_of_day_description ? $time_of_day_description->title . ':' . $foodTagArr : '' }} </span>
        <span class="d-block">
            {{ $ProductFoodDrink->drink == 'yes' ? 'Drinks:' . $drinkTagArr : '' }}
        </span>

        <span class="icofont icofont-ui-delete text-danger float-right pointer remove_food_drink"
            id="{{ $ProductFoodDrink->id }}"></span>
        </span>
    </div>
@endif
