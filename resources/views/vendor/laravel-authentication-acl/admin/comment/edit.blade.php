@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit comment
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- model general errors from the form --}}
        @if($errors->has('model') )
        <div class="alert alert-danger">{{$errors->first('model')}}</div>
        @endif
        
        <?php // var_dump($comment);die(); ?>
        
        {{-- successful message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{{$message}}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title bariol-thin">{!! isset($comment->comment_id) ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-lock"></i> Create' !!} comment</h3>
            </div>
            <div class="panel-body">
                {!! Form::model($comment, [ 'url' => isset($comment->comment_id) ? [URL::route('comment.edit'), $comment->comment_id ] : [URL::route('comment.edit')], 'method' => 'post'] )  !!}
                
                <!-- name text field -->
                <div class="form-group">
                    {!! Form::label('comment_name','Name: *') !!}
                    {!! Form::text('comment_name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'id' => 'slugme', 'required']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('comment_name') !!}</span>
                
                <!-- email text field -->
                <div class="form-group">
                    {!! Form::label('comment_email','Email: *') !!}
                    {!! Form::email('comment_email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'id' => 'slugme', 'required']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('comment_email') !!}</span>
                
                <!-- website text field -->
                <div class="form-group">
                    {!! Form::label('comment_website','Website: ') !!}
                    {!! Form::text('comment_website', null, ['class' => 'form-control', 'placeholder' => 'Website', 'id' => 'slugme']) !!}
                </div>
                
                <!-- comment description text field -->
                <div class="form-group">
                    {!! Form::label('comment_description','Description: *') !!}
                    {!! Form::text('comment_description', null, ['class' => 'form-control', 'placeholder' => 'Description', 'id' => 'slugme', 'required']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('comment_description') !!}</span>
                
                {!! Form::hidden('comment_id', isset($comment->comment_id) ? $_GET['comment_id'] : null) !!}
                <?php if(isset($comment->comment_id)) : ?>
                    <a href="{!! URL::route('comment.delete',['comment_id' => $comment->comment_id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">Delete</a>
                <?php endif; ?>
                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_scripts')
{!! HTML::script('packages/jacopo/laravel-authentication-acl/js/vendor/slugit.js') !!}
<script>
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
    $(function(){
        $('#slugme').slugIt();
    });
</script>
@stop