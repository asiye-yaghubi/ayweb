@extends('admin.layout.app')

@section('title-page')
<title>{{__('home.Users')}}</title>
@endsection

@section('extra-css-header')
<link href="/admin/theme/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
<link href="/admin/theme/plugins/multi-select/css/multi-select.css" rel="stylesheet">
<link href="/admin/theme/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
@endsection

@section('content')
<ol class="breadcrumb breadcrumb-col-cyan">
    <li><a href="javascript:void(0);"><i class="material-icons">home</i> {{__('home.Home')}}</a></li>
    <li class="active"><i class="material-icons">accessibility</i> {{__('home.Users')}}</li>
</ol>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{__('home.USERS')}}
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
                                    {{__('home.New User')}}
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
                                <th>{{__('home.Name')}}</th>
                                <th>{{__('home.Email')}}</th>
                                <th>{{__('home.type')}}</th>
                                <th>{{__('home.status')}}</th>
                                <th>{{__('home.Roles')}}</th>
                                <th>{{__('home.Image')}}</th>
                                <th>{{__('home.Action')}}</th>
                            </tr>
                        </thead>
                        <tbody id="values-crud">
                            @foreach ($users as $u_info)
                            <tr id="value_id_{{ $u_info->id }}">
                                <td id="index">{{ $loop->iteration }}</td>
                                <td><a href="javascript:void(0)" data-id="{{ $u_info->id }}"
                                        id="show-value">{{ $u_info->name }}</a></td>
                                <td>{{ $u_info->email }}</td>
                                <td>{{ $u_info->type }}</td>
                                <td>
                                    @if ($u_info->status)
                                        <span class="label bg-green">{{__('home.Active')}}</span>
                                    @else
                                        <span class="label bg-red">{{__('home.Inactive')}}</span>
                                    @endif
                                </td>
                                <td id="roles_update">
                                    @if(!empty($u_info->roles()->first()))
                                        @foreach ($u_info->roles as $item)
                                        {{ $item->title }}
                                        @endforeach
                                    @else
                                    {{__('home.dont have role')}}
                                    @endif
                                </td>
                                <td>
                                    @if ($u_info->images()->first())
                                        <img src="/{{ $u_info->images()->first()->url }}" width="48" height="48" alt="User" />
                                    @else
                                        <img src="/admin/theme/images/user.png" width="48" height="48" alt="User" />
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0)" id="edit-value" data-id="{{ $u_info->id }}"
                                        class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                        <i class="material-icons">mode_edit</i>
                                    </a>&nbsp;
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
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" >
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 show_just_create_modal" id="div-password">
                        <div class="input-group">
                            <div class="form-line">
                                <input type="password" class="form-control" id="password-field" name="password" placeholder="Password">
                            </div>
                            <span class="input-group-addon" style="cursor: pointer" id="eyeBtn" onclick="showPassword()">
                                <i class="material-icons" id="pass-status">visibility</i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 show_just_create_modal" id="div-password">
                        <div class="input-group">
                            <div class="form-line">
                                <input type="password" class="form-control" id="password-reapet" name="password_confirmation" placeholder="Repeat Password">
                            </div>
                            <span class="input-group-addon" style="cursor: pointer" id="RepeatEyeBtn" onclick="showRepeatPassword()">
                                <i class="material-icons" id="repeat-pass-status">visibility</i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 show_just_create_modal">
                        <p>
                            <b>{{__('home.Select Image Profile')}}</b>
                        </p>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                  
                    <div class="col-sm-12 m-t-10">
                        <p>
                            <b>{{__('home.Select Roles')}}</b>
                        </p>
                        <select class="form-control show-tick" multiple  name="role_id[]" id="role_id">
                            @foreach ($roles as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 m-t-10">
                        <div class="demo-switch-title">Status</div>
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
                    <button type="submit" name="action_button" id="action_button" value="SAVE RECORD" class="btn btn-link waves-effect">
                        SAVE RECORD
                    </button>
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
    function showPassword() {
        var input_password = document.getElementById("password-field");
        if (input_password.type === "password") {
            input_password.type = "text";
            $('#pass-status').text('visibility_off');
            
        } else {
            input_password.type = "password";
            $('#pass-status').text('visibility');

        }
    } 
    function showRepeatPassword() {
        var input_password = document.getElementById("password-reapet");
        if (input_password.type === "password") {
            input_password.type = "text";
            $('#repeat-pass-status').text('visibility_off');
            
        } else {
            input_password.type = "password";
            $('#repeat-pass-status').text('visibility');

        }
    } 

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
            $('#btn-save').val("create-value");
            $('#btn-save').html("{{__('home.SAVE RECORD')}}");
            $('#btn-save').attr("disabled", false);
            $('#title').val();
            $('#valueForm').trigger("reset");
            $('#div-password').show();
            $('.show_just_create_modal').show();

            $('#valueCrudModal').html("{{__('home.add new information')}}");
            $('#ajax-crud-modal').modal('show');
        });

        $('#valueForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Add') {
                $.ajax({
                    url: "{{ route('user.store') }}",
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
                            $('#btn-save').attr("disabled", false);
                            $('#btn-save').html("{{__('home.SAVE RECORD')}}");
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
                            $('#msg_div').removeClass('alert-danger');
                            $('#valueForm')[0].reset();
                            $('#msg_div').show();
                            $('#res_message').show();

                            var value = '<tr id="value_id_' + data.user.id + '"><td>' + data.user.id +                   
                            '</td><td> <a id="show-value" data-id="' + data.user.id + '" href="javascript:void(0)' + 
                            data.user.id + '">' + data.user.name +'</a></td><td>' + data.user.email + '</td><td>'
                            + data.user.type + '</td>';

                             if(data.user.status){
                                value += '<td><span class="label bg-green">{{__("home.Active")}}</span></td><td>';
                            } else {
                                value += '<td><span class="label bg-red">{{__("home.Inactive")}}</span></td><td>';
                            }
                            if(data.select == 'false') {
                                value += "{{__('home.dont have role')}}";
                                
                            } else {
                                var roles_select = data.select.toString();
                                value += roles_select;
                            }
                            value += '<td><img src="/'+ data.pic.path +'" width="48" height="48" alt="User" /></td>';

                            value += '<td><a href="javascript:void(0)" id="edit-value" data-id="' + data.user.id +
                            '" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">mode_edit</i></a> &nbsp;';
                            value += ' <a href="javascript:void(0)" id="delete-value" data-id="' +data.user.id +    
                            '" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete_forever</i></a></td></tr>';

                            $('#values-crud').prepend(value);
                            $('#valueForm').trigger("reset");
                            $('#msg_div').addClass('alert-success');
                            $('#msg_div').show();
                            $('#res_message').show();
                            $('#btn-save').html("{{__('home.SAVED')}}");
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
                    url: "{{ route('user.update') }}",
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
                            $('#btn-save').attr("disabled", false);
                            $('#btn-save').html("{{__('home.SAVE RECORD')}}");
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
                            $('#msg_div').removeClass('alert-danger');
                            $('#valueForm')[0].reset();
                            $('#msg_div').show();
                            $('#res_message').show();

                            var value = '<tr id="value_id_' + data.user.id + '"><td>' + data.user.id +                   
                            '</td><td> <a id="show-value" data-id="' + data.user.id + '" href="javascript:void(0)' + 
                            data.user.id + '">' + data.user.name +'</a></td><td>' + data.user.email + '</td><td>'
                            + data.user.type + '</td>';
                            if(data.user.status){
                                value += '<td><span class="label bg-green">{{__("home.Active")}}</span></td><td>';
                            } else {
                                value += '<td><span class="label bg-red">{{__("home.Inactive")}}</span></td><td>';
                            }
                            if(data.select == 'false') {
                                value += "{{__('home.dont have role')}}";
                                
                            } else {
                                var roles_select = data.select.toString();
                                value += roles_select;
                            }
                            value += '</td><td><img src="/admin/theme/images/user.png" width="48" height="48" alt="User" /></td>';
                            value += '<td><a href="javascript:void(0)" id="edit-value" data-id="' + data.user.id +
                            '" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">mode_edit</i></a> &nbsp;';
                            value += ' <a href="javascript:void(0)" id="delete-value" data-id="' +data.user.id +    
                            '" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete_forever</i></a></td></tr>';

                            // $('#values-crud').prepend(value);
                            $('#valueForm').trigger("reset");
                            $('#msg_div').addClass('alert-success');
                            $('#msg_div').show();
                            $('#res_message').show();
                            $('#btn-save').html("{{__('home.SAVED')}}");
                            jQuery('.alert-success').append('<p>' +
                                "{{__('home.success')}}" + '</p>');
                            swal("{{__('home.success')}}", "{{__('home.DONE!')}}",
                                "success");
                            setTimeout(function() {
                                $('#ajax-crud-modal').modal('hide');
                                window.location.reload();
                            }, 2000);
                            $("#value_id_" + data.user.id).replaceWith(value);
                        }
                    }
                });
            }
        });
        
        $(document).on('click', '#edit-value', function() {
            var value_id = $(this).data('id');
            // alert(value_id);
            // $('#form_result').html('');
            $.ajax({
                url: "{{ url('manage/user')}}" + '/' + value_id + '/edit',
                dataType: "json",
                success: function(data) {
                    $('#msg_div').empty();
                    $('#msg_div').removeClass('alert-danger');
                    $('#valueCrudModal').html("{{__('home.edit information')}}");
                    $('#btn-save').val("edit-value");
                    $('#msg_div').removeClass('alert-danger');
                    $('#msg_div').removeClass('alert-success');
                    $('#btn-save').html("{{__('home.EDIT RECORD')}}");
                    $('#name').attr('disabled','disabled');
                    $('#email').attr('disabled', 'disabled');
                    $('#div-password').hide();
                    $('.show_just_create_modal').hide();
                    $('#action').val("Edit");
                    $('.filter-option').text("{{__('home.Nothing selected')}}");
                    if(data.user.status) {
                        $('#status').prop('checked', true);
                    }else {
                        $('#status').prop('checked', false);
                    }
                    // alert($('#status').val());
                    // if ($('#status').is(':checked')) {
                    //     alert(' is checked');
                    // }
                    $('#ajax-crud-modal').modal('show');
                    $('#value_id').val(data.user.id);
                    $('#name').val(data.user.name);
                    $('#email').val(data.user.email);
                    if(data.select != 'false') {
                        $('.filter-option').text('');
                        $.each(data.select,function(i,val)
                        {
                            $('.filter-option').append(val + ',');
                            $(".inner li").each((id, elem) => { 
                                if ($(elem).text().trim() == val) { 
                                    $(elem).addClass('selected');
                                } 
                            }); 
                        });
                    }

                }
            })
        });

        /* When click show value */
        $('body').on('click', '#show-value', function() {
            var value_id = $(this).data('id');
            $.get("{{ url('manage/user')}}" + '/' + value_id + '/edit', function(data) {
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
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirrmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('manage/user')}}" + '/' + value_id,
                        success: function(data) {
                            $("#value_id_" + value_id).remove();
                            swal("Deleted!",
                                "Your imaginary file has been deleted.",
                                "success");
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });




















        // /*  When value click add value button */
        // $('#create-new-value').click(function() {
        //     $('.inner>li').removeClass('selected');
        //     $('#valueForm')[0].reset();
        //     $('#action').val("Add");
        //     $('.filter-option').text("{{__('home.Nothing selected')}}");
        //     $('#msg_div').empty();
        //     $('#msg_div').removeClass('alert-danger');
        //     $('#msg_div').removeClass('alert-success');
        //     $('#btn-save').val("create-value");
        //     $('#btn-save').html("{{__('home.SAVE RECORD')}}");
        //     $('#btn-save').attr("disabled", false);
        //     $('#title').val();
        //     $('#valueForm').trigger("reset");
        //     $('#div-password').show();
        //     $('#valueCrudModal').html("{{__('home.add new information')}}");
        //     $('#ajax-crud-modal').modal('show');
        // });
        // /* When click edit value */
        // $('body').on('click', '#edit-value', function() {
        //     var value_id = $(this).data('id');
        //     $.get("{{ url('manage/user')}}" + '/' + value_id + '/edit', function(data) {
        //         $('#msg_div').empty();
        //         $('#msg_div').removeClass('alert-danger');
        //         $('#valueCrudModal').html("{{__('home.edit information')}}");
        //         $('#btn-save').val("edit-value");
        //         $('#msg_div').removeClass('alert-danger');
        //         $('#msg_div').removeClass('alert-success');
        //         $('#btn-save').html("{{__('home.EDIT RECORD')}}");
        //         $('#name').attr('disabled','disabled');
        //         $('#email').attr('disabled', 'disabled');
        //         $('#div-password').hide();
        //         $('.filter-option').text("{{__('home.Nothing selected')}}");
        //         if(data.user.status) {
        //             $('#status').prop('checked', true);
        //         }else {
        //             $('#status').prop('checked', false);
        //         }
        //         // alert($('#status').val());
        //         // if ($('#status').is(':checked')) {
        //         //     alert(' is checked');
        //         // }
        //         $('#ajax-crud-modal').modal('show');
        //         $('#value_id').val(data.user.id);
        //         $('#name').val(data.user.name);
        //         $('#email').val(data.user.email);

                
        //         if(data.select != 'false') {
        //             $('.filter-option').text('');
        //             $.each(data.select,function(i,val)
        //             {
        //                 $('.filter-option').append(val + ',');
        //                 $(".inner li").each((id, elem) => { 
        //                     if ($(elem).text().trim() == val) { 
        //                         $(elem).addClass('selected');
        //                     } 
        //                 }); 
        //             });
        //         }
                
        //     })
        // });

        // if ($("#valueForm").length > 0) {
        //     $("#valueForm").validate({
        //         submitHandler: function(form) {
        //             var actionType = $('#btn-save').val();
        //             // if ($('#status').is(':checked')){
        //             //     $('#status').val('1');
        //             // } else {
        //             //     $('#status').val('0');
        //             // }
                    
        //             $('#btn-save').html("{{__('home.send')}}");
        //             $('#btn-save').attr("disabled", true);
        //             $.ajax({
        //                 data: $('#valueForm').serialize(),
        //                 url: "{{ route('user.update')}}",
        //                 type: "POST",
        //                 dataType: 'json',
        //                 success: function(data) {
        //                     $('#msg_div').empty();
        //                     if (data.arr.status) {
        //                         $('#msg_div').removeClass('alert-danger');
        //                         $('#msg_div').show();
        //                         $('#res_message').show();
        //                     } else {
        //                         $('#msg_div').addClass('alert-danger');
        //                         $('#btn-save').attr("disabled", false);
        //                         $('#btn-save').html("{{__('home.SAVE RECORD')}}");
        //                         $('#msg_div').show();
        //                         $('#res_message').show();
        //                         jQuery('.alert-danger').append('<p>' +
        //                             "{{__('home.error')}}" + '</p>');
        //                         jQuery.each(data.errors, function(key, value) {
        //                             jQuery('.alert-danger').show();
        //                             jQuery('.alert-danger').append('<p>' +
        //                                 value + '</p>');
        //                         });
        //                     }
        //                     var value = '<tr id="value_id_' + data.user.id +
        //                         '"><td>' + data.user.id +
        //                         '</td><td> <a id="show-value" data-id="' + data
        //                         .user.id + '" href="javascript:void(0)' + data
        //                         .role.id + '">' + data.user.name +
        //                         '</a></td><td>' + data.user.email + '</td>';
        //                     value +=
        //                         '<td><a href="javascript:void(0)" id="edit-value" data-id="' +
        //                         data.user.id +
        //                         '" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">mode_edit</i></a> &nbsp;';
        //                     value +=
        //                         ' <a href="javascript:void(0)" id="delete-value" data-id="' +
        //                         data.user.id +
        //                         '" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete_forever</i></a></td></tr>';
        //                     if (actionType == "create-value") {
        //                         $('#values-crud').prepend(value);
        //                     } else {
        //                         $("#value_id_" + data.user.id).replaceWith(value);
        //                     }
        //                     $('#valueForm').trigger("reset");
        //                     $('#msg_div').addClass('alert-success');
        //                     $('#msg_div').show();
        //                     $('#res_message').show();
        //                     $('#btn-save').html("{{__('home.SAVED')}}");
        //                     jQuery('.alert-success').append('<p>' +
        //                         "{{__('home.success')}}" + '</p>');
        //                     swal("{{__('home.success')}}", "{{__('home.DONE!')}}",
        //                         "success");
        //                     setTimeout(function() {
        //                         $('#ajax-crud-modal').modal('hide');
        //                         window.location.reload();
        //                     }, 2000);
        //                 },
        //                 error: function(data) {
        //                     console.log('Error:', data);
        //                     $('#btn-save').html("{{__('home.error')}}");
        //                 }
        //             });
        //         }
        //     })
        // }
        
    });
</script>

@endsection