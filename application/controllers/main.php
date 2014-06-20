<?php
/**
 * @package Loyality Portal
 * @author Supme
 * @copyright Supme 2014
 * @license http://opensource.org/licenses/MIT MIT License
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF
 *	ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 *	IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR
 *	PURPOSE.
 *
 *	Please see the license.txt file for more information.
 *
 */

class Main extends Controller
{
    public function index()
    {
        $content = $this->loadModel('Content');

        $this->render([
            'result' => $content->getContent(),
            'notifications' => [
                'info' => [
                    'This info notification',
                    'And one more notification',
                ],
                'warning' => [
                    'This warning notification',
                ],
                'success' => [
                    'This success notification',
                ],
                'danger' => [
                    'This danger notification',
                ],
            ],
            'debug' => [
                'debug' => 'This debug message'
            ],
        ]);
    }
}
