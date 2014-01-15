<div class="container">
    <?php

    function makeGame($o, $name, $title)
    {
        echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">';
        echo $o->Html->link($title . ' ' . $o->Html->image($name . '.jpg', array('width' => '50%')),
            array('controller' => 'games', 'action' => 'index', 'game' => $title),
            array('class' => 'btn btn-primary btn-block active', 'escape' => false));
        echo '</div>';
    }

    echo '<div class="row" style="padding: 10px">';
    makeGame($this, 'dvonn', 'Dvonn');
    makeGame($this, 'invers', 'Invers');
    makeGame($this, 'gipf', 'Gipf');
    makeGame($this, 'tzaar', 'Tzaar');
    echo '</div>';
    echo '<div class="row" style="padding: 10px">';
    makeGame($this, 'yinsh', 'Yinsh');
    makeGame($this, 'zertz', 'Zertz');
    echo '</div>';
    ?>

</div>