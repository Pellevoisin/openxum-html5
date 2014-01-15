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
                return $this->redirect(array('controller' => 'pages', 'action' => 'display',
                    CakeSession::read('OpenXum.game')));
            } else {
                $this->Game->create();
                $this->request->data['Game']['user_id'] = AuthComponent::user('id');
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
        $games = $this->Game->find('all',
            array('conditions' => array('Game.game' => CakeSession::read('OpenXum.game'),
            'Game.user_id' => AuthComponent::user('id'))));
        $this->set('games', $games);
    }

    public function join()
    {
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

    public function resume()
    {
    }
}