Loyalty
=======

Easy MVC intranet site.

Requery:
PHP 5.4
SQLite

In Twig templates you must use:

{{ _user.isLogin }} (bool)
{{ _user.read }} (bool)
{{ _user.add }} (bool)
{{ _user.edit }} (bool)
{{ _user.delete }} (bool)
{{ _user.userName }} (text)
{{ _user.groupName }} (text)

{{ _page.id }} (int)
{{ _page.segment }} (text)

