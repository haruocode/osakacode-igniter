<html>
<head>
  <title>レッスン一覧-管理画面</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
@include('myadmin.includes.headmenu')
    <h1>レッスン管理</h1>

    <h2>レッスン一覧<h2>
      
      <p>
        <a class="btn btn-warning" href="/adm/series/" role="button"><span class="glyphicon glyphicon glyphicon-menu-left" aria-hidden="true"></span> 戻る</a>
        <a class="btn btn-success" href="/adm/add_lesson/{{$id}}" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> レッスンを追加する</a>
      </p>
      
      <table class="table table-striped">
        <tr>
          <th>ID</th>
          <th>レッスン名</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
        
        @foreach($lessons as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->title}}</td>
          <td><a class="btn btn-info" href="/adm/edit_lesson/{{$item->id}}/" role="button">編集</a></td>
          <td>
            @if($item->deleted)
            <a class="btn btn-danger" href="" role="button" disabled="disabled">削除済み</a>
            @else
            <a class="btn btn-danger" href="/adm/delete_lesson/{{$item->id}}/" role="button">削除</a>
            @endif
          </td>
        </tr>
        @endforeach
        
      </table>

    @include('myadmin.includes.footer')
</div>
</body>
</html>