

    <tr>
        @foreach ($columns as $column)
            @if($column == 'id')
            <th class="text-white">{{ __('user') }}</th>
            @elseif(!($editType == 'workout' && $column == 'user_id'))
            <th class="text-white">{{ __(str_replace('id', '', str_replace('_', ' ', __($column)))) }}</th>
            @endif

        @endforeach
        <th class="text-white text-center">{{ __('Edit') }}</th>
        <th class="text-white text-center">{{ __('Delete') }}</th>
    </tr> 
    @foreach ($items as $item)
    <tr>
        @foreach ($columns as $column)
        @if(!($editType == 'workout' && $column == 'user_id'))
        <td class="text-white table-item">
            <div>
                @if($column == 'muscle_group_id' && $item->muscleGroup)
                    {{ __($item->muscleGroup->muscle_group_name) }}
                @elseif($column == 'user_admin_privilege')
                    {{ __($item->$column == 1 ? 'Yes' : 'No') }}
                @else
                    {{ __($item->$column) }}
                @endif
            </div>
        </td>
        @endif
@endforeach
    <td class="text-center">
        @if($editType == 'workout')
            <a href="{{ route($editRoute, ['id' => $item->workout_id]) }}" class="btn btn-primary">{{ __('Edit') }}</a>
        @else
            <button type="button" class="btn btn-primary edit-btn"
                data-bs-target="#editModal{{ $item->$tableId }}">{{ __('Edit') }}
            </button>
        @endif
    </td>
        <td class="text-center">
            <form method="POST" action="{{ route($deleteRoute, ['id' => $item->$tableId]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary" onclick="return confirm('{{__('Are you sure you want to delete this item?')}}')">{{__('Delete') }}</button>
            </form>
        </td>
    </tr>

    <div class="modal fade" id="editModal{{ $item->$tableId }}" tabindex="-1"
        role="dialog" aria-labelledby="editModalLabel{{ $item->$tableId }}"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if($editType == 'muscleGroup')
                            @include('partials._table.muscleGroup')
                    @elseif($editType == 'exercise')
                            @include('partials._table.exercise')
                    @elseif($editType == 'user')
                            @include('partials._table.user')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach