# VikingBot
*VikingBot is yet another simple PHP based IRC bot with support for plugins and secure IRC servers.*<br/>
The bot requires Unix/Linux shell access with PHP support and SSL support in PHP for use against secure IRC servers.

### INSTALLING
1. copy config.dist.php to config.php `cp config.dist.php config.php`
2. update config.php with correct settings `nano config.php`
3. run it `sh start.sh`
4. check log outout `cat logs/vikingbot.log`

### SUPPORTED COMMANDS
The following commands are supported out of the box (aka they are not controlled via plugins):
* `!exit [adminPassword]` Shuts down the bot
* `!restart [adminPassword]` Restarts the bot
* `!help [command]` Sends a list of commands or the description of a given command to the user

The following commands are supported via the plugins that
is installed per default:

* `!botlog [adminPassword] [rows]` The bot responds with the [rows] last rows of the bot log file (default: 10 rows)
* `!memory` The bot responds with memory usage statistics
* `!ping` The bot responds with a pong to say that it is still alive
* `!uptime` The bot responds with the bots uptime
* `!upgrade [adminPassword]` The bot will attempt to upgrade itself to the latest version via GIT pull
* `!op nick channel [adminPassword]` The bot attempts to give *user* on *channel OP status

### INSTALLED PLUGINS
The following plugins are installed per default:
* fileReaderPlugin
	* Outputs data from db/fileReaderOutput.db to channel specified in the plugin, useful for GIT/SVN commit hooks or anything other that should push data to a channel
* botLogPlugin
	* Plugin that responds to a `!botlog` with the last N rows of the bot's log file
* memoryPlugin
	* Plugin that responds to a `!memory` with information about memory usage
* opPlugin
	* Plugin that respons to a `!op ...` by oping a user if the bot has op itsefl
* pingPlugin
	* Plugin that responds to a `!ping` with a "PONG".
* uptimePlugin
    * Plugin that responds to a `!uptime` with the bots uptime
* rssPlugin
	* Plugin that pulls RSS feeds at specified intervals and outputs new RSS elements to a specified channel.
* upgradePlugin
    * Plugin that upgrades the bot via git pull.
* autoOpPlugin
	* Plugin that gives +o to everyone or to certain nicks on channel join.

### THIRD-PARTY PLUGINS
Links to other plugins for VikingBot:
* [Doorway/Plugin for Roundup Issue Tracker](https://gist.github.com/3295338)

Make sure to install your plugins into the thirdparty-plugins folder so git ignores them!

### TEXT FORMATTING
If you wish, you can format text the bot sends to a channel/user, via your plugins.
Use any of the following codes to apply the relevant text color or format. The text will
keep the given format until either end of string, or the {reset} tag.

**Available colors:**<br/>
{white}, {black}, {blue}, {green}, {red}, {darkRed}, {purple}, {orange}, {yellow}, {lime}, {teal}, {cyan}, {lightBlue}, {pink}, {grey} & {lightGrey}

**Other tags:**<br/>
{reset}, {bold} & {underline}

**Example:**<br/>
"{bold}**i am bold and **{red}**red**{reset}, but now i am normal"

PS: Different IRC-clients may display colors differently, some servers even deny color use!

### BUGS/PROBLEMS?
Feel free to contact me via IRC on EfNet/Freenode/Undernet (Ueland)
or via e-mail: tor.henning AT gmail.com.