
**Panglossa go!Johnny PHP Library**

version 9.0

release 2025-06-06

Author: Sérgio Domingues (known aliases: panglossa, QVASIMODO, oderalon)

panglossa@yahoo.com.br

Licensed under Creative Commons, please see:

http://creativecommons.org/licenses/by-sa/3.0/deed.en_GB

Araçatuba - SP - Brazil - 2025







# What is it?

The go!Johnny library is a set of classes built with the purpose of automating the generation of html code in your projects. This approach allows you to write only php code, without bothering to mix up html (except in special cases). Each HTML5 tag has its own class. Besides, there are some special classes for html pages, databases, configuration and more. As an example, instead of writing the whole HTML markup for a page, you can do just this:

----------------------------------------

```
gj('page', 'Here you add any content you want the page to include.')
    ->title('Here goes the page title')
    ->icon('mypage.ico')
	  ->render();
```

----------------------------------------

and the whole html5 markup, from <!DOCTYPE html><html ... to ... /html>, will be generated for you.

However, the classes are highly flexible, so there are many ways in which you can create a page. You can, for example, instantiate a page object, then change its properties (such as js files and css stylesheets to include, page title, page icon), add content to it, then, when everything is in place, render it to the client browser. Ex.:

----------------------------------------

```
$page = gj('page');
$page->css[] = 'mystyle.css';
$page->js[] = 'myscript.js';
$page->icon = 'myicon.ico';
$page->title = 'Testing';
$page->add(
	gj('h1', 'Hello!') .
	gj('div', 'This is some text inside a div.')
	);
$page->render();
```

----------------------------------------

Each element can also be handled in a similar manner. Ex.:

----------------------------------------

```
$panel = gj('div');
$panel->add('Some text');
$panel->id('panel1');
$panel->onclick("alert('you clicked me');");
$page->add($panel);
```




# What it is not

This is not a framework. At least not as what is commonly understood by the word 'framework'. It can be used in a similar manner, after you get used to working with it. But I see it as it was designed to be: a set of usefull classes.



# The Latest Version

You can always get the latest version at GitHub:

https://github.com/panglossa/gojohnny9




# Documentation

The documentation is still being written. Full tutorials, including videos, are planned. However, as for now, the only documentation is this README file you are looking at.




# Installation & Use

These classes have been tested with the latest versions of apache and php (at least version 5.0), both on Linux (Debian) and Windows (Seven) machines. You have to unzip the package contents to a folder in your server that your php scripts have access to. Then, in your scripts, you can set some options and then include the main `<gojohnny.php>` file. Ex.:

----------------------------------------

```
global $gj_options = array(
define('LOCALPATH', '/usr/share/gojohnny9');
define('WEBPATH', 'http://myserveraddress/gojohnny');
require_once(LOCALPATH . '/gojohnny.php");
```

----------------------------------------



Some classes may make use of third-party libraries, when available. These have to be placed in the <lib> subfolder. The blueprint css framework and the jQuery library are included by default, both in the release package and in the page's js and css references. The latest versions of these libraries can be found at: 

http://www.blueprintcss.org/

and

http://jquery.com/



# Licensing

http://creativecommons.org/licenses/by-sa/3.0/deed.en_GB
You can use any of the files in this release as you want. If you use re-publish any portion of this project in any medium or if you use it in a project of your own, please be sure to credit the original author or at least include a link to the project's main page (https://sourceforge.net/projects/gojohnny/).
