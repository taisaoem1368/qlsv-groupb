<div class="row">
    <div class="col-md-12 margin-bottom-12">
        <a href="{!! URL::route('comment.edit') !!}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add New</a>
    </div>
</div>
@if( ! $comments->isEmpty() )
    <table class="table table-hover">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Author name</th>
            <th>Author email</th>
            <th>Website</th>
            <th>Comment description</th>
        </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td style="width:18%">{!! $comment->user_id !!}</td>
                <td style="width:18%">{!! $comment->comment_name !!}</td>
                <td style="width:18%">{!! $comment->comment_email !!}</td>
                <td style="width:18%">{!! $comment->comment_website !!}</td>
                <td style="width:18%">{!! $comment->comment_description !!}</td>
                <td style="witdh:10%">
                    @if(! $comment->protected)
                    <a href="{!! URL::route('comment.edit', ['comment_id' => $comment->comment_id]) !!}"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                    <a href="{!! URL::route('comment.delete',['comment_id' => $comment->comment_id, '_token' => csrf_token()]) !!}" class="margin-left-5"><i class="fa fa-trash-o delete fa-2x"></i></a>
                    @else
                        <i class="fa fa-times fa-2x light-blue"></i>
                        <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        {{$comments->links()}}
    </table>
@else
<span class="text-warning"><h5>No comments found.</h5></span>
@endif