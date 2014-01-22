<script>
    function verify_password() {
        var pwd1 = document.getElementById('UserPassword').value;
        var pwd2 = document.getElementById('UserConfirmPassword').value;

        if (pwd1 === pwd2) {
            $('#confirm_passwd').attr('class', 'glyphicon glyphicon-check');
        } else {
            $('#confirm_passwd').attr('class', 'glyphicon glyphicon-unchecked');
        }
    }
</script>

<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Sign up'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('User'); ?>
                    <fieldset>
                        <?php
                        echo '<div class="form-group"><div class="input-group">';
                        echo '<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
                        echo $this->Form->input('username',
                            array('label' => false,
                                'div' => false, 'placeholder' => __('Login'),
                                'class' => 'form-control',
                                'required'));
                        echo '</div></div>';
                        echo '<div class="form-group"><div class="input-group">';
                        echo '<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>';
                        echo $this->Form->input('mail',
                            array('label' => false,
                                'div' => false, 'placeholder' => __('Mail'),
                                'class' => 'form-control',
                                'required'));
                        echo '</div></div>';
                        echo '<div class="form-group"><div class="input-group">';
                        echo '<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>';
                        echo $this->Form->input('password',
                            array('label' => false,
                                'div' => false, 'placeholder' => __('Password'),
                                'class' => 'form-control',
                                'required'));
                        echo '</div></div>';
                        echo '<div class="form-group"><div class="input-group">';
                        echo '<span class="input-group-addon">';
                        echo '<span id="confirm_passwd" class="glyphicon glyphicon-unchecked"></span>';
                        echo '</span>';
                        echo $this->Form->input('confirm_password',
                            array('label' => false, 'type' => 'password',
                                'div' => false, 'placeholder' => __('Confirm password'),
                                'class' => 'form-control', 'onkeyup' => 'verify_password()',
                                'required'));
                        echo '</div></div>';
                        echo $this->Form->submit(__('Create an account'),
                            array('class' => 'btn btn-lg btn-success btn-block'));
                        ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>