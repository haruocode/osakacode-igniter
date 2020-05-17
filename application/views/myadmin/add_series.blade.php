<html>
<head>
  <title>講座を追加する-管理画面</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
@include('myadmin.includes.headmenu')
    <h1>講座管理</h1>

    <h2>講座を追加する<h2>
      <form method="POST" action="/adm/add_series">
        <input type="hidden" name="{{$this->security->get_csrf_token_name()}}" 
    		value="{{$this->security->get_csrf_hash()}}">
      <table class="table table-striped">
        <tr>
          <td>講座タイトル</td>
          <td width="70%"><input name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>キーワード</td>
          <td><input name="keyword" value="<?php echo $this->input->post('keyword'); ?>" placeholder="全角 or 半角スペースで区切る" class="form-control"></td>
        </tr>
        <tr>
          <td>講座概要</td>
          <td><textarea name="description" class="form-control"><?php echo $this->input->post('description'); ?></textarea></td>
        </tr>
        <tr>
          <td>画像ファイル名</td>
          <td><input name="image" value="<?php echo $this->input->post('image'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>難易度</td>
          <td><input name="difficulty" value="<?php echo $this->input->post('difficulty'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>ステータス</td>
          <td><input name="status" value="<?php echo $this->input->post('status'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>おすすめ</td>
          <td><input name="featured" value="<?php echo $this->input->post('featured'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>アーカイブ</td>
          <td><input name="archived" value="<?php echo $this->input->post('archived'); ?>" class="form-control"></td>
        </tr>
      </table>
      <input class="btn btn-primary" type="submit">
      </form>

    @include('myadmin.includes.footer')
</div>
</body>
</html>