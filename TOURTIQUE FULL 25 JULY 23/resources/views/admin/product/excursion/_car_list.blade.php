<table class="m-auto mb-2 mt-2 table table-responsive w-90">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ translate('Name') }}</th>
            <th>{{ translate('Number Of Passenger') }}</th>
            <th>{{ translate('Price') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($car as $C)
            <tr>
                <td>
                    <input class="form-check-input mt-2 car_check" id="flexCheckDefault" id="option_status"
                        @if (in_array($C['id'], $alreadyAdded)) {{ ' checked' }} @endif type="checkbox"
                        name="car_check[{{ $data }}][]" value="{{ $C['id'] }}" />
                </td>
                <td>
                    {{ $C['title'] }}
                </td>
                <td>{{ $C['number_of_passengers'] }}</td>
                <td>{{ $C['price'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>
                <button type="button" class="btn btn-primary add_car" data-dataid="{{ $data }}">
                    <span class="fa fa-upload"></span> {{ translate('Update') }}
                </button>
            </td>
        </tr>
    </tfoot>
</table>
