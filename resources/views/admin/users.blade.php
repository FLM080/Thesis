<x-adminLayout>
    <div class="background">
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit users') }}</h1>
            <div class="d-flex justify-content-end">
                <div class="input-group mb-3 searchbar">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search user" data-url="{{ route($searchRoute) }}">
                </div>
            </div>
            <div class="scrollable-table">
                <table class="table table-dark table-striped my-2 text-center" id="exercises-table">
                    <tbody id="table-body">
                        @include('partials._table', ['items' => $items, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute, 'editType' => $editType])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-adminLayout>