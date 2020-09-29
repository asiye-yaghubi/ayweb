@extends('admin.layout.app')

@section('title-page')
<title>{{__('home.Categories')}}</title>
@endsection

@section('extra-css-header')
<link href="/admin/theme/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
<link href="/admin/theme/plugins/multi-select/css/multi-select.css" rel="stylesheet">
<link href="/admin/theme/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
@endsection

@section('content')
<ol class="breadcrumb breadcrumb-col-cyan">
    <li><a href="javascript:void(0);"><i class="material-icons">home</i> {{__('home.Home')}}</a></li>
    <li class="active"><i class="material-icons">accessibility</i> {{__('home.Categories')}}</li>
</ol>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{__('home.CATEGORIES')}}
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right js-sweetalert-asiye">
                            <li>
                                <a href="javascript:void(0);" class="btn bg-green waves-effec" 
                                    id="create-new-value" data-toggle="modal">
                                    <i class="material-icons">add_circle</i>
                                    {{__('home.New Category')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table
                        class="table table-bordered table-striped table-hover js-basic-example dataTable align-center"
                        id="data-table">
                        <thead>
                            <tr>
                                <th>{{__('home.id')}}</th>
                                <th>{{__('home.Title')}}</th>
                                <th>{{__('home.Slug')}}</th>
                                <th>{{__('home.icon')}}</th>
                                <th>{{__('home.status')}}</th>
                                <th>{{__('home.Subcategory')}}</th>
                                <th>{{__('home.Tags')}}</th>
                                <th>{{__('home.Image')}}</th>
                                <th>{{__('home.Edit')}}</th>
                                <th>{{__('home.Delete')}}</th>

                            </tr>
                        </thead>
                        <tbody id="values-crud">
                            @foreach ($categorys as $u_info)
                            <tr id="value_id_{{ $u_info->id }}">
                                <td id="index">{{ $loop->iteration }}</td>
                                <td><a href="javascript:void(0)" data-id="{{ $u_info->id }}"
                                        id="show-value">{{ $u_info->title }}</a></td>
                                <td>{{ $u_info->slug }}</td>
                                <td>
                                    <i class="material-icons">{{ $u_info->icon->class }}</i>{{ $u_info->icon->class }}
                                </td>
                                <td>
                                    @if ($u_info->status)
                                        <span class="label bg-green">{{__('home.Active')}}</span>
                                    @else
                                        <span class="label bg-red">{{__('home.Inactive')}}</span>
                                    @endif
                                </td>
                                
                                <td class="align-left">
                                    @if(count($u_info->childs))
                                        @foreach ($u_info->childs as $item)
                                        <a style="display: block" href="javascript:void(0)" class="edit-value" data-id="{{ $item->id }}">
                                            {{ $item->title ?? ''}} => {{ $u_info->title ?? ''}}
                                        </a>
                                        @if(count($item->childs))
                                            @include('admin.pages.category.subCategoryList',['subcategories' => $item->childs])
                                            
                                        @endif
                                        @endforeach
                                    @else
                                        {{__('home.Without Subcategory')}}
                                    @endif
                                    
                                </td>
                                <td>
                                    @foreach ($u_info->tag as $item)
                                        {{ $item->title }}
                                    @endforeach
                                </td>
                                
                                
                                <td>
                                    @if ($u_info->images()->first())
                                        <img src="/{{ $u_info->images()->first()->url }}" width="48" height="48" alt="User" />
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0)" id="edit-value" data-id="{{ $u_info->id }}"
                                        class="btn bg-blue btn-circle waves-effect waves-circle waves-float edit-value">
                                        <i class="material-icons">mode_edit</i>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" id="delete-value" data-id="{{ $u_info->id }}"
                                        class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                        <i class="material-icons">delete_forever</i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('modal')
<div class="modal fade" id="ajax-crud-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert" id="msg_div" style="display:none">
                    <span id="res_message"></span>
                </div>
                <h4 class="modal-title" id="valueCrudModal">Modal title</h4>
            </div>
            <form id="valueForm" name="valueForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Tilte" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="slug" >
                            </div>
                        </div>
                    </div>
                                 
                    <div class="col-sm-12">
                        <p>
                            <b>{{__('home.Select Image Category')}}</b>
                        </p>
                        <input type="file" class="form-control" id="image" name="image">
                        <span id="store_image"></span>
                    </div>
                    <div class="col-sm-12 m-t-10 icons">
                        <p>
                            <b>{{__('home.Select Icon')}}</b>
                        </p>
                        <select class="form-control show-tick"  name="icon_id" id="icon_id">
                            @foreach ($icons as $item)
                            <option value="{{ $item->id }}" data-content="<i class='material-icons'>{{ $item->class }}</i>{{ $item->class }}"></option>
                            @endforeach
                        </select>
                    </div>

                    
                  
                    <div class="col-sm-12 m-t-10 tags">
                        <p>
                            <b>{{__('home.Select Tag')}}</b>
                        </p>
                        <select class="form-control show-tick" multiple  name="tag_id[]" id="tag_id">
                            @foreach ($tags as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 m-t-10 tags">
                        <p>
                            <b>{{__('home.Select Category Leader')}}</b>
                        </p>
                        <select class="form-control show-tick"  name="parent_id" id="parent_id">
                            <option value="0">
                                {{__('home.Leader')}}
                            </option>
                            @foreach ($categorys as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name ?? ''}}
                                </option>
                                @if(!empty($item->children))
                                    @include('Places.Attractions.categories.subCategoryList',['subcategories' => $item->children])
                                @endif 
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-sm-12 m-t-10">
                        <div class="demo-switch-title">{{__('home.Status')}}</div>
                        <div class="switch">
                            <label><input type="checkbox" id="status" name="status"><span class="lever switch-col-red"></span></label>
                        </div>
                    </div>
                   
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <input type="hidden" class="form-control" id="value_id" name="value_id">
                            <input type="hidden" name="action" id="action" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="action_button" id="action_button" class="btn btn-link waves-effect"> </button>   
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('extra-script-footer')
<script src="/admin/theme/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/admin/theme/js/pages/ui/dialogs.js"></script>
<script src="/admin/theme/plugins/multi-select/js/jquery.multi-select.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-new-value').click(function() {
            $('#action').val("Add");
            $('.inner>li').removeClass('selected');
            $('#valueForm')[0].reset();
            $('#action').val("Add");
            $('.filter-option').text("{{__('home.Nothing selected')}}");
            $('#msg_div').empty();
            $('#msg_div').removeClass('alert-danger');
            $('#msg_div').removeClass('alert-success');
            $('#action_button').val("create-value");
            $('#action_button').html("{{__('home.SAVE RECORD')}}");
            $('#action_button').attr("disabled", false);
            $('#title').val();
            $('#valueForm').trigger("reset");
            $('#store_image').hide();
            $('#valueCrudModal').html("{{__('home.add new information')}}");
            $('#ajax-crud-modal').modal('show');
        });

        $('#valueForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Add') {
                $.ajax({
                    url: "{{ route('category.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        
                        $('#msg_div').empty();
                        if (data.errors) {                        
                            $('#msg_div').addClass('alert-danger');
                            $('#action_button').attr("disabled", false);
                            $('#action_button').html("{{__('home.SAVE RECORD')}}");
                            $('#msg_div').show();
                            $('#res_message').show();
                            jQuery('.alert-danger').append('<p>' +
                                "{{__('home.error')}}" + '</p>');
                            jQuery.each(data.errors, function(key, value) {
                                jQuery('.alert-danger').show();
                                jQuery('.alert-danger').append('<p>' +
                                    value + '</p>');
                            });
                        }
                        if (data.arr.status) {

                            if(data.category != 'false') {

                                var value = '<tr id="value_id_' + data.category.id + '"><td>' + data.category.id +                   
                                '</td><td> <a id="show-value" data-id="' + data.category.id + '" href="javascript:void(0)' + 
                                data.category.id + '">' + data.category.title +'</a></td><td>' + data.category.slug + '</td><td><i class="material-icons">'
                                + data.icon.class + '</i></td>';

                                if(data.category.status){
                                    value += '<td><span class="label bg-green">{{__("home.Active")}}</span></td><td>';
                                } else {
                                    value += '<td><span class="label bg-red">{{__("home.Inactive")}}</span></td><td class="align-left">';
                                }

                                if(data.childs == 'false') {
                                    value += "{{__('home.Without Subcategory')}}";
                                    
                                } else {
                                    var childs = data.childs.toString();
                                    value += childs;
                                }
                                
                                var tags = data.tags.toString();
                                value += '</td><td>' + tags + '</td>';

                                value += '<td><img src="/'+ data.pic.path +'" width="48" height="48" alt="User" /></td>';

                                value += '<td><a href="javascript:void(0)" id="edit-value" data-id="' + data.category.id +
                                '" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">mode_edit</i></a> </td><td>';
                                value += ' <a href="javascript:void(0)" id="delete-value" data-id="' +data.category.id +    
                                '" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete_forever</i></a></td></tr>';
                                $('#values-crud').prepend(value);
                            }
                            
                            $('#msg_div').removeClass('alert-danger');
                            $('#valueForm')[0].reset();
                            $('#msg_div').show();
                            $('#res_message').show();
                            $('#valueForm').trigger("reset");
                            $('#msg_div').addClass('alert-success');
                            $('#msg_div').show();
                            $('#res_message').show();
                            $('#action_button').html("{{__('home.SAVED')}}");
                            jQuery('.alert-success').append('<p>' +
                                "{{__('home.success')}}" + '</p>');
                            swal("{{__('home.success')}}", "{{__('home.DONE!')}}",
                                "success");
                            setTimeout(function() {
                                $('#ajax-crud-modal').modal('hide');
                                window.location.reload();
                            }, 2000);
                            
                        }
                      
                    }
                })
            }
            if ($('#action').val() == "Edit") {
                $.ajax({
                    url: "{{ route('category.update') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        
                        $('#msg_div').empty();
                        if (data.errors) {
                            $('#msg_div').addClass('alert-danger');
                            $('#action_button').attr("disabled", false);
                            $('#action_button').html("{{__('home.EDIT RECORD')}}");
                            $('#msg_div').show();
                            $('#res_message').show();
                            jQuery('.alert-danger').append('<p>' +
                                "{{__('home.error')}}" + '</p>');
                            jQuery.each(data.errors, function(key, value) {
                                jQuery('.alert-danger').show();
                                jQuery('.alert-danger').append('<p>' +
                                    value + '</p>');
                            });
                        }
                        if (data.arr.status) {
                            if(data.category != 'false') {

                                var value = '<tr id="value_id_' + data.category.id + '"><td>' + data.category.id +                   
                                '</td><td> <a id="show-value" data-id="' + data.category.id + '" href="javascript:void(0)' + 
                                data.category.id + '">' + data.category.title +'</a></td><td>' + data.category.slug + '</td><td><i class="material-icons">'
                                + data.icon.class + '</i></td>';

                                if(data.category.status){
                                    value += '<td><span class="label bg-green">{{__("home.Active")}}</span></td><td>';
                                } else {
                                    value += '<td><span class="label bg-red">{{__("home.Inactive")}}</span></td><td class="align-left">';
                                }

                                if(data.childs == 'false') {
                                    value += "{{__('home.Without Subcategory')}}";
                                    
                                } else {
                                    var childs = data.childs.toString();
                                    value += childs;
                                }

                                var tags = data.tags.toString();
                                value += '</td><td>' + tags + '</td>';

                                value += '<td><img src="/'+ data.pic.path +'" width="48" height="48" alt="User" /></td>';

                                value += '<td><a href="javascript:void(0)" id="edit-value" data-id="' + data.category.id +
                                '" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">mode_edit</i></a> </td><td>';
                                value += ' <a href="javascript:void(0)" id="delete-value" data-id="' +data.category.id +    
                                '" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete_forever</i></a></td></tr>';

                                if(data.category.parent_id == 0) {
                                    $('#values-crud').prepend(value);
                                }
                                else {
                                    $("#value_id_" + data.user.id).replaceWith(value);
                                }
                            }

                                $('#msg_div').removeClass('alert-danger');
                                $('#valueForm')[0].reset();
                                $('#msg_div').show();
                                $('#res_message').show();
                                $('#valueForm').trigger("reset");
                                $('#msg_div').addClass('alert-success');
                                $('#msg_div').show();
                                $('#res_message').show();
                                $('#action_button').html("{{__('home.SAVED')}}");
                                jQuery('.alert-success').append('<p>' +
                                "{{__('home.success')}}" + '</p>');
                                swal("{{__('home.success')}}", "{{__('home.DONE!')}}",
                                "success");
                                setTimeout(function() {
                                $('#ajax-crud-modal').modal('hide');
                                window.location.reload();
                                }, 2000);

                                
                        }
                    }
                });
            }
        });
        
        $(document).on('click', '.edit-value', function() {
            var value_id = $(this).data('id');
            $.ajax({
                url: "{{ url('manage/category')}}" + '/' + value_id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#msg_div').empty();
                    $('.tags .inner>li').removeClass('selected');
                    $('.parents .inner>li').removeClass('selected');

                    $('#msg_div').removeClass('alert-danger');
                    $('#valueCrudModal').html("{{__('home.edit information')}}");
                    $('#action_button').val("edit-value");
                    $('#msg_div').removeClass('alert-danger');
                    $('#msg_div').removeClass('alert-success');
                    $('#action_button').html("{{__('home.EDIT RECORD')}}");
                    $('#action').val("Edit");
                    if(data.category.status == 1) {
                        $('#status').prop('checked', true);
                    }else {
                        $('#status').prop('checked', false);
                    } 
                    $('#ajax-crud-modal').modal('show');
                    $('#value_id').val(data.category.id);
                    $('#title').val(data.category.title);
                    $('#slug').val(data.category.slug);
                    $('#store_image').html('<img src="/' + data.pic.path + '" width="48" height="48" alt="User" />');

                    $('.icons .filter-option').text(data.icon.class);
                    $(".icons .inner li").each((id, elem) => { 
                        if ($(elem).text().trim() == data.icon.class) { 
                            $(elem).addClass('selected');
                        } 
                    }); 

                    $('.tags .filter-option').text('');
                    $.each(data.tags,function(i,val)
                    {
                        $('.tags .filter-option').append(val + ',');
                        $(".tags .inner li").each((id, elem) => { 
                            if ($(elem).text().trim() == val) { 
                                $(elem).addClass('selected');
                            } 
                        }); 
                    });

                    $('.parents .inner>li').removeClass('selected');
                    if(data.category.parent_id == 0) {
                        $(".parents .inner li").each((id, elem) => { 
                            if ($(elem).text().trim() == "{{ __('home.Category Leader') }}") { 
                                $(elem).addClass('selected');
                            } 
                        }); 
                         
                    } else {
                        $('.parents .filter-option').text('');
                        $(".parents .inner li").each((id, elem) => { 
                            var str = $(elem).text().trim().split(" ").join("");
                            var substr = data.category.title  +"\n=>" +  data.parent.title;
                            if (str.indexOf(substr) == 0) { 
                                $('.parents .filter-option').append(str + ',');
                                $(elem).addClass('selected');
                            } 
                        }); 
                    }
                
                }
            })
        });

        /* When click show value */
        $('body').on('click', '#show-value', function() {
            var value_id = $(this).data('id');
            $.get("{{ url('manage/category')}}" + '/' + value_id + '/edit', function(data) {
                var roles_select = data.select.toString();
                // alert(permissions_select);
                swal({
                    title: "<span style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Id : </span>" +
                        data.user.id + "</span>",
                    text: "<div style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Name : </span>" +
                        data.user.name +
                        "</div><div style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Email : </span>" +
                        data.user.email +
                        "</div><div style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Roles : </span>" 
                        + "<span id='per'>" 
                        + roles_select
                        + "</span></div>",
                    html: true,
                });   
            })
        });
        //delete value 
        $('body').on('click', '#delete-value', function() {
            var value_id = $(this).data("id");
            swal({
                title: "{{__('home.Are you sure?')}}",
                text: "{{__('home.You will not be able to recover this imaginary file!')}}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirrmButtonText: "{{__('home.Yes, delete it!')}}",
                cancelButtonText: "{{__('home.No, cancel plx!')}}",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('manage/category')}}" + '/' + value_id,
                        success: function(data) {
                            if(data.status == 'error') {
                                swal("{{__('home.Unable to delete a row')}}",
                                "{{__('home.First delete its subcategories')}}",
                                "error");
                            } else {
                                $("#value_id_" + value_id).remove();
                                swal("{{__('home.Deleted!')}}",
                                "{{__('home.record has been deleted.')}}",
                                "success");
                            }
                            
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    swal("{{__('home.Cancelled')}}", "{{__('home.Safe row:)')}}", "error");
                }
            });
        });
        
    });
</script>

@endsection