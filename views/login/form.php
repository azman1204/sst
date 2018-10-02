<!DOCTYPE html>
<html>
    <head>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <form method="post" action="index.php?r=login/auth">
            <div class="container">
                <legend>Login Form</legend>
                <div class="row">
                    <div class="col">ID Pengguna</div>
                </div>
                <div class="row">
                    <div class="col"><input type="text" name="user_id" class="form-control"></div>
                </div>
                <div class="row">
                    <div class="col">Katalaluan</div>
                </div>
                <div class="row">
                    <div class="col"><input type="password" name="pwd" class="form-control"></div>
                </div>
                <div class="row">
                    <div class="col"><input type="submit" value="Hantar" class="btn btn-primary"></div>
                </div>
            </div>
            <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
        </form>
        
        <style>
            .row {
                margin-top: 5px;
            }
            
            .container {
                width: 50%;
                margin: auto;
                margin-top: 100px;
                padding: 20px;
                background-color: #eee;
                border: 1px solid #ddd;
            }
        </style>
    </body>
</html>
