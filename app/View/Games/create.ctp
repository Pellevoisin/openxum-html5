<div data-role="content">
    <?php
    echo $this->Form->create('Game');

    echo '<div data-role="fieldcontain">';

    echo $this->Form->input('game',
        array('type' => 'hidden', 'value' => CakeSession::read('OpenXum.game')));
    echo $this->Form->input('name',
        array('label' => __('Game Name'), 'placeholder' => __('Game Name'), 'required'));
    echo '<br />';

    echo '<fieldset data-role="controlgroup" data-type="horizontal">';
    echo '<legend>' . __('Color') . '</legend>';
    echo $this->Form->radio('color',
        array('black' => __('Black'), 'white' => __('White')),
        array('fieldset' => false, 'legend' => false, 'hiddenField' => false, 'default' => 'black')
    );
    echo '</fieldset>';
    echo '<br />';

    echo '<fieldset data-role="controlgroup" data-type="horizontal">';
    echo '<legend>' . __('Mode') . '</legend>';
    echo $this->Form->radio('mode',
        array('regular' => __('Regular'), 'blitz' => __('Blitz')),
        array('fieldset' => false, 'legend' => false, 'hiddenField' => false, 'default' => 'regular'));

    echo '</fieldset>';
    echo '<br />';

    echo '<fieldset data-role="controlgroup" data-type="horizontal">';
    echo '<legend>' . __('Type') . '</legend>';
    echo $this->Form->radio('type',
        array('online' => __('Online'), 'offline' => __('Offline'), 'ia' => __('Versus IA')),
        array('fieldset' => false, 'legend' => false, 'hiddenField' => false, 'default' => 'realtime')
    );
    echo '</fieldset>';
    echo '<br /></div>';

    echo $this->Form->end(__('Create'));
    ?>

</div>

<div data-role="footer" class="ui-bar"
     style="position: absolute; bottom: 0; width: 100%; margin-left:auto; margin-right:auto; align:center; text-align:center;">
    <div data-role="controlgroup" data-type="horizontal">
        <a href="#">About</a>
    </div>
</div>