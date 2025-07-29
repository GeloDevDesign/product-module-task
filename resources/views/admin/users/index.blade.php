@extends('layouts.app')

@section('banner')
   <x-banner :current-page="'View Users'"></x-banner>
@endsection

{{-- @section('styles')
    <style>
        .datatable-header {
            display: flex;
            margin-bottom: 25px;
        }

        .dataTables_length, .dataTables_filter {
            width: 50% !important;
        }

        .dataTables_filter label{
            width: 100%;
            padding-right: 15px;
        }

        td.actions {
            width: 150px !important;
        }

        .dataTables_info {
            padding: 17px 0;
        }

        @media only screen and (max-width: 1024px) {
            .dataTables_length, .dataTables_filter {
                width: 100% !important;
            }

            .card {
                overflow-x: scroll;
            }

        }
    </style>
@endsection --}}

@section('content')
    <div class="text-end mb-4">
        <a href="{{route('admin.users.create')}}"><x-button type="button"  class="btn-primary pull-right me-2" :action="'add'">Add user</x-button></a>
    </div>

    <x-filters
        :action="route('admin.users.index')"
        :has-users="false"
        :users="$users"
        :has-daterange="false"
        :has-user-type="true"
        :has-search="true"
        :search-placeholder="'First Name / Last Name / Email'"
    >

    </x-filters>

    <!-- add user starts here -->
    <x-admin-panel
        :has-per-page="true"
        :per-page-route="route('admin.users.index')"
        :filters="$filters"
    >
        <x-table-container>
            <thead class="table-head">
                <tr>
                    <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_1" aria-sort="ascending">Name</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1">Email</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1">Type</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1">Created By</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1">Status</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1">Last Login</th>
                    <th class="sorting_disabled actions" aria-label="Actions" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $numberofuser = 1; @endphp
                @foreach ($users as $user)
                    <tr class= "{{ $numberofuser % 2 == 0 ? 'odd' : 'even'}} table-tr">
                        <td class="sorting_1 table-td">
                            <a href="{{ route('admin.users.show', $user) }}">
                                {{optional($user)->full_name}}
                            </a>
                        </td>
                        <td class="table-td">{{optional($user)->email}}</td>
                        <td class="table-td">{{optional($user)->type_name}}</td>
                        <td class="table-td">{{optional($user->createdBy)->first_name}} {{optional($user->createdBy)->last_name}}</td>
                        @if(optional($user)->active)
                            <td class="table-td"><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                        @else
                            <td class="table-td"><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
                        @endif
                        <td class="table-td">{{optional($user)->last_login ? optional($user)->last_login->format('F d, Y h:i A') : ''}}</td>
                        <td class="actions table-td">
                            <x-entity-actions :edit="route('admin.users.edit', $user)"
                                :entity-id="'user-'.$user->id"
                                :no-edit="false"
                                :delete="route('admin.users.destroy', $user)"
                                :name="$user->first_name . ' ' . $user->last_name"
                                :show="route('admin.users.show', $user)">
                                <a type="button" title="Change Password" onclick="location.href='{{ route('admin.users.change-password', ['user' => $user->id]) }}'" class="btn btn-warning edit-btn btn-action btn-no-radius btn-square">
                                    <i class="fa fa-user-lock" aria-hidden="true" style="margin-right: 0;"></i>
                                </a>
                            </x-entity-actions>
                        </td>
                    </tr>
                    @php $numberofuser++ @endphp
                @endforeach
            </tbody>
        </x-table-container>

    </x-admin-panel>
    <!-- add user ends here -->
@endsection

