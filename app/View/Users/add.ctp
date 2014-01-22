<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Add player'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('User');?>
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
                        echo '<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>';
                        echo $this->Form->input('password',
                            array('label' => false,
                                'div' => false, 'placeholder' => __('Password'),
                                'class' => 'form-control',
                                'required'));
                        echo '</div></div>';
                        echo '<div class="form-group"><div class="input-group">';
                        echo '<span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>';
                        echo $this->Form->input('role',
                            array('label' => false,
                                'options' => array('admin' => 'Admin', 'player' => 'Player'),
                                'class' => 'form-control'
                            ));
                        echo '</div></div>';
                        echo $this->Form->submit(__('Add'),
                            array('class' => 'btn btn-lg btn-success btn-block'));
                        ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>