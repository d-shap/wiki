<?php
# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "MediaWiki";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/wiki";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "server";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL paths to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogos = [ '1x' => "$wgResourceBasePath/resources/assets/mediawiki.png" ];

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@🌻.invalid";
$wgPasswordSender = "apache@🌻.invalid";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "dbname";
$wgDBuser = "dbuser";
$wgDBpassword = "dbpassword";

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Shared database table
# This has no effect unless $wgSharedDB is also set.
$wgSharedTables[] = "actor";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

$wgStrictFileExtensions = true;
$wgFileExtensions = [ 'png', 'gif', 'jpg', 'jpeg', 'webp', 'svg' ];

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale. This should ideally be set to an English
## language locale so that the behaviour of C library functions will
## be consistent with typical installations. Use $wgLanguageCode to
## localise the wiki.
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "language";

$wgSecretKey = "secretkey";

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "upgradekey";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['edit'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );


# End of automatically generated settings.
# Add more configuration options below.

# Arrays extension settings
wfLoadExtension( 'Arrays' );

# BCmath extension settings
wfLoadExtension( 'BCmath' );

# Capiunto extension settings
wfLoadExtension( 'Capiunto' );

# Cite extension settings
wfLoadExtension( 'Cite' );

# CiteThisPage extension settings
wfLoadExtension( 'CiteThisPage' );

# CodeEditor extension settings
wfLoadExtension( 'CodeEditor' );

# CodeMirror extension settings
wfLoadExtension( 'CodeMirror' );
$wgDefaultUserOptions['usecodemirror'] = 1;
$wgCodeMirrorEnableBracketMatching = true;
$wgCodeMirrorAccessibilityColors = false;
$wgCodeMirrorLineNumberingNamespaces = null;

# CSS extension settings
wfLoadExtension( 'CSS' );

# Gadgets extension settings
wfLoadExtension( 'Gadgets' );

# HeaderTabs extension settings
wfLoadExtension( 'HeaderTabs' );
$wgHeaderTabsUseHistory = false;
$wgHeaderTabsRenderSingleTab = true;
$wgHeaderTabsAutomaticNamespaces[] = NS_MAIN;
$wgHeaderTabsDisableDefaultToc = true;

# InputBox extension settings
wfLoadExtension( 'InputBox' );

# LinkTarget extension settings
wfLoadExtension( 'LinkTarget' );
$wgLinkTargetDefault = '_self';
$wgExternalLinkTarget = '_blank';

# Loops extension settings
wfLoadExtension( 'Loops' );

# MyVariables extension settings
wfLoadExtension( 'MyVariables' );

# NoTitle extension settings
wfLoadExtension( 'NoTitle' );
$wgRestrictDisplayTitle = false;

# ParserFunctions extension settings
wfLoadExtension( 'ParserFunctions' );
$wgPFEnableStringFunctions = true;

# Poem extension settings
wfLoadExtension( 'Poem' );

# RegexFunctions extension settings
wfLoadExtension( 'RegexFunctions' );

# Scribunto extension settings
wfLoadExtension( 'Scribunto' );
$wgScribuntoDefaultEngine = 'luastandalone';

# Spoilers extension settings
wfLoadExtension( 'Spoilers' );

# SyntaxHighlight extension settings
wfLoadExtension( 'SyntaxHighlight_GeSHi' );

# Tabs extension settings
wfLoadExtension( 'Tabs' );

# TemplateData extension settings
wfLoadExtension( 'TemplateData' );

# TemplateSandbox extension settings
wfLoadExtension( 'TemplateSandbox' );

# TemplateStyles extension settings
wfLoadExtension( 'TemplateStyles' );

# TemplateStylesExtender extension settings
wfLoadExtension( 'TemplateStylesExtender' );

# TemplateWizard extension settings
wfLoadExtension( 'TemplateWizard' );

# TextExtracts extension settings
wfLoadExtension( 'TextExtracts' );

# Variables extension settings
wfLoadExtension( 'Variables' );

# WikiEditor extension settings
wfLoadExtension( 'WikiEditor' );
$wgHiddenPrefs[] = 'usebetatoolbar';
$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgWikiEditorRealtimePreview = true;

# WikiTextLoggedInOut extension settings
wfLoadExtension( 'WikiTextLoggedInOut' );
