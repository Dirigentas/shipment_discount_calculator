<!-- kodas ne foreach'intas, kad matytųsi, jog gautas masyvas tikrai asociatyvinis (suprantama, kad tai nėra gerai palikti tokį kodą View faile) -->

<div class="container">
    <h1><?= $name ?></h1>
    <?php
    echo '<pre>';
    print_r($data);
    ?>
</div>