<x-adminLayout>
    <div id="admin-page">
        <div class="container my-5 rounded border border-dark bg-dark w-25">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Add muscle group') }}</h1>

            <form method="POST" action="/admin/addMuscleGroup">
                @csrf
                <div class="form-group mx-3">
                    <label for="name" class="text-white">{{ __('Muscle Group Name') }}</label>
                    <input type="text" class="form-control" id="muscle_group_name" name="muscle_group_name"
                        placeholder="{{ __('Enter name') }}">
                    @error('muscle_group_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary my-3">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit exercises') }}</h1>
            <input type="text" id="search" name="search" placeholder="Search exercises" data-url="{{ route($searchRoute) }}">
            <div class="scrollable-table">
                <table class="table table-dark table-striped my-5 text-center">
                    <tbody id="table-body">
                        @include('partials._table', ['items' => $items, 'columns' => $columns, 'tableId' =>
                        $tableId, 'deleteRoute' => $deleteRoute, 'editRoute' => $editRoute])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-adminLayout>