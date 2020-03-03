@include('shared._errors')

<div style="display:block;">
    <form action="{{route('replies.store')}}" method="post">
        @csrf
        <input type="hidden" name="topic_id" value="{{ $topic }}">
        <div class="form-group">
            <textarea name="content" class="form-control" rows="5">{{old('content')}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
</div>