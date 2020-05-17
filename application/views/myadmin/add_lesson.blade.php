<html>
<head>
  <title>レッスンを追加する-管理画面</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
@include('myadmin.includes.headmenu')
    <h1>レッスン管理</h1>

    <h2>レッスンを追加する<h2>
      <form method="POST" action="/adm/add_lesson/{{$id}}">
        <input type="hidden" name="{{$this->security->get_csrf_token_name()}}" 
    		value="{{$this->security->get_csrf_hash()}}">
      <table class="table table-striped">
        <tr>
          <td>レッスンタイトル</td>
          <td width="70%"><input name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>講座ID</td>
          <td><input name="course_id" value="<?php echo $id; ?>"placeholder="数字" class="form-control"></td>
        </tr>
        <tr>
          <td>順序</td>
          <td><input name="order" value="<?php echo $this->input->post('order'); ?>" placeholder="数字" class="form-control"></td>
        </tr>
        <tr>
          <td>再生時間</td>
          <td><input name="time" value="<?php echo $this->input->post('time'); ?>" placeholder="数字" class="form-control"></td>
        </tr>
        <tr>
          <td>レッスン概要</td>
          <td><textarea name="description" class="form-control"><?php echo $this->input->post('description'); ?></textarea></td>
        </tr>
        <tr>
          <td>ポイント</td>
          <td><input name="point" value="<?php echo $this->input->post('point'); ?>" placeholder="数字" class="form-control"></td>
        </tr>
        <tr>
          <td>ビデオURL</td>
          <td><input name="video_url" value="<?php echo $this->input->post('video_url'); ?>" class="form-control"></td>
        </tr>
        <tr>
          <td>無料</td>
          <td><input name="free" value="<?php echo $this->input->post('free'); ?>" placeholder="1 or 0" class="form-control"></td>
        </tr>
        <tr>
          <td>難易度</td>
          <td><input name="difficulty" value="<?php echo $this->input->post('difficulty'); ?>" placeholder="1:初級/ 2:中級/ 3:上級" class="form-control"></td>
        </tr>
      </table>
      <input class="btn btn-primary" type="submit">
      </form>

    @include('myadmin.includes.footer')
</div>
</body>
</html>