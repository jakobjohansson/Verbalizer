@include(framework.Admin.Views.partials.admin-header)

<div class="column is-offset-3 is-6">

    @foreach ($posts as $post)
        <h2 class="title">{{$post->title}}</h2>
        <h3>
            Written {{$post->created_at}}.
            <a href="/admin/edit/{{$post->id}}">Edit</a>
            <a href="/admin/delete/{{$post->id}}">Delete</a>
        </h3>
        <div class="content">
            {{nl2br($post->body)}}
        </div>
    @endforeach
</div>

@include(framework.Admin.Views.partials.admin-footer)
