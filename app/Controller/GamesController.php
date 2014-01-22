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
 * @package       app.Controller
 * @license       http://www.gnu.org/licenses/ GPLv3 License
 */

class GamesController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function isAuthorized($user)
    {
        return true;
    }

    public function create()
    {
        if ($this->request->is('post')) {
            if ($this->request->data['Game']['type'] == 'ia') {
                return $this->redirect(array('controller' => 'games', 'action' => 'play_'
                    . CakeSession::read('OpenXum.game'), 'color' => $this->request->data['Game']['color']));
            } else {
                $this->Game->create();
                $this->request->data['Game']['owner_id'] = AuthComponent::user('id');
                $this->request->data['Game']['status'] = 'wait';
                $this->request->data['Game']['opponent_id'] = -1;
                if ($this->Game->save($this->request->data)) {
                    return $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

    public function index()
    {
        if (isset($this->params['named']['game'])) {
            CakeSession::write('OpenXum.game', $this->params['named']['game']);
        }
        $my_online_games = $this->Game->find('all',
            array('conditions' => array('Game.game' => CakeSession::read('OpenXum.game'),
                'Game.owner_id' => AuthComponent::user('id'), 'Game.type' => 'online')));
        $other_online_games = $this->Game->find('all',
            array('conditions' => array('Game.game' => CakeSession::read('OpenXum.game'),
                'Game.owner_id !=' => AuthComponent::user('id'), 'Game.type' => 'online'),
                'recursive' => 1));
        $my_offline_games = $this->Game->find('all',
            array('conditions' => array('Game.game' => CakeSession::read('OpenXum.game'),
                'Game.owner_id' => AuthComponent::user('id'), 'Game.type' => 'offline')));
        $other_offline_games = $this->Game->find('all',
            array('conditions' => array('Game.game' => CakeSession::read('OpenXum.game'),
                'Game.owner_id !=' => AuthComponent::user('id'), 'Game.type' => 'offline')));
        $this->set('my_online_games', $my_online_games);
        $this->set('other_online_games', $other_online_games);
        $this->set('my_offline_games', $my_offline_games);
        $this->set('other_offline_games', $other_offline_games);
    }

    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Game->id = $id;
        if ($this->Game->delete()) {
            return $this->redirect(array('action' => 'index'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function play_Yinsh()
    {
        if (array_key_exists('game_id', $this->params['named'])) {
            $this->set('game_id', $this->params['named']['game_id']);
        } else {
            $this->set('game_id', -1);
        }
        if (array_key_exists('owner_id', $this->params['named'])) {
            $this->set('owner_id', $this->params['named']['owner_id']);
        } else {
            $this->set('owner_id', -1);
        }
        if (array_key_exists('opponent_id', $this->params['named'])) {
            $this->set('opponent_id', $this->params['named']['opponent_id']);
        } else {
            $this->set('opponent_id', -1);
        }
        if (array_key_exists('color', $this->params['named'])) {
            $this->set('color', $this->params['named']['color']);
        } else {
            $this->set('opponent_id', -1);
        }
    }
}