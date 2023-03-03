<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feeds</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List of Feeds</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('feed.create') }}"> Create Feed</a>
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
            <th>Name</th>
            <th>Url</th>
            <th>Frequency</th>
            <th>UpdateAt</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($feeds as $feed)
            <tr>
                <td>{{ $feed->id }}</td>
                <td>{{ $feed->name }}</td>
                <td>{{ $feed->url }}</td>
                <td>{{ $feed->getUpdateFrequency() }}</td>
                <td>{{ $feed->updated_at }}</td>
                <td>{{ $feed->getStatus() }}</td>
                <td>
                    <form action="{{ route('feed.destroy',$feed->id) }}" method="Post">
                        <a class="btn btn-primary" href="{{ route('feed.edit',$feed->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $feeds->links() !!}
</div>
</body>
</html>