<html>
<head>
  <title>講座を編集する-管理画面</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
@include('myadmin.includes.headmenu')
    <h1>講座管理</h1>

    <h2>講座を編集する<h2>
      <p>
        <a href="/adm/series/" class="btn btn-warning"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> 戻る</a>
      </p>
      <form method="POST" action="/adm/edit_series/{{$id}}">
        <input type="hidden" name="{{$this->security->get_csrf_token_name()}}" 
    		value="{{$this->security->get_csrf_hash()}}">
      <table class="table table-striped">
        <tr>
          <td>講座タイトル</td>
          <td width="70%"><input name="title" value="<?php echo $series->title; ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>キーワード</td>
          <td><input name="keyword" value="<?php //echo $series->keyword; ?>" placeholder="全角 or 半角スペースで区切る" class="form-control"></td>
        </tr>
        <tr>
          <td>講座概要</td>
          <td><textarea name="description" class="form-control"><?php echo $series->description; ?></textarea></td>
        </tr>
        <tr>
          <td>画像ファイル名</td>
          <td><input name="image" value="<?php echo $series->image; ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>難易度</td>
          <td><input name="difficulty" value="<?php echo $series->difficulty; ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>ステータス</td>
          <td><input name="status" value="<?php echo $series->status; ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>おすすめ</td>
          <td><input name="featured" value="<?php echo $series->featured; ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>アーカイブ</td>
          <td><input name="archived" value="<?php echo $series->archived; ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>削除</td>
          <td><input name="deleted" value="<?php echo $series->deleted; ?>" class="form-control"></td>
        </tr>
      </table>
      <input class="btn btn-primary" type="submit">
      </form>

    @include('myadmin.includes.footer')
</div>
</body>
</html>