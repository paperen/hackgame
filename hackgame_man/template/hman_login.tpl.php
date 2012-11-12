<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HG_ADMIN LOGIN</title>
<link rel="stylesheet" media="screen" href="css/admin.css" />
</head>

<body>

<div class="login_form">
	<h4>VERIFY YOURSELF</h4>
	<form method="post" action="">
    <p>
    	<label for="name">帐号</label> <input type="text" id="name" name="login[name]" class="txtbox" />
    </p>
    <p>
    	<label for="password">密码</label> <input type="password" id="password" name="login[password]" class="txtbox" />
    </p>
    <p>
    	<label for="auth">验证</label> <input type="textbox" id="auth" name="login[auth]" class="txtbox" maxlength="5" /> <?php echo $authcode; ?>
    </p>
    <p>
    	<input type="submit" value="ENTER" class="btn" />
    </p>
    </form>
</div>

</body>
</html>