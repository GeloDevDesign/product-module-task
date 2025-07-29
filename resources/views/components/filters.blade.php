@props(['action' => null, 
    'hasUsers' => false, 
    'users' => [], 
    'hasDaterange' => false, 
    'hasSearch' => false,
    'hasUserType' => false ,
    'hasGender',
    'searchPlaceholder' => null,
    // 'noPerPage' => false
])

@php
    if (!$action) {
        return throw new \Exception('No action value specified.');
    }

    // if ($hasUsers) {
    //     if ($users) {
    //         return throw new \Exception('Users filter is enabled but no users specified.');
    //     }
    // }
@endphp

<div class="col-md-12">
    <form action="{{ $action }}" method="get">
        <x-admin-panel>
            <div class="row">
                @if ($hasUsers)
                <div class="col-md-2 mb-2 mb-xl-0">
                    <x-select2 :label="'Users'" :icon="'ph-user-circle'" name="user">
                        <option value="">-- Select User --</option>
                        @if( $users )
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{ isset($_GET['user']) && ( $_GET['user'] == $user->id) ? 'selected' : '' }}>{{$user->full_name}}</option>
                            @endforeach
                        @endif
                    </x-select2>

                    {{-- <label for="">
                        User
                    </label>
                    <div class="input-group mt-1">

                        <span class="input-group-text">
                            <i class="ph-user-circle"></i>
                        </span>
                        <select class="form-select" name="user" :error="$errors->first('user')" >
                            <option value="">-- Select User --</option>
                            @if( $users )
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{ isset($_GET['user']) && ( $_GET['user'] == $user->id) ? 'selected' : '' }}>{{$user->full_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div> --}}
                </div>
                @endif

                @if ($hasDaterange)
                <div class="col-md-2 mb-2 mb-xl-0">
                    <label for="">
                        Date
                    </label>
                    <div class="custom-label search-field pr-2">
                        <x-text-input id="date" :label="'Date'" :icon="'ph-calendar-blank'" class="block w-full daterange-basic mt-1" name="date" type="text" value="{{ isset($_GET['date']) ? $_GET['date'] : '' }}" placeholder="Select Date"></x-text-input>
                    </div>
                </div>
                @endif

                @if ($hasSearch)
                <div class="col-md-2 mb-2 mb-xl-0">
                    <label for="">
                        Search
                    </label>
                    <div class="custom-label search-field pr-2">
                        <x-text-input :label="'Search'" class="search mt-1" placeholder="{{ $searchPlaceholder ?? 'Search' }}" name="s" type="text" value="{{ isset($_GET['s']) ? $_GET['s'] : '' }}" :error="$errors->first('s')"></x-text-input>
                    </div>
                </div>
                @endif

                @if ($hasUserType)
                <div class="col-md-2 mb-2 mb-xl-0">
                    <label for="">
                        Type
                    </label>
                    <div class="input-group mt-1">

                        <span class="input-group-text">
                            <i class="ph-user-circle"></i>
                        </span>
                        <select class="form-select" name="type" :error="$errors->first('type')" >
                            <option value="">-- Select Type --</option>
                            @foreach (\App\Models\User::$types as $type => $val)
                            <option value="{{ $type }}" {{ request()->input('type') == $type ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                {{-- @if (!$noPerPage)
                <div class="col-md-2">
                    <label for="">
                        Per Page
                    </label>
                    <div class="input-group mt-1">
                        <span class="input-group-text">
                            <i class="ph-user-circle"></i>
                        </span>
                        <select class="form-select" name="per_page">
                            <option value="10" {{ request()->per_page == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request()->per_page == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request()->per_page == '50' || !request()->per_page ? 'selected' : '' }}>50</option>
                            <option value="25" {{ request()->per_page == '100' ? 'selected' : '' }}>100</option>
                            <option value="all" {{ request()->per_page == 'all' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                </div>
                @endif --}}

                <div class="col-md-3">
                    <div class="custom-label pl-2 d-flex align-items-center mt-3">
                        <div style="margin-right: 1rem">
                            <a href="{{ $action }}" class="btn waves-effect waves-light btn-secondary">Reset</a>
                        </div>
                        <button type="submit" class="btn waves-effect waves-light btn-success" style = "height: 42px;">Search</button>
                    </div>
                </div>

            </div>

            {!! $slot !!}
            
        </x-admin-panel>
    </form>
</div>
