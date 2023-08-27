<div class='container'>
    <h1>shipment discount calculation</h1>
    <div class='flex'>
        <div>
            <h3>input:</h3>
            <?php
            echo '<pre>';
            print_r($data[0]);
            ?>
            <ul>
                <!-- <?php foreach ($data as $transaction): ?>
                <?php
                echo '<pre>';
                print_r($transaction);
                ?>
                <?php endforeach; ?> -->
            </ul>
        </div>
        <div>
            <h3>output:</h3>
            <?php
            echo '<pre>';
            print_r($data[1]);
            ?>
            <!-- <ul>
                <?php foreach ($data as $transaction): ?>
                <li><?=$transaction?></li>
                <?php endforeach; ?>
            </ul> -->
        </div>    
    </div>
</div>