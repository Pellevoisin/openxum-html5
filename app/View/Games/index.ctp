<?php
echo $this->Html->script('GameClient');
?>

<script language="javascript">
    var client = new GameClient(<?php echo AuthComponent::user('id') ?>);
    client.start();
</script>

<div class="container">

    <?php

    function build_table($o, $games, $my)
    {
        echo '<table class="table">';
        echo '<tr><th>Name</th><th>Color</th><th>Mode</th>';
        echo '<th>Opponent</th>';
        echo '<th>Actions</th></tr>';
        foreach ($games as $game):
            echo '<tr><td>';
            echo $game['Game']['name'];
            echo '</td><td>';
            echo $game['Game']['color'];
            echo '</td><td>';
            echo $game['Game']['mode'];
            echo '</td><td>';
            if ($my) {
                if (!empty($game['Opponent']['username'])) {
                    echo $game['Opponent']['username'];
                } else {
                    echo '<div id="opponent_' . $game['Game']['id'] . '">-</div>';
                }
            } else {
                echo $game['Owner']['username'];
            }
            echo '</td><td>';

            // Actions
            if ($my) {
                echo $o->Form->postLink('<i class="glyphicon glyphicon-trash"></i> ' . __('release'),
                    array('action' => 'delete', $game['Game']['id']),
                    array('class' => 'btn btn-danger btn-md active',
                        'escape' => false),
                    __('Are you sure to delete game?'));
                echo ' ';
            }
            if ($game['Game']['type'] == 'offline') {
                if ($my) {
                    if ($game['Game']['status'] == 'wait') {
                        echo $o->Html->link('<i class="glyphicon glyphicon-pause"></i> ' . __('waiting...'),
                            array(),
                            array('class' => 'btn btn-success btn-md active',
                                'id' => 'button_game_' . $game['Game']['id'],
                                'escape' => false));
                    } else if ($game['Game']['status'] == 'run') {
                        echo $o->Html->link('<i class="glyphicon glyphicon-refresh"></i> ' . __('resume'),
                            array('controller' => 'games', 'action' => 'resume'),
                            array('class' => 'btn btn-success btn-md active',
                                'id' => 'button_game_' . $game['Game']['id'],
                                'escape' => false));
                    }
                } else {
                    if ($game['Game']['status'] == 'wait') {
                        echo '<a href="javascript:client.join(' . AuthComponent::user('id') . ','
                            . $game['Game']['id'] . ');" id ="button_game_' . $game['Game']['id']
                            . '" class="btn btn-success btn-md active"><i class="glyphicon glyphicon-share-alt"></i>'
                            . __('join') . '</a>';
                    } else if ($game['Game']['status'] == 'run') {
                        echo $o->Html->link('<i class="glyphicon glyphicon-refresh"></i> ' . __('resume'),
                            array('controller' => 'games', 'action' => 'resume'),
                            array('class' => 'btn btn-success btn-md active',
                                'id' => 'button_game_' . $game['Game']['id'],
                                'escape' => false));
                    }
                }
            } else {
                if ($my) {
                    echo $o->Html->link('<i class="glyphicon glyphicon-pause"></i> ' . __('waiting...'),
                        array(),
                        array('class' => 'btn btn-success btn-md active',
                            'id' => 'button_game_' . $game['Game']['id'],
                            'escape' => false));
                } else {
                    echo '<a href="javascript:client.join(' . AuthComponent::user('id') . ','
                        . $game['Game']['id'] . ');" id ="button_game_' . $game['Game']['id']
                        . '" class="btn btn-success btn-md active"><i class="glyphicon glyphicon-share-alt"></i>'
                        . __('join') . '</a>';
                }
            }
            echo '</td></tr>';
        endforeach;
        echo '</table>';
    }

    echo '<H3>My online games</H3>';
    build_table($this, $my_online_games, true);

    echo '<H3>Other online games</H3>';
    build_table($this, $other_online_games, false);

    echo '<H3>My offline games</H3>';
    build_table($this, $my_offline_games, true);

    echo '<H3>Other offline games</H3>';
    build_table($this, $other_offline_games, false);

    echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> ' . __('Create'),
        array('controller' => 'games', 'action' => 'create',
            'game' => CakeSession::read('OpenXum.game')),
        array('class' => 'btn btn-primary btn-md active',
            'escape' => false));

    ?>

</div>