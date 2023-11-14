<form action="" method="post" class="register-form ">
    <h1>Đăng nhập</h1>
    <hr>
    <div class="from-group">
        <label for="username">Username :</label>
        <input type="text" class="form-control mr-sm-2" name="username" placeholder="Tên đăng nhập" required>
    </div><br>
    <div class="from-group">
        <label for="password">Password :</label>
        <input type="password" class="form-control mr-sm-2" name="password" placeholder="Mật khẩu" required>
    </div><br>
    <div class="from-group text-center " style="color: #B22222;">
        <?php if (!empty($error)) { ?>
            <span><?= $error ?></span>
        <?php } ?>
    </div> <br>
    <div class="from-group">
        <input type="submit" class="btn btn-primary" name="login" value="Đăng nhập">
    </div><br>
    <div class="from-group" style="text-align: right;">
        <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
</form>