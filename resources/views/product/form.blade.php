<x-entity-form :model="$product" :action="$action" :return-url="route('admin.products.index')">

    <div class="row mt-3">
        <!-- Name -->
        <div class="col-12 col-md-6">
            <x-input-label class="label-" for="name" :value="__('Name')" />
            <x-text-input id="name" name="name"
                          class="block mt-1 w-full"
                          :icon="'ph-package'"
                        :value="optional($product)->name ? optional($product)->name : old('name')" 
                        
                          :error="$errors->get('name')"
                           />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Sell Price -->
        <div class="col-12 col-md-6">
            <x-input-label class="label-" for="sell_price" :value="__('Sell Price')" />
            <x-text-input id="sell_price" name="sell_price"
                          type="number"
                          step="0.01"
                          class="block mt-1 w-full"
                          :icon="'ph-currency-dollar'"
                           :value="optional($product)->sell_price ? optional($product)->sell_price : old('sell_price')" 
                          :error="$errors->get('sell_price')"
                           />
            <x-input-error :messages="$errors->get('sell_price')" class="mt-2" />
        </div>

      
    <div class="col-12 col-md-12 mt-3">
    <x-input-label class="label- mb-2" :value="__('Select Categories')" />

    <div class="row ">
       <div class="col-12 col-md-6 mt-3">
         @foreach ($categories as $category)
            <div >
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="category_{{ $category->id }}"
                        name="category_ids[]"
                        value="{{ $category->id }}"
                        {{ in_array($category->id, old('category_ids', $product->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            </div>
        @endforeach
             <x-input-error :messages="$errors->get('category_ids')" class="mt-2" />
       </div>
        
                <div class="col-12 col-md-6 mt-3">
    <x-input-label class="label- mb-2" :value="__('Active Status')" />

    <input type="hidden" name="is_active" value="0">
   <div class="form-check form-switch">
    <input
        class="form-check-input"
        type="checkbox"
        id="active"
        name="is_active"
        :value="optional($product)->is_active ? optional($product)->is_active : 1" 
        value="1"
        {{ old('is_active', $product->is_active ?? false) ? 'checked' : '' }}
    >
    <label class="form-check-label" for="active">
        {{ old('is_active', $product->is_active ?? false) ? 'Active' : 'Inactive' }}
    </label>
</div>

    <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
</div>
    </div>

   


</div>


       
    </div>

</x-entity-form>
