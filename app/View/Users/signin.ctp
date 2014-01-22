<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Please sign in'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('User', array('role' => 'form')); ?>
                    <?php
                    echo '<fieldset>';
                    echo '<div class="form-group"><div class="input-group">';
                    echo '<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
                    echo $this->Form->input('username',
                        array('label' => false,
                            'div' => false, 'placeholder' => __('Login'),
                            'class' => 'form-control',
                            'required'));
                    echo '</div></div>';
                    echo '<div class="form-group"><div class="input-group">';
                    echo '<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>';
                    echo $this->Form->input('password',
                        array('label' =>false,
                            'div' => false, 'placeholder' => __('Password'),
                            'class' => 'form-control',
                            'required'));
                    echo '</div></div>';
                    echo $this->Form->submit(__('Sign in'),
                        array('class' => 'btn btn-lg btn-success btn-block'));
                    echo '</fieldset>';

                    echo '<br>';

                    echo $this->Html->link(__('Sign up'),
                        array('controller' => 'users', 'action' => 'signup'),
                        array('class' => 'btn btn-lg btn-primary btn-block', 'escape' => false));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>