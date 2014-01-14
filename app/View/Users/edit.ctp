<h1>Edit player</h1>

<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'Username'));
echo $this->Form->input('ban', array('label' => 'Ban'));
echo $this->Form->end('Valid');
?>
