<x-adminLayout>
    <div id="admin-page">
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Add Exercises') }}</h1>

            <form method="POST" action="/admin/addExercises" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="text-white">{{ __('Exercise Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Enter name') }}">
                    @error('name')
                    <?php notify()->error(__($message)) ?>
                    @enderror



                    <label for="image" class="text-white">{{ __('Image') }}</label>
                    <input type="file" class="form-control" id="image" name="image" placeholder="{{ __('Upload Image') }}">
                    @error('image')
                    <?php notify()->error(__($message)) ?>
                    @enderror

                    <label for="description" class="text-white">{{ __('Exercise Description') }}</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="{{ __('Enter description') }}"></textarea>
                    @error('description')
                    <?php notify()->error(__($message)) ?>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </form>
        </div>
        <div class="container my-5 rounded border border-dark bg-dark">
            <h1 class="text-white m-3 text-uppercase mb-0">{{ __('Edit exercises') }}</h1>
        </div>
    </div>
</x-adminLayout>
