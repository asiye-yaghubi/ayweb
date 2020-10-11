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
                    {{__('home.POSTS')}}
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right js-sweetalert-asiye">
                            <li>
                                <a href="javascript:void(0)" class="btn bg-green waves-effec" 
                                    id="create-new-value" data-toggle="modal">
                                    <i class="material-icons">add_circle</i>
                                    {{__('home.New Post')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    
                       
                           {!! $post->description !!}
                       
                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection