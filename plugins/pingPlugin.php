<?php

/**
 * Plugin that responds to "!ping" messages with a pong
 * simply to verify that the bot is alive
 */
class pingPlugin implements pluginInterface {

	var $socket, $config;

	function init($config, $socket) {
		$this->socket = $socket;
		$this->config = $config;
	}

	/**
	 * @return array[]
	 */
	function help() {
		return array(
			array(
				'command'     => 'ping',
				'description' => 'Returns PONG.'
			)
		);
	}

	function onData($data) {
	}

	function tick() {
	}

	function onMessage($from, $channel, $msg) {
		if(stringEndsWith($msg, "{$this->config['trigger']}ping")) {
			sendMessage($this->socket, $channel, $from.": Pong");
		}
	}

	function destroy() {
		$this->socket = null;
	}
}
