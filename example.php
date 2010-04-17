<?php
require("pluralize.php");

echo Inflector::pluralize('mês');
echo '<hr>';
echo Inflector::singularize('meses');

?>