<div data-role="content">

<?php echo $this->Html->link($this->Html->image('user-add.png',
        array('alt' => 'add', 'height' => '24px')),
    array('controller' => 'games', 'action' => 'create',
        'game' => CakeSession::read('OpenXum.game')),
    array('escape' => false)); ?>

    <table>
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
                    echo $this->Form->postLink(__('release'),
                        array('action' => 'delete', $game['Game']['id']),
                        array('escape' => false),
                        __('Are you sure to delete game?'));
                    echo ' ';
                    if ($game['Game']['type'] == 'offline') {
                        echo $this->Html->link(__('resume'),
                            array('controller' => 'games', 'action' => 'resume'),
                            array('escape' => false));
                    } else {
                        echo $this->Html->link(__('join'),
                            array('controller' => 'games', 'action' => 'join'),
                            array('escape' => false));
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php unset($user); ?>

    </table>

</div>

<div data-role="footer" class="ui-bar"
     style="position: absolute; bottom: 0; width: 100%; margin-left:auto; margin-right:auto; align:center; text-align:center;">
    <div data-role="controlgroup" data-type="horizontal">
        <a href="#">About</a>
    </div>
</div>