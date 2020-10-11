@extends('admin.layout.app')

@section('title-page')
<title>{{__('home.Profile')}}</title>
@endsection

@section('extra-css-header')
<link href="/admin/theme/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
<link href="/admin/theme/plugins/multi-select/css/multi-select.css" rel="stylesheet">
<link href="/admin/theme/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
@endsection

@section('content')
<ol class="breadcrumb breadcrumb-col-cyan">
    <li><a href="{{route('home')}}"><i class="material-icons">home</i> {{__('home.Home')}}</a></li>
    <li class="active"><i class="material-icons">person</i> {{__('home.Profile')}}</li>
</ol>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       



        <div class="col-xs-12 col-sm-3">
            <div class="card profile-card">
                <div class="profile-header">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        @if (auth()->user()->images()->first())
                            <img src="/{{ auth()->user()->images()->first()->url }}" id="prof" alt="{{ auth()->user()->name ?? '' }}" />
                        @else
                            <img src="/admin/theme/images/user-lg.jpg" id="prof" alt="{{ auth()->user()->name ?? '' }}" />
                        @endif
                    </div>
                    <div class="content-area">
                        <h3>{{ ucfirst($user->name) }}</h3>
                        <p>{{ $user->email }}</p>
                        <p>
                            @foreach ($user->roles as $item)
                                {{ ucfirst($item->title) }}
                            @endforeach
                        </p>
                    </div>
                </div>
                <div class="profile-footer">
                    <ul>
                        <li>
                            <span>{{__('home.Phone')}}</span>
                            <span>{{ $user->phone ?? '' }}</span>
                        </li>
                     
                    </ul>
                    {{-- <a class="btn btn-primary btn-lg waves-effect btn-block" href="javascript:void(0)" id="edit-value" data-id="{{ $user->id }}" disabled>
                        {{__('home.Change Image')}}
                    </a> --}}
                </div>
            </div>

            <div class="card card-about-me">
                <div class="header">
                    <h2>ABOUT ME</h2>
                </div>
                <div class="body">
                    <ul>
                        <li>
                            <div class="title">
                                <i class="material-icons">library_books</i>
                                Education
                            </div>
                            <div class="content">
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <i class="material-icons">location_on</i>
                                Location
                            </div>
                            <div class="content">
                                Malibu, California
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <i class="material-icons">edit</i>
                                Skills
                            </div>
                            <div class="content">
                                <span class="label bg-red">UI Design</span>
                                <span class="label bg-teal">JavaScript</span>
                                <span class="label bg-blue">PHP</span>
                                <span class="label bg-amber">Node.js</span>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <i class="material-icons">notes</i>
                                Description
                            </div>
                            <div class="content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="card">
                <div class="body">
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Change Image</a></li>
                            <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Settings</a></li>
                            <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Password</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                {{-- <div class="panel panel-default panel-post">
                                    <div class="panel-heading">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/admin/theme/images/user-lg.jpg" />
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="#">Marc K. Hammond</a>
                                                </h4>
                                                Shared publicly - 26 Oct 2018
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="post">
                                            <div class="post-heading">
                                                <p>I am a very simple wall post. I am good at containing <a href="#">#small</a> bits of <a href="#">#information</a>. I require little more information to use effectively.</p>
                                            </div>
                                            <div class="post-content">
                                                <img src="/admin/theme/images/profile-post-image.jpg" class="img-responsive" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">thumb_up</i>
                                                    <span>12 Likes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">comment</i>
                                                    <span>5 Comments</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">share</i>
                                                    <span>Share</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" placeholder="Type a comment" />
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <form class="form-horizontal" id="valueForm" name="valueForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="row">
                                            @csrf
                                            <div class="col-sm-4 text-center">
                                                <div id="upload-demo"></div>
                                            </div>
                                            <div class="col-sm-4 control-label" style="padding:5%;">
                                                <strong>Select image to crop:</strong>
                                                <input type="file" id="image">
                                                <button class="btn btn-primary btn-block upload-image" type="submit" style="margin-top:2%">Upload Image</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                {{-- <div class="panel panel-default panel-post">
                                    <div class="panel-heading">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="/admin/theme/images/user-lg.jpg" target="blank">
                                                    <img src="/admin/theme/images/user-lg.jpg" />
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="#">Marc K. Hammond</a>
                                                </h4>
                                                Shared publicly - 01 Oct 2018
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="post">
                                            <div class="post-heading">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                            <div class="post-content">
                                                <iframe width="100%" height="360" src="https://www.youtube.com/embed/10r9ozshGVE" frameborder="0" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">thumb_up</i>
                                                    <span>125 Likes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">comment</i>
                                                    <span>8 Comments</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">share</i>
                                                    <span>Share</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" placeholder="Type a comment" />
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                            <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="Name" class="col-sm-2 control-label">{{__('home.Name')}}</label>
                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="Name" name="name" placeholder="{{__('home.Name')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Email" class="col-sm-2 control-label">{{__('home.Email')}}</label>
                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="email" class="form-control" id="Email" name="Email" placeholder="{{__('home.Email')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="InputSkills" class="col-sm-2 control-label">{{__('home.Skills')}}</label>

                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="InputSkills" name="skill" placeholder="{{__('home.Skills')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Location" class="col-sm-2 control-label">{{__('home.Location')}}</label>

                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="Location" name="location" placeholder="{{__('home.Location')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=" Description" class="col-sm-2 control-label">{{__('home.Description')}}</label>

                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <textarea class="form-control" id=" Description" name="description" rows="3" placeholder="{{__('home.Description')}}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Education" class="col-sm-2 control-label">{{__('home.Education')}}</label>

                                        <div class="col-sm-10">
                                            <div class="form-line">
                                                <textarea class="form-control" id="  Education" name="description" rows="3" placeholder="{{__('home.Education')}}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="OldPassword" class="col-sm-3 control-label">Old Password</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="OldPassword" name="OldPassword" placeholder="Old Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NewPassword" class="col-sm-3 control-label">New Password</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="New Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NewPasswordConfirm" class="col-sm-3 control-label">New Password (Confirm)</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="NewPasswordConfirm" name="NewPasswordConfirm" placeholder="New Password (Confirm)" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-danger">SUBMIT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>

@endsection



@section('extra-script-footer')
<script src="/admin/theme/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/admin/theme/js/pages/ui/dialogs.js"></script>
<script src="/admin/theme/plugins/multi-select/js/jquery.multi-select.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>



<script type="text/javascript">
  $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    
    
    var resize = $('#upload-demo').croppie({
        enableExif: true,
        enableOrientation: true,    
        viewport: { // Default { width: 100, height: 100, type: 'square' } 
            width: 130,
            height: 130,
            type: 'circle' //square
        },
        boundary: {
            width: 130,
            height: 130
        }
    });
    
    
    $('#image').on('change', function () { 
      var reader = new FileReader();
        reader.onload = function (e) {
          resize.croppie('bind',{
            url: e.target.result
          }).then(function(){
            console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
    });
    
    
    // $('.upload-image').on('click', function (ev) {
    $('#valueForm').on('submit',function (ev) {
        event.preventDefault();
      resize.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function (img) {
        $.ajax({
          url: "{{url('manage/change-profile')}}",
          type: "POST",
          data: {"image":img},
          success: function (data) {
            //   alert(data.status);
            html = '<img src="' + img + '" />';
            // $("#preview-crop-image").html(html);
            $("#prof").attr('src', img);

          }
        });
      });
    });
    
});
    </script>

@endsection