<div class='container'>
    <h1>shipment discount calculation</h1>
    <div class='flex'>
        <div>
            <h3>No.</h3>
            <?php foreach (range(1, 21) as $number): ?>
            <div>
                <div class="list"><?=$number?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div>
            <h3>input:</h3>
            <?php foreach ($data[0] as $inputTransactions): ?>
            <div>
                <div class="list"><?=$inputTransactions?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div>
            <h3>output:</h3>
            <?php foreach ($data[1] as $inputTransactions): ?>
            <div>
                <div class="list"><?=$inputTransactions?></div>
            </div>
            <?php endforeach; ?>
        </div>    
    </div>
</div>