<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('New game'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('Game', array('role' => 'form')); ?>
                    <fieldset>
                        <?php

                        if (CakeSession::read('OpenXum.game') == 'Yinsh') {
                            $colors = array('black' => __('Black'), 'white' => __('White'));
                            $default_color = 'black';
                            $modes = array('regular' => __('Regular'), 'blitz' => __('Blitz'));
                            $default_mode = 'regular';
                        } else if (CakeSession::read('OpenXum.game') == 'Kamisado') {
                            $colors = array('black' => __('Black'), 'white' => __('White'));
                            $default_color = 'black';
                            $modes = array('simple' => __('Simple'), 'standard' => __('Standard'),
                                'long' => __('Long'), 'marathon' => __('Marathon'));
                            $default_mode = 'simple';
                        } else {
                            $colors = array();
                            $modes = array();
                        }

                        echo $this->Form->input('game',
                            array('type' => 'hidden', 'value' => CakeSession::read('OpenXum.game')));

                        echo '<div class="form-group"><div class="input-group">';
                        echo '<span class="input-group-addon"><span class="glyphicon glyphicon-tower"></span></span>';
                        echo $this->Form->input('name',
                            array('label' => false,
                                'div' => false, 'placeholder' => __('Game name'),
                                'class' => 'form-control', 'required'));
                        echo '</div></div>';

                        if (!empty($colors)) {
                            echo '<div class="form-group">';
                            echo $this->Form->radio('color',
                                $colors,
                                array('separator' => ' ', 'fieldset' => false,
                                    'legend' => __('Color'), 'hiddenField' => false,
                                    'label' => array('class' => 'radio-inline'),
                                    'default' => $default_color));
                            echo '</div>';
                        }

                        if (!empty($modes)) {
                            echo '<div class="form-group">';
                            echo $this->Form->radio('mode',
                                $modes,
                                array('separator' => ' ', 'fieldset' => false,
                                    'legend' => __('Mode'), 'hiddenField' => false,
                                    'label' => array('class' => 'radio-inline'),
                                    'default' => $default_mode));
                            echo '</div>';
                        }

                        echo '<div class="form-group">';
                        echo $this->Form->radio('type',
                            array('online' => __('Online'), 'offline' => __('Offline'), 'ia' => __('IA')),
                            array('separator' => ' ', 'fieldset' => false,
                                'legend' => __('Type'), 'hiddenField' => false,
                                'label' => array('class' => 'radio-inline'),
                                'default' => 'ia')
                        );
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo $this->Form->submit(__('Create'),
                            array('class' => 'btn btn-lg btn-success btn-block'));
                        echo '</div>';

                        ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>