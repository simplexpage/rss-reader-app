<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List of Posts</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('posts.parse') }}"> Get new posts</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Source</th>
            <th>Source Url</th>
            <th>Published Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td><a class="" href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a></td>
                <td>{{ $post->source }}</td>
                <td>{{ $post->source_url }}</td>
                <td>{{ $post->pub_date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
