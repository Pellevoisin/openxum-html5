<div class="container">
    <?php
    echo $this->Form->create('Game', array('class' => 'form-horizontal', 'role' => 'form'));

    echo $this->Form->input('game',
        array('type' => 'hidden', 'value' => CakeSession::read('OpenXum.game')));

    echo '<div class="form-group">';
    echo $this->Form->input('name',
        array('label' => array('text' => __('Game name'), 'class' => 'control-label'),
            'div' => false, 'placeholder' => __('Game name'),
            'class' => 'form-control', 'required'));
    echo '</div>';

    echo '<div class="form-group">';
    echo $this->Form->radio('color',
        array('black' => __('Black'), 'white' => __('White')),
        array('separator' => ' ', 'fieldset' => false, 'legend' => __('Color'), 'hiddenField' => false,
            'default' => 'black')
    );
    echo '</div>';

    echo '<div class="form-group">';
    echo $this->Form->radio('mode',
        array('regular' => __('Regular'), 'blitz' => __('Blitz')),
        array('separator' => ' ', 'fieldset' => false, 'legend' => __('Mode'), 'hiddenField' => false,
            'default' => 'regular'));
    echo '</div>';

    echo '<div class="form-group">';
    echo $this->Form->radio('type',
        array('online' => __('Online'), 'offline' => __('Offline'), 'ia' => __('IA')),
        array('separator' => ' ', 'fieldset' => false, 'legend' => __('Type'), 'hiddenField' => false,
            'default' => 'ia')
    );
    echo '</div>';

    echo '<div class="form-group">';
    echo $this->Form->submit(__('Create'), array('class' => 'btn btn-primary'));
    echo '</div>';

    ?>
</div>