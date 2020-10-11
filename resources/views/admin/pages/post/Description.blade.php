@extends('admin.layout.app')

@section('title-page')
<title>{{__('home.Posts')}}</title>
@endsection

@section('extra-css-header')
<link href="/admin/theme/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
<link href="/admin/theme/plugins/multi-select/css/multi-select.css" rel="stylesheet">
<link href="/admin/theme/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
@endsection

@section('content')
<ol class="breadcrumb breadcrumb-col-cyan">
    <li><a href="javascript:void(0);"><i class="material-icons">home</i> {{__('home.Home')}}</a></li>
    <li class="active"><i class="material-icons">accessibility</i> {{__('home.Posts')}}</li>
</ol>
 <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{__('home.Description post with name')}} <span style="color: green;">{{ $post->title ?? ''}}</span>
                </h2>
             
            </div>
          
            <form method="post" action="{{route('save.description')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group form-float">
                    <div class="form-line">
                    <input type="hidden"  name="value_id" value="{{$post->id}}" />
                    </div>
                </div>  

                <div class="form-group col-sm-8 form-float m-l-6 m-r-10">
                    <div class="form-line ">
                    <textarea class="ckeditor form-control" name="description" id="description">
                        {{$post->description ?? ''}}
                    </textarea>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-sm">{{__('home.Save')}}</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@section('extra-script-footer')
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    // CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'description', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
</script>
@endsection