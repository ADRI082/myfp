<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo RUTA_URL ?>/public/js/resetPassword.js?v=<?php echo(rand()); ?>"></script>
<!------ Include the above in your HEAD tag ---------->



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="form-gap" style="padding-top: 150px;"></div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Olvidaste la contraseña?</h2>
                        <p>Ingresa tu correo y te mandaremos tu nueva contraseña</p>
                        <div class="panel-body">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                    <input id="resetEmail" name="email" placeholder="Ingresa email" class="form-control" type="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="recover-submit" id="resetEmailButton" class="btn btn-lg btn-primary btn-block" value="Resetear Contraseña" type="button">
                            </div>

                            <!-- <input type="hidden" class="hide" name="token" id="token" value=""> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

