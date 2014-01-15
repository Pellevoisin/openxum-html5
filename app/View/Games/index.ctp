<div class="container">

    <table class='table'>
        <tr>
            <th>Name</th>
            <th>Color</th>
            <th>Mode</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($games as $game): ?>
            <tr>
                <td>
                    <?php echo $game['Game']['name']; ?>
                </td>
                <td>
                    <?php echo $game['Game']['color']; ?>
                </td>
                <td>
                    <?php echo $game['Game']['mode']; ?>
                </td>
                <td>
                    <?php echo $game['Game']['type']; ?>
                </td>
                <td>
                    <?php
                    echo $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> '.__('release'),
                        array('action' => 'delete', $game['Game']['id']),
                        array('class' => 'btn btn-danger btn-md active',
                            'escape' => false),
                        __('Are you sure to delete game?'));
                    echo ' ';
                    if ($game['Game']['type'] == 'offline') {
                        echo $this->Html->link('<i class="glyphicon glyphicon-refresh"></i> '.__('resume'),
                            array('controller' => 'games', 'action' => 'resume'),
                            array('class' => 'btn btn-success btn-md active',
                                'escape' => false));
                    } else {
                        echo $this->Html->link('<i class="glyphicon glyphicon-share-alt"></i> '.__('join'),
                            array('controller' => 'games', 'action' => 'join'),
                            array('class' => 'btn btn-success btn-md active',
                                'escape' => false));
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php unset($user); ?>

    </table>

    <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> '.__('Create'),
        array('controller' => 'games', 'action' => 'create',
            'game' => CakeSession::read('OpenXum.game')),
        array('class' => 'btn btn-primary btn-md active',
            'escape' => false)); ?>

</div>