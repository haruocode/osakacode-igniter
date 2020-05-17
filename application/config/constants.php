<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * Define difficulty level
 */
defined('DIFFICULTY_BEGINNER') OR define('DIFFICULTY_BEGINNER', 1);
defined('DIFFICULTY_INTERMEDIATE') OR define('DIFFICULTY_INTERMEDIATE', 2);
defined('DIFFICULTY_ADVANCED') OR define('DIFFICULTY_ADVANCED', 3);

/**
 * Define series status
 */
defined('SERIES_STATUS_NEW_RELEASE') OR define('SERIES_STATUS_NEW_RELEASE', 1);
defined('SERIES_STATUS_UPDATED') OR define('SERIES_STATUS_UPDATED', 2);

/**
 * Define picture path
 */
defined('PICTURE_STORAGE_PATH') OR define('PICTURE_STORAGE_PATH', '/images/');
defined('PICTURE_STORAGE_UPLOAD') OR define('PICTURE_STORAGE_UPLOAD', BASEPATH . '../public/images/');
defined('AVATAR_DEFAULT') OR define('AVATAR_DEFAULT', 'default-gravatar-pic.png');
defined('TEMP_UPLOAD_DIR')      OR define('TEMP_UPLOAD_DIR','tmp/upload');
defined('TEMP_VIEW_DIR')      OR define('TEMP_VIEW_DIR','/tmp/upload');
/**
 * Define playlist type
 */
defined('PLAYLIST_FAVORITES_TYPE') OR define('PLAYLIST_FAVORITES_TYPE', 1);
defined('PLAYLIST_WATCH_LATER_TYPE') OR define('PLAYLIST_WATCH_LATER_TYPE', 2);
defined('PLAYLIST_OBJECT_TYPE_SERIES') OR define('PLAYLIST_OBJECT_TYPE_SERIES', 1);
defined('PLAYLIST_OBJECT_TYPE_LESSON') OR define('PLAYLIST_OBJECT_TYPE_LESSON', 2);

/**
 * Define status lession complete
 */
defined('LESSON_COMPLETE') OR define('LESSON_COMPLETE', 1);

/**
 * Define email who receive customer's messages
 */
defined('RECEIVER_EMAIL') or define('RECEIVER_EMAIL', 'osakacode@gakuen.com');

/**
 * Define account SendGrid
 */
defined('GRID_USER') or define('GRID_USER', '');
defined('GRID_PASS') or define('GRID_PASS', '');

/**
 * Define email support
 */
defined('EMAIL_SUPPORT_ADDRESS') or define('EMAIL_SUPPORT_ADDRESS','osakacode@gakuen.com');
defined('EMAIL_SUPPORT_NAME') or define('EMAIL_SUPPORT_NAME','大阪コード学園');

/**
 * Define admin email
 */
defined('ADMIN_EMAIL') or define('ADMIN_EMAIL','osakacode@gakuen.com');