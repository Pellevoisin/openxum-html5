<div class="container">
    <?php echo $this->Form->create('User', array('class' => 'form-horizontal', 'role' => 'form'));?>
    <?php
    echo '<div class="form-group">';
    echo $this->Form->input('username',
        array('label' => array('text' => __('Login'),
            'class' => 'control-label'),
            'div' => false, 'placeholder' => __('login'),
            'class' => 'form-control',
            'required'));
    echo '</div>';
    echo '<div class="form-group">';
    echo $this->Form->input('password',
        array('label' => array('text' => __('Password'),
            'class' => 'control-label'),
            'div' => false, 'placeholder' => __('password'),
            'class' => 'form-control',
            'required'));
    echo '</div>';
    ?>
    <?php echo $this->Form->submit(__('Sign in'), array('class' => 'btn btn-primary'));?>
</div>