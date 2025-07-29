@extends('layouts.app')

@section('banner')
    <x-banner :current-page="$title"></x-banner>
@endsection


@section('content')
    <div class="text-end mb-4">
        <a href="{{ route('admin.products.create') }}"><x-button type="button" class="btn-primary pull-right me-2"
                :action="'add'">Add New Product</x-button></a>
    </div>

    <x-filters :action="route('admin.products.index')" :users="$products" :has-daterange="false" :has-user-type="false" :has-search="true" :search-placeholder="'Name/Categories'">

    </x-filters>


    <div class="row">

        <div class="col-md-12">
            <x-admin-panel :has-per-page="true" :per-page-route="route('admin.products.index')" :filters="$filters">
                <div class="row">
                    <div class="col-md-12">
                        <x-table-container>
                            <thead class="table-head">
                                <th></th>
                                <th>Name</th>
                                <th>Sell Price</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? 'odd' : 'even' }} table-tr">
                                        <!-- Optional: Row Number -->
                                        <td class="table-td">{{ $loop->iteration }}</td>

                                        <!-- Product Name -->
                                        <td class="table-td">
                                            <a href="{{ route('admin.products.edit', $product) }}">
                                                {{ $product->name }}
                                            </a>
                                        </td>

                                        <!-- Sell Price -->
                                        <td class="table-td">
                                            ₱{{ number_format($product->sell_price, 2) }}
                                        </td>

                                        <!-- Status (you can update this logic if you have an `active` flag) -->
                                        <td class="table-td">
                                            @if (optional($product)->is_active)
                                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span>
                                            @endif
                                        </td>

                                        <!-- Categories -->
                                        <td class="table-td">
                                            @forelse ($product->categories as $category)
                                                <span class="badge bg-primary">{{ $category->name }}</span>
                                            @empty
                                                <span class="text-muted">None</span>
                                            @endforelse
                                        </td>

                                        <!-- Actions -->
                                        <td class="actions table-td">
                                            <x-entity-actions :edit="route('admin.products.edit', $product)" :entity-id="'product-' . $product->id" :delete="route('admin.products.destroy', $product)"
                                                :name="$product->name" :show="route('admin.products.edit', $product)">
                                            </x-entity-actions>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </x-table-container>
                        <x-table-pagination :action="route('admin.products.index')" :filters="$filters" :collection="$products">
                        </x-table-pagination>
                    </div>
                </div>

            </x-admin-panel>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $('.daterange-basic').daterangepicker({
            parentEl: '.content-inner',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
            console.log('START')
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
            console.log('END')
            $(this).val('');
        });
    </script>
@endsection
