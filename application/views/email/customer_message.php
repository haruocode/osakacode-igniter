<!DOCTYPE html>
<html>
<head>
	<title>会員のお問い合わせメール内容</title>
</head>
<body>
	<strong><?= $name ?></strong>
	送信元
	<em><a href="mailto:<?= $email ?>"><?= $email ?></a></em>
	内容:<br />

	<blockquote>
		&ldquo;<?= $question ?>&rdquo;
	</blockquote>
</body>
</html>
