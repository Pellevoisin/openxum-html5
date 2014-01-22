<div class="container">

    <?php
    echo $this->Html->script('AdminClient');
    ?>

    <script language="javascript">
        var client = new AdminClient();
        client.start();
    </script>

    <div class="row vertical-offset-100">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo __('Players'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php

                    echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> ' . __('Create'),
                        array('controller' => 'users', 'action' => 'add'),
                        array('class' => 'btn btn-primary btn-md active', 'escape' => false));

                    ?>

                    <br><br>

                    <table class="table">
                        <tr>
                            <th>Login</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?php
                                    echo $this->Html->link($user['User']['username'],
                                        array('controller' => 'users', 'action' => 'view', $user['User']['id']));
                                    ?>
                                </td>
                                <td><?php
                                    if ($user['User']['role'] === 'admin') {
                                        echo '<b><span style="color:red">';
                                    }
                                    echo $user['User']['role'];
                                    if ($user['User']['role'] === 'admin') {
                                        echo "<span></b>";
                                    }
                                    ?>
                                </td>
                                <?php echo '<td id="td_user_' . $user['User']['id'] . '">no connected</td>'; ?>
                                <td>
                                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i> ' . __('Edit'),
                                        array('controller' => 'users', 'action' => 'edit'),
                                        array('class' => 'btn btn-warning btn-md active', 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<i class="glyphicon glyphicon-remove"></i> ' . __('Remove'),
                                        array('controller' => 'users', 'action' => 'delete', $user['User']['id']),
                                        array('class' => 'btn btn-danger btn-md active', 'escape' => false),
                                        __('Are you sure to remove this user?'));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($user); ?>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>