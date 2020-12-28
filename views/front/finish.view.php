<div class="game-play">
    <div class="game-play-inner">

        <div class="game-play-content">
            <h1>Game Over!</h1>
            <h3>Thank you for playing.</h3>
            <p>Please save the data by entering your name.</p>

            <form action="" method="post">
                <?php if ($error && !empty($error)): ?>
                    <div class="game-play-error"><?=$error?></div>
                <?php endif;?>
                <div class="game-play-input">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" id="name" value="<?=$_POST['name'] ?? ''?>">
                </div>
                <div class="game-answer-submit">
                    <button type="submit">save</button>
                </div>
            </form>
        </div>

    </div>
</div>
