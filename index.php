<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home | Drapp </title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="LoginForm">
            <div class="container">
                <center class="form-heading">Login Form</center>
                <div class="login-form">
                    <div class="main-div">
                        <div class="panel">
                            <h2>Admin Login</h2>
                            <p>Please enter your email and password</p>
                        </div>
                        <form id="Login" method="post" action="includes/admin_redirect.php">
                            <div class="form-group">
                                <input type="text" id="username" class="username form-control" name="username" placeholder="User Name/ Email Address" required>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" class="password form-control" name="password" placeholder="Password" required>
                            </div>
                            <input type="submit" id="submit-btn" class="btn btn-primary submit-btn" name="submitbtn" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>