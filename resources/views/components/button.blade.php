@props(['action' => 'save', 'type' => 'submit', 'title' => null])

<?php
    switch ($action) {

        case 'download':
            $icon = '<i class="fa fa-download" aria-hidden="true"></i>';
            $class = 'btn-success';
            break;

        case 'export-excel':
            $icon = '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
            $class = 'btn-success';
            break;

         case 'search':
            $icon = '<i class="fa fa-search" aria-hidden="true"></i>';
            $class = 'btn-success';
            break;

        case 'add':
            $icon = '<i class="fa fa-plus" aria-hidden="true"></i>';
            $class = 'btn-success';
            break;

        case 'draft':
            $icon = '<i class="fa fa-plus" aria-hidden="true"></i>';
            $class = 'btn-primary';
            break;

        case 'reload':
            $icon = '<i class="fa fa-undo" aria-hidden="true"></i>';
            $class = 'btn-warning';
            break;

        case 'remove':
            $icon = '<i class="fa fa-times" aria-hidden="true"></i>';
            $class = 'btn-danger';
            break;

        case 'delete':
            $icon = '<i class="fa fa-trash" aria-hidden="true"></i>';
            $class = 'btn-danger';
            break;

        case 'email':
            $icon = '<i class="fa fa-envelope" aria-hidden="true"></i>';
            $class = 'btn-primary';
            break;

        case 'signout':
            $icon = '<i class="fa fa-sign-out-alt" aria-hidden="true"></i>';
            $class = 'btn-primary';
            break;

        case 'no-icon':
            $icon = '';
            $class = 'btn-primary';
            break;

        case 'sort':
            $icon = '<i class="fa fa-sort" aria-hidden="true"></i>';
            $class = 'btn-success';
            break;

        case 'back':
            $icon = '<i class="fa fa-times" aria-hidden="true"></i>';
            $class = 'btn-default';
            break;

        case 'next':
            $icon = '<i class="fa fa-arrow-right" aria-hidden="true"></i>';
            $class = 'btn-default';
            break;

        case 'edit':
            $icon = '<i class="fa fa-pencil" aria-hidden="true"></i>';
            $class = 'btn-warning';
            break;

        case 'upload':
            $icon = '<i class="fa fa-upload" aria-hidden="true"></i>';
            $class = 'btn-default';
            break;

        case 'comment':
            $icon = '<i class="fa fa-comment" aria-hidden="true"></i>';
            $class = 'btn-info';
            break;    

        default:
            $icon = '<i class="fa fa-save" aria-hidden="true"></i>';
            $class = 'btn-success';
        break;
    }
?>


<button  {{ $attributes->merge(['type' => $type, 'class' => 'btn btn-labeled btn-labeled-start '.$class, ]) }}>
    <span class="btn-labeled-icon bg-black bg-opacity-20">
        {!! $icon !!}
    </span>
    {{ $slot }}
</button>

