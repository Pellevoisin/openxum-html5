<?php
/**
 *  This file is part of OpenXum project.
 *
 *  OpenXum is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This Web application is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with OpenXum.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright (c) Eric Ramat
 * @link          http://github.com/openxum-team/openxum-html5
 * @package       app.View.Layouts
 * @license       http://www.gnu.org/licenses/ GPLv3 License
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php
    echo '<meta charset="utf-8">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo $this->Html->meta('icon');
    ?>

    <title>
        <?php __('OpenXum'); ?>
        <?php echo $title_for_layout; ?>
    </title>

    <?php

    echo $this->Html->css('openxum');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-theme.min');

    echo $this->Html->script('jquery.min');
    echo $this->Html->script('bootstrap.min');

    echo $scripts_for_layout;
    ?>
</head>
<body>
<div style="height: 60px;">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            echo $this->Html->link(__('Home'),
                array('controller' => 'pages', 'action' => 'display', 'home'),
                array("class" => "navbar-brand"));
            ?>
        </div>
        <div class="navbar-collapse collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if (AuthComponent::user('id') != 0): ?>
                    <?php if (AuthComponent::user('role') == 'admin'): ?>
                        <li>
                            <?php
                            echo $this->Html->link(__('Admin'),
                                array('controller' => 'users', 'index'));
                            ?>
                        </li>
                    <?php else: ?>
                        <li>
                            <?php
                            if (CakeSession::read('OpenXum.game') == '') {
                                echo $this->Html->link(__('Games'),
                                    array('controller' => 'pages', 'action' => 'display', 'games'));
                            } else {
                                echo $this->Html->link(__('Games') . ' [' . CakeSession::read('OpenXum.game') . ']',
                                    array('controller' => 'pages', 'action' => 'display', 'games'));
                            }
                            ?>
                        </li>
                    <?php endif ?>
                <?php endif ?>
                <li><a href="#">Ranking</a></li>
                <li><a href="#">Help</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php
                    if (AuthComponent::user('id') != 0) {
                        echo $this->Html->link(__('Logout') . ' [' . AuthComponent::user('username') . ']',
                            array('controller' => 'users', 'action' => 'logout'));
                    } else {
                        echo $this->Html->link('Sign in',
                            array('controller' => 'users', 'action' => 'signin'));
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div id="#content">
    <?php echo $content_for_layout; ?>
</div>

</body>
</html>