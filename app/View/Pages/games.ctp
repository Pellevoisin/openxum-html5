<div data-role="content">
    <ul data-role="listview" data-inset="true" class="data-split-icon"
        style="width: 30%; margin-left:auto; margin-right:auto; align:center; text-align:center;">
        <li>
            <?php
            echo $this->Html->link($this->Html->image('dvonn.jpg').'<h2>Dvonn</h2>',
                array('controller' => 'games', 'action' => 'index', 'game' => 'dvonn'),
                array('escape' => false));
            ?>
        <li>
            <?php
            echo $this->Html->link($this->Html->image('invers.jpg').'<h2>Invers</h2>',
                array('controller' => 'games', 'action' => 'index', 'game' => 'invers'),
                array('escape' => false));
            ?>
        <li>
            <?php
            echo $this->Html->link($this->Html->image('gipf.jpg').'<h2>Gipf</h2>',
                array('controller' => 'games', 'action' => 'index', 'game' => 'gipf'),
                array('escape' => false));
            ?>
        <li>
            <?php
            echo $this->Html->link($this->Html->image('tzaar.jpg').'<h2>Tzaar</h2>',
                array('controller' => 'games', 'action' => 'index', 'game' => 'tzaar'),
                array('escape' => false));
            ?>
        <li>
            <?php
            echo $this->Html->link($this->Html->image('yinsh.jpg').'<h2>Yinsh</h2>',
                array('controller' => 'games', 'action' => 'index', 'game' => 'yinsh'),
                array('escape' => false));
            ?>
        <li>
            <?php
            echo $this->Html->link($this->Html->image('zertz.jpg').'<h2>Zertz</h2>',
                array('controller' => 'games', 'action' => 'index', 'game' => 'zertz'),
                array('escape' => false));
            ?>
    </ul>
</div>

<div data-role="footer" class="ui-bar"
     style="position: absolute; bottom: 0; width: 100%; margin-left:auto; margin-right:auto; align:center; text-align:center;">
    <div data-role="controlgroup" data-type="horizontal">
        <a href="#">About</a>
    </div>
</div>