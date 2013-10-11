<?php
// app/classes/my/ratchet/ws.php

use \Ratchet\ConnectionInterface;

/**
 * Sample Class for WsServer
 *
 * @author    Mamoru Otsuka http://madroom-project.blogspot.jp/
 * @copyright 2013 Mamoru Otsuka
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 */
class My_Ratchet_Ws extends Ratchet_Ws
{

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {
		$this->clients->attach($conn);
	}

	public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		foreach ($this->clients as $client) {
			if ($from != $client) {
				$client->send(Security::htmlentities($msg));
			}
		}
	}
}
