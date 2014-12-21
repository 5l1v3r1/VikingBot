<?php

interface pluginInterface {

	/**
	 * Called when plugins are loaded
	 *
	 * @param mixed[]	$config
	 * @param resource 	$socket
	 */
	function init($config, $socket);

	/**
	 * Called about twice per second or when there are
	 * activity on the channel the bot are in.
	 * put your jobs that needs to be run without user interaction here
	 */
	function tick();

	/**
	 * Called when messages are posted on the channel
	 * the bot are in, or when somebody talks to it
	 *
	 * @param string $from
	 * @param string $channel
	 * @param string $msg
	 */
	function onMessage($from, $channel, $msg);

	/**
	 * Called when the bot is shutting down
	 */
	function destroy();
}
