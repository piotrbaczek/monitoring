<?
$qdb=mssql_connect("WIN-5FPJ2ZISB5P","sa","BeR5348833") or die("<h1>Can't connect to database</h1>");
$currentuser=substr($_SERVER[AUTH_USER],16,13);
?>