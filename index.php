<?php

require_once __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/example/text.php';
include __DIR__ . '/templates/contents.php';

$text = '<h2>First h2 header</h2>
    <p>Some text</p>    
    <h3>First h3 header</h3>
    <p>Some text</p>    
    <h3>2nd h3 header</h3>
    <p>Some text</p>    
    <h4>First h4 header</h4>
    <p>Some text</p>
    <h4>2nd h4</h4>
    <p>Some text</p>
    <h2>Latest header</h2>';

$tableOfContents = new \NikolayOskin\Contents\Contents();
$tableOfContents->fromText($text)->setMinLength(100)->setTags(['h2', 'h3']);
$handledBody = $tableOfContents->getHandledText();
$contents = $tableOfContents->getContentsArray();

?>

<html lang="en">
<body>
<?php
getContentsHTMLTemplate($contentsArray);
echo $handledText;
?>
</body>
</html>




